<?php
include('Connection.php');

if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $query3 = "
        SELECT om.order_date AS sale_date, SUM(o.total_price) AS daily_total
        FROM ordermaster om
        JOIN orderdetails o ON om.ordermaster_id = o.ordermaster_id
        WHERE om.order_date BETWEEN ? AND ?
        GROUP BY om.order_date
        ORDER BY om.order_date";

    $stmt = $conn->prepare($query3);
    $stmt->bind_param('ss', $start_date, $end_date);
    $stmt->execute();
    $result3 = $stmt->get_result();

    $dates = [];
    $totals = [];
    while ($row = mysqli_fetch_assoc($result3)) {
        $dates[] = $row['sale_date'];
        $totals[] = $row['daily_total'];
    }

    // Send JSON response for AJAX request
    echo json_encode(['dates' => $dates, 'totals' => $totals]);
    exit;
}
?>
