<?php include '../../Condition/auth.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include '../../Layout/AdminLayout/linkscss.php' ?>
</head>

<body>
    <?php include '../../Layout/AdminLayout/header.php' ?>
    <?php include '../../Layout/AdminLayout/sidebar.php' ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Thêm Câu Hỏi</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href=<?php echo $Home ?>>Trang Chủ</a></li>
                    <li class="breadcrumb-item active"><a href=<?php echo $AdminQLDT ?>>Quản Lý Đề Thi</a></li>
                    <li class="breadcrumb-item active"><?php echo $_GET['id'] ?></li>
                </ol>
            </nav>
        </div>
        <!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Thêm Câu Hỏi</h5>
                            <div class="alert alert-primary">
                                <h5 class="mb-3">Tổng số câu hỏi đã chọn:
                                    <span id="totalSelected" class="badge bg-success">0</span> / 25
                                </h5>

                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Khái niệm
                                        <div>
                                            <span class="badge bg-info" id="selectedConcepts">0</span> / 1
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Tình huống mất an toàn giao thông nghiêm trọng
                                        <div>
                                            <span class="badge bg-info" id="selectedSituation">0</span> / 1
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Quy tắc giao thông
                                        <div>
                                            <span class="badge bg-info" id="selectedRules">0</span> / 6
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Tốc độ, khoảng cách
                                        <div>
                                            <span class="badge bg-info" id="selectedSpeedDistance">0</span> / 1
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Văn hóa giao thông và đạo đức người lái xe
                                        <div>
                                            <span class="badge bg-info" id="selectedCulture">0</span> / 1
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Kỹ thuật lái xe hoặc cấu tạo sửa chữa
                                        <div>
                                            <span class="badge bg-info" id="selectedTechnique">0</span> / 1
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Hệ thống biển báo đường bộ
                                        <div>
                                            <span class="badge bg-info" id="selectedSigns">0</span> / 7
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Giải các thế sa hình và kỹ năng xử lý tình huống giao thông
                                        <div>
                                            <span class="badge bg-info" id="selectedHandling">0</span> / 7
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="mb-3 d-flex align-items-center">
                                <label for="filterQuestionType" class="me-2 fw-bold">Lọc theo Loại Câu Hỏi:</label>
                                <select id="filterQuestionType" class="form-select w-auto">
                                    <option value="">Tất cả</option>
                                    <option value="Khái niệm">Khái niệm</option>
                                    <option value="Tình huống mất an toàn giao thông nghiêm trọng">Tình huống mất an
                                        toàn</option>
                                    <option value="Quy tắc giao thông">Quy tắc giao thông</option>
                                    <option value="Tốc độ, khoảng cách">Tốc độ, khoảng cách</option>
                                    <option value="Văn hóa giao thông và đạo đức người lái xe">Văn hóa giao thông
                                    </option>
                                    <option value="Kỹ thuật lái xe hoặc cấu tạo sửa chữa">Kỹ thuật lái xe</option>
                                    <option value="Hệ thống biển báo đường bộ">Hệ thống biển báo</option>
                                    <option value="Giải các thế sa hình và kỹ năng xử lý tình huống giao thông">Giải thế
                                        sa hình</option>
                                </select>
                            </div>


                            <!-- Bảng DataTable -->
                            <table id="accountTable" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Loại Câu Hỏi</th>
                                        <th>Câu Hỏi</th>
                                        <th>A</th>
                                        <th>B</th>
                                        <th>C</th>
                                        <th>D</th>
                                        <th>Thêm Câu Hỏi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $idBaiThi = $_GET['id'];
                                    $sql = "
                                        SELECT c.*, 
                                            CASE 
                                                WHEN bc.IDCAUHOI IS NOT NULL THEN 1 
                                                ELSE 0 
                                            END AS isChecked
                                        FROM cauhoi c
                                        LEFT JOIN baithi_cauhoi bc 
                                        ON c.IDCAUHOI = bc.IDCAUHOI 
                                        AND bc.IDBAITHI = $idBaiThi
                                    ";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        function formatData($data)
                                        {
                                            if (strpos($data, '@img:') === 0) {
                                                return "<img src='" . substr($data, 5) . "' width='100'>";
                                            }
                                            return $data;
                                        }
                                        while ($row = $result->fetch_assoc()) {
                                            $checked = $row['isChecked'] ? "checked" : "";
                                            echo "
                                            <tr>
                                                <td>{$row['IDCAUHOI']}</td>
                                                <td>{$row['LOAICAUHOI']}</td>
                                                <td>" . formatData($row['CAUHOI']) . "</td>
                                                <td>" . formatData($row['A']) . "</td>
                                                <td>" . formatData($row['B']) . "</td>
                                                <td>" . formatData($row['C']) . "</td>
                                                <td>" . formatData($row['D']) . "</td>
                                                <td>
                                                    <input type='checkbox' class='add-question-checkbox' 
                                                        data-idcauhoi='{$row['IDCAUHOI']}' 
                                                        data-idbaithi='{$idBaiThi}' 
                                                        $checked>
                                                </td>
                                            </tr>
                                            ";
                                        }
                                    } else {
                                        echo "<tr><td colspan='8' class='text-center'>Không có dữ liệu</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <?php include '../../Layout/AdminLayout/footer.php' ?>
    <?php include '../../Layout/AdminLayout/linksjs.php' ?>
    <script>
        $(document).ready(function () {
            $('#accountTable').DataTable({
                "columnDefs": [
                    {
                        "targets": [2, 3, 4, 5, 6],
                        "render": function (data, type, row) {
                            if (data.includes('assets/img/cauhoi')) {
                                return '<img src="' + data + '" alt="Image" width="50">';
                            } else {
                                return data;
                            }
                        }
                    }
                ],
                "language": {
                    "lengthMenu": "Hiển thị _MENU_ dòng mỗi trang",
                    "zeroRecords": "Không tìm thấy dữ liệu",
                    "info": "Hiển thị _PAGE_ của _PAGES_",
                    "infoEmpty": "Không có dữ liệu",
                    "infoFiltered": "(lọc từ _MAX_ dữ liệu)",
                    "search": "Tìm kiếm:",
                    "paginate": {
                        "first": "Đầu",
                        "last": "Cuối",
                        "next": "Tiếp",
                        "previous": "Trước"
                    }
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $(".add-question-checkbox").change(function () {
                let isChecked = $(this).prop("checked");
                let idCauHoi = $(this).data("idcauhoi");
                let idBaiThi = $(this).data("idbaithi");

                $.ajax({
                    url: "add_question_to_exam.php",
                    type: "POST",
                    data: { idCauHoi: idCauHoi, idBaiThi: idBaiThi, checked: isChecked },
                    success: function (response) {

                    },
                    error: function () {
                        alert("Có lỗi xảy ra.");
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            function updateSelectedCount() {
                let totalChecked = $(".add-question-checkbox:checked").length; // Đếm tất cả checkbox (kể cả dòng ẩn)
                $("#totalSelected").text(totalChecked);

                let limits = {
                    "Khái niệm": 1,
                    "Tình huống mất an toàn giao thông nghiêm trọng": 1,
                    "Quy tắc giao thông": 6,
                    "Tốc độ, khoảng cách": 1,
                    "Văn hóa giao thông và đạo đức người lái xe": 1,
                    "Kỹ thuật lái xe hoặc cấu tạo sửa chữa": 1,
                    "Hệ thống biển báo đường bộ": 7,
                    "Giải các thế sa hình và kỹ năng xử lý tình huống giao thông": 7
                };

                let countByCategory = {};
                Object.keys(limits).forEach(key => countByCategory[key] = 0);

                $(".add-question-checkbox:checked").each(function () {
                    let category = $(this).closest("tr").find("td:nth-child(2)").text().trim();
                    if (countByCategory.hasOwnProperty(category)) {
                        countByCategory[category]++;
                    }
                });

                $("#selectedConcepts").text(countByCategory["Khái niệm"]);
                $("#selectedSituation").text(countByCategory["Tình huống mất an toàn giao thông nghiêm trọng"]);
                $("#selectedRules").text(countByCategory["Quy tắc giao thông"]);
                $("#selectedSpeedDistance").text(countByCategory["Tốc độ, khoảng cách"]);
                $("#selectedCulture").text(countByCategory["Văn hóa giao thông và đạo đức người lái xe"]);
                $("#selectedTechnique").text(countByCategory["Kỹ thuật lái xe hoặc cấu tạo sửa chữa"]);
                $("#selectedSigns").text(countByCategory["Hệ thống biển báo đường bộ"]);
                $("#selectedHandling").text(countByCategory["Giải các thế sa hình và kỹ năng xử lý tình huống giao thông"]);
            }

            $(".add-question-checkbox").change(function () {
                let isChecked = $(this).prop("checked");
                let idCauHoi = $(this).data("idcauhoi");
                let idBaiThi = $(this).data("idbaithi");

                $.ajax({
                    url: "add_question_to_exam.php",
                    type: "POST",
                    data: { idCauHoi: idCauHoi, idBaiThi: idBaiThi, checked: isChecked },
                    success: function (response) {
                        updateSelectedCount(); // Cập nhật số lượng câu hỏi đã chọn
                    },
                    error: function () {
                        alert("Có lỗi xảy ra.");
                    }
                });
            });

            // Cập nhật số lượng câu hỏi đã chọn khi trang load
            updateSelectedCount();
        });
    </script>

    <script>
        $(document).ready(function () {
            let table = $('#accountTable').DataTable();

            $('#filterQuestionType').change(function () {
                let selectedType = $(this).val();

                if (selectedType) {
                    table.column(1).search("^" + selectedType + "$", true, false).draw(); // Dùng regex để lọc chính xác
                } else {
                    table.column(1).search("").draw(); // Hiển thị tất cả
                }
            });
        });
    </script>

</body>

</html>