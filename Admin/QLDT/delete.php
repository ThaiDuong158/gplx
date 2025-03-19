<?php
include '../../Condition/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $id = intval($_POST['id']);

        // Xóa các câu hỏi liên quan trong bảng baithi_cauhoi
        $sql_delete_questions = "DELETE FROM baithi_cauhoi WHERE IDBAITHI = ?";
        $stmt_questions = $conn->prepare($sql_delete_questions);
        $stmt_questions->bind_param("i", $id);
        $stmt_questions->execute();
        $stmt_questions->close();

        // Xóa bài thi trong bảng baithi
        $sql = "DELETE FROM baithi WHERE IDBAITHI = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header("Location: index.php"); // Chuyển hướng về trang index.php
            exit();
        } else {
            echo "<script>alert('Lỗi khi xóa bài thi.'); window.location.href='index.php';</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Thiếu ID bài thi.'); window.location.href='index.php';</script>";
    }
} else {
    echo "<script>alert('Phương thức không hợp lệ.'); window.location.href='index.php';</script>";
}

$conn->close();
?>