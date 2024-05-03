import React from "react";
import { Link, Head } from "@inertiajs/react";
import "./styles.css";

export default function Welcome({ auth, laravelVersion, phpVersion }) {
    return (
        <>
            <Head title="Welcome" />
            <div className="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
                <div className="relative min-h-screen flex flex-col items-center justify-center">
                    <div className="relative w-full max-w-7xl">
                        <header class="custom-header">
                        <Link href="/" className="logo-link">
        <img src="illustrations/logo.png" alt="VividPalette Logo" class="logo" />
    </Link>
                            <nav className="flex gap-4">
                                <Link
                                    href="/home"
                                    className="text-gray-800 dark:text-white hover:underline"
                                >
                                    Accueil
                                </Link>

                                <Link
                                    href="/dashboard"
                                    className="text-gray-800 dark:text-white hover:underline"
                                >
                                    Dasboard
                                </Link>

                                {auth.user ? (
                                    <Link
                                        href={route("dashboard")}
                                        className="text-black ring-1 ring-transparent hover:text-black/70 focus:outline-none focus-visible:ring-red-500 dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        Dashboard
                                    </Link>
                                ) : (
                                    <>
                                        <Link
                                            href={route("login")}
                                            className="text-black ring-1 ring-transparent hover:text-black/70 focus:outline-none focus-visible:ring-red-500 dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                        >
                                            Log in
                                        </Link>
                                        <Link
                                            href={route("register")}
                                            className="text-black ring-1 ring-transparent hover:text-black/70 focus:outline-none focus-visible:ring-red-500 dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                        >
                                            Register
                                        </Link>
                                    </>
                                )}
                            </nav>
                        </header>

                        {/*   header  */}


                        <div className="grid grid-cols-1 md:grid-cols-3 gap-4"></div>
  {/* 
                        
                        
                        {/*   content  */}
                        <div className="text-center">

                            <h1 className="text-3xl font-bold mb-4">
                                Bienvenue !
                                
                            </h1>
                           
                            <p className="text-lg mb-8">
                                Avec notre outil convivial, vous pouvez créer
                                des itinéraires sur mesure, découvrir de
                                nouvelles activités passionnantes et gérer
                                efficacement votre budget de voyage.
                            </p>

                            <img
                                src="/images/Acceuil/carte.jpeg"
                                alt="Description"
                                class="fond-image"
                               
                            />
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div className="card">
                                <img src="illustrations/avent.svg" alt="Adventure " class="text-4xl text-center mb-2" />

                                <div className="text-center font-bold">
                                    <strong>Créez vos propres aventures</strong>{" "}
                                    :
                                </div>
                                <p className="text-lg">
                                    Explorez une multitude d'activités
                                    disponibles dans différentes localités grâce
                                    à notre intégration API. Choisissez par type
                                    d'activité ou par lieu, et accédez à des
                                    informations détaillées telles que les prix,
                                    la localisation et les conseils essentiels
                                    avant de partir.
                                </p>
                            </div>
                            <div className="card">

                                {/*    <i className="fas fa-hiking text-4xl text-center mb-2"></i>*/}
                                <img src="illustrations/sharing.svg" alt="Sharing " class="text-4xl text-center mb-2" />
                                <div className="text-center font-bold">
                                    <strong>Partagez vos découvertes</strong> :
                                </div>
                                <p className="text-lg">
                                    Échangez vos plans de voyage avec votre
                                    groupe en toute simplicité. Que ce soit pour
                                    inspirer vos amis ou pour organiser des
                                    excursions en groupe, notre application vous
                                    permet de partager vos itinéraires avec
                                    facilité.
                                </p>
                            </div>
                            <div className="card">

                                <img src="illustrations/itinairies.svg" alt="Itinéraires " class="text-4xl text-center mb-2" />
                                <div className="text-center font-bold">
                                    <strong> Visualisez votre aventure </strong>{" "}
                                    :
                                </div>
                                <p className="text-lg">
                                    Tracez votre parcours sur la carte intégrée
                                    et suivez vos étapes avec précision. De la
                                    planification à l'exécution, gardez le
                                    contrôle total sur votre voyage.
                                </p>
                            </div>
                            <div className="card">

                                <img src="illustrations/value.svg" alt="Wallet " class="text-4xl text-center mb-2" />
                                <div className="text-center font-bold">
                                    <strong> Gérez votre budget </strong> :
                                </div>
                                <p className="text-lg">
                                    Enregistrez vos dépenses directement dans
                                    l'application pour une gestion budgétaire
                                    optimale. Suivez vos coûts en temps réel et
                                    prenez des décisions éclairées pour
                                    maximiser votre expérience de voyage.
                                </p>
                            </div>
                        </div>

                        <button className="transition duration-500 ease-in-out transform hover:-translate-y-1 hover:scale-110">
                            Cliquer pour vous inscrire.
                        </button>

                        <footer className="py-4 text-center text-sm text-black dark:text-white/70">
                            Laravel v{laravelVersion} (PHP v{phpVersion})
                        </footer>
                    </div>
                </div>
            </div>
        </>
    );
}
