import React from 'react';
import { Link } from '@inertiajs/inertia-react';
import Navbar2 from '../Navbar2';
import './style.css'; 

function Trips({ usertrips, auth }) {
    return (
        <div>
            <Navbar2 auth={auth} />
            <div className="container"  style={{ marginTop: '180px'}}>
                <h1 className="title">Liste de mes voyages</h1>
                <div className="trip-container">
                    {usertrips.map((trip) => (
                        <div key={trip.id} className="card">
                            <h2 className="text-xl font-semibold">{trip.title}</h2>
                            <h2 className="text-xl">{trip.departure} - {trip.arrival}</h2>
                            <p className="text-gray-600">Estimation totale: {trip.totalestimation}</p>
                            <Link href={route('trip.show', { trip: trip.id })} className="btn-primary">Voir les détails</Link>
                        </div>
                    ))}
                </div>

                
            </div>
        </div>
    );
}

export default Trips;