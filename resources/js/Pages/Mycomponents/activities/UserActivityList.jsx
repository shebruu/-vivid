import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Link } from '@inertiajs/inertia-react';
import Navbar2 from '../Navbar';
import './style.css';


function UserActivityList({ activities, auth }) {
    return (

        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Itinéraires</h2>}
        >

            <div>

                <Navbar2 auth={auth} />
                <div className="content-container" style={{ marginTop: '150px' }}>

                    <h1 className="text-3xl font-bold mb-4">
                        Liste des activitées réalisé par nos utilisateurs !

                    </h1>

                    <div className="cards-container">




                        {activities.map((activity) => (
                            <Link href={route('user_activity.show', activity.id)} key={activity.id} className="card-link">
                                <div className="card">

                                    <h2>{activity.activity.activity}</h2>
                                    <p>Place: {activity.place.title}</p>
                                    <p>Created by: {activity.user.firstname} {activity.user.lastname}</p>
                                    <p>Status: {activity.status}</p>
                                    <p>Prices:</p>
                                    <ul>
                                        {activity.activity.prices.map((price) => (
                                            <li key={price.id}>
                                                Amount: {price.amount}, Age Range: {price.age_range}
                                            </li>

                                        ))}
                                    </ul>
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