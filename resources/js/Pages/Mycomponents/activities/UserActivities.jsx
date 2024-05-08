function UserActivities({ trip }) {
    // Utilisez les données du voyage de l'utilisateur ici
    return (
        <div>
            <p>Start Time: {trip.start_time}</p>
            <p>End Time: {trip.end_time}</p>
            {/* Autres détails du voyage */}
        </div>
    );
}

export default UserActivities;

