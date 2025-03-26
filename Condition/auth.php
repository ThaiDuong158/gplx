<?php
session_start();

// Các trang web
$Home = '/index.php';
$Login = '/login/login.php';
$Register = '/login/register.php';
$Forgot = '/login/forgot-password.php';
$Logout = '/login/logout.php';
$UserInfo = '/user/updateInfo.php';
$TaiDeThi = '/TaiDeThi/index.php';
$ThiThu = '/ThiThu/index.php';
$Thi = '/Thi/index.php';

$AdminQLTK = '/Admin/QLTK/index.php';
$AdminQLCH = '/Admin/QLCH/index.php';
$AdminQLDT = '/Admin/QLDT/index.php';
$AdminQLLT = '/Admin/QLLT/index.php';


$Address = '73 Nguyễn Huệ, Phường 2, Vĩnh Long, Việt Nam';
$Phone = '(+84) 027 03822 141';
$Email = 'spktvl@vlute.edu.vn';

// Danh sách trang ngoại lệ (không cần đăng nhập)
$allowed_pages = [
    $Home,
    $TaiDeThi,
    $Login,
    $Register,
    $Forgot,
];

// Lấy đường dẫn của trang hiện tại (tính từ thư mục gốc)
$current_page = $_SERVER['PHP_SELF'];

// Nếu trang hiện tại không nằm trong danh sách ngoại lệ và chưa đăng nhập
if (!in_array($current_page, $allowed_pages) && !isset($_SESSION['user_id'])) {
    // Chuyển hướng đến trang đăng nhập
    // header("Location: $Login");
    // exit();
}

// Kết nối MySQL
$servername = "localhost";
$username = "root";
$password = ""; 
$database = "gplx"; 

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);


?>