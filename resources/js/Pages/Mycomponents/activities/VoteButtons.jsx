import React from 'react';
import "./Sondage.css";

const VoteButtons = ({ activityId, onVote }) => {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const handleVote = (voteType) => {
        console.log(`Voting ${voteType} for activity ID: ${activityId}`);
        fetch(`/activities/${activityId}/vote`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken, // Ajouter le jeton CSRF
            },
            body: JSON.stringify({ vote: voteType }),
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    console.log('Vote successful:', data);
                    onVote(); // Appeler onVote après un vote réussi
                } else {
                    console.error('Vote failed:', data);
                }
            })
            .catch(error => console.error('Error:', error));
    };

    return (
        <div className="vote-buttons">
            <button className="vote-button" onClick={() => handleVote('yes')}>Yes</button>
            <button className="vote-button" onClick={() => handleVote('no')}>No</button>
        </div>
    );
};

export default VoteButtons;