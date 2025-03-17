<?php
include '../../Condition/auth.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $hoten = $_POST['hoten'];
    $ho_ten = explode(" ", $hoten, 2);
    $ho = $ho_ten[0];
    $ten = isset($ho_ten[1]) ? $ho_ten[1] : "";
    $email = $_POST['email'];

    $sql = "UPDATE nguoidung SET USERNAME=?, HO=?, TEN=?, EMAIL=? WHERE IDNGUOIDUNG=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $username, $ho, $ten, $email, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Cập nhật thành công!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi cập nhật!');</script>";
    }
}
?>