import React from 'react';
import DatePicker from 'react-datepicker';
import 'react-datepicker/dist/react-datepicker.css';

function CustomDatepicker({ selectedDate, onChange, startDate, endDate }) {
    
    if (!startDate || !endDate) {
        return <p>Loading dates...</p>; // Ou un autre message/placement par défaut
    }
    
    
    
    return (
        <DatePicker
            selected={selectedDate}
            onChange={onChange}
            showTimeSelect
            timeFormat="HH:mm"
            timeIntervals={30} 
            dateFormat="yyyy/MM/dd HH:mm" 
            minDate={new Date(startDate)}
            maxDate={new Date(endDate)}
            className="form-control"
        />
    );
}

export default CustomDatepicker;
