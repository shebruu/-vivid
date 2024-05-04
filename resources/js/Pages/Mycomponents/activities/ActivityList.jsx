import React from 'react';

function ActivityList({ activities }) {
    return (
        <div className="cards-container">
            {activities.map((activity) => (
                <div key={activity.id} className="card">
                    <h2>{activity.activity}</h2>
                    <p>Participants:</p>
                    <ul>
                        {activity.participants.map((participant) => (
                            <li key={participant.id}>{participant.firstname} {participant.lastname}</li>
                        ))}
                    </ul>
                    <p>Places:</p>
                    <ul>
                        {activity.places.map((place) => (
                            <li key={place.id}>{place.title}</li>
                        ))}
                    </ul>
                </div>
            ))}
        </div>
    );
}

export default ActivityList;