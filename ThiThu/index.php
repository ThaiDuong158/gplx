<?php include '../Condition/auth.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include '../Layout/UserLayout/linkscss.php' ?>
</head>

<body>
    <?php include '../Layout/UserLayout/header.php' ?>

    <?php
    // Kết nối database và đảm bảo UTF-8
    $conn->set_charset("utf8");

    // Truy vấn danh sách bài thi thử
    $sql = "SELECT IDBAITHI, TenBaiThi, THOIGIAN FROM gplx.baithi WHERE TRANGTHAI = 'Thi thử'";
    $result = $conn->query($sql);
    ?>

    <main class="main">
        <!-- About Section -->
        <section id="about" class="about section">
            <div class="pt-4"></div>
            <!-- Section Title -->
            <div class="container section-title pt-4" data-aos="fade-up">
                <h2>Đề Thi Thử Lý Thuyết</h2>
            </div>

            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row gy-4">
                    <h4>Danh sách bài thi thử:</h4>
                    <div class="row">
                        <?php
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="col-md-6 mb-3">'; // Mỗi bài thi chiếm 1/2 hàng (col-md-6)
                            echo "<div class='list-group-item p-3 border rounded shadow-sm'>
                                <strong>{$row['TenBaiThi']}</strong> - {$row['THOIGIAN']} phút
                                <a href='{$Thi}?id={$row['IDBAITHI']}' class='btn btn-primary btn-sm float-end'>Làm bài</a>
                            </div>";
                            echo '</div>'; // Đóng cột
                        }
                        ?>
                    </div>
                </div>
        </section><!-- /About Section -->
    </main>


    <?php include '../Layout/UserLayout/footer.php' ?>
    <?php include '../Layout/UserLayout/linksjs.php' ?>
</body>


</html>