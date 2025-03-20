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

  <!-- Modal Thêm Lịch Thi -->
  <div class="modal fade" id="addScheduleModal" tabindex="-1" aria-labelledby="addScheduleLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-3 shadow-lg">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title" id="addScheduleLabel">Thêm Lịch Thi Mới</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="addScheduleForm">
            <!-- Dropdown chọn bài thi -->
            <div class="mb-3">
              <label for="add-idbaithi" class="form-label">Bài Thi</label>
              <select class="form-select" id="add-idbaithi" name="idbaithi" required>
                <option value="">Chọn bài thi...</option>
                <?php
                $sql = "SELECT IDBAITHI, TenBaiThi FROM gplx.baithi WHERE TRANGTHAI = 'Hoạt động'";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                  echo "<option value='{$row['IDBAITHI']}'>{$row['IDBAITHI']} - {$row['TenBaiThi']}</option>";
                }
                ?>
              </select>
            </div>

            <div class="mb-3">
              <label for="add-ngaythi" class="form-label">Ngày Thi</label>
              <input type="date" class="form-control" id="add-ngaythi" name="ngaythi" required>
            </div>

            <div class="mb-3">
              <label for="add-thoigian" class="form-label">Thời Gian</label>
              <input type="time" class="form-control" id="add-thoigian" name="thoigian" required>
            </div>

            <div class="mb-3">
              <label for="add-diadiemthi" class="form-label">Địa Điểm Thi</label>
              <input type="text" class="form-control" id="add-diadiemthi" name="diadiemthi" required>
            </div>

            <div class="mb-3">
              <label for="add-soluong" class="form-label">Số Lượng</label>
              <input type="number" class="form-control" id="add-soluong" name="soluong" required>
            </div>

            <div class="mb-3">
              <label for="add-trangthai" class="form-label">Trạng Thái</label>
              <select class="form-select" id="add-trangthai" name="trangthai" required>
                <option value="Hoạt động">Hoạt động</option>
                <option value="Đã đóng">Đã đóng</option>
                <option value="Hủy bỏ">Hủy bỏ</option>
              </select>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
              <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Thêm</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Sửa Lịch Thi -->
  <div class="modal fade" id="editScheduleModal" tabindex="-1" aria-labelledby="editScheduleLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-3 shadow-lg">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="editScheduleLabel">Chỉnh Sửa Lịch Thi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editScheduleForm">
            <input type="hidden" id="edit-id" name="id">

            <!-- Dropdown chọn bài thi -->
            <div class="mb-3">
              <label for="edit-idbaithi" class="form-label">Bài Thi</label>
              <select class="form-select" id="edit-idbaithi" name="idbaithi" required>
                <option value="">Chọn bài thi...</option>
                <?php
                $sql = "SELECT IDBAITHI, TenBaiThi FROM gplx.baithi WHERE TRANGTHAI = 'Hoạt động'";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                  echo "<option value='{$row['IDBAITHI']}'>{$row['IDBAITHI']} - {$row['TenBaiThi']}</option>";
                }
                ?>
              </select>
            </div>

            <div class="mb-3">
              <label for="edit-ngaythi" class="form-label">Ngày Thi</label>
              <input type="date" class="form-control" id="edit-ngaythi" name="ngaythi" required>
            </div>

            <div class="mb-3">
              <label for="edit-thoigian" class="form-label">Thời Gian</label>
              <input type="time" class="form-control" id="edit-thoigian" name="thoigian" required>
            </div>

            <div class="mb-3">
              <label for="edit-diadiemthi" class="form-label">Địa Điểm Thi</label>
              <input type="text" class="form-control" id="edit-diadiemthi" name="diadiemthi" required>
            </div>

            <div class="mb-3">
              <label for="edit-soluong" class="form-label">Số Lượng</label>
              <input type="number" class="form-control" id="edit-soluong" name="soluong" required>
            </div>

            <div class="mb-3">
              <label for="edit-trangthai" class="form-label">Trạng Thái</label>
              <select class="form-select" id="edit-trangthai" name="trangthai" required>
                <option value="Hoạt động">Hoạt động</option>
                <option value="Đã đóng">Đã đóng</option>
                <option value="Hủy bỏ">Hủy bỏ</option>
              </select>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
              <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Lưu</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Xóa Lịch Thi -->
  <div class="modal fade" id="deleteScheduleModal" tabindex="-1" aria-labelledby="deleteScheduleLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-3 shadow-lg">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title" id="deleteScheduleLabel">Xác nhận xóa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Bạn có chắc chắn muốn xóa lịch thi này?</p>
          <form id="deleteScheduleForm">
            <input type="hidden" id="delete-id" name="id">
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
              <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i> Xóa</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Quản Lý Lịch Thi</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href=<?php echo $Home ?>>Trang Chủ</a></li>
          <li class="breadcrumb-item active">Quản Lý Lịch Thi</li>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-0">Danh Sách Lịch Thi</h5>
              <button class="btn btn-success add-btn"><i class="fas fa-plus"></i> Thêm Lịch Thi</button>
              <!-- Bảng DataTable -->
              <table id="scheduleTable" class="display" style="width:100%">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>ID Bài Thi</th>
                    <th>Ngày Thi</th>
                    <th>Thời Gian</th>
                    <th>Địa Điểm Thi</th>
                    <th>Số Lượng</th>
                    <th>Trạng Thái</th>
                    <th>Hành Động</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql = "SELECT * FROM gplx.lichthi";
                  $result = $conn->query($sql);

                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo "
                        <tr>
                            <td>{$row['IDLICHTHI']}</td>
                            <td>{$row['IDBAITHI']}</td>
                            <td>{$row['NGAYTHI']}</td>
                            <td>{$row['THOIGIAN']}</td>
                            <td>{$row['DIADIEMTHI']}</td>
                            <td>{$row['SOLUONG']}</td>
                            <td>{$row['TRANGTHAI']}</td>
                            <td>
                                <button class='btn btn-primary btn-sm edit-btn' 
                                        data-id='{$row['IDLICHTHI']}' 
                                        data-idbaithi='{$row['IDBAITHI']}' 
                                        data-ngaythi='{$row['NGAYTHI']}' 
                                        data-thoigian='{$row['THOIGIAN']}'
                                        data-diadiemthi='{$row['DIADIEMTHI']}' 
                                        data-soluong='{$row['SOLUONG']}'
                                        data-trangthai='{$row['TRANGTHAI']}'>Sửa</button>

                                <button class='btn btn-danger btn-sm delete-btn' 
                                        data-id='{$row['IDLICHTHI']}'>Xóa</button>
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
      $('#scheduleTable').DataTable({
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
      // Khi bấm nút "Xóa"
      $(".delete-btn").click(function () {
        let id = $(this).data("id"); // Lấy ID lịch thi từ nút xóa
        $("#delete-id").val(id); // Gán ID vào input ẩn của form modal
        $("#deleteScheduleModal").modal("show"); // Hiển thị modal
      });

      // Xử lý gửi yêu cầu xóa bằng AJAX khi người dùng xác nhận trong modal
      $("#deleteScheduleForm").submit(function (e) {
        e.preventDefault(); // Ngăn chặn load lại trang

        let id = $("#delete-id").val(); // Lấy ID lịch thi từ input ẩn

        $.ajax({
          url: "delete.php",
          type: "POST",
          data: { id: id },
          dataType: "json",
          success: function (response) {
            $("#deleteScheduleModal").modal("hide"); // Ẩn modal sau khi xóa
            alert(response.message);
            if (response.status === "success") {
              location.reload(); // Làm mới trang sau khi xóa
            }
          },
          error: function () {
            alert("Lỗi kết nối đến server!");
          }
        });
      });
    });
  </script>

  <script>
    $(document).ready(function () {
      // Mở modal chỉnh sửa và điền dữ liệu
      $(".edit-btn").click(function () {
        let id = $(this).data("id");
        let idbaithi = $(this).data("idbaithi");
        let ngaythi = $(this).data("ngaythi");
        let thoigian = $(this).data("thoigian");
        let diadiemthi = $(this).data("diadiemthi");
        let soluong = $(this).data("soluong");
        let trangthai = $(this).data("trangthai");

        $("#edit-id").val(id);
        $("#edit-idbaithi").val(idbaithi);
        $("#edit-ngaythi").val(ngaythi);
        $("#edit-thoigian").val(thoigian);
        $("#edit-diadiemthi").val(diadiemthi);
        $("#edit-soluong").val(soluong);
        $("#edit-trangthai").val(trangthai);

        $("#editScheduleModal").modal("show");
      });

      // Xử lý cập nhật lịch thi khi submit form
      $("#editScheduleForm").submit(function (e) {
        e.preventDefault(); // Ngăn chặn load lại trang

        let formData = $(this).serialize(); // Lấy dữ liệu từ form

        $.ajax({
          url: "edit.php",
          type: "POST",
          data: formData,
          dataType: "json",
          success: function (response) {
            $("#editScheduleModal").modal("hide");
            alert(response.message);
            if (response.status === "success") {
              location.reload(); // Làm mới trang sau khi cập nhật
            }
          },
          error: function () {
            alert("Lỗi kết nối đến server!");
          }
        });
      });
    });
  </script>

  <script>
    $(document).ready(function () {
      // Mở modal khi nhấn nút thêm lịch thi
      $(".add-btn").click(function () {
        $("#addScheduleModal").modal("show");
      });

      // Xử lý form thêm lịch thi
      $("#addScheduleForm").submit(function (e) {
        e.preventDefault(); // Ngăn chặn load lại trang

        let formData = $(this).serialize(); // Lấy dữ liệu từ form

        $.ajax({
          url: "add.php",
          type: "POST",
          data: formData,
          dataType: "json",
          success: function (response) {
            $("#addScheduleModal").modal("hide");
            alert(response.message);
            if (response.status === "success") {
              location.reload(); // Làm mới trang sau khi thêm thành công
            }
          },
          error: function () {
            alert("Lỗi kết nối đến server!");
          }
        });
      });
    });
  </script>


</body>

</html>