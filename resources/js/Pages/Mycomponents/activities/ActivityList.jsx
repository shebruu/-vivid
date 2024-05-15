import React from "react";

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";

import Navbar2 from "../Navbar";
import "./styleactivitylist.css";

import VoteButtons from "./VoteButtons";

/**
 * Composant pour afficher la liste des activités pour un voyage sélectionné.
 * @param {Object} props - Propriétés du composant.
 * @param {Object} props.activities - Les activités classées par ID de voyage.
 * @param {number} props.selectedTripId - L'ID du voyage sélectionné.
 */
const ActivityList = ({ activities }) => {
    console.log("Activities to render:", activities);

    const [results, setResults] = useState({});

    if (activities.length === 0) {
        return <p>No activities added yet for this trip.</p>;
    }

    return (
        <div className="activities-container">
            <h2 className="activities-header">
                Activities for the selected trip:
            </h2>
            <ul className="activities-list">
                {activities.map((activity, index) => (
                    <li key={index} className="activity-card">
                        <div className="activity-info">
                            <h3 className="activity-name">
                                {activity.activity_name}
                            </h3>
                            <p className="activity-detail">
                                Created By: {activity.user_firstname}{" "}
                                {activity.user_lastname}
                            </p>
                            <p className="activity-detail">
                                Trip: {activity.trip_title}
                            </p>
                            <p className="activity-detail">
                                Start Date:{" "}
                                {new Date(
                                    activity.start_time
                                ).toLocaleDateString()}
                            </p>
                            <p className="activity-detail">
                                Duration: {activity.duration} hours
                            </p>
                            <p className="activity-detail">
                                Status: {activity.status}
                            </p>
                            <p className="activity-detail">
                                Location: {activity.place_title}
                            </p>
                            <p className="activity-detail">
                                Price:{" "}
                                {activity.price_amount
                                    ? `$${activity.price_amount}`
                                    : "Free"}
                            </p>
                        </div>
                        <VoteButtons activityId={activity.activity_id} />

                        <div>
                            <h1>Voting Results</h1>
                            {Object.entries(results).map(
                                ([status, percentage]) => (
                                    <div key={status}>
                                        <strong>{status.toUpperCase()}:</strong>{" "}
                                        {percentage}%
                                    </div>
                                )
                            )}
                        </div>
                    </li>
                ))}
            </ul>
        </div>
    );
};

export default ActivityList;
