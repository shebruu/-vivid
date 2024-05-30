import React, { useState } from 'react';
import { Link } from '@inertiajs/inertia-react';
import "./Navbarstyle.css";

const Sidebar = ({ usertrips = [], user, tripId, isCreator, userTrips }) => {
   

    return (
        <div className="sidebar">
    
        
            {tripId && (
                <>
                    <Link href={route("trip.calendar", { tripId })} className="sidebar-link">
                        Calendrier
                    </Link>
                    {isCreator && (
                        <Link href={route("trip.manage", { tripId })} className="sidebar-link">
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
