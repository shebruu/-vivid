import React, { useState, useEffect  } from "react";
import { Inertia } from "@inertiajs/inertia";
import Navbar2 from "../Navbar";
import "./style.css";

const initialFormData = {
    activity_title: "",
    duration: "",
    address: "",
    postal_code: "",
    start_time: "",
    amount: "",
    age_range: "",
    season: "",
};

const Create = ({ auth }) => {
    const [formData, setFormData] = useState(initialFormData);


    useEffect(() => {
        // Récupérer les données du formulaire depuis le stockage local
        const storedFormData = JSON.parse(localStorage.getItem("formData"));
        if (storedFormData) {
            setFormData(storedFormData);
        }
    }, []);


    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData((prevFormData) => ({
            ...prevFormData,
            [name]: value,
        }));
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        Inertia.post(route("user_activity.store"), formData);
    };

    useEffect(() => {
        // Sauvegarder les données du formulaire dans le stockage local à chaque modification
        localStorage.setItem("formData", JSON.stringify(formData));
    }, [formData]); // Exécuter chaque fois que formData change

    return (
        <div>
            <Navbar2 auth={auth} />

            <div className="create-form">
            <div className="container">
                <div className="title">Créer une nouvelle activité</div>
                <div className="card">
                    <form onSubmit={handleSubmit}>
                        <FormField
                            label="Titre de l'activité"
                            id="title"
                            type="text"
                            name="activity_title"
                            value={formData.activity_title}
                            onChange={handleChange}
                        />
                        <FormField
                            label="Durée estimée (heure)"
                            id="duration"
                            type="number"
                            name="duration"
                            value={formData.duration}
                            onChange={handleChange}
                        />
                        <FormField
                            label="Adresse"
                            id="address"
                            type="text"
                            name="address"
                            value={formData.address}
                            onChange={handleChange}
                        />
                        <FormField
                            label="Code postal"
                            id="postal_code"
                             type="text"
                            name="postal_code"
                            value={formData.postal_code}
                            onChange={handleChange}
                        />
                        <FormField
                            label="Date et heure de départ"
                            id="start_time"
                            type="datetime-local"
                            name="start_time"
                            value={formData.start_time}
                            onChange={handleChange}
                        />
                        <FormField
                            label="Prix"
                            id="amount"
                            type="number"
                            name="amount"
                            value={formData.amount}
                            onChange={handleChange}
                        />
                        <div className="form-group">
                            <label htmlFor="age_range">Choisissez une tranche d'âge :</label>
                            <select id="age_range" name="age_range" value={formData.age_range} onChange={handleChange}>
                                <option value="adulte">Adulte</option>
                                <option value="enfant">Enfant</option>
                                <option value="étudiant">Étudiant</option>
                            </select>
                        </div>
                        <div className="form-group">
                            <label htmlFor="season">Choisissez une saison :</label>
                            <select id="season" name="season" value={formData.season} onChange={handleChange}>
                                <option value="winter">Winter</option>
                                <option value="summer">Summer</option>
                            </select>
                        </div>
                        <div className="button-container">
                                <button className="form-submit" type="submit">
                                    Enregistrer   
                                </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    );
};

// Composant réutilisable pour les champs de formulaire
const FormField = ({ label, id, type, name, value, onChange }) => {
    return (
        <div className="form-group">
            <label htmlFor={id}>{label}</label>
            <input
                id={id}
                type={type}
                name={name}
                value={value}
                onChange={onChange}
            />
        </div>
    );
};

export default Create;