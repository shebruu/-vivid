
import React from 'react';
import { Link } from '@inertiajs/inertia-react';
import "./Navbarstyle.css";



const Sidebar = ({ user, tripId, isCreator  }) => {

    console.log("Receiving in Sidebar -> user: ", user, ", tripId: ", tripId, 'iscreator',isCreator);

    return (

        
        <div className="sidebar">

        {/* Liens toujours affichés */}
        <Link href={route("user_activities.index")} className="sidebar-link">
            Toutes les activités
        </Link>
        
        {/* Conditionnellement afficher ces liens si tripId est présent */}
        {tripId && (
            
            <>
             
                <Link href={route("trip.calendar", { tripId })} className="sidebar-link">
                    Calendrier
                </Link>
                {isCreator && (
                    
                        <Link href={route("trip.manage", { tripId})} className="sidebar-link">
                            Gestion des membres
                        </Link>
                    )}
                <Link href={route("itinerarie.list", { tripId })} className="sidebar-link">
                    Activités proposées
                </Link>
                <Link href={route("expenses.create", { tripId })} className="sidebar-link">
                    Finances
                </Link>
                <Link href={route("notifications.index", { tripId })} className="sidebar-link">
                    Notifications
                </Link>
            </>
        )}
    </div>
);
};

export default Sidebar;