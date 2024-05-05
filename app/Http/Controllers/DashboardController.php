<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // $request->session();
        $user = $request->user();
        // dd($user);
        $message = $user ? 'Bienvenue ' . $user->firstname : 'Bienvenue sur le tableau de bord, individus';

        return Inertia::render('Dashboard', [
            'message' => $message,
        ]);
    }
}
