<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับข้อมูลจากฟอร์ม
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];  // รับชื่อไฟล์ภาพ

    // อัปโหลดไฟล์ภาพไปยังโฟลเดอร์ที่กำหนด
    $target = "assets/images/" . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $target);

    // เพิ่มข้อมูลสินค้าลงในฐานข้อมูล
    $sql = "INSERT INTO products (name, price, description, image) 
            VALUES ('$name', '$price', '$description', '$image')";

    if ($conn->query($sql) === TRUE) {
        echo "Product added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

include('header.php');
?>

<h2>Add Product</h2>

<form method="POST" enctype="multipart/form-data">
    <label for="name">Product Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label for="price">Price:</label><br>
    <input type="number" name="price" step="0.01" required><br><br>

    <label for="description">Description:</label><br>
    <textarea name="description" required></textarea><br><br>

    <label for="image">Image:</label><br>
    <input type="D:\xampp\htdocs\ecommerce\assets\images\tattoo1.jpg" name="image" required><br><br>

    <button type="submit">Add Product</button>
</form>

<?php include('footer.php'); ?>
