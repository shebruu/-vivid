import React, { useState, useEffect } from "react";
import Navbar2 from "../Navbar";
import "./style.css";
import ActivityList from "./ActivityList";

import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
//import route from 'ziggy-js';
import BookingManager from './BookingManager';

<link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@300;400&display=swap"
    rel="stylesheet"
></link>;

/**
 * Validates if the provided date string represents a valid date.
 * @param {string} dateStr - The date string to validate.
 * @returns {boolean} True if the date is valid, false otherwise.
 */
const isValidDate = (dateStr) => {
    const date = new Date(dateStr);
    return !isNaN(date.getTime());
};

/**
 * Component for displaying user activities associated with trips, providing functionalities
 * for managing dates, activities, and trip details within an authenticated layout.
 *
 * @component
 * @param {Object} props - Component props
 * @param {Object} props.activity - Details about the activity.
 * @param {Object} props.place - Details about the place of the activity.
 * @param {Object} props.createdby - Information about the creator of the activity.
 * @param {Array} props.prices - Pricing options available for the activity.
 * @param {Array} props.placeImages - URLs of images for the place.
 * @param {Object} props.auth - Authentication details, including user information.
 * @param {Array} props.trips - List of available trips.
 */
function ShowUserActivity({
    activity,
    place,
    createdby,
    prices,
    placeImages,
    auth,
    trips,
    bookedTimes
}) {

    const placeId = place.id;
    if (!bookedTimes) {
        console.error('bookedTimes is undefined or not passed correctly.');
        bookedTimes = []; // Définir une valeur par défaut si nécessaire
    }
    // // State hooks to manage various aspects of the component.
    const [activitiesByTrip, setActivitiesByTrip] = useState({});

    const [selectedTrip, setSelectedTrip] = useState(trips[0] || {});

    const [selectedPrice, setSelectedPrice] = useState(prices[0]?.id || "");

    const [selectedDateTime, setSelectedDateTime] = useState(
        new Date(trips[0]?.departure || Date.now())
    );

    /**
     * useEffect to update selectedDateTime based on the selectedTrip changes.
     */
    useEffect(() => {
        if (
            selectedTrip &&
            isValidDate(selectedTrip.departure) &&
            isValidDate(selectedTrip.arrival)
        ) {
            setSelectedDateTime(new Date(selectedTrip.departure)); // Assurez-vous que cette date est également valide
        }
    }, [selectedTrip]);

    console.log(
        "Selected Trip Dates:",
        selectedTrip.departure,
        selectedTrip.arrival
    );
    console.log(
        "Valid Dates:",
        isValidDate(selectedTrip.departure),
        isValidDate(selectedTrip.arrival)
    );

    /**
     * Handles changes to the trip selection, updating the selectedTrip state.
     * @param {Event} e - The event object from the select element.
     */
    const handleTripChange = (e) => {
        const tripId = e.target.value;
        const trip = trips.find((t) => t.id.toString() === tripId);
        setSelectedTrip(trip);
    };
    console.log(selectedTrip);

    /**
     * Adds an activity to a list for a specific trip. Updates the state to include new activities.
     * @param {number} activityId - The ID of the activity to add.
     * @param {number} tripId - The ID of the trip associated with the activity.
     */
    const addToActivityList = (activityId, tripId, selectedPrice, selectedDateTime, placeId) => {
        console.log(
            "Attempting to add activity:",
            activityId,
            " To trip :",
            tripId,
            "at place:", placeId
        );

        // Envoi de la demande au backend pour ajouter l'activité au statut "proposé"
        Inertia.post(route('itinerarie.addlist'), {

            activityId: activityId,
            tripId: tripId,
            selectedPrice: selectedPrice,
            selectedDateTime: selectedDateTime.toISOString(),
            placeId: placeId,

        }).then(response => {
            console.log('Success:', response);
        }).catch(error => {
            console.error('Error:', error);
        });

    };

    /**
     * useEffect to load activities from local storage when the component mounts.
     */
    useEffect(() => {
        const savedActivities = JSON.parse(
            localStorage.getItem("activitiesByTrip")
        );
        if (savedActivities) {
            setActivitiesByTrip(savedActivities);
        }
    }, []);

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
                <div className="activity-details-container">
                    <header className="activity-header">
                        <h1>{activity.activity}</h1>
                    </header>

                    {/* Place Images Section */}
                    <section className="place-images-section">
                        <div className="place-images">
                            {placeImages.map((src, index) => (
                                <img
                                    key={index}
                                    src={src}
                                    alt={`Image ${index + 1}`}
                                    className="place-image"
                                />
                            ))}
                        </div>
                    </section>

                    {/* Place Details Section */}
                    <section className="place-section">
                        <h2>Place Information</h2>
                        <p>
                            <strong>google Title:</strong> {place.title}
                        </p>
                        <br />
                        <p>
                            <strong>Description:</strong> {place.description}
                        </p>
                        <br />
                        <p>
                            <strong>Address:</strong> {place.adress} {place.postal_code}

                        </p>
                    </section>





                    {/* Price Selection */}
                    <section className="price">
                        <h2>Select Price</h2>
                        <select
                            value={selectedPrice}
                            onChange={(e) => setSelectedPrice(e.target.value)}
                            className="price-select"
                        >
                            {place.prices.map((price) => (
                                <option key={price.id} value={price.id}>
                                    {`${price.age_rang} - ${price.amount} $`}
                                </option>
                            ))}
                        </select>
                    </section>
                    <section className="trip-section">
                        <h2>Select your  Trip</h2>
                        <select
                            value={selectedTrip ? selectedTrip.id : ""}
                            onChange={handleTripChange}
                            className="trip-select"
                        >
                            {trips.map((trip) => (
                                <option key={trip.id} value={trip.id}>
                                    {` ${trip.title} to  ${trip.arrival}`}
                                </option>
                            ))}
                        </select>
                    </section>


                    <BookingManager
                        userActivityId={selectedTrip.id}
                        bookedTimes={bookedTimes}
                        startDate={selectedTrip.departure}
                        endDate={selectedTrip.arrival}
                    />
                    {/* Add to List Button */}
                    <div className="actions">
                        <button
                            className="add-to-list-btn"
                            onClick={() =>
                                selectedTrip &&
                                addToActivityList(activity.id, selectedTrip.id, selectedPrice, selectedDateTime, placeId)
                            }
                        >
                            Add to My List
                        </button>
                    </div>


                </div>
            </div>
        </AuthenticatedLayout>
    );
}

export default ShowUserActivity;
