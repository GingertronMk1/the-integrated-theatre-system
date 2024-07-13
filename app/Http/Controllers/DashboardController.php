<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        /** @var StatefulGuard $auth */
        $auth = auth();

        return view('dashboard', [
            'user' => $auth->user(),
        ]);
    }
}
