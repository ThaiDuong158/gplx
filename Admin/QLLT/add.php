<?php
include '../../Condition/auth.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idbaithi = intval($_POST['idbaithi']);
    $ngaythi = $_POST['ngaythi'];
    $thoigian = $_POST['thoigian'];
    $diadiemthi = $_POST['diadiemthi'];
    $soluong = intval($_POST['soluong']);
    $trangthai = $_POST['trangthai'];

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

    // Thêm lịch thi vào database với THOIGIAN và TRANGTHAI
    $sql = "INSERT INTO gplx.lichthi (IDBAITHI, NGAYTHI, THOIGIAN, DIADIEMTHI, SOLUONG, TRANGTHAI) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssis", $idbaithi, $ngaythi, $thoigian, $diadiemthi, $soluong, $trangthai);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Thêm lịch thi thành công!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Lỗi khi thêm lịch thi!"]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Yêu cầu không hợp lệ!"]);
}

$conn->close();
?>
