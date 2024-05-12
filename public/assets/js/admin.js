document.addEventListener('DOMContentLoaded', function () {
    const coll = document.getElementsByClassName("collapsible");
    for (let i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function () {
            const content = document.getElementById(this.getAttribute('data-target'));
            const arrow = this.getElementsByClassName('arrow')[0];
            if (content.style.maxHeight) {
                content.style.maxHeight = null;
                arrow.innerHTML = "&#9660;"; // Down arrow
                content.classList.remove('show');
            } else {
                content.style.maxHeight = content.scrollHeight + "px";
                arrow.innerHTML = "&#9650;"; // Up arrow
                content.classList.add('show');
            }
        });
    }
});


document.addEventListener('DOMContentLoaded', function () {
// Parse the JSON data from the PHP script
    /*
    console.log(jsonData);
    */
    const data = jsonData;

    /*console.log(data);*/ //debug log

// Extract the months and revenues into separate arrays
    const months = data.map(function (row) {
        return row.MONTH; // Changed from 'Month' to 'MONTH'
    });
    const revenues = data.map(function (row) {
        return parseFloat(row.REVENUE); // Changed from 'Revenue' to 'REVENUE' and parse string to float
    });

    //debug logs
    /*console.log(months);
    console.log(revenues);*/

// Create the chart
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Monthly Revenue',
                data: revenues,
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Month'
                    }
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Revenue'
                    }
                }
            }
        }
    });
})