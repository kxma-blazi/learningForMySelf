<?php 
session_start(); // เริ่ม session

// เชื่อมต่อกับฐานข้อมูล E-commerce
$conn = new mysqli("localhost", "root", "", "ecommerce");  // เปลี่ยน 'ecommerce' เป็นชื่อฐานข้อมูลของคุณ

// ตรวจสอบการเชื่อมต่อฐานข้อมูล
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // กรองค่าอีเมล
    $password = $_POST['password'];

    // ตรวจสอบว่าอีเมลถูกต้องหรือไม่
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<p>Invalid email format. Please try again.</p>";
    } else {
        // ตรวจสอบว่ามีผู้ใช้อยู่ในฐานข้อมูลหรือไม่
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);  // Bind email เป็น string
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            // รับข้อมูลผู้ใช้
            $row = $result->fetch_assoc();
            
            // ตรวจสอบรหัสผ่าน
            if (password_verify($password, $row['password'])) {
                // ตั้งค่า session
                $_SESSION['email'] = $email;
                $_SESSION['name'] = $row['name'];  // เก็บชื่อผู้ใช้ใน session
                $_SESSION['role'] = $row['role']; // เก็บ role ของผู้ใช้ใน session (เช่น admin, user)

                // เปลี่ยนเส้นทางไปยังหน้าหลักหรือหน้าผู้ใช้
                if ($row['role'] == 'Admin') {
                    header("Location: admin_dashboard.php");  // สำหรับผู้ใช้ที่เป็น admin
                } else {
                    header("Location: index.php");  // สำหรับผู้ใช้ทั่วไป
                }
                exit();
            } else {
                echo "<p>Invalid password. Please try again.</p>";
            }
        } else {
            echo "<p>No user found with that email. Please try again.</p>";
        }
    }
}

$conn->close();  // ปิดการเชื่อมต่อฐานข้อมูล
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- เรียกใช้ style.css ที่อยู่ในโฟลเดอร์ css -->
    <link href="css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="form-container">
        <form action="login.php" method="POST">
            <h2>Login</h2>

            <div class="field">
                <input autocomplete="off" name="email" placeholder="Email" class="input-field" type="email" required>
            </div><br>

            <div class="field">
                <input name="password" placeholder="Password" class="input-field" type="password" required>
            </div>

            <div class="btn">
                <button type="submit" class="button2">Login</button>
            </div>

            <div class="register-link">
                <a href="register.php">Don't have an account? Register here</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
