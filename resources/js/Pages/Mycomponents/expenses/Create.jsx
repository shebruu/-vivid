import React, { useState } from 'react';
import { Inertia } from '@inertiajs/inertia';

const Create = ({ activities, tripId, users, currentUser }) => {
    const [selectedPrices, setSelectedPrices] = useState({});
    const [selectedUsers, setSelectedUsers] = useState({});
    const [totalAmount, setTotalAmount] = useState({});

    const parsePrices = (priceString) => {
        return priceString.split(',').map(price => {
            const details = price.split(' ');
            return { amount: parseFloat(details[0]), ageRange: details[1], season: details[2], dayType: details[3] };
        });
    };

    const handlePriceChange = (activityId, price) => {
        setSelectedPrices(prev => ({ ...prev, [activityId]: price }));
        calculateTotal(activityId, price, selectedUsers[activityId] || []);
    };

    const handleUserChange = (activityId, userId) => {
        setSelectedUsers(prev => {
            const usersForActivity = prev[activityId] || [];
            if (!usersForActivity.includes(userId)) {
                usersForActivity.push(userId);
            }
            calculateTotal(activityId, selectedPrices[activityId], usersForActivity);
            return { ...prev, [activityId]: usersForActivity };
        });
    };

    const calculateTotal = (activityId, price, users) => {
        if (price && users) {
            const total = price.amount * users.length;
            setTotalAmount(prev => ({ ...prev, [activityId]: total }));
        }
    };

    const handlePayment = (price, activityId, selectedUsers) => {
        const totalAmount = parseFloat(price.amount) * selectedUsers.length;
        console.log('Total to pay:', totalAmount, 'for activity ID:', activityId);
        // You would send this data to server
        // Inertia.post('/path-to-payment-server', { price, activityId, totalAmount, users: selectedUsers });
    };

    return (
        <div>
            {activities.map(activity => (
                <div key={activity.user_activity_id}>
                    <h3>Activity: {activity.activity_name}</h3>
                    <form onSubmit={(e) => {
                        e.preventDefault();
                        handlePayment(selectedPrices[activity.user_activity_id], activity.user_activity_id, selectedUsers[activity.user_activity_id]);
                    }}>
                        <label htmlFor={`price-select-${activity.user_activity_id}`}>Choose a price:</label>
                        <select
                            name="price"
                            id={`price-select-${activity.user_activity_id}`}
                            onChange={(e) => handlePriceChange(activity.user_activity_id, parsePrices(activity.all_prices_at_place)[e.target.selectedIndex])}
                        >
                            {parsePrices(activity.all_prices_at_place).map((price, index) => (
                                <option key={index} value={price.amount}>
                                    {price.amount} - {price.ageRange} - {price.season} - {price.dayType}
                                </option>
                            ))}
                        </select>
                        <label htmlFor={`user-select-${activity.user_activity_id}`}>Add people to pay for:</label>
                        <div id={`user-select-${activity.user_activity_id}`}>
                            {users.concat(currentUser).map(user => (
                                <div key={user.id}>
                                    <span>{user.name}</span>
                                    <button type="button" onClick={() => handleUserChange(activity.user_activity_id, user.id)}>Add</button>
                                </div>
                            ))}
                        </div>
                        <p>Total to pay: {totalAmount[activity.user_activity_id] || 0}</p>
                        <button type="submit">Pay</button>
                    </form>
                </div>
            ))}
        </div>
    );
};

export default Create;
