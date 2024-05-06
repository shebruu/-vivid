import React, { useState } from 'react';
import { Inertia } from '@inertiajs/inertia';
import Navbar2 from '../Navbar';
import './style.css';

function Edit({ trip, auth }) {
    const [tripDetails, setTripDetails] = useState(trip);

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        setTripDetails({
            ...tripDetails,
            [name]: value
        });
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        // Update the trip through an API or Inertia request
        Inertia.post(route('trip.update', { trip: trip.id }), {
            ...tripDetails,
            _method: 'PUT' // to trigger a PUT request
        });
    };

    return (
        <div className="container">
            <Navbar2 auth={auth} />
            <h1 className="text-3xl font-bold mb-4">Modifier le voyage</h1>
            <form onSubmit={handleSubmit} className="trip-form">
                <div>
                    <label>Titre du voyage:</label>
                    <input
                        type="text"
                        name="title"
                        value={tripDetails.title}
                        onChange={handleInputChange}
                    />
                </div>
                <div>
                    <label>Départ:</label>
                    <input
                        type="date"
                        name="departure"
                        value={tripDetails.departure}
                        onChange={handleInputChange}
                    />
                </div>
                <div>
                    <label>Arrivée:</label>
                    <input
                        type="date"
                        name="arrival"
                        value={tripDetails.arrival}
                        onChange={handleInputChange}
                    />
                </div>
                <div>
                    <label>Estimation totale:</label>
                    <input
                        type="text"
                        name="totalestimation"
                        value={tripDetails.totalestimation}
                        onChange={handleInputChange}
                    />
                </div>
                <div>
                    <label>Note:</label>
                    <input
                        type="text"
                        name="note"
                        value={tripDetails.note}
                        onChange={handleInputChange}
                    />
                </div>
                <button type="submit" className="btn-save-trip">Enregistrer</button>
            </form>
        </div>
    );
}

export default Edit;