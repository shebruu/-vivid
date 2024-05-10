import React from 'react';

const ActivityList = ({ activities,selectedTripId  }) => {
    console.log('Activities to render:', activities);

    
    // Extraire les activités pour le voyage sélectionné
    const activitiesForTrip = activities[selectedTripId] || [];

    if (activities.length === 0) {
        return <p>No activities added yet.</p>;
    }

    return (
        <ul>
            {activitiesForTrip.map((activityId, index) => (
                <li key={index}>Activity ID: {activityId}</li>
            ))}
        </ul>
    );
};

export default ActivityList;