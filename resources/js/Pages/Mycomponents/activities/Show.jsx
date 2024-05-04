// resources/js/Pages/Activity/Show.jsx

import React from 'react';

function Show({ activity }) {
    return (
        <div className="activity-detail">
            <h1>{activity.activity}</h1>
            <p><strong>Place:</strong> {activity.place.title}</p>
            <p><strong>Locality:</strong> {activity.place.locality}</p>
            <p><strong>Created by:</strong> {activity.user.firstname} {activity.user.lastname}</p>
            <p><strong>Status:</strong> {activity.status}</p>
            <p><strong>Prices:</strong></p>
            <ul>
                {activity.prices.map((price) => (
                    <li key={price.id}>
                        Amount: {price.amount}, Age Range: {price.age_range}
                    </li>
                ))}
            </ul>
            <button onClick={() => addToActivityList(activity.id)}>Ajouter à ma liste</button>
        </div>
    );
}

function addToActivityList(activityId) {
    // Logique pour ajouter l'activité à la liste de l'utilisateur
    console.log(`Ajouter l'activité ${activityId} à ma liste`);
}

export default Show;