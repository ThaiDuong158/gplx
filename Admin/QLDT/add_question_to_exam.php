<?php
include '../../Condition/auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idCauHoi = $_POST['idCauHoi'];
    $idBaiThi = $_POST['idBaiThi'];
    $checked = $_POST['checked'];

    if ($checked == "true") {
        // Thêm vào bảng baithi_cauhoi nếu chưa tồn tại
        $sql = "INSERT IGNORE INTO baithi_cauhoi (IDBAITHI, IDCAUHOI) VALUES (?, ?)";
    } else {
        // Xóa khỏi bảng baithi_cauhoi
        $sql = "DELETE FROM baithi_cauhoi WHERE IDBAITHI = ? AND IDCAUHOI = ?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $idBaiThi, $idCauHoi);

    if (!$stmt->execute()) {
        error_log("Lỗi khi thực thi truy vấn: " . $stmt->error); 
    } else {
        if ($checked == "true") {
            echo "added"; 
        } else {
            echo "removed";
        }
    }

    $stmt->close();
    $conn->close();
}
?>