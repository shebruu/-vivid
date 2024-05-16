import React from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Link } from "@inertiajs/inertia-react";
import Navbar2 from "../Navbar";
import "./style.css";

function Trips({ usertrips, auth }) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Itinéraires
                </h2>
            }
        >
           
            <div className="container">
                <h1 className="title">Liste de mes voyages</h1>
                <div className="trip-container">
                    {usertrips.map((trip) => (
                        <div key={trip.id} className="card">
                            <h2 className="text-xl font-semibold">
                                {trip.title}
                            </h2>
                            <h2 className="text-xl">
                                {trip.departure} - {trip.arrival}
                            </h2>
                            <p className="text-gray-600">
                                Estimation totale: {trip.totalestimation}
                            </p>

                            <div>
                                <Link
                                    href={route("trip.show", { trip: trip.id })}
                                    className="btn-primary"
                                >
                                    Voir les détails
                                </Link>

                                {auth.user &&
                                    trip.created_by === auth.user.id && (
                                        <Link
                                            href={route("trip.manage", {
                                                tripId: trip.id,
                                            })}
                                            className="btn-primary"
                                        >
                                            Gestion des membres
                                        </Link>
                                    )}

                                <Link
                                    href={route("itinerarie.list", {
                                        tripId: trip.id,
                                    })}
                                    className="btn-primary"
                                >
                                    Activités proposé{" "}
                                </Link>

                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}

export default Trips;
