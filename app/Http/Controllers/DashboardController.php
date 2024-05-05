<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {

        $data = [
            // Exemple de données
            'message' => 'Bienvenue sur le tableau de bord',
        ];

        return Inertia::render('Dashboard', $data);
    }
}
