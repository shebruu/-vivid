import React from 'react';
import { Link } from '@inertiajs/inertia-react';
import Navbar2 from '../Navbar2';
import './style.css'; 


import React from 'react';
import { Link } from '@inertiajs/inertia-react';
import Navbar2 from '../Navbar2';
import './style.css'; 

function Show({ trip, auth }) {
    return (
        <div className="container">
            <Navbar2 auth={auth} />
            <h1 className="text-3xl font-bold mb-4">Détails du voyage</h1>
            <div className="trip-details">
                <div>
                    <h2 className="text-xl font-semibold">Titre du voyage:</h2>
                    <p>{trip.title}</p>
                </div>
                <div>
                    <h2 className="text-xl font-semibold">Départ:</h2>
                    <p>{trip.departure}</p>
                </div>
                <div>
                    <h2 className="text-xl font-semibold">Arrivée:</h2>
                    <p>{trip.arrival}</p>
                </div>
                <div>
                    <h2 className="text-xl font-semibold">Estimation totale:</h2>
                    <p>{trip.totalestimation}</p>
                </div>
                <div>
                    <h2 className="text-xl font-semibold">Note:</h2>
                    <p>{trip.note}</p>
                </div>
                <div>
                    <h2 className="text-xl font-semibold">Créé par:</h2>
                    <p>{trip.created_by}</p>
                </div>
                <div>
                    <Link href={route('trip.edit', { trip: trip.id })} className="btn-edit-trip">Modifier</Link>
                </div>
            </div>
        </div>
    );
}

export default Show;