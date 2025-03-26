<?php
include '../Condition/auth.php';

// Kết nối database và đảm bảo UTF-8
$conn->set_charset("utf8");

// Lấy ID bài thi từ URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID bài thi không hợp lệ!");
}
$idBaiThi = intval($_GET['id']);

// Truy vấn thông tin bài thi
$sqlBaiThi = "SELECT * FROM gplx.baithi WHERE IDBAITHI = $idBaiThi";
$resultBaiThi = $conn->query($sqlBaiThi);
$baiThi = $resultBaiThi->fetch_assoc();

if (!$baiThi) {
    die("Bài thi không tồn tại!");
}
// Truy vấn danh sách câu hỏi trong bài thi
$sqlCauHoi = "SELECT ch.* FROM gplx.cauhoi ch 
              JOIN gplx.baithi_cauhoi bc ON ch.IDCAUHOI = bc.IDCAUHOI 
              WHERE bc.IDBAITHI = $idBaiThi 
              ORDER BY RAND()";
$resultCauHoi = $conn->query($sqlCauHoi);

$totalQuestions = $resultCauHoi->num_rows;
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($baiThi['TenBaiThi']); ?></title>
    <?php include '../Layout/UserLayout/linkscss.php'; ?>

    <style>
        .col-sticky {
            position: sticky;
            top: 20px;
        }

        #questionStatusContainer {
            position: sticky;
            top: 160px;
        }

        #questionStatus {
            border: 2px solid #ccc;
            padding: 10px;
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <?php include '../Layout/UserLayout/header.php'; ?>
    <main class="main">
        <div class="pt-4"></div>
        <div class="pt-4"></div>
        <div class="pt-4"></div>
        <div class="pt-4"></div>
        <div class="container mt-4">
            <div class="row position-relative">
                <div class="col-10">
                    <h2><?php echo htmlspecialchars($baiThi['TenBaiThi']); ?></h2>
                    <form action="ket-qua.php" method="post">
                        <input type="hidden" name="idBaiThi" value="<?php echo $idBaiThi; ?>">
                        <?php $index = 1;
                        while ($row = $resultCauHoi->fetch_assoc()): ?>
                            <div class="card mb-3" id="question-<?php echo $index; ?>">
                                <div class="card-body">
                                    <p class="fw-bold">
                                        <?php echo "Câu " . $index . ": "; ?>
                                        <?php
                                        if (strpos($row['CAUHOI'], '@img:') !== false) {
                                            $parts = explode('@img:', $row['CAUHOI']);
                                            $text = trim($parts[0]);
                                            $imgPath = isset($parts[1]) ? trim($parts[1]) : '';

                                            if (!empty($imgPath)) {
                                                echo "<img src='$imgPath' alt='Câu hỏi $index' class='img-fluid d-block mb-2'>";
                                            }

                                            if (!empty($text)) {
                                                echo htmlspecialchars($text);
                                            }
                                        } else {
                                            echo htmlspecialchars($row['CAUHOI']);
                                        }
                                        ?>
                                    </p>
                                    <?php foreach (['A', 'B', 'C', 'D'] as $option): ?>
                                        <?php
                                        $inputId = "q{$row['IDCAUHOI']}{$option}";
                                        $answer = $row[$option];

                                        // Kiểm tra nếu đáp án chứa hình ảnh
                                        if (strpos($answer, '@img:') !== false) {
                                            $parts = explode('@img:', $answer);
                                            $text = trim($parts[0]); // Lấy phần chữ nếu có
                                            $imgPath = isset($parts[1]) ? trim($parts[1]) : ''; // Lấy đường dẫn ảnh nếu có
                                        } else {
                                            $text = $answer;
                                            $imgPath = '';
                                        }
                                        ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="<?php echo $inputId; ?>"
                                                name="answers[<?php echo $row['IDCAUHOI']; ?>]" value="<?php echo $option; ?>"
                                                required onclick="updateStatus(<?php echo $index; ?>)">
                                            <label class="form-check-label" for="<?php echo $inputId; ?>">
                                                <?php
                                                if (!empty($imgPath)) {
                                                    echo "<img src='$imgPath' alt='Đáp án $option' class='img-fluid d-block mb-2'>";
                                                }
                                                if (!empty($text)) {
                                                    echo htmlspecialchars($text);
                                                }
                                                ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>

                                </div>
                            </div>
                            <?php $index++; endwhile; ?>
                        <button type="submit" class="btn btn-success">Nộp bài</button>
                    </form>
                </div>
                <div class="col col-sticky">
                    <div id="questionStatusContainer">
                        <h4>Trạng thái câu hỏi</h4>
                        <div id="questionStatus" class="d-flex flex-wrap gap-2">
                            <?php for ($i = 1; $i <= $totalQuestions; $i++): ?>
                                <button id="q<?php echo $i; ?>" class="btn btn-outline-dark status-btn"> <?php echo $i; ?>
                                </button>
                            <?php endfor; ?>
                        </div>
                        <p>Thời gian làm bài: <span id="timer" class="fw-bold text-danger"></span></p>

                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include '../Layout/UserLayout/footer.php'; ?>
    <?php include '../Layout/UserLayout/linksjs.php'; ?>
    <script>
        $(document).ready(function () {
            let timeLeft = <?php echo $baiThi['THOIGIAN'] * 60; ?>;
            function updateTimer() {
                let minutes = Math.floor(timeLeft / 60);
                let seconds = timeLeft % 60;
                $("#timer").text(minutes + ":" + (seconds < 10 ? "0" : "") + seconds);
                if (timeLeft > 0) {
                    timeLeft--;
                    setTimeout(updateTimer, 1000);
                } else {
                    alert("Hết thời gian!");
                    $("form").submit();
                }
            }
            updateTimer();

            $(".status-btn").click(function () {
                let qNumber = $(this).text().trim();
                $('html, body').animate({
                    scrollTop: $("#question-" + qNumber).offset().top - 100
                }, 500);
            });
        });

        function updateStatus(qNumber) {
            $("#q" + qNumber).removeClass("btn-outline-dark").addClass("btn-success text-white");
        }
    </script>

    <script>
        $(document).ready(function () {
            $("form").on("submit", function (event) {
                let totalQuestions = <?php echo $totalQuestions; ?>;
                let unanswered = [];

                for (let i = 1; i <= totalQuestions; i++) {
                    let questionAnswered = $(`#question-${i} input[type=radio]:checked`).length > 0;
                    if (!questionAnswered) {
                        unanswered.push(i);
                    }
                }

                if (unanswered.length > 0) {
                    event.preventDefault();
                    alert("Bạn chưa trả lời hết các câu hỏi! Vui lòng kiểm tra lại.\nCâu chưa trả lời: " + unanswered.join(", "));
                    $('html, body').animate({
                        scrollTop: $("#question-" + unanswered[0]).offset().top - 100
                    }, 500);
                }
            });
        });

    </script>
</body>

</html>
<?php $conn->close(); ?>