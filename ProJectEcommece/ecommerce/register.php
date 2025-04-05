<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับข้อมูลจากฟอร์ม
    $name = htmlspecialchars($_POST['name']);  // ป้องกันการโจมตี XSS
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // กรองค่าอีเมล
    $password = $_POST['password'];

    // ตรวจสอบว่าอีเมลมีรูปแบบที่ถูกต้อง
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<p>Invalid email format. Please try again.</p>";
    } else {
        // เช็คว่าอีเมลนี้มีในฐานข้อมูลหรือยัง
        $sql_check = "SELECT * FROM users WHERE email = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            echo "<p>Email already exists! Please try again with a different email.</p>";
        } else {
            // เข้ารหัสรหัสผ่านก่อนบันทึก
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);

            // เพิ่มข้อมูลผู้ใช้ใหม่ในฐานข้อมูล
            $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $name, $email, $password_hashed);

            if ($stmt->execute()) {
                echo "<p>New record created successfully. Redirecting...</p>";
                header("Location: login.php"); // เปลี่ยนเส้นทางไปยังหน้า login
                exit();
            } else {
                echo "<p>Error: " . $stmt->error . "</p>";
            }
        }
    }
}

include('header.php');
?>

<form method="POST" class="form-container">
    <h2>Register</h2><br>
    Name: <input type="text" name="name" class="input-field" required><br><br>
    Email: <input type="email" name="email" class="input-field" required><br><br>
    Password: <input type="password" name="password" class="input-field" required><br><br>
    <button type="submit" class="button2">Register</button><br><br>
    <a href="login.php">Already have an account? Login here</a>
</form>

<?php include('footer.php'); ?>
