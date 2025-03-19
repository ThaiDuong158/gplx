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

  <!-- Modal Thêm Bài Thi -->
  <div class="modal fade" id="addExamModal" tabindex="-1" aria-labelledby="addExamLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-3 shadow-lg">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title" id="addExamLabel">Thêm Bài Thi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="addExamForm" action="add.php" method="POST">
            <div class="mb-3">
              <label for="examName" class="form-label">Tên Bài Thi</label>
              <input type="text" class="form-control" id="examName" name="examName" required>
            </div>
            <div class="mb-3">
              <label for="examTime" class="form-label">Thời Gian (phút)</label>
              <input type="number" class="form-control" id="examTime" name="examTime" required>
            </div>
            <div class="mb-3">
              <label for="examStatus" class="form-label">Trạng Thái</label>
              <select class="form-select" id="examStatus" name="examStatus">
                <option value="Hoạt động">Hoạt động</option>
                <option value="Thi thử">Thi thử</option>
                <option value="Không hoạt động">Không hoạt động</option>
              </select>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success">Thêm</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Sửa Bài Thi -->
  <div class="modal fade" id="editExamModal" tabindex="-1" aria-labelledby="editExamLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-3 shadow-lg">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="editExamLabel">Sửa Bài Thi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editExamForm" action="edit.php" method="POST">
            <input type="hidden" id="editExamId" name="id">
            <div class="mb-3">
              <label for="editExamName" class="form-label">Tên Bài Thi</label>
              <input type="text" class="form-control" id="editExamName" name="examName" required>
            </div>
            <div class="mb-3">
              <label for="editExamTime" class="form-label">Thời Gian (phút)</label>
              <input type="number" class="form-control" id="editExamTime" name="examTime" required>
            </div>
            <div class="mb-3">
              <label for="editExamStatus" class="form-label">Trạng Thái</label>
              <select class="form-select" id="editExamStatus" name="examStatus">
                <option value="Hoạt động">Hoạt động</option>
                <option value="Thi thử">Thi thử</option>
                <option value="Không hoạt động">Không hoạt động</option>
              </select>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Cập Nhật</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Xóa Câu Hỏi -->
  <div class="modal fade" id="deleteExamModal" tabindex="-1" aria-labelledby="deleteExamLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-3 shadow-lg">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title" id="deleteExamLabel">Xác nhận xóa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Bạn có chắc chắn muốn xóa câu hỏi này?</p>
          <form id="deleteExamForm" action="delete.php" method="POST">
            <input type="hidden" id="delete-id" name="id">
            <div class="modal-footer">
              <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i> Xóa</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Quản Lý Đề Thi</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href=<?php echo $Home ?>>Trang Chủ</a></li>
          <li class="breadcrumb-item active">Quản Lý Đề Thi</li>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Danh Sách Đề Thi</h5>
              <button class="btn btn-success add-btn">Thêm Đề Thi</button>
              <!-- Bảng DataTable -->
              <table id="accountTable" class="display" style="width:100%">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Tên Bài Thi</th>
                    <th>Thời Gian</th>
                    <th>Số Câu Hỏi</th>
                    <th>Trạng Thái</th>
                    <th>Hành Động</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql = "
                    SELECT baithi.*, COUNT(baithi_cauhoi.IDBAITHI) AS SoLuongCauHoi 
                      FROM baithi
                      LEFT JOIN baithi_cauhoi ON baithi.IDBAITHI = baithi_cauhoi.IDBAITHI
                      GROUP BY baithi.IDBAITHI
                  ";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo "
                      <tr>
                        <td>{$row['IDBAITHI']}</td>
                        <td>{$row['TenBaiThi']}</td>
                        <td>{$row['THOIGIAN']} phút</td>
                        <td>{$row['SoLuongCauHoi']}/25</td>
                        <td>{$row['TRANGTHAI']}</td>
                        <td>
                            <button class='btn btn-primary btn-sm edit-btn' 
                              data-id='{$row['IDBAITHI']}' 
                              data-tenbaithi='{$row['TenBaiThi']}' 
                              data-thoigian='{$row['THOIGIAN']}' 
                              data-soluongcauhoi='{$row['SoLuongCauHoi']}' 
                              data-trangthai='{$row['TRANGTHAI']}' 
                              >Sửa</button>

                            <button class='btn btn-danger btn-sm delete-btn' 
                                    data-id='{$row['IDBAITHI']}'>Xóa</button>
                        </td>
                      </tr>
                      ";
                    }
                  } else {
                    echo "<tr><td colspan='5' class='text-center'>Không có dữ liệu</td></tr>";
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
      $('.add-btn').click(function () {
        $('#addExamModal').modal('show');
      });

      $('.edit-btn').click(function () {
        let id = $(this).data('id');
        let name = $(this).data('tenbaithi');
        let time = $(this).data('thoigian');
        let status = $(this).data('trangthai');

        $('#editExamId').val(id);
        $('#editExamName').val(name);
        $('#editExamTime').val(time);
        $('#editExamStatus').val(status);

        $('#editExamModal').modal('show');
      });

      $('.delete-btn').click(function () {
        let id = $(this).data('id');
        $('#delete-id').val(id);
        $('#deleteExamModal').modal('show');
      });
    });
  </script>


</body>

</html>