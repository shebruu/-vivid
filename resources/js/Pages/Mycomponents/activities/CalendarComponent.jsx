import React, { useState, useEffect } from 'react';
import FullCalendar from '@fullcalendar/react';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import axios from 'axios';

const CalendarComponent = ({ tripId }) => {
    const [events, setEvents] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        //fetchRevisedActivities
        axios.get(`/trips/${tripId}/revised-activities`)
            .then(response => {
                console.log(response.data); 
                setEvents(response.data);
                setLoading(false);
            })
            .catch(error => {
                console.error('Error fetching activities:', error);
                setError(error);
                setLoading(false);
            });
    }, [tripId]);

    if (loading) return <p>Loading...</p>;
    if (error) return <p>Error loading activities!</p>;

    return (
        <div>
            <h2>Calendrier des Activités</h2>
            <FullCalendar
                plugins={[dayGridPlugin, interactionPlugin]}
                initialView="dayGridMonth"
                events={events}
                eventClick={(info) => {
                    info.jsEvent.preventDefault();
                    if (info.event.url) {
                        window.open(info.event.url, "_blank");
                    }
                }}
            />
        </div>
    );
};

export default CalendarComponent;
