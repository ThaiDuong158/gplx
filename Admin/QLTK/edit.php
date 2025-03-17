<?php
include '../../Condition/auth.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hoten = $_POST['hoten'];
    $ho_ten = explode(" ", $hoten, 2);
    $ho = $ho_ten[0];
    $ten = isset($ho_ten[1]) ? $ho_ten[1] : "";
    $email = $_POST['email'];
    $sdt = $_POST['sdt'];
    $quyen = $_POST['quyen'];

    // Mã hóa mật khẩu nếu có thay đổi
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    }

    // Xử lý ảnh đại diện
    $avatar = "";
    if (isset($_FILES['avatar']) && $_FILES['avatar']['size'] > 0) {
        $target_dir = "../../assets/img/avatar/$id/"; // Thư mục lưu avatar
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true); // Tạo thư mục nếu chưa tồn tại
        }

        $avatar_name = basename($_FILES["avatar"]["name"]);
        $avatar_path = $target_dir . $avatar_name;
        $imageFileType = strtolower(pathinfo($avatar_path, PATHINFO_EXTENSION));

        // Kiểm tra định dạng ảnh
        $allowed_types = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($imageFileType, $allowed_types)) {
            echo "<script>alert('Chỉ chấp nhận định dạng JPG, JPEG, PNG, GIF!');</script>";
            exit();
        }

        // Di chuyển file ảnh tải lên
        if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $avatar_path)) {
            $avatar = $avatar_name;
        } else {
            echo "<script>alert('Lỗi khi tải lên ảnh!');</script>";
            exit();
        }
    }

    // Cập nhật thông tin vào cơ sở dữ liệu
    if (!empty($password) && $avatar !== "") {
        $sql = "UPDATE nguoidung SET USERNAME=?, PASSWORD=?, HO=?, TEN=?, EMAIL=?, SDT=?, AVATAR=?, IDQUYEN=? WHERE IDNGUOIDUNG=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssii", $username, $hashed_password, $ho, $ten, $email, $sdt, $avatar, $quyen, $id);
    } elseif (!empty($password)) {
        $sql = "UPDATE nguoidung SET USERNAME=?, PASSWORD=?, HO=?, TEN=?, EMAIL=?, SDT=?, IDQUYEN=? WHERE IDNGUOIDUNG=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssii", $username, $hashed_password, $ho, $ten, $email, $sdt, $quyen, $id);
    } elseif ($avatar !== "") {
        $sql = "UPDATE nguoidung SET USERNAME=?, HO=?, TEN=?, EMAIL=?, SDT=?, AVATAR=?, IDQUYEN=? WHERE IDNGUOIDUNG=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssii", $username, $ho, $ten, $email, $sdt, $avatar, $quyen, $id);
    } else {
        $sql = "UPDATE nguoidung SET USERNAME=?, HO=?, TEN=?, EMAIL=?, SDT=?, IDQUYEN=? WHERE IDNGUOIDUNG=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssiii", $username, $ho, $ten, $email, $sdt, $quyen, $id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Cập nhật thành công!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi cập nhật!');</script>";
    }
}
?>
