// ShowUserActivity.jsx
import React, { useState, useEffect  } from "react";
import Navbar2 from '../Navbar';
import './style.css';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';



<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@300;400&display=swap" rel="stylesheet"></link>

const ActivityListItem = ({ activity }) => {
    const [selectedDate, setSelectedDate] = useState(activity.availableDates ? activity.availableDates[0] : '');

    const handleDateChange = (event) => {
        setSelectedDate(event.target.value);
    };

    return (
        <div>
            <h3>{activity.title}</h3>
            <p>{activity.description}</p>
            <select value={selectedDate} onChange={handleDateChange}>
                {activity.availableDates.map(date => (
                    <option key={date} value={date}>{date}</option>
                ))}
            </select>
            <p>Prix: {activity.prices[selectedDate] || activity.defaultPrice}</p>



               {/* Afficher les détails du voyage de l'utilisateur */}
               <section className="trip-details-section">
                <h2>User Trip Details</h2>
                <p>Start Time: {userTripDetails.start_time}</p>
                <p>End Time: {userTripDetails.end_time}</p>
                {/* Autres détails du voyage */}
            </section>
        </div>

         
    );
};
function ActivityList({ activities }) {
    if (activities.length === 0) {
        return <p>No activities added yet.</p>;
    }

    return (
        <ul>
            {activities.map((activity, index) => (
                <li key={index}>
                    <ActivityListItem activity={activity} />
                </li>
            ))}
        </ul>
    );
}


function ShowUserActivity({ activity, place, createdby, prices, placeImages, auth, trip }) {
    const [activityList, setActivityList] = useState([]);
    
  
      // Charger la liste sauvegardée quand le composant est monté
      useEffect(() => {
        const savedActivities = JSON.parse(localStorage.getItem('activityList') || '[]');
        setActivityList(savedActivities);
    }, []);

    const addToActivityList = (activity) => {
        if (!activityList.find(a => a.id === activity.id)) {
            const newList = [...activityList, activity];
            localStorage.setItem('activityList', JSON.stringify(newList));
            setActivityList(newList);
            alert('Activity added to your list!');
        } else {
            alert('This activity is already in your list.');
        }
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
