import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';




import { Link } from '@inertiajs/inertia-react';
import Navbar2 from './Mycomponents/Navbar';

import "./styles.css";
//import "./Mycomponents/Navbarstyle.css";

//import UserActivityForm from './Mycomponents/activities/UserActivityForm';


export default function Dashboard({ auth, message }) {
    return (
        <AuthenticatedLayout
            user={auth.user}
           
        >
            
            
          

            {/* Arrière-plan plein écran */}
            <div className="full-page-background"></div>
        
            <div className="relative py-12 ">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
                    <div className="bg-transparent shadow-none sm:rounded-lg">
                        
                        {/* Titre utilisateur */}
                        <h1 className='user'>{message}</h1>

                        {/* Description pour créer un voyage */}
                        <p className="mt-4 text-gray-800">
                            Commencez par créer un voyage, entrez les dates, ajoutez les membres, et commencez à planifier votre voyage.
                        </p>

                        {/* Bouton pour créer un voyage */}
                        <div className="button-container">
                            <Link
                                href={route('trip.create')}
                                className="custom-button"
                            >
                                Cliquez ici pour créer un voyage
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}