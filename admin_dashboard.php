<?php
include('Connection.php');
$cilent_sql = "SELECT COUNT(*) AS clients FROM customer";
$cilent_result = mysqli_query($conn, $cilent_sql); // Corrected variable name

if ($cilent_result && mysqli_num_rows($cilent_result) > 0) {
    $cilent_row = mysqli_fetch_assoc($cilent_result);
    $clients = $cilent_row['clients'];
}

$sale_sql = "SELECT COUNT(*) AS sales FROM payment WHERE payment_status = 'Completed'";
$sale_result = mysqli_query($conn, $sale_sql); // Corrected variable name

if ($sale_result && mysqli_num_rows($sale_result) > 0) {
    $sale_row = mysqli_fetch_assoc($sale_result);
    $sales = $sale_row['sales'];
}


$pending_sql = "SELECT COUNT(*) AS pending_orders FROM ordermaster om JOIN customer c ON om.customer_id=c.customer_id 
                WHERE status NOT IN ('Delivered', 'Cancelled')";
$pending_result = mysqli_query($conn, $pending_sql);

if ($pending_result && mysqli_num_rows($pending_result) > 0) {
    $pending_row = mysqli_fetch_assoc($pending_result);
    $pending_orders = $pending_row['pending_orders'];
}

$query1 = "
    SELECT p.name, SUM(o.total_price) AS total_price
    FROM orderdetails o
    JOIN single_product sp ON o.single_product_id = sp.single_product_id 
    JOIN product p ON sp.product_id = p.product_id 
    GROUP BY p.product_id
    ORDER BY total_price DESC
    LIMIT 5"; // Adjust the limit if needed
$result1 = mysqli_query($conn, $query1);

$productNames = [];
$totalAmounts = [];

while ($row = mysqli_fetch_assoc($result1)) {
    $productNames[] = $row['name'];
    $totalAmounts[] = $row['total_price'];
}


// Query to get sales amount by brand
$query2 = "
    SELECT b.name as brand_name, SUM(o.quantity * p.price) AS total_sales
    FROM orderdetails o
    JOIN single_product sp ON o.single_product_id = sp.single_product_id 
    JOIN product p ON sp.product_id = p.product_id
    JOIN brand b ON p.brand_id = b.brand_id
    GROUP BY b.brand_id
    ORDER BY total_sales DESC";
$result2 = mysqli_query($conn, $query2);

$brandNames = [];
$totalSales = [];

while ($row = mysqli_fetch_assoc($result2)) {
    $brandNames[] = $row['brand_name'];
    $totalSales[] = $row['total_sales'];
}

?>


<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="adminstyle/css/tailwind.output.css" />
    <script
        src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"
        defer></script>
    <script src="adminstyle/js/init-alpine.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</head>

<body>
    <div class="container px-6 mx-auto grid">
        <h2
            class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Dashboard
        </h2>

        <!-- Cards -->
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
            <!-- Card -->
            <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div
                    class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                    </svg>
                </div>
                <div>
                    <p
                        class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Total clients
                    </p>
                    <p
                        class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        <?php echo $clients; ?>
                    </p>
                </div>
            </div>

            <!-- Card -->
            <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div
                    class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path>
                    </svg>
                </div>
                <div>
                    <p
                        class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Total Sales
                    </p>
                    <p
                        class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        <?php echo $sales; ?>
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div
                    class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            fill-rule="evenodd"
                            d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <p
                        class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Pending Orders
                    </p>
                    <p
                        class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        <?php echo $pending_orders; ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Reports -->
        <h2
            class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Sales Report
        </h2>


        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Best Selling Products
        </h2>

        <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <div class="col-md-8" style="margin-left: 150px;margin-bottom: 100px;">
                <div class="card">
                    <canvas id="bestSellingChart"></canvas>
                </div>
            </div>
        </div>

        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Sales by Brand
        </h2>


        <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <div class="col-md-8" style="margin-left: 150px; margin-bottom: 100px;">
                <div class="card">
                    <canvas id="salesByBrandChart" style="width: 500px;height: 500px;"></canvas>
                </div>
            </div>
        </div>
    </div>

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



    <!-- Sales By Best selling products -->
    <script>
        const ctx = document.getElementById('bestSellingChart').getContext('2d');

        // Format the total amounts with the Indian Rupee symbol
        const formattedTotalAmounts = <?php echo json_encode($totalAmounts); ?>.map(amount =>
            new Intl.NumberFormat('en-IN', {
                style: 'currency',
                currency: 'INR',
                minimumFractionDigits: 0
            }).format(amount)
        );

        const bestSellingChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($productNames); ?>,
                datasets: [{
                    label: 'Total Amount',
                    data: <?php echo json_encode($totalAmounts); ?>, // Unformatted for correct bar heights
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const index = context.dataIndex;
                                return `Total Amount: ${formattedTotalAmounts[index]}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₹' + new Intl.NumberFormat('en-IN').format(value);
                            }
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>


    <!-- Sales By Brand -->
    <script>
        const ctx2 = document.getElementById('salesByBrandChart').getContext('2d');
        const salesByBrandChart = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($brandNames); ?>,
                datasets: [{
                    label: 'Total Sales by Brand',
                    data: <?php echo json_encode($totalSales); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += new Intl.NumberFormat('en-IN', {
                                    style: 'currency',
                                    currency: 'INR'
                                }).format(context.raw);
                                return label;
                            }
                        }
                    }
                }
            }
        });
    </script>

    <!-- Sales By Date -->
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

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

</body>

</html>