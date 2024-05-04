import React from 'react';
import { Link } from '@inertiajs/inertia-react';
import './style.css'; // Assurez-vous que le chemin soit correct

function UserActivityList({ activities }) {
    return (
        <div className="cards-container">

      
                                <h1 className="text-3xl font-bold mb-4">
                                    Liste des activitées réalisé par nos utilisateurs !
                                 
                                </h1>

            {activities.map((activity) => (
                 <Link href={route('activity.show', activity.id)} key={activity.id} className="card-link">
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
    );
}
export default UserActivityList;