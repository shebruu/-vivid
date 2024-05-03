import React from 'react';
import { Link } from 'react-router-dom';

const Header = () => (
    <header class="custom-header">
        <Link href="/" className="logo-link">
            <img src="path/to/your/logo.png" alt="VividPalette Logo" class="logo" />
        </Link>
        <nav className="flex gap-4">
            <Link href="/home" className="nav-link">Accueil</Link>
            <Link href="/dashboard" className="nav-link">Dashboard</Link>
            {/* Autres liens */}
        </nav>
    </header>
);


