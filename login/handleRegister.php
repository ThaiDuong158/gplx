<?php
include '../Condition/auth.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ho = $_POST['ho'];
    $ten = $_POST['ten'];
    $email = $_POST['email'];
    $sdt = $_POST['sdt'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Mã hóa mật khẩu
    $idQuyen = 2; // Quyền mặc định (VD: 2 là user thông thường)

    // Kiểm tra username hoặc email đã tồn tại chưa
    $checkQuery = "SELECT * FROM nguoidung WHERE USERNAME = ? OR EMAIL = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Tên đăng nhập hoặc Email đã tồn tại!'); window.location.href = 'register.php';</script>";
    } else {
        // Thêm tài khoản mới vào database
        $query = "INSERT INTO nguoidung (IDQUYEN, USERNAME, PASSWORD, EMAIL, SDT, HO, TEN) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("issssss", $idQuyen, $username, $password, $email, $sdt, $ho, $ten);
        
        if ($stmt->execute()) {
            echo "<script>alert('Đăng ký thành công!'); window.location.href = 'login.php';</script>";
        } else {
            echo "<script>alert('Có lỗi xảy ra, vui lòng thử lại!'); window.location.href = 'register.php';</script>";
        }
    }
    $stmt->close();
}
$conn->close();
?>
