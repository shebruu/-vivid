import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

import Navbar2 from './Mycomponents/Navbar2';

import "./styles.css";
//import "./Mycomponents/Navbarstyle.css";

import UserActivityForm from './Mycomponents/activities/UserActivityForm';


export default function Dashboard({ auth, message }) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>}
        >


            <Navbar2 auth={auth} />
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    
                        <div className="p-6 text-gray-900">You're logged in!</div>
                        <h1 className='user'>{message}</h1>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}