<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id']; // สมมุติว่าได้ข้อมูลจาก session หรือฟอร์ม
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // เพิ่มคำสั่งซื้อใหม่
    $order_sql = "INSERT INTO orders (user_id, status) VALUES ('$user_id', 'pending')";
    if ($conn->query($order_sql) === TRUE) {
        $order_id = $conn->insert_id;

        // เพิ่มสินค้าในคำสั่งซื้อ
        $order_item_sql = "INSERT INTO order_items (order_id, product_id, quantity) VALUES ('$order_id', '$product_id', '$quantity')";
        if ($conn->query($order_item_sql) === TRUE) {
            echo "Order placed successfully!";
        }
    }
}
?>

<form method="POST">
    User ID: <input type="text" name="user_id" required><br>
    Product ID: <input type="text" name="product_id" required><br>
    Quantity: <input type="number" name="quantity" required><br>
    <button type="submit">Place Order</button>
</form>
