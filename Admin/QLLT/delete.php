<?php
include '../../Condition/auth.php';


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']); // Chuyển ID về kiểu số nguyên để tránh SQL Injection

    $sql = "DELETE FROM gplx.lichthi WHERE IDLICHTHI = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Xóa thành công!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Lỗi khi xóa!"]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Yêu cầu không hợp lệ!"]);
}

$conn->close();
?>
