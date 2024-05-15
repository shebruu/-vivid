import React, { useState, useEffect } from "react";
import { Inertia } from "@inertiajs/inertia";
import DatePicker from "react-datepicker";
import "react-datepicker/dist/react-datepicker.css";
const BookingManager = ({
    userActivityId,
    bookedTimes,
    startDate,
    endDate,
}) => {
    // Convertir les chaînes de date en objets Date, si elles ne le sont pas déjà
    const start = new Date(startDate);
    const end = new Date(endDate);

    const [startTime, setStartTime] = useState(start);
    const [endTime, setEndTime] = useState(
        new Date(start.getTime() + 30 * 60000)
    ); // Définir endTime par défaut 30 minutes après startTime

    const handleBooking = () => {
        if (!startTime || !endTime) {
            alert("Please select both start and end times.");
            return;
        }
        if (endTime <= startTime) {
            alert("End time must be after start time.");
            return;
        }
        Inertia.post("/bookings", {
            user_activity_id: userActivityId,
            start_time: startTime,
            end_time: endTime,
        });
    };

    return (
        <div>
            <h3>Book a time slot</h3>
            <DatePicker
                selected={startTime}
                onChange={(date) => setStartTime(date)}
                showTimeSelect
                timeFormat="HH:mm"
                timeIntervals={30}
                dateFormat="MMMM d, yyyy h:mm aa"
                minDate={start}
                maxDate={end}
                className="form-control"
            />
            <DatePicker
                selected={endTime}
                onChange={(date) => setEndTime(date)}
                showTimeSelect
                timeFormat="HH:mm"
                timeIntervals={30}
                dateFormat="MMMM d, yyyy h:mm aa"
                minDate={startTime}
                maxDate={end}
                className="form-control"
            />
            <button onClick={handleBooking}>Book</button>
        </div>
    );
};

export default BookingManager;
