import React, { useState, useEffect } from 'react';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import './expensestyle.css';  

const PriceSelector = ({ activity, handlePriceChange, parsePrices }) => {
    return (
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
    );
};

const UserSelector = ({ activity, users, handleUserChange }) => {
    return (
        <div id={`user-select-${activity.user_activity_id}`}>
            {users.map(user => (
                <div key={user.id}>
                    <span>{user.name}</span>
                    <button type="button" onClick={() => handleUserChange(activity.user_activity_id, user.id)}> + </button>
                </div>
            ))}
        </div>
    );
};

const Create = ({ activities, tripId, users, categories, currentUser, isCreator, tripTitle }) => {
    const [selectedPrices, setSelectedPrices] = useState({});
    const [selectedUsers, setSelectedUsers] = useState({});
    const [totalAmount, setTotalAmount] = useState({});
    const [amount, setAmount] = useState('');
    const [categoryId, setCategoryId] = useState('');

    useEffect(() => {
        if (!categories || !categories.length) {
            console.error('Categories are undefined or empty');
        }
    }, [categories]);

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
    };

    const handleNewExpenseSubmit = (e) => {
        e.preventDefault();
        Inertia.post(`/trips/${tripId}/expenses`, {
            category_id: categoryId,
            amount: amount,
        });
    };

    return (
        <AuthenticatedLayout
            user={currentUser}
            tripId={tripId}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Financing Activities - {tripTitle} </h2>}
            isCreator={isCreator}
        >
            <div className="create-container">
                <div className="activity-grid">
                    {activities.map(activity => (
                        <div key={activity.user_activity_id} className="activity-card">
                            <h3>{activity.activity_name}</h3>
                            <div className="activity-info">
                                <div>
                                    <PriceSelector activity={activity} handlePriceChange={handlePriceChange} parsePrices={parsePrices} />
                                    <UserSelector activity={activity} users={users.concat(currentUser)} handleUserChange={handleUserChange} />
                                    <p>Total to pay: {totalAmount[activity.user_activity_id] || 0}</p>
                                </div>
                                <button onClick={() => handlePayment(selectedPrices[activity.user_activity_id], activity.user_activity_id, selectedUsers[activity.user_activity_id])}>
                                    Pay
                                </button>
                            </div>
                        </div>
                    ))}
                </div>
                <br></br><br />
                <h2> <strong>Add New Expense </strong></h2>
                <form onSubmit={handleNewExpenseSubmit}>
                    <div className="form-group">
                        <label htmlFor="category">Category</label>
                        <select id="category" value={categoryId} onChange={(e) => setCategoryId(e.target.value)}>
                            <option value="">Select a category</option>
                            {categories.map(category => (
                                <option key={category.id} value={category.id}>{category.name}</option>
                            ))}
                        </select>
                    </div>
                    <div className="form-group">
                        <label htmlFor="amount">Amount</label>
                        <input type="number" id="amount" value={amount} onChange={(e) => setAmount(e.target.value)} min="0" step="0.01" required />
                    </div>
                    <button type="submit">Add Expense</button>
                </form>
            </div>
        </AuthenticatedLayout>
    );
};

export default Create;
