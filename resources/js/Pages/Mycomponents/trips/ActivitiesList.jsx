const ActivitiesList = ({ trip, activities }) => {
    return (
        <div>
            <h1>Activities for {trip.title}</h1>
            <ul>
                {activities.map(activity => (
                    <li key={activity.id}>{activity.name}</li>  
                ))}
            </ul>
        </div>
    );
};

export default ActivitiesList;