<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\ChangelogService;
use Illuminate\Contracts\View\View;

class ChangelogController extends Controller
{
    public function __invoke(ChangelogService $changelog): View
    {
        $releases = $changelog->releases();

        return view('changelog', [
            'currentVersion' => $changelog->currentVersion(),
            'releases' => $releases,
            'changelog' => $changelog,
        ]);
    }
}
