import React, { useState, useEffect } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Link } from '@inertiajs/inertia-react';
import Navbar2 from '../Navbar';
import './style.css';

function UserActivityList({ activities, auth }) {
    console.log("Activités reçues :", activities);
    const [searchTerm, setSearchTerm] = useState('');
    // Conversion des activités d'objet en tableau s'ils sont présentés comme un objet
    const initialActivities = Array.isArray(activities) ? activities : Object.values(activities || {});
    const [filteredActivities, setFilteredActivities] = useState(initialActivities);

    useEffect(() => {
        // S'assure que activities est toujours traité comme un tableau
        const arrayActivities = Array.isArray(activities) ? activities : Object.values(activities || {});
        const results = arrayActivities.filter(activity => {
            return (
                activity.activity.activity.toLowerCase().includes(searchTerm.toLowerCase()) ||
                activity.place.title.toLowerCase().includes(searchTerm.toLowerCase()) ||
                activity.place.locality.city.toLowerCase().includes(searchTerm.toLowerCase())
            );
        });
        setFilteredActivities(results);
    }, [searchTerm, activities]);

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Itinéraires</h2>}
        >
            <div>
                <Navbar2 auth={auth} />
                <div className="content-container" style={{ marginTop: '150px' }}>
                    <h1 className="text-3xl font-bold mb-4">
                      Découvrez les activités réalisées par nos utilisateurs 
                    </h1>
                    <input
                        style={{ width: '50%', height: '7%' }}
                        type="text"
                        value={searchTerm}
                        onChange={(e) => setSearchTerm(e.target.value)}
                        placeholder="Rechercher par activité, lieu ou ville..."
                        className="mb-4 p-2 border rounded"
                    />
                    <div className="cards-container">
                        {filteredActivities.map((activity) => (
                            <Link href={route('user_activity.show', activity.id)} key={activity.id} className="card-link">
                                <div className="card">
                                    <h2>{activity.activity.activity}</h2>
                                    <p>Place: {activity.place.title}</p>
                                    <p>City: {activity.place.locality.city}</p>
                                    <p>Created by: {activity.user.firstname} {activity.user.lastname}</p>
                                    <p>Status: {activity.status}</p>
                                    <p>Prices:</p>
                                    {activity.place.prices.length > 0 && (
                                        <ul>
                                            <li>
                                                à partir de : ${activity.place.prices.reduce((min, p) => p.amount < min ? p.amount : min, activity.place.prices[0].amount)}
                                            </li>
                                        </ul>
                                    )}
                                </div>
                            </Link>
                        ))}
                    </div>
                </div>
            </div>
            <div className="mt-4">
                <Link
                    href={route('user_activity.create')}
                    className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                >
                    Cliquez ici pour créer une activité
                </Link>
            </div>
        </AuthenticatedLayout>
    );
}

export default UserActivityList;
