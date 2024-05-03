// LogoutModal.js
import React from 'react';
import { Inertia } from '@inertiajs/inertia';

const LogoutModal = ({ isOpen, onClose }) => {
    if (!isOpen) return null;

    const handleLogout = (e) => {
        e.preventDefault();
        Inertia.post('/logout');
    };

    return (
        <div className="logout-modal">
            <div className="modal-content">
                <h4>Voulez-vous vraiment vous déconnecter?</h4>
                <button onClick={handleLogout}>Déconnexion</button>
                <button onClick={onClose}>Annuler</button>
            </div>
        </div>
    );
};

export default LogoutModal;
