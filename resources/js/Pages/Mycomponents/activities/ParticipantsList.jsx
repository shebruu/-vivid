const ParticipantsList = ({ participants }) => (
    <ul>
           <h3> <strong>Participants : </strong> </h3>
        {participants.map(participant => (
            <li key={participant.id}>{participant.firstname} {participant.lastname}</li>
        ))}
    </ul>
);

export default ParticipantsList;
