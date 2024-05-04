
import React from 'react';

function ActivityShow({ activity }) {
    return (
        <div>
            <h1>{activity.activity}</h1>
            <p>Description: {activity.description}</p>
            <p>Price: {activity.price}</p>
            <p>Place: {activity.place.title}</p>
            <p>Locality: {activity.place.locality}</p>
        </div>
    );
}

export default ActivityShow;