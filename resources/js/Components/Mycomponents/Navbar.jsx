import React from 'react';
import { InertiaLink } from '@inertiajs/inertia-react';

function Navbar() {
    return (
        <nav className="flex justify-between items-center p-4 bg-white shadow">
            <InertiaLink href="/" className="text-blue-500 hover:text-blue-600">Accueil</InertiaLink>
            <InertiaLink href="/itinerarie" className="text-blue-500 hover:text-blue-600">Itinéraires</InertiaLink>
            <InertiaLink href="/finance" className="text-blue-500 hover:text-blue-600">Dépenses</InertiaLink>
            <InertiaLink href="/map" className="text-blue-500 hover:text-blue-600">Carte</InertiaLink>
            <InertiaLink href="/travel" className="text-blue-500 hover:text-blue-600">Voyages</InertiaLink>
        </nav>
    );
}

export default Navbar;