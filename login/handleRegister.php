<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Kiểm tra dữ liệu nhập vào có rỗng không
    if (empty($name) || empty($email) || empty($username) || empty($password)) {
        $_SESSION['error'] = "Vui lòng nhập đầy đủ thông tin!";
        header("Location: register.php");
        exit();
    }

    // Kiểm tra định dạng email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Email không hợp lệ!";
        header("Location: register.php");
        exit();
    }

    // Mã hóa mật khẩu trước khi lưu vào database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Kiểm tra xem email hoặc username đã tồn tại chưa
    $sql_check = "SELECT * FROM nguoidung WHERE EMAIL = ? OR USERNAME = ?";
    $stmt = $conn->prepare($sql_check);
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Email hoặc tên đăng nhập đã tồn tại!";
        header("Location: register.php");
        exit();
    }

    // Thêm người dùng vào database
    $sql = "INSERT INTO nguoidung (HOTEN, EMAIL, USERNAME, PASSWORD, IDQUYEN) VALUES (?, ?, ?, ?, 2)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $username, $hashed_password);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Đăng ký thành công! Vui lòng đăng nhập.";
        header("Location: login.php");
    } else {
        $_SESSION['error'] = "Đã xảy ra lỗi, vui lòng thử lại!";
        header("Location: register.php");
    }

    $stmt->close();
    $conn->close();
}
?>
