import { Link, Head } from '@inertiajs/react';

export default function Welcome({ auth, laravelVersion, phpVersion }) {
    return (
        <>
            <Head title="Welcome" />
            <div className="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
                <div className="relative min-h-screen flex flex-col items-center justify-center">
                    <div className="relative w-full max-w-7xl">
                        <header className="w-full flex justify-between items-center p-6">
                            <Link href="/" className="text-lg font-bold text-red-500 hover:text-red-700">Laravel Inertia App</Link>
                            <nav className="flex gap-4">
                                <Link href="/home" className="text-gray-800 dark:text-white hover:underline">Accueil</Link>
                                <Link href="/dashboard" className="text-gray-800 dark:text-white hover:underline">Dasboard</Link>
                                <Link href="/itinéraires" className="text-gray-800 dark:text-white hover:underline">Itinéraires</Link>
                               
                                
                                <Link href="/profil" className="text-gray-800 dark:text-white hover:underline">Profil</Link>
                                <Link href="/carte" className="text-gray-800 dark:text-white hover:underline">Carte</Link>
                                {auth.user ? (
                                    <Link
                                        href={route('dashboard')}
                                        className="text-black ring-1 ring-transparent hover:text-black/70 focus:outline-none focus-visible:ring-red-500 dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        Dashboard
                                    </Link>
                                ) : (
                                    <>
                                        <Link
                                            href={route('login')}
                                            className="text-black ring-1 ring-transparent hover:text-black/70 focus:outline-none focus-visible:ring-red-500 dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                        >
                                            Log in
                                        </Link>
                                        <Link
                                            href={route('register')}
                                            className="text-black ring-1 ring-transparent hover:text-black/70 focus:outline-none focus-visible:ring-red-500 dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                        >
                                            Register
                                        </Link>
                                    </>
                                )}
                            </nav>
                        </header>

                        {/* Ajoutez le contenu de la page ici */}

                        <footer className="py-4 text-center text-sm text-black dark:text-white/70">
                            Laravel v{laravelVersion} (PHP v{phpVersion})
                        </footer>
                    </div>
                </div>
            </div>
        </>
    );
}