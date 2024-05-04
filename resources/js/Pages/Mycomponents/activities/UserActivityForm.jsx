import React, { useState } from 'react';
import { useForm, usePage } from '@inertiajs/react';


export default function UserActivityForm() {
    // Retrieve activities passed from the controller via Inertia.js
    const { activities } = usePage().props;

    console.log(activities);



    if (!activities || activities.length === 0) {
        return <div>No activities available</div>; // Message lorsque aucune donnée n'est disponible
    }

    // Initialize form state
    const { data, setData, post, errors } = useForm({
        activity_id: '',
        // Other form data
    });

    // Form submit handler
    const handleSubmit = (e) => {
        e.preventDefault();
        post('/useractivity/store'); // Adjust based on your routing
    };

    return (
        <form onSubmit={handleSubmit}>
        <label htmlFor="activity_id">Select Existing Realized Activity:</label>
        <select
            id="activity_id"
            name="activity_id"
            value={data.activity_id}
            onChange={(e) => setData('activity_id', e.target.value)}
        >
            <option value="">-- Select Activity --</option>

            {activities.map((activity) => (
                <option key={activity.id} value={activity.id}>
                    {activity.activity} 
                </option>
            ))}
        </select>
        {errors.activity_id && <div>{errors.activity_id}</div>}


        <button type="submit">Submit</button>
    </form>
);
}