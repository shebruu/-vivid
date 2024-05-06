import React, { useState } from 'react';
import { Link } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';
import Navbar2 from '../Navbar';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import './style.css'; 

function Show({ errors, trip, auth }) {
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
        // Verify that `trip.id` is available and correctly passed to the route
        console.log("Trip ID:", trip.id);

        // Update the trip using the specified ID
        Inertia.put(route('trip.update', { trip: trip.id }), tripDetails);
        setIsEditing(false);
    };


    const [newMemberLogin, setNewMemberLogin] = useState({
        login: '',
        user_activities: ''
    });

    return (

        <AuthenticatedLayout
        user={auth.user}
        header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Itinéraires</h2>}
    >
        <div>
         
            <div className="container">
                <h1 className="title">Détails du voyage : {trip.title}</h1>

                {/* Error Messages Section */}
                {Object.keys(errors).length > 0 && (
                    <div className="error-messages">
                        <ul>
                            {Object.keys(errors).map((key) => (
                                <li key={key}>{errors[key]}</li>
                            ))}
                        </ul>
                    </div>
                )}

                {/* Trip Details */}
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
        </AuthenticatedLayout>
    );
}

export default Show;