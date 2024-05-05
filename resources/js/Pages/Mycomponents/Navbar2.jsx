import React from 'react';
import { Link } from "@inertiajs/react";
import { Inertia } from '@inertiajs/inertia';
import "./Navbarstyle.css";
import { route } from 'ziggy-js';


//import LogoutModal from './LogoutModal';

const Navbar2 = ({ auth, csrfToken }) => {
    const handleLogout = (e) => {
        e.preventDefault();
        Inertia.post('/logout', { _token: csrfToken });
    };
    return (
        <header className={`custom-header`}>
            <Link href="/" className="logo-link">
                <img src="illustrations/logo.png" alt="VividPalette Logo" className="logo" />
            </Link>
            <nav className="flex justify-between">
                {/* Liens pour tous les utilisateurs */}
                <div className="nav-links">
                    <Link href="/" className="nav-link">Accueil</Link>
                    {auth.user ? (
                        <>
                            <Link href={route('expense.index')} className="nav-link">Dépenses</Link>
                           
                            <Link href={route('user_activities.index')} className="nav-link">Itinéraires</Link>
                            <Link href={route('trip.index')} className="nav-link">Mes voyages</Link>
                            
                           
                        </>
                    ) : (
                        <>
                            <Link href="/login" className="nav-link">Log in</Link>
                            <Link href="/register" className="nav-link">Register</Link>
                        </>
                    )}
                </div>

                       {/* Gestion de l'authentification et du profil utilisateur */}
                       {auth.user && (
                    <div className="nav-user">
                        <div className="dropdown">
                            <button className="dropbtn">Mon Profil</button>
                            <div className="dropdown-content">
                                <Link href="/profile" className="dropdown-item">Informations personnelles</Link>
                                <a href="#" onClick={handleLogout} className="dropdown-item">Se déconnecter</a>
                            </div>
                        </div>
                    </div>
                )}
            </nav>
        </header>
    );
};

export default Navbar2;