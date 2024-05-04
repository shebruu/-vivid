import React from 'react';

function Activityindex({ activity }) {
    return (
        <div className="card">
            <h2>{activity.activity}</h2>
            <p>Place: {activity.place.title}</p> 
            <p>Locality: {activity.place.locality}</p> 
            <a href={`/activities/${activity.id}`}>View Details</a>
        </div>
    );
}

export default Activityindex;