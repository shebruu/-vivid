// resources/js/Pages/Mycomponents/activities/ActivitiesList.jsx

import React from 'react';

function UserActivityList({ activities }) {
    return (
        <div className="cards-container">
            {activities.map((activity) => (
                <div key={activity.id} className="card">
                    <h2>{activity.activity.activity}</h2>
                    <p>Place: {activity.place.title}</p>
                    <p>Created by: {activity.user.firstname} {activity.user.lastname}</p>
                    <p>Status: {activity.status}</p>
                   
                </div>
            ))}
        </div>
    );
}
export default UserActivityList;
