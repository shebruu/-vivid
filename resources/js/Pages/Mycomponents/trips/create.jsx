import React, { useState } from 'react';

import { Inertia } from '@inertiajs/inertia';
import Navbar2 from '../Navbar';
import './style.css'; 



const Create = ({ onSubmit, errors, auth }) => {
    const [formData, setFormData] = useState({
        title: '',
        departure: '',
        arrival: '',
        totalestimation: '',
     
    });

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData({
            ...formData,
            [name]: value
        });
    };
    const handleSubmit = (e,formData) => {
        e.preventDefault();
        onSubmit(e, formData); // Soumettre les données du formulaire à la fonction onSubmit
    };

    return (

<div>  
<Navbar2 auth={auth} />


<div className="container">
                <div className="title">Créer un nouveau voyage</div>
                <div className="card">
        <form onSubmit={(e) => onSubmit(e, formData)}>
            
            {/* Champ Titre */}
            <div>
                <label htmlFor="title">Titre du Voyage</label>
                <input id="title" type="text" name="title" value={formData.title} onChange={handleChange} />
                {errors.title && <span>{errors.title}</span>}
            </div>

            {/* Champ Date de Départ */}
            <div>
                <label htmlFor="departure">Date de Départ</label>
                <input id="departure" type="date" name="departure" value={formData.departure} onChange={handleChange} />
                {errors.departure && <span>{errors.departure}</span>}
            </div>

            {/* Champ Date d'Arrivée */}
            <div>
                <label htmlFor="arrival">Date d'Arrivée</label>
                <input id="arrival" type="date" name="arrival" value={formData.arrival} onChange={handleChange} />
                {errors.arrival && <span>{errors.arrival}</span>}
            </div>

            {/* Champ Estimation Totale */}
            <div>
                <label htmlFor="totalestimation">Estimation Totale</label>
                <input id="totalestimation" type="number" name="totalestimation" value={formData.totalestimation} onChange={handleChange} />
                {errors.totalestimation && <span>{errors.totalestimation}</span>}
            </div>

            {/* Champ Note */}
            

            {/* Bouton de Soumission */}
            <div>
                <button type="submit">Créer Voyage</button>
            </div>
        </form>
        </div>
     
        </div>
            </div>
       
    );
};

export default Create;