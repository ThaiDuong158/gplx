<?php
include '../../Condition/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['examName'], $_POST['examTime'], $_POST['examStatus'])) {
        $examName = $_POST['examName'];
        $examTime = intval($_POST['examTime']);
        $examStatus = $_POST['examStatus'];

        // Kiểm tra trạng thái hợp lệ
        $validStatuses = ['Hoạt động', 'Không hoạt động', 'Thi thử'];
        if (!in_array($examStatus, $validStatuses)) {
            echo "<script>alert('Trạng thái không hợp lệ.'); window.location.href='index.php';</script>";
            exit();
        }

        // Thêm bài thi vào bảng baithi
        $sql = "INSERT INTO baithi (TenBaiThi, THOIGIAN, TRANGTHAI) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sis", $examName, $examTime, $examStatus);

        if ($stmt->execute()) {
            header("Location: index.php"); // Chuyển hướng về trang index.php
            exit();
        } else {
            echo "<script>alert('Lỗi khi thêm bài thi.'); window.location.href='index.php';</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Thiếu dữ liệu đầu vào.'); window.location.href='index.php';</script>";
    }
} else {
    echo "<script>alert('Phương thức không hợp lệ.'); window.location.href='index.php';</script>";
}

$conn->close();
?>