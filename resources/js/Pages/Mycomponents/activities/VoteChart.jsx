import React from 'react';
import { Bar } from 'react-chartjs-2';
import Chart from 'chart.js/auto';

const VotesChart = ({ votes }) => {
    const data = {
        labels: ['Votes'],
        datasets: [
            {
                label: 'Yes Votes',
                data: [votes.yes_votes],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
            },
            {
                label: 'No Votes',
                data: [votes.no_votes],
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
            }
        ],
    };

    const options = {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    };

    return <Bar data={data} options={options} />;
};

export default VotesChart;
