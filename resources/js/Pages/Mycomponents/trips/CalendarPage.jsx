import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import CalendarComponent from '../activities/CalendarComponent';

const CalendarPage = ({ auth, tripId , tripTitle}) => {

    const trip = { id: tripId, created_by: auth.user.id };
    const isCreator = auth.user.id === trip.created_by;
    return (
        <AuthenticatedLayout
            user={auth.user} 
            tripId={tripId}  
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Calendrier des Activités - {tripTitle}</h2>}
            isCreator={isCreator}
        >
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 bg-white border-b border-gray-200">
                            <CalendarComponent tripId={tripId} userId={auth.user.id} />
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
};

export default CalendarPage;
