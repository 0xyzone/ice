<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\File;

class ChangelogService
{
    /**
     * Get the current (latest) version string from CHANGELOG.md.
     */
    public function currentVersion(): string
    {
        $releases = $this->releases();

        return $releases[0]['version'] ?? 'v1.0.0';
    }

    /**
     * Parse CHANGELOG.md into structured release entries.
     *
     * @return array<int, array{
     *     version: string,
     *     date: ?string,
     *     is_latest: bool,
     *     sections: array<int, array{type: string, items: array<int, string>}>
     * }>
     */
    public function releases(): array
    {
        $path = base_path('CHANGELOG.md');

        if (! File::exists($path)) {
            return [];
        }

        $lines = preg_split("/\r\n|\n|\r/", File::get($path)) ?: [];
        $releases = [];
        $currentReleaseIndex = null;
        $currentSectionIndex = null;

        foreach ($lines as $line) {
            $trimmed = trim($line);

            if (preg_match('/^##\s+\[?(v?\d+\.\d+\.\d+)\]?(?:\s*-\s*(\d{4}-\d{2}-\d{2}))?/i', $trimmed, $matches)) {
                $version = str_starts_with(strtolower($matches[1]), 'v')
                    ? $matches[1]
                    : 'v'.$matches[1];

                $releases[] = [
                    'version' => $version,
                    'date' => $matches[2] ?? null,
                    'is_latest' => count($releases) === 0,
                    'sections' => [],
                ];

                $currentReleaseIndex = array_key_last($releases);
                $currentSectionIndex = null;

                continue;
            }

            if ($currentReleaseIndex === null) {
                continue;
            }

            if (preg_match('/^###\s+(.+)$/', $trimmed, $sectionMatches)) {
                $releases[$currentReleaseIndex]['sections'][] = [
                    'type' => trim($sectionMatches[1]),
                    'items' => [],
                ];
                $currentSectionIndex = array_key_last($releases[$currentReleaseIndex]['sections']);

                continue;
            }

            if (preg_match('/^[-*]\s+(.+)$/', $trimmed, $itemMatches)) {
                if ($currentSectionIndex === null) {
                    $releases[$currentReleaseIndex]['sections'][] = [
                        'type' => 'Changes',
                        'items' => [],
                    ];
                    $currentSectionIndex = array_key_last($releases[$currentReleaseIndex]['sections']);
                }

                $releases[$currentReleaseIndex]['sections'][$currentSectionIndex]['items'][] = trim($itemMatches[1]);
            }
        }

        return $releases;
    }

    /**
     * Safely render inline markdown (**bold** and `code`) to HTML.
     */
    public function formatInlineMarkdown(string $text): string
    {
        $escaped = e($text);
        $escaped = preg_replace('/\*\*(.+?)\*\*/', '<strong class="font-semibold text-white">$1</strong>', $escaped) ?? $escaped;

        return preg_replace(
            '/`([^`]+)`/',
            '<code class="px-1.5 py-0.5 rounded-md bg-white/10 border border-white/10 text-orange-300 text-xs font-mono">$1</code>',
            $escaped
        ) ?? $escaped;
    }
}
