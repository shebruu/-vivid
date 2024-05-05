import React, { useState } from 'react';
import { Link } from '@inertiajs/inertia-react';

import Navbar2 from '../Navbar2';
import './style.css'; 

function Show({ trip, auth }) {
   
    const [tripDetails, setTripDetails] = useState({
        title: trip.title || '',
        departure: trip.departure || '',
        arrival: trip.arrival || '',
        totalestimation: trip.totalestimation || '',
        note: trip.note || ''
    });
    const [isEditing, setIsEditing] = useState(false);

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        setTripDetails({
            ...tripDetails,
            [name]: value
        });
    };

    const toggleEditing = () => setIsEditing(!isEditing);

    const handleSave = () => {
       
        Inertia.put(route('trip.update', { trip: trip.id }), tripDetails);
        setIsEditing(false);
    };

    return (
        <div>
            <Navbar2 auth={auth} />
            <div className="container">
                <h1 className="title">Détails du voyage</h1>
                <div className="card trip-details">
                    <div>
                        <h2>Titre du voyage:</h2>
                        {isEditing ? (
                            <input
                                type="text"
                                name="title"
                                value={tripDetails.title}
                                onChange={handleInputChange}
                            />
                        ) : (
                            <p>{tripDetails.title}</p>
                        )}
                    </div>
                    <div>
                        <h2>Départ:</h2>
                        {isEditing ? (
                            <input
                                type="date"
                                name="departure"
                                value={tripDetails.departure}
                                onChange={handleInputChange}
                            />
                        ) : (
                            <p>{tripDetails.departure}</p>
                        )}
                    </div>
                    <div>
                        <h2>Arrivée:</h2>
                        {isEditing ? (
                            <input
                                type="date"
                                name="arrival"
                                value={tripDetails.arrival}
                                onChange={handleInputChange}
                            />
                        ) : (
                            <p>{tripDetails.arrival}</p>
                        )}
                    </div>
                    <div>
                        <h2>Estimation totale:</h2>
                        {isEditing ? (
                            <input
                                type="text"
                                name="totalestimation"
                                value={tripDetails.totalestimation}
                                onChange={handleInputChange}
                            />
                        ) : (
                            <p>{tripDetails.totalestimation}</p>
                        )}
                    </div>
                    <div>
                        <h2>Note:</h2>
                        {isEditing ? (
                            <input
                                type="text"
                                name="note"
                                value={tripDetails.note}
                                onChange={handleInputChange}
                            />
                        ) : (
                            <p>{tripDetails.note}</p>
                        )}
                    </div>
                    <div>
                        <h2>Créé par:</h2>
                        <p>{trip.created_by}</p>
                    </div>
                    <div>
                        {isEditing ? (
                            <button type="button" onClick={handleSave} className="btn-primary">
                                Enregistrer les modifications
                            </button>
                        ) : (
                            <button type="button" onClick={toggleEditing} className="btn-primary">
                                Modifier les informations
                            </button>
                        )}
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Show;