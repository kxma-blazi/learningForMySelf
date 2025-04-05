<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $payment_method = $_POST['payment_method'];
    $status = $_POST['status'];

    $payment_sql = "INSERT INTO payments (order_id, payment_method, status) VALUES ('$order_id', '$payment_method', '$status')";
    if ($conn->query($payment_sql) === TRUE) {
        echo "Payment recorded successfully!";
    }
}
?>

<form method="POST">
    Order ID: <input type="text" name="order_id" required><br>
    Payment Method: <input type="text" name="payment_method" required><br>
    Status: <input type="text" name="status" required><br>
    <button type="submit">Record Payment</button>
</form>
