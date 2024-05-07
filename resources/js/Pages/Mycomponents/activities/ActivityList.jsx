import React from 'react';

const ActivityList = ({ activities }) => {
    console.log('Activities to render:', activities);
    if (activities.length === 0) {
        return <p>No activities added yet.</p>;
    }

    return (
        <ul>
            {activities.map((activityId, index) => (
                <li key={index}>Activity ID: {activityId}</li>
            ))}
        </ul>
    );
};

export default ActivityList;