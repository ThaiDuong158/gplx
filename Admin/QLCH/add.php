<?php
include '../../Condition/auth.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cauhoi = $_POST['cauhoi'];
    $a = $_POST['a'];
    $b = $_POST['b'];
    $c = $_POST['c'];
    $d = $_POST['d'];
    $dapan = $_POST['dapan'];
    $loaicauhoi = $_POST['loaicauhoi']; // Lấy giá trị loại câu hỏi

    // Thư mục lưu ảnh
    $targetDir = "../../assets/img/cauhoi/";

    // Tạo thư mục nếu chưa có
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Hàm xử lý upload ảnh
    function uploadImage($inputName) {
        global $targetDir;

        if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] == 0) {
            $fileExt = strtolower(pathinfo($_FILES[$inputName]["name"], PATHINFO_EXTENSION));
            $allowTypes = ['jpg', 'png', 'jpeg', 'gif'];

            // Kiểm tra định dạng ảnh hợp lệ
            if (!in_array($fileExt, $allowTypes)) {
                return ["error" => "Chỉ chấp nhận file ảnh JPG, JPEG, PNG, GIF"];
            }

            $newFileName = time() . "_" . uniqid() . "." . $fileExt;
            $targetFilePath = $targetDir . $newFileName;

            // Kiểm tra và lưu file ảnh
            if (move_uploaded_file($_FILES[$inputName]["tmp_name"], $targetFilePath)) {
                return ["success" => "@img:" . $targetFilePath];
            } else {
                return ["error" => "Lỗi khi lưu ảnh"];
            }
        }
        return ["success" => null];
    }

    // Xử lý upload ảnh
    $cauhoi_img = uploadImage("cauhoi_img");
    $a_img = uploadImage("a_img");
    $b_img = uploadImage("b_img");
    $c_img = uploadImage("c_img");
    $d_img = uploadImage("d_img");

    // Kiểm tra lỗi ảnh
    $errors = [];
    foreach ([$cauhoi_img, $a_img, $b_img, $c_img, $d_img] as $img) {
        if (isset($img["error"])) {
            $errors[] = $img["error"];
        }
    }

    // Nếu có lỗi ảnh, trả về lỗi
    if (!empty($errors)) {
        echo json_encode(["status" => "error", "message" => implode(", ", $errors)]);
        exit();
    }

    // Gán ảnh vào câu hỏi nếu có
    if ($cauhoi_img["success"]) $cauhoi .= " " . $cauhoi_img["success"];
    if ($a_img["success"]) $a .= " " . $a_img["success"];
    if ($b_img["success"]) $b .= " " . $b_img["success"];
    if ($c_img["success"]) $c .= " " . $c_img["success"];
    if ($d_img["success"]) $d .= " " . $d_img["success"];

    // Thêm câu hỏi vào database (có LOAICAUHOI)
    $sql = "INSERT INTO cauhoi (CAUHOI, A, B, C, D, DAPAN, LOAICAUHOI) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $cauhoi, $a, $b, $c, $d, $dapan, $loaicauhoi);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Thêm câu hỏi thành công"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Lỗi khi thêm câu hỏi"]);
    }

    $stmt->close();
    $conn->close();
}
?>
