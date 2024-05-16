import React from 'react';
import { Doughnut } from 'react-chartjs-2';
import Chart from 'chart.js/auto';

const VotesChart = ({ votes, totalParticipants }) => {

    const totalVotes = parseInt(votes.yes_votes, 10) + parseInt(votes.no_votes, 10);
    const data = {
        labels: ['Yes Votes', 'No Votes'],
        datasets: [
            {
                data: [parseInt(votes.yes_votes, 10), parseInt(votes.no_votes, 10)],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.6)',  
                    'rgba(255, 99, 132, 0.6)'    
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1,
            }
        ],
    };

    const options = {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'top',
            },
            tooltip: {
                enabled: true,
            },
            title: {
                display: true,
                text: `Total Votes: ${totalVotes} / Total Participants: ${totalParticipants}`,
                font: {
                    size: 14
                }
            }
        },
        animation: {
            animateScale: true,
            animateRotate: true
        }
    };

    const chartContainerStyle = {
        width: '200px',
        height: '200px',
        margin: 'auto'
    };

    return (
        <div style={chartContainerStyle}>
            <Doughnut data={data} options={options} />
        </div>
    );
};

export default VotesChart;
