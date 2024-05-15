import React, { useState, useEffect } from "react";
import { Inertia } from "@inertiajs/inertia";
import Navbar2 from "../Navbar";

import "./style.css";

const initialFormData = {
    activity: "",
    duration: "",
    adress: "",
    postal_code: "",
    start_time: "",
    amount: "",
    age_range: "",
    season: "",
};

const Create = ({ auth }) => {
    const [formData, setFormData] = useState(initialFormData);

    // récupérer les données stockées 
    useEffect(() => {

        const storedFormData = JSON.parse(localStorage.getItem("formData"));
        if (storedFormData) {
            setFormData(storedFormData);
        }
    }, []);
    //non submission ou rechargement de page 
    //Écouteur pour les changements de formData pour mise à jour du localStorage

    useEffect(() => {
        localStorage.setItem("formData", JSON.stringify(formData));
    }, [formData]);



    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData((prevFormData) => ({
            ...prevFormData,
            [name]: value,
        }));

    };

    const handleSubmit = (e) => {
        console.log("Tentative de soumission du formulaire");
        e.preventDefault();
        console.log('Envoi des données :', formData);

        Inertia.post(route("user_activity.store"), formData)

            .then(response => {
                console.log('URL:', route("user_activity.store"));
                console.log(Inertia.post);
                console.log('Réponse reçue:', response);
                // statut de réponse
                if (response.props.success) {
                    // Si la requête est un succès, supprimez les données stockées
                    localStorage.removeItem("formData");
                    alert('Activité ajoutée avec succès!');
                } else {
                    // sinon erreur 
                    alert('Une erreur s\'est produite lors de la validation.');
                }
            })
            .catch(error => {
                // gestion d'  erreurs de requête 
                console.error('Erreur de requête:', error);
                alert('Erreur lors de l\'ajout de l\'activité. Veuillez réessayer.');
            });
    };

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
                                name="activity"
                                value={formData.activity}
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
                                id="adress"
                                type="text"
                                name="adress"
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