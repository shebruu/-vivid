import React, { useState, useEffect } from "react";
import { Inertia } from '@inertiajs/inertia';

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import BookingManager from './BookingManager';
import "./style.css";

/**
 * Component for displaying user activities associated with trips, providing functionalities
 * for managing dates, activities, and trip details within an authenticated layout.
 *
 * @component
 */
function ShowUserActivity({
    activity,
    place,
    createdby,
    prices,
    placeImages,
    auth,
    trips,
    bookedTimes,
    tripId // Recevez le tripId directement depuis les props
}) {

    const placeId = place.id;

    // State for selected price and date/time
    const [selectedPrice, setSelectedPrice] = useState(prices[0]?.id || "");
    const [selectedDateTime, setSelectedDateTime] = useState(new Date());

    useEffect(() => {
        if (tripId) {
            const selectedTrip = trips.find(trip => trip.id === tripId);
            if (selectedTrip && isValidDate(selectedTrip.departure)) {
                setSelectedDateTime(new Date(selectedTrip.departure));
            }
        }
    }, [tripId, trips]);

    // Validate if a date string is a valid date
    const isValidDate = (dateStr) => {
        const date = new Date(dateStr);
        return !isNaN(date.getTime());
    };

    /**
     * Adds an activity to the list for the specific trip.
     */
    const addToActivityList = (activityId, tripId, selectedPrice, selectedDateTime, placeId) => {
        console.log("Adding activity:", activityId, "to trip:", tripId, "at place:", placeId);

        // Envoi de la requête pour ajouter l'activité au voyage
        Inertia.post(route('itinerarie.addlist'), {
            activityId,
            tripId,
            selectedPrice,
            selectedDateTime: selectedDateTime.toISOString(),
            placeId
        });
    };


    console.log("showSidebar in ShowUserActivity:", true);

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Itinéraires</h2>}
            showSidebar={true} 
     
     >
            <div className="activity-details-container">
                <header className="activity-header">
                    <h1>{activity.activity}</h1>
                </header>

                {/* Section des images */}
                <section className="place-images-section">
                    <div className="place-images">
                        {placeImages.map((src, index) => (
                            <img key={index} src={src} alt={`Image ${index + 1}`} className="place-image" />
                        ))}
                    </div>
                </section>

                {/* Informations du lieu */}
                <section className="place-section">
                    <h2>Informations sur le lieu</h2>
                    <p><strong>Title:</strong> {place.title}</p>
                    <p><strong>Description:</strong> {place.description}</p>
                    <p><strong>Adresse:</strong> {place.adress} {place.postal_code}</p>
                </section>

                {/* Sélection du prix */}
                <section className="price">
                    <h2>Sélectionnez le prix</h2>
                    <select value={selectedPrice} onChange={(e) => setSelectedPrice(e.target.value)} className="price-select">
                        {prices.map((price) => (
                            <option key={price.id} value={price.id}>
                                {`${price.age_rang} - ${price.amount} $`}
                            </option>
                        ))}
                    </select>
                </section>

                {/* Manager des réservations */}
                <BookingManager
                    userActivityId={tripId}
                    bookedTimes={bookedTimes}
                    startDate={selectedDateTime}
                    endDate={selectedDateTime}
                />

                {/* Bouton pour ajouter l'activité à la liste */}
                <div className="actions">
                    <button
                        className="add-to-list-btn"
                        onClick={() => addToActivityList(activity.id, tripId, selectedPrice, selectedDateTime, placeId)}
                    >
                        Ajouter à ma liste
                    </button>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}

export default ShowUserActivity;
