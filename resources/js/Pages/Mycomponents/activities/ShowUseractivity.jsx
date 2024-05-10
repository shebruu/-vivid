// ShowUserActivity.jsx
import React, { useState, useEffect } from "react";
import Navbar2 from "../Navbar";
import "./style.css";
import ActivityList from "./ActivityList";
import CustomDatePicker from "./CustomDatepicker";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";

<link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@300;400&display=swap"
    rel="stylesheet"
></link>;

function ShowUserActivity({
    activity,
    place,
    createdby,
    prices,
    placeImages,
    auth,
    trips,
}) {
    const [activitiesByTrip, setActivitiesByTrip] = useState([]);

    //stocker l objet voyage complet
    const [selectedTrip, setSelectedTrip] = useState(trips[0] || {});

    const [selectedPrice, setSelectedPrice] = useState(prices[0]?.id || "");

    const [selectedDateTime, setSelectedDateTime] = useState(
        new Date(trips[0]?.departure ||  Date.now()));

    useEffect(() => {
        if (selectedTrip) {
            setSelectedDateTime(new Date(selectedTrip.departure));
        }
    }, [selectedTrip]);

    //mise a jour du changement de selection , recupere objet voyage avec id 
    const handleTripChange = (e) => {
        const tripId = e.target.value;
        const trip = trips.find((t) => t.id.toString() === tripId);
        setSelectedTrip(trip);
    };
    console.log(selectedTrip);

    // Charger la liste sauvegardée quand le composant est monté
    useEffect(() => {
        const savedActivities = JSON.parse(
            localStorage.getItem("activitiesByTrip")
        );
        if (savedActivities) {
            setActivitiesByTrip(savedActivities);
        }
    }, []);

    const addToActivityList = (activityId, tripId) => {
        console.log("Attempting to add activity:", activityId, tripId);

        setActivitiesByTrip((prevList) => {

            const listForTrip = prevList[tripId] || [];

               if (!listForTrip.includes(activityId)) {
            return {
                ...prevList,
                [tripId]: [...listForTrip, activityId]
            };
        }
        return prevList;
    });
};

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
                            <strong>Title:</strong> {place.title}
                        </p>
                        <p>
                            <strong>Description:</strong> {place.description}
                        </p>
                        <p>
                            <strong>Address:</strong> {place.adress}
                        </p>
                    </section>

                    {/* Created By Section */}
                    <section className="creator-section">
                        <h2>Created By</h2>
                        <p>
                            <strong>Name:</strong> {createdby.firstname}{" "}
                            {createdby.lastname}
                        </p>
                    </section>

                    {/* Prices Section */}
                    <section className="prices-section">
                        <h2>Prices</h2>
                        <ul className="prices-list">
                            {prices.map((price) => (
                                <li key={price.id}>
                                    <strong>Range:</strong> {price.age_range},
                                    <strong>Amount:</strong> {price.amount}
                                </li>
                            ))}
                        </ul>
                    </section>

                    {/* Price Selection */}
                    <section className="price">
                        <h2>Select Price</h2>
                        <select
                            value={selectedPrice}
                            onChange={(e) => setSelectedPrice(e.target.value)}
                            className="price-select"
                        >
                            {prices.map((price) => (
                                <option key={price.id} value={price.amount}>
                                    {`${price.age_range} - ${price.amount} $`}
                                </option>
                            ))}
                        </select>
                    </section>
                    <section className="trip-section">
                        <h2>Select a Trip</h2>
                        <select
                            value={selectedTrip ? selectedTrip.id : ''}
                            onChange={handleTripChange}
                            className="trip-select"
                        >
                            {trips.map((trip) => (
                                <option key={trip.id} value={trip.id}>
                                    {`From ${trip.title} to  ${trip.arrival}`}
                                </option>
                            ))}
                        </select>
                    </section>

                    <div>
                        <h1>Choisissez une date </h1>
                       {/*   {selectedTrip && selectedTrip.departure && selectedTrip.arrival ? (
   <CustomDatepicker
        selectedDate={selectedDateTime}
        onChange={setSelectedDateTime}
        startDate={selectedTrip.departure}
        endDate={selectedTrip.arrival}
    />
) : (
    <p>Please select a trip</p> )}
*/}
                    </div>
                    {/* Add to List Button */}
                    <div className="actions">
                        <button
                            className="add-to-list-btn"
                            onClick={() => selectedTrip && addToActivityList(activity.id, selectedTrip.id)}
                        >
                            Add to My List
                        </button>
                    </div>

                    <ActivityList activities={activitiesByTrip} selectedTripId={selectedTrip ? selectedTrip.id : null} />
                </div>
            </div>
        </AuthenticatedLayout>
    );
}

export default ShowUserActivity;
