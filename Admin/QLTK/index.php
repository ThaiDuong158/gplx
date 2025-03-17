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

  <!-- Modal Sửa -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Chỉnh Sửa Tài Khoản</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="editForm" action="edit.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="id" id="edit-id">
            <div class="mb-3">
              <label class="form-label">Tài Khoản</label>
              <input type="text" class="form-control" name="username" id="edit-username" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Họ Tên</label>
              <input type="text" class="form-control" name="hoten" id="edit-hoten" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" name="email" id="edit-email" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Vai Trò</label>
              <input type="text" class="form-control" name="quyen" id="edit-quyen" disabled>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
            <button type="submit" class="btn btn-primary">Lưu</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal Xóa -->
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">Xác Nhận Xóa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Bạn có chắc chắn muốn xóa tài khoản này?
        </div>
        <div class="modal-footer">
          <form id="deleteForm" action="delete.php" method="POST">
            <input type="hidden" name="id" id="delete-id">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
            <button type="submit" class="btn btn-danger">Xóa</button>
          </form>
        </div>
      </div>
    </div>
  </div>


  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Quản Lý Tài Khoản</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href=<?php echo $Home ?>>Trang Chủ</a></li>
          <li class="breadcrumb-item active">Quản Lý Tài Khoản</li>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Danh Sách Tài Khoản</h5>

              <!-- Bảng DataTable -->
              <table id="accountTable" class="display" style="width:100%">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Ảnh Đại Diện</th>
                    <th>Tài Khoản</th>
                    <th>Họ Tên</th>
                    <th>Email</th>
                    <th>SDT</th>
                    <th>Vai Trò</th>
                    <th>Hành Động</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql = "
                    SELECT nguoidung.*, phanquyen.TENQUYEN 
                      FROM nguoidung
                      INNER JOIN phanquyen ON nguoidung.IDQUYEN = phanquyen.IDQUYEN
                  ";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo "<tr>
                                <td>{$row['IDNGUOIDUNG']}</td>
                                <td>
                                  <img src='assets/img/avartar/" . $row['IDNGUOIDUNG'] . "/" . $row['AVATAR'] . "' alt='Avatar'
                                  class='img-thumbnail rounded-circle' width='50' height='50'>
                                </td>
                                <td>{$row['USERNAME']}</td>
                                <td>" . $row['HO'] . " " . $row['TEN'] . "</td>
                                <td>{$row['EMAIL']}</td>
                                <td>{$row['SDT']}</td>
                                <td>{$row['TENQUYEN']}</td>
                                <td>
                                    <button class='btn btn-primary btn-sm edit-btn' 
                                      data-id='{$row['IDNGUOIDUNG']}' 
                                      data-username='{$row['USERNAME']}' 
                                      data-ho='{$row['HO']}' 
                                      data-ten='{$row['TEN']}' 
                                      data-email='{$row['EMAIL']}' 
                                      data-quyen='{$row['TENQUYEN']}'>Sửa</button>

                                    <button class='btn btn-danger btn-sm delete-btn' 
                                            data-id='{$row['IDNGUOIDUNG']}'>Xóa</button>
                                </td>
                              </tr>";
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
      // Hiển thị modal Sửa khi nhấn nút "Sửa"
      $(".edit-btn").click(function () {
        let id = $(this).data("id");
        let username = $(this).data("username");
        let ho = $(this).data("ho");
        let ten = $(this).data("ten");
        let email = $(this).data("email");
        let quyen = $(this).data("quyen");

        $("#edit-id").val(id);
        $("#edit-username").val(username);
        $("#edit-hoten").val(ho + " " + ten);
        $("#edit-email").val(email);
        $("#edit-quyen").val(quyen);

        $("#editModal").modal("show");
      });

      // Hiển thị modal Xóa khi nhấn nút "Xóa"
      $(".delete-btn").click(function () {
        let id = $(this).data("id");
        $("#delete-id").val(id);
        $("#deleteModal").modal("show");
      });
    });
  </script>


</body>

</html>