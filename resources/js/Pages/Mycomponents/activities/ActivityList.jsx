import React from 'react';

/**
 * Composant pour afficher la liste des activités pour un voyage sélectionné.
 * @param {Object} props - Propriétés du composant.
 * @param {Object} props.activities - Les activités classées par ID de voyage.
 * @param {number} props.selectedTripId - L'ID du voyage sélectionné.
 */
const ActivityList = ({ activities, selectedTripId }) => {
    console.log('Activities to render:', activities);

    // Extraire les activités pour le voyage sélectionné
    const activitiesForTrip = activities[selectedTripId] || [];

    if (activitiesForTrip.length === 0) {
        return <p>No activities added yet for this trip.</p>;
    }

    return (
        <div>
            <h2>Activities for the selected trip:</h2>
            <ul>
                {activitiesForTrip.map((activityId, index) => (
                    <li key={index}>Activity ID: {activityId}</li>
                ))}
            </ul>
        </div>
    );
};

export default ActivityList;
