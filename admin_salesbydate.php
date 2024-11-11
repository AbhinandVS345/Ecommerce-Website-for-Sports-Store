<?php
include('connection.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales by Date</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</head>

<body>

<h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Sales Between Dates
    </h2>

    <!-- Date Selection Form -->
    <form id="sales-form" style="margin-bottom: 30px;">
        <label for="start_date" class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Start Date:</label>
        <input type="date"
            class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
            id="start_date" name="start_date"
            value="<?php echo isset($_POST['start_date']) ? htmlspecialchars($_POST['start_date']) : ''; ?>"
            style="margin-right: 10px;" required>

        <label for="end_date" class="mb-4 font-semibold text-gray-800 dark:text-gray-300">End Date:</label>
        <input type="date"
            class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
            id="end_date" name="end_date"
            value="<?php echo isset($_POST['end_date']) ? htmlspecialchars($_POST['end_date']) : ''; ?>"
            style="margin-right: 10px;" required>

        <button type="submit" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
            Show Sales
        </button>
    </form>

    <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 m-b-50">
        <div class="col-md-8" style="margin-left: 100px; margin-right: 100px; margin-bottom: 50px;">
            <div class="card">
                <canvas id="salesByDateChart" style="width: 500px; height: 500px;"></canvas>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Chart.js with empty data
            const ctx = document.getElementById('salesByDateChart').getContext('2d');
            const salesByDateChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [], // Initially empty
                    datasets: [{
                        label: 'Total Sales Amount',
                        data: [],
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Sales Amount'
                            },
                            beginAtZero: true
                        }
                    }
                }
            });

            // Handle form submission with AJAX
            document.getElementById('sales-form').addEventListener('submit', function(e) {
                e.preventDefault();

                // Fetch form data
                const formData = new FormData(this);

                // Send AJAX request
                fetch('sales_by_date.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Update chart data
                        salesByDateChart.data.labels = data.dates;
                        salesByDateChart.data.datasets[0].data = data.totals;
                        salesByDateChart.update(); // Redraw the chart
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    </script>

</body>

</html>