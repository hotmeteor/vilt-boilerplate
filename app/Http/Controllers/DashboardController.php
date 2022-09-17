<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        return Inertia::render('Dashboard/Index', [
            'projects' => fn () => $request->account()
                ->projects()
                ->with(['members'])
                ->withCount(['members', 'components'])
                ->get(),
        ]);
    }
}
