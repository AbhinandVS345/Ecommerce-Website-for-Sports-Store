<?php

include('connection.php');

$address_id = isset($_POST['address_id']) ? intval($_POST['address_id']) : 0;

if ($address_id > 0) {

    $stmt = "SELECT * FROM deliveryaddress WHERE deliveryaddress_id = '$address_id'";

    $result = mysqli_query($conn, $stmt);

    if (mysqli_num_rows($result)>0) {
        $address = mysqli_fetch_assoc($result);
        echo json_encode($address);
    } else {
        echo json_encode(['error' => 'Address not found']);
    }
} else {
    echo json_encode(['error' => 'Invalid address ID']);
}
?>