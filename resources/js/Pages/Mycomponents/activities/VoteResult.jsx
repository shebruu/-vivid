import React, { useState, useEffect } from 'react';
import { Inertia } from '@inertiajs/inertia';

const VoteResults = ({ userActivityId, tripId }) => { 
    const [votes, setVotes] = useState({ yes: 0, no: 0, total: 0 });

   

    useEffect(() => {
        const fetchVotes = () => {
            fetch(`/votes/${userActivityId}/${tripId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
                .then(data => {
                    setVotes({
                        yes: data.yes_votes || 0,
                        no: data.no_votes || 0,
                        total: data.total_votes || 0
                    });
                })
                .catch(error => console.error('Error fetching votes:', error));
                setVotes({ yes: 0, no: 0, total: 0 }); 
        };
    
        fetchVotes();
        const interval = setInterval(fetchVotes, 5000); 
        return () => clearInterval(interval); 
    }, [userActivityId, tripId]); 

    if (!votes || votes.total === 0) {
        return <p>Aucun vote pour le moment.</p>;
    }
    

    return (
        <div>
           <p>Yes Votes: {votes.yes}</p>
           <p>No Votes: {votes.no}</p>
           <p>Total Votes: {votes.total}</p>
        </div>
    );
};

export default VoteResults;
