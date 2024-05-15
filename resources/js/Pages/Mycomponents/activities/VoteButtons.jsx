
import React, { useState, useEffect } from 'react';

import { Inertia } from '@inertiajs/inertia';

function VoteButtons({ activityId }) {
    const [hasVoted, setHasVoted] = useState(() => {
        return localStorage.getItem(`voted_${activityId}`) === 'true';
    });
       
     
    useEffect(() => {
        console.log(`Initial vote state for activity ${activityId}:`, hasVoted);
    }, []);

    const handleVote = (voteType) => {
        console.log("Voting", voteType, "for activity", activityId);
        Inertia.post(route('activities.vote', { activity: activityId }), { vote: voteType })
        .then(() => {
            console.log("Vote success");
            setHasVoted(true);
            localStorage.setItem(`voted_${activityId}`, 'true');
        })
        .catch(error => {
            console.error("Error voting:", error);
        });
    };


    console.log("Button render state:", hasVoted); 

    if (hasVoted) {
        return <p>Thank you for voting!</p>;
    }
    

   
    return (
        <div className="activity-actions">
            <button onClick={() => handleVote( 'yes')} className="vote-button yes">Yes</button>
            <button onClick={() => handleVote( 'no')} className="vote-button no">No</button>
        </div>
    );
}

export default VoteButtons; 
