// ShowUserActivity.jsx
import React, { useState, useEffect  } from "react";
import Navbar2 from '../Navbar';
import './style.css';
import ActivityList from './ActivityList'; 
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@300;400&display=swap" rel="stylesheet"></link>

function ShowUserActivity({ activity, place, createdby, prices, placeImages, auth }) {
    const [activityList, setActivityList] = useState([]);
    
  
      // Charger la liste sauvegardée quand le composant est monté
      useEffect(() => {
        const savedActivities = JSON.parse(localStorage.getItem('activityList'));
        if (savedActivities) {
            setActivityList(savedActivities);
        }
    }, []);

    const addToActivityList = (activityId) => {
        console.log('Attempting to add activity:', activityId);
        setActivityList(prevList => {
            if (!prevList.includes(activityId)) {
                const updatedList = [...prevList, activityId];
                localStorage.setItem('activityList', JSON.stringify(updatedList));
                console.log('New activity list:', updatedList);
                return updatedList;
            }
            return prevList;
        });
    };
  
   
    return (

        <AuthenticatedLayout
        user={auth.user}
        header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Itinéraires</h2>}
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
                        <img key={index} src={src} alt={`Image ${index + 1}`} className="place-image" />
                    ))}
                </div>
            </section>


            {/* Place Details Section */}
            <section className="place-section">
                <h2>Place Information</h2>
                <p><strong>Title:</strong> {place.title}</p>
                <p><strong>Description:</strong> {place.description}</p>
                <p><strong>Address:</strong> {place.adress}</p>
            </section>

            {/* Created By Section */}
            <section className="creator-section">
                <h2>Created By</h2>
                <p><strong>Name:</strong> {createdby.firstname} {createdby.lastname}</p>
             
            </section>

            {/* Prices Section */}
            <section className="prices-section">
                <h2>Prices</h2>
                <ul className="prices-list">
                    {prices.map(price => (
                        <li key={price.id}>
                            <strong>Range:</strong> {price.age_range},
                            <strong>Amount:</strong> {price.amount}
                        </li>
                    ))}
                </ul>
            </section>

            {/* Add to List Button */}
            <div className="actions">
                <button className="add-to-list-btn" onClick={() => addToActivityList(activity.id)}>
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
