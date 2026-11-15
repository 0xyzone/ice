<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Services\ChangelogService;
use Tests\TestCase;

class ChangelogTest extends TestCase
{
    public function test_changelog_service_parses_markdown_versions(): void
    {
        $service = app(ChangelogService::class);
        $currentVersion = $service->currentVersion();
        $releases = $service->releases();

        $this->assertMatchesRegularExpression('/^v\d+\.\d+\.\d+$/', $currentVersion);
        $this->assertNotEmpty($releases);
        $this->assertTrue($releases[0]['is_latest']);
        $this->assertSame($currentVersion, $releases[0]['version']);
        $this->assertNotEmpty($releases[0]['sections']);
    }

    public function test_changelog_page_renders_current_version_and_releases(): void
    {
        $currentVersion = app(ChangelogService::class)->currentVersion();

        $this->get('/changelog')
            ->assertOk()
            ->assertSee('System Changelog')
            ->assertSee($currentVersion)
            ->assertSee('v1.0.0');
    }

    public function test_login_page_and_filament_brand_logo_display_version_pill(): void
    {
        $currentVersion = app(ChangelogService::class)->currentVersion();

        $this->get('/login')
            ->assertOk()
            ->assertSee($currentVersion)
            ->assertSee(route('changelog'));

        $brandLogoHtml = view('filament.components.brand-logo')->render();
        $this->assertStringContainsString($currentVersion, $brandLogoHtml);
        $this->assertStringContainsString(route('changelog'), $brandLogoHtml);
    }
}
