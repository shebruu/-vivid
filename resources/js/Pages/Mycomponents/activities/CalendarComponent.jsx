import React, { useState, useEffect } from 'react';
import FullCalendar from '@fullcalendar/react';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import axios from 'axios';

const CalendarComponent = ({ tripId }) => {
    const [events, setEvents] = useState([]);

    useEffect(() => {
        axios.get(`/trips/${tripId}/revised-activities`)
            .then(response => {
                console.log(response.data); 
                setEvents(response.data);
            })
            .catch(error => {
                console.error('Error fetching activities:', error);
            });
    }, [tripId]);

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
