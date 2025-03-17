<?php
include '../../Condition/auth.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    
    $sql = "DELETE FROM nguoidung WHERE IDNGUOIDUNG=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Xóa thành công!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi xóa!');</script>";
    }
}
?>
