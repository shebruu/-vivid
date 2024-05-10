import React, { useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Link } from '@inertiajs/inertia-react';
import Navbar2 from '../Navbar';
import './style.css'; 


function Trips({ usertrips, auth }) {



    const [memberLogins, setMemberLogins] = useState({});

    const handleLoginChange = (tripId, login) => {
        setMemberLogins({ ...memberLogins, [tripId]: login });
    };

    const addMember = (tripId) => {
        if (!memberLogins[tripId]) {
            alert("Please enter a member's login.");
            return;
        }
        Inertia.post(`/trips/${tripId}/addMember`, { login: memberLogins[tripId] });
        setMemberLogins({ ...memberLogins, [tripId]: '' }); // Reset the input after submit
    };

        

    return (
        <AuthenticatedLayout
        user={auth.user}
        header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Itinéraires</h2>}
    >
        <div>
            <Navbar2 auth={auth} />
            <div className="container"  style={{ marginTop: '20px'}}>
                <h1 className="title">Liste de mes voyages</h1>
                <div className="trip-container">
                    {usertrips.map((trip) => (
                        <div key={trip.id} className="card">
                            <h2 className="text-xl font-semibold">{trip.title}</h2>
                            <h2 className="text-xl">{trip.departure} - {trip.arrival}</h2>
                            <p className="text-gray-600">Estimation totale: {trip.totalestimation}</p>
                            <Link href={route('trip.show', { trip: trip.id })} className="btn-primary">Voir les détails</Link>
                            <ul>
                                    {trip.users.map(user => (
                                        <li key={user.id}>{user.login}</li>
                                    ))}
                                </ul>
                                <input 
                                    type="text" 
                                    value={memberLogins[trip.id] || ''}
                                    onChange={(e) => handleLoginChange(trip.id, e.target.value)} 
                                    placeholder="Enter member login"
                                />
                                <button onClick={() => addMember(trip.id)}>Add Member</button>
                            
                            
                        </div>
                    ))}
                </div>

                
            </div>
        </div>
        </AuthenticatedLayout>
    );
}

export default Trips;