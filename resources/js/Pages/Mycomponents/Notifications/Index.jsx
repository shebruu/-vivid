// ExpensesNotifications.js

import React from 'react';
function ExpensesNotifications({ notifications }) {
    return (
        <div>
            <h1>Notifications</h1>
            {notifications.map(notification => (
                <div key={notification.id}>
                    <p>{notification.message}</p>
                </div>
            ))}
        </div>
    );
};
export default ExpensesNotifications;
