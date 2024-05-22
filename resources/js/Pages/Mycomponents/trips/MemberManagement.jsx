import React, { useState } from "react";
import { Inertia } from "@inertiajs/inertia";

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Link } from "@inertiajs/inertia-react";

import "./memberstyle.css";

function MemberManagement({ auth, trip }) {
    const [memberLogin, setMemberLogin] = useState("");

    const handleAddMember = () => {
        if (memberLogin) {
            Inertia.post(route("trip.addmember", { tripId: trip.id }), {
                login: memberLogin,
            });
            setMemberLogin("");
        }
    };

    const handleRemoveMember = (userId) => {
        Inertia.delete(
            route("trip.removemember", { tripId: trip.id, userId }),
            {
                onSuccess: () => {
                    console.log("Member removed successfully");
                },
            }
        );
    };

    const isCreator = auth.user.id === trip.created_by;
    const tripId=trip.id;
    console.log('creators',trip.created_by, auth.user.id,tripId )

    console.log('iscreator ' , isCreator)

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Participants{" "}
                </h2>
            }
            tripId={tripId}  
            showSidebar={true}
            isCreator={isCreator}
           
        >
          
          <div className="container">
                <h2 className="title">Gestion des membres pour {trip.title}</h2>
                <ul>
                    {trip.users.map((user) => (
                        <li key={user.id}>
                            {user.login}
                            <button onClick={() => handleRemoveMember(user.id)}>
                                Retirer
                            </button>
                        </li>
                    ))}
                </ul>
                <div className="member-form">
                    <input
                        type="text"
                        value={memberLogin}
                        onChange={(e) => setMemberLogin(e.target.value)}
                        placeholder="Enter member login"
                    />
                    <button onClick={handleAddMember} className="btn-primary">Ajouter Membre</button>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}

export default MemberManagement;
