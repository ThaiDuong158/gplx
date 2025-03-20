<?php
include '../../Condition/auth.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $idbaithi = intval($_POST['idbaithi']);
    $ngaythi = $_POST['ngaythi'];
    $diadiemthi = $_POST['diadiemthi'];
    $soluong = intval($_POST['soluong']);

    // Kiểm tra xem bài thi có hợp lệ không (phải là "Hoạt động")
    $check_sql = "SELECT * FROM gplx.baithi WHERE IDBAITHI = ? AND TRANGTHAI = 'Hoạt động'";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $idbaithi);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(["status" => "error", "message" => "Bài thi không hợp lệ hoặc không hoạt động!"]);
        exit();
    }

    // Cập nhật lịch thi
    $sql = "UPDATE gplx.lichthi SET IDBAITHI = ?, NGAYTHI = ?, DIADIEMTHI = ?, SOLUONG = ? WHERE IDLICHTHI = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issii", $idbaithi, $ngaythi, $diadiemthi, $soluong, $id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Cập nhật thành công!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Lỗi khi cập nhật!"]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Yêu cầu không hợp lệ!"]);
}

$conn->close();
?>