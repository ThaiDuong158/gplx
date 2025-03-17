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
    <div class="modal-dialog modal-lg"> <!-- Tăng kích thước modal -->
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title fw-bold" id="editModalLabel">Chỉnh Sửa Tài Khoản</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="editForm" action="edit.php" method="POST" enctype="multipart/form-data">
          <div class="modal-body container">
            <input type="hidden" name="id" id="edit-id">

            <!-- Avatar -->
            <div class="mb-3 text-center">
              <label class="form-label fw-bold">Ảnh Đại Diện</label>
              <div class="d-flex justify-content-center">
                <img id="edit-avatar-preview" src="" class="img-thumbnail rounded-circle shadow mb-2" width="120"
                  height="120">
              </div>
              <input type="file" class="form-control" name="avatar" id="edit-avatar">
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Tài Khoản</label>
                <input type="text" class="form-control" name="username" id="edit-username" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Mật Khẩu Mới</label>
                <input type="password" class="form-control" name="password" id="edit-password">
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Họ Tên</label>
                <input type="text" class="form-control" name="hoten" id="edit-hoten" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Email</label>
                <input type="email" class="form-control" name="email" id="edit-email" required>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Số Điện Thoại</label>
                <input type="text" class="form-control" name="sdt" id="edit-sdt" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Vai Trò</label>
                <select class="form-select" name="quyen" id="edit-quyen">
                  <option value="1">Quản trị viên</option>
                  <option value="2">Người dùng</option>
                </select>
              </div>
            </div>
          </div>

          <div class="modal-footer bg-light">
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
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title fw-bold" id="deleteModalLabel">Xác Nhận Xóa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
          <p class="fs-5 text-danger">Bạn có chắc chắn muốn xóa tài khoản này?</p>
        </div>
        <div class="modal-footer bg-light">
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
                                  <img src='assets/img/avatar/" . $row['IDNGUOIDUNG'] . "/" . $row['AVATAR'] . "' alt='Avatar'
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
                                      data-avatar='{$row['AVATAR']}' 
                                      data-username='{$row['USERNAME']}' 
                                      data-ho='{$row['HO']}' 
                                      data-ten='{$row['TEN']}' 
                                      data-email='{$row['EMAIL']}' 
                                      data-sdt='{$row['SDT']}'
                                      data-idquyen='{$row['IDQUYEN']}' 
                                      data-quyen='{$row['TENQUYEN']}'>Sửa</button>

                                    <button class='btn btn-danger btn-sm delete-btn' 
                                            data-id='{$row['IDNGUOIDUNG']}'>Xóa</button>
                                </td>
                              </tr>";
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
        let sdt = $(this).data("sdt");
        let idQuyen = $(this).data("idquyen");
        let quyen = $(this).data("quyen");
        var avatar = $(this).data("avatar");

        $("#edit-id").val(id);
        $("#edit-username").val(username);
        $("#edit-hoten").val(ho + " " + ten);
        $("#edit-email").val(email);
        $("#edit-sdt").val(sdt);
        $("#edit-quyen").val(idQuyen);

        // Cập nhật ảnh đại diện
        if (avatar) {
          $("#edit-avatar-preview").attr("src", `assets/img/avatar/${id}/${avatar}`);
        } else {
          $("#edit-avatar-preview").attr("src", "assets/img/hero-logo.png");
        }

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