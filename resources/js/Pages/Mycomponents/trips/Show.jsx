import React, { useState } from "react";
import { Link } from "@inertiajs/inertia-react";
import { Inertia } from "@inertiajs/inertia";
import Navbar2 from "../Navbar";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import "./style.css";

function Show({ errors, trip, auth }) {
    const [formData, setFormData] = useState({
        title: trip.title || "",
        departure: trip.departure || "",
        arrival: trip.arrival || "",
        totalestimation: trip.totalestimation || "",
        note: trip.note || "",
    });

    const [isEditing, setIsEditing] = useState(false);

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData({
            ...formData,
            [name]: value,
        });
    };

    //mode show, edit
    const toggleEditing = () => setIsEditing(!isEditing);

    const handleSubmit = () => {
        console.log("Trip ID:", trip.id);

        Inertia.put(route("trip.update", { trip: trip.id }), formData);
        setIsEditing(false);
    };

    const [newMemberLogin, setNewMemberLogin] = useState({
        login: "",
        user_activities: "",
    });

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Itinéraires
                </h2>
            }
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
                                    value={formData.title}
                                    onChange={handleChange}
                                />
                            ) : (
                                <p>{formData.title}</p>
                            )}
                        </div>
                        <div>
                            <h2>Départ:</h2>
                            {isEditing ? (
                                <input
                                    type="date"
                                    name="departure"
                                    value={formData.departure}
                                    onChange={handleChange}
                                />
                            ) : (
                                <p>{formData.departure}</p>
                            )}
                        </div>
                        <div>
                            <h2>Arrivée:</h2>
                            {isEditing ? (
                                <input
                                    type="date"
                                    name="arrival"
                                    value={formData.arrival}
                                    onChange={handleChange}
                                />
                            ) : (
                                <p>{formData.arrival}</p>
                            )}
                        </div>
                        <div>
                            <h2>Estimation totale:</h2>
                            {isEditing ? (
                                <input
                                    type="text"
                                    name="totalestimation"
                                    value={formData.totalestimation}
                                    onChange={handleChange}
                                />
                            ) : (
                                <p>{formData.totalestimation}</p>
                            )}
                        </div>
                        <div>
                            <h2>Note:</h2>
                            {isEditing ? (
                                <input
                                    type="text"
                                    name="note"
                                    value={formData.note}
                                    onChange={handleChange}
                                />
                            ) : (
                                <p>{formData.note}</p>
                            )}
                        </div>
                        <div>
                            <h2>Créé par:</h2>
                            <p>{trip.created_by}</p>
                        </div>
                        <div>
                            {isEditing ? (
                                <button
                                    className="form-submit"
                                    type="button"
                                    onClick={handleSubmit}
                                >
                                    Enregistrer les modifications
                                </button>
                            ) : (
                                <button
                                    className="form-submit"
                                    type="button"
                                    onClick={toggleEditing}
                                >
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
