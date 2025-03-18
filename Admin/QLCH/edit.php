<?php
include '../../Condition/auth.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $cauhoi = $_POST['cauhoi'];
    $a = $_POST['a'];
    $b = $_POST['b'];
    $c = $_POST['c'];
    $d = $_POST['d'];
    $dapan = $_POST['dapan'];

    // Thư mục lưu ảnh
    $targetDir = "../../assets/img/cauhoi/";

    // Tạo thư mục nếu chưa có
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Hàm xử lý upload file & xóa ảnh cũ
    function uploadFile($inputName, $oldValue) {
        global $targetDir;

        if (!empty($_FILES[$inputName]['name'])) {
            $fileExt = pathinfo($_FILES[$inputName]["name"], PATHINFO_EXTENSION);
            $newFileName = time() . "_" . basename($_FILES[$inputName]["name"]);
            $targetFilePath = $targetDir . $newFileName;

            // Xóa ảnh cũ nếu có
            if (!empty($oldValue) && file_exists($oldValue)) {
                unlink($oldValue);
            }

            // Kiểm tra & lưu file mới
            if (move_uploaded_file($_FILES[$inputName]["tmp_name"], $targetFilePath)) {
                return $targetFilePath;
            }
        }
        return $oldValue; // Giữ nguyên nếu không có ảnh mới
    }

    // Hàm xóa ảnh nếu người dùng chọn xóa
    function deleteOldImage($checkboxName, $oldValue) {
        if (isset($_POST[$checkboxName]) && $_POST[$checkboxName] == "delete") {
            if (!empty($oldValue) && file_exists($oldValue)) {
                unlink($oldValue); // Xóa ảnh khỏi thư mục
            }
            return ""; // Xóa ảnh trong database
        }
        return $oldValue; // Giữ nguyên nếu không chọn xóa
    }

    // Xử lý ảnh câu hỏi và các đáp án
    $cauhoi_img = deleteOldImage("delete_cauhoi_img", $_POST['cauhoi_img_old'] ?? "");
    $cauhoi_img = uploadFile("cauhoi_img", $cauhoi_img);

    $a_img = deleteOldImage("delete_a_img", $_POST['a_img_old'] ?? "");
    $a_img = uploadFile("a_img", $a_img);

    $b_img = deleteOldImage("delete_b_img", $_POST['b_img_old'] ?? "");
    $b_img = uploadFile("b_img", $b_img);

    $c_img = deleteOldImage("delete_c_img", $_POST['c_img_old'] ?? "");
    $c_img = uploadFile("c_img", $c_img);

    $d_img = deleteOldImage("delete_d_img", $_POST['d_img_old'] ?? "");
    $d_img = uploadFile("d_img", $d_img);

    // Ghi chú ảnh vào dữ liệu nếu có
    if ($cauhoi_img) $cauhoi .= " @img:" . $cauhoi_img;
    if ($a_img) $a .= " @img:" . $a_img;
    if ($b_img) $b .= " @img:" . $b_img;
    if ($c_img) $c .= " @img:" . $c_img;
    if ($d_img) $d .= " @img:" . $d_img;

    // Cập nhật dữ liệu vào database
    $sql = "UPDATE cauhoi SET CAUHOI = ?, A = ?, B = ?, C = ?, D = ?, DAPAN = ? WHERE IDCAUHOI = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $cauhoi, $a, $b, $c, $d, $dapan, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Cập nhật thành công!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi cập nhật: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: index.php");
    exit();
}
?>
