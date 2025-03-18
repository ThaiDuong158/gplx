<?php
include '../../Condition/auth.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    // Xóa dữ liệu từ bảng liên quan trước (nếu có khóa ngoại)
    $conn->query("DELETE FROM dapanhocsinh WHERE IDCAUHOI = $id");

    // Xóa câu hỏi
    $sql = "DELETE FROM cauhoi WHERE IDCAUHOI = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Xóa thành công!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi xóa!'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: index.php");
    exit();
}
?>
