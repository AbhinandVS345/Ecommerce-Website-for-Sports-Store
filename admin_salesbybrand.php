<?php
include('connection.php');

// Query to get sales amount by brand
$query = "
    SELECT b.name as brand_name, SUM(o.quantity * p.price) AS total_sales
    FROM orderdetails o
    JOIN single_product sp ON o.single_product_id = sp.single_product_id 
    JOIN product p ON sp.product_id = p.product_id
    JOIN brand b ON p.brand_id = b.brand_id
    GROUP BY b.brand_id
    ORDER BY total_sales DESC";
$result = mysqli_query($conn, $query);

$brandNames = [];
$totalSales = [];

while ($row = mysqli_fetch_assoc($result)) {
    $brandNames[] = $row['brand_name'];
    $totalSales[] = $row['total_sales'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales by Brand</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

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

    <script>
        const ctx = document.getElementById('salesByBrandChart').getContext('2d');
        const salesByBrandChart = new Chart(ctx, {
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

</body>

</html>