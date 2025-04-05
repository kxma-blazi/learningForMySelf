<?php
include('config.php');
include('header.php');

// ดึงข้อมูลสินค้า
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tattoo Shop</title>
    <link rel="stylesheet" href="assets/css/style.css"> <!-- เรียกใช้ไฟล์ style.css -->
</head>

<body>

<div class="product-list">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='product'>";
            echo "<h2>" . $row['name'] . "</h2>";
            echo "<p>" . $row['description'] . "</p>";
            echo "<p>Price: " . $row['price'] . " THB</p>";
            echo "<img src='assets/images/" . $row['image'] . "' alt='" . $row['name'] . "' />";
            echo "<button>Add to Cart</button>";
            echo "</div>";
        }
    } else {
        echo "No products found";
    }
    ?>
</div>

<?php include('footer.php'); ?>

</body>
</html>