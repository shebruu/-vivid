import React, { useState } from "react";

import { Inertia } from "@inertiajs/inertia";
import Navbar2 from "../Navbar";
import "./style.css";

import Swal from 'sweetalert2';

const initialFormData = {
    title: "",
    departure: "",
    arrival: "",
    totalestimation: "",
};

const Create = ({ auth, errors }) => {
    const [formData, setFormData] = useState(initialFormData);

    
    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData((prevFormData) => ({
            ...prevFormData,
            [name]: value,
        }));
    };
    const handleSubmit = (e) => {
        e.preventDefault();

        // console.log('FormData:', formData);

        Inertia.post(route('trip.store'), formData, {
            onSuccess: (page) => {
                if (page.props.flash.success) {
                    Swal.fire({
                        title: 'Succès',
                        text: page.props.flash.success,
                        icon: 'success',
                        confirmButtonText: 'OK',
                    });
                }
            },
        });
    };
    return (
        <div>
          

            <div className="container">
                <div className="title">Créer un nouveau voyage</div>
                <div className="card">
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
                    <form onSubmit={handleSubmit}>
                        {/* Champ Titre */}
                        <div>
                            <label htmlFor="title">Titre du Voyage</label>
                            <input
                                id="title"
                                type="text"
                                name="title"
                                value={formData.title}
                                onChange={handleChange}
                            />
                        </div>

                        {/* Champ Date de Départ */}
                        <div>
                            <label htmlFor="departure">Date de Départ</label>
                            <input
                                id="departure"
                                type="date"
                                name="departure"
                                value={formData.departure}
                                onChange={handleChange}
                            />
                        </div>

                        {/* Champ Date d'Arrivée */}
                        <div>
                            <label htmlFor="arrival">Date d'Arrivée</label>
                            <input
                                id="arrival"
                                type="date"
                                name="arrival"
                                value={formData.arrival}
                                onChange={handleChange}
                            />
                        </div>

                        {/* Champ Estimation Totale */}
                        <div>
                            <label htmlFor="totalestimation">
                                Estimation Totale
                            </label>
                            <input
                                id="totalestimation"
                                type="number"
                                name="totalestimation"
                                value={formData.totalestimation}
                                onChange={handleChange}
                            />
                        </div>

                        {/* Champ Note */}

                        {/* Bouton de Soumission */}
                        <div>
                            <button className="form-submit" type="submit">
                                Créer Voyage
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    );
};

export default Create;
