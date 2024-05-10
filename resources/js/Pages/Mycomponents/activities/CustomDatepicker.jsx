import React from 'react';
import DatePicker from 'react-datepicker';
import 'react-datepicker/dist/react-datepicker.css';



/**
 * Composant pour sélectionner une date et une heure dans une plage spécifiée.
 * @param {Object} props - Propriétés du composant.
 * @param {Date} props.selectedDate - La date actuellement sélectionnée.
 * @param {Function} props.onChange - Fonction appelée lors du changement de la date sélectionnée.
 * @param {Date} props.startDate - Date de début de la plage de sélection.
 * @param {Date} props.endDate - Date de fin de la plage de sélection.
 */
function isValidDate(dateStr) {
    const date = new Date(dateStr);
    return !isNaN(date.getTime());
}

function CustomDatepicker({ selectedDate, onChange, startDate, endDate }) {
    
    const start = new Date(startDate);
    const end = new Date(endDate);
    if (!isValidDate(startDate) || !isValidDate(endDate)) {
        return <p>Loading dates or invalid date range...</p>;
    }
    
    
    
    return (
        <DatePicker
            selected={selectedDate}
            onChange={onChange}
            showTimeSelect
            timeFormat="HH:mm"
            timeIntervals={30} 
            dateFormat="yyyy/MM/dd HH:mm" 
            minDate={start}
            maxDate={end}
            className="form-control"
        />
    );
}

export default CustomDatepicker;
