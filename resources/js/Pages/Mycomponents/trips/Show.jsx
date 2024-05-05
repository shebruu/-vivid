import React from 'react';
import { Link } from '@inertiajs/inertia-react';
import Navbar2 from '../Navbar2';
import './style.css'; 


function Show({ trip, auth }) {
    // Example highlighting based on the upcoming trip
    const isUpcoming = new Date(trip.departure) > new Date();
    const highlightClass = isUpcoming ? 'text-green-500' : 'text-red-500';

    

    return (

        <div>
            
            
            <Navbar2 auth={auth} />
        <div className="container">
          
            <h1 className="title">Détails de :   <p>{trip.title}</p></h1>
            <div className="card trip-details">
                
                <div>
                    <h2>Départ:</h2>
                    <p className={highlightClass}>{trip.departure}</p>
                </div>
                <div>
                    <h2>Arrivée:</h2>
                    <p>{trip.arrival}</p>
                </div>
                <div>
                    <h2>Estimation totale:</h2>
                    <p>{trip.totalestimation}</p>
                </div>
                <div>
                    <h2>Note:</h2>
                    <p>{trip.note}</p>
                </div>
                <div>
                    <h2>Créé par:</h2>
                    <p>{trip.created_by}</p>
                </div>
                <div>
                    <Link href={route('trip.edit', { trip: trip.id })} className="btn-primary">Cliquez pour modifier les informations</Link>
                </div>
            </div>
        </div>
        </div>
    );
}

export default Show;