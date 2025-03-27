<?php
include '../Condition/auth.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kiểm tra tài khoản trong database
    $query = "SELECT * FROM nguoidung WHERE USERNAME = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Kiểm tra mật khẩu
        if (password_verify($password, $user['PASSWORD'])) {
            // Lưu thông tin vào session
            $_SESSION['user_id'] = $user['IDNGUOIDUNG'];
            $_SESSION['username'] = $user['USERNAME'];
            $_SESSION['id_quyen'] = $user['IDQUYEN'];

            echo "<script>alert('Đăng nhập thành công!'); window.location.href = '".$Home."';</script>";
        } else {
            echo "<script>alert('Sai mật khẩu!'); window.location.href = 'login.php';</script>";
        }
    } else {
        echo "<script>alert('Tên đăng nhập không tồn tại!'); window.location.href = 'login.php';</script>";
    }

    $stmt->close();
}
$conn->close();
?>
