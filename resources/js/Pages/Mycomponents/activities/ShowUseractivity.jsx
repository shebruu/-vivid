// ShowUserActivity.jsx
import React, { useState, useEffect } from "react";
import Navbar2 from "../Navbar";
import "./style.css";
import ActivityList from "./ActivityList";
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
    const [activityList, setActivityList] = useState([]);

    const [selectedTrip, setSelectedTrip] = useState(trips[0]?.id || "");

    const [selectedPrice, setSelectedPrice] = useState(prices[0]?.id || "");

    // Charger la liste sauvegardée quand le composant est monté
    useEffect(() => {
        const savedActivities = JSON.parse(
            localStorage.getItem("activityList")
        );
        if (savedActivities) {
            setActivityList(savedActivities);
        }
    }, []);

    const addToActivityList = (activityId) => {
        console.log("Attempting to add activity:", activityId);
        setActivityList((prevList) => {
            if (!prevList.includes(activityId)) {
                const updatedList = [...prevList, activityId];
                localStorage.setItem(
                    "activityList",
                    JSON.stringify(updatedList)
                );
                console.log("New activity list:", updatedList);
                return updatedList;
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
                            value={selectedTrip}
                            onChange={(e) => setSelectedTrip(e.target.value)}
                            className="trip-select"
                        >
                            {trips.map((trip) => (
                                <option key={trip.id} value={trip.id}>
                                    {`From ${trip.title} to  ${trip.arrival}`}
                                </option>
                            ))}
                        </select>
                    </section>

                    {/* Add to List Button */}
                    <div className="actions">
                        <button
                            className="add-to-list-btn"
                            onClick={() => addToActivityList(activity.id)}
                        >
                            Add to My List
                        </button>
                    </div>

                    <ActivityList activities={activityList} />
                </div>
            </div>
        </AuthenticatedLayout>
    );
}

export default ShowUserActivity;
