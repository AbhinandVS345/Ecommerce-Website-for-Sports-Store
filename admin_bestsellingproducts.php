<?php
include('connection.php');

$query = "
    SELECT p.name, SUM(o.total_price) AS total_price
    FROM orderdetails o
    JOIN single_product sp ON o.single_product_id = sp.single_product_id 
    JOIN product p ON sp.product_id = p.product_id 
    GROUP BY p.product_id
    ORDER BY total_price DESC
    LIMIT 5"; // Adjust the limit if needed
$result = mysqli_query($conn, $query);

$productNames = [];
$totalAmounts = [];

while ($row = mysqli_fetch_assoc($result)) {
    $productNames[] = $row['name'];
    $totalAmounts[] = $row['total_price'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Best Selling Products</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

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

</body>

</html>