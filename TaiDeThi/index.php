<?php
include '../Condition/auth.php';
require_once __DIR__ . '/../vendor/autoload.php'; // Gọi mPDF

// Kết nối database và đảm bảo UTF-8
$conn->set_charset("utf8");

// Đường dẫn ảnh dựa trên URL
$imageBaseURL = "../assets/img/cauhoi/"; // Đảm bảo URL đúng

// Khởi tạo mPDF với font mặc định hỗ trợ tiếng Việt
$mpdf = new \Mpdf\Mpdf([
    'default_font' => 'dejavusans'
]);

// Bootstrap CSS để tạo kiểu
$bootstrapCSS = "
<style>
    body { 
        font-family: 'DejaVu Sans', sans-serif; 
        font-size: 14px; 
        margin: 20px; 
    }
    .container { 
        width: 100%; 
        padding: 10px; 
    }
    h1 { 
        text-align: center; 
        color: #007bff; 
        font-size: 20px; 
        text-transform: uppercase; 
        margin-bottom: 20px; 
    }
    .question { 
        font-weight: bold; 
        margin-top: 15px; 
        font-size: 16px; 
    }
    .answer { 
        list-style: none; 
        padding-left: 0; 
        margin-top: 10px;
    }
    .answer li { 
        padding: 8px; 
        border-radius: 5px; 
        margin-bottom: 5px; 
        font-size: 14px;
    }
    .correct { 
        color: white; 
        background: #28a745; /* Màu xanh đậm cho đáp án đúng */ 
        padding: 8px; 
        font-weight: bold;
    }
    .incorrect { 
        color: black; 
        background: #f1f1f1; /* Màu sáng hơn cho đáp án sai */ 
        padding: 8px; 
    }
    img { 
        max-width: 250px; 
        display: block; 
        margin: 10px auto; 
        border: 1px solid #ddd; 
        border-radius: 5px;
    }
    hr { 
        border-top: 2px solid #007bff; 
        margin: 20px 0; 
    }
</style>";


$html = '<div class="container">';
$html .= '<h1>Danh sách câu hỏi lý thuyết</h1><hr>';

// Truy vấn dữ liệu từ bảng cauhoi
$sql = "SELECT * FROM cauhoi";
$result = $conn->query($sql);

$stt = 1; // Biến đếm số thứ tự

while ($row = $result->fetch_assoc()) {
    $questionText = $row['CAUHOI'];

    // Xử lý ảnh trong câu hỏi
    if (preg_match('/@img:.*\/([^\/]+)$/', $questionText, $matches)) {
        $imageName = $matches[1]; // Chỉ lấy tên file ảnh
        $imageURL = $imageBaseURL . $imageName; // URL đầy đủ của ảnh

        // Kiểm tra ảnh có tồn tại không
        if (@getimagesize($imageURL)) {
            $imgTag = "<img src='$imageURL' alt='Câu hỏi' />";
        } else {
            $imgTag = "<p style='color:red;'>[Hình ảnh không tồn tại]</p>";
        }
        $questionText = str_replace($matches[0], $imgTag, $questionText);
    }

    // Thêm số thứ tự vào câu hỏi
    $html .= "<p class='question'><b>Câu $stt:</b> $questionText</p>";
    $html .= '<ul class="answer">';

    // Đáp án
    $answers = ['A' => $row['A'], 'B' => $row['B'], 'C' => $row['C'], 'D' => $row['D']];
    foreach ($answers as $key => $answer) {
        // Xử lý ảnh trong đáp án
        if (preg_match('/@img:.*\/([^\/]+)$/', $answer, $matches)) {
            $imageName = $matches[1];
            $imageURL = $imageBaseURL . $imageName;

            if (@getimagesize($imageURL)) {
                $imgTag = "<img src='$imageURL' alt='Đáp án' />";
            } else {
                $imgTag = "<p style='color:red;'>[Hình ảnh không tồn tại]</p>";
            }
            $answer = str_replace($matches[0], $imgTag, $answer);
        }

        if ($key == $row['DAPAN']) {
            $html .= "<li class='correct'>$key. $answer</li>";
        } else {
            $html .= "<li class='incorrect'>$key. $answer</li>";
        }
    }
    $html .= '</ul><hr>';

    $stt++; // Tăng số thứ tự lên 1
}

$html .= '</div>';

// Đưa nội dung vào mPDF
$mpdf->WriteHTML($bootstrapCSS . $html);

// Xuất PDF
$mpdf->Output('de_thi_ly_thuyet.pdf', 'D');

$conn->close();
?>