import React, { useState, useEffect } from 'react';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import Navbar2 from "../Navbar";
import "./Sondage.css";
import VoteButtons from "./VoteButtons";
import VoteResults from "./VoteResult"; 
import VotesChart from './VoteChart';
import ParticipantsList from './ParticipantsList';

/**
 * Composant pour afficher la liste des activités pour un voyage sélectionné.
 * @param {Object} props - Propriétés du composant.
 * @param {Object} props.activities - Les activités classées par ID de voyage.
 * @param {number} props.selectedTripId - L'ID du voyage sélectionné.
 */
const ActivityList = ({ activities, selectedTripId, selectedTripTitle, participants, auth, isCreator }) => {
    const [votedActivities, setVotedActivities] = useState({});

    useEffect(() => {
        const initialVotes = activities.reduce((acc, activity) => {
            if (Array.isArray(activity.votes)) {
                acc[activity.activity_id] = activity.votes.some(vote => vote.user_id === auth.user.id);
            } else {
                acc[activity.activity_id] = false;
            }
            return acc;
        }, {});
        setVotedActivities(initialVotes);
        console.log('Initial votes:', initialVotes);
    }, [activities, auth.user.id]);

    const handleVote = (activityId) => {
        setVotedActivities(prevState => ({
            ...prevState,
            [activityId]: true
        }));
        console.log(`Voted for activity ID: ${activityId}`);
    };

    if (activities.length === 0) {
        return <p>No activities added yet for this trip.</p>;
    }

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Activities for the trip: {selectedTripTitle}</h2>}
            tripId={selectedTripId}
            showSidebar={true}
            isCreator={isCreator}
        >
            <div className="activities-container">
                <ParticipantsList participants={participants} />
                <ul className="activities-list">
                    {activities.map((activity, index) => {
                        const hasVoted = votedActivities[activity.activity_id];
                        console.log(`Activity ID: ${activity.activity_id}, Has Voted: ${hasVoted}`);

                        return (
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
                                        {new Date(activity.start_time).toLocaleDateString()}
                                    </p>
                                    <p className="activity-detail">
                                        Duration: {activity.duration} hours
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

                                {!hasVoted ? (
                                    <VoteButtons
                                        activityId={activity.activity_id}
                                        onVote={() => handleVote(activity.activity_id)}
                                    />
                                ) : (
                                    <p>You have already voted.</p>
                                )}
                                
                                <VotesChart votes={activity.votes} totalParticipants={participants.length} />
                            </li>
                        );
                    })}
                </ul>
            </div>
        </AuthenticatedLayout>
    );
};

export default ActivityList;
