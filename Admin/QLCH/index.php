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

  <!-- Modal Thêm Câu Hỏi -->
  <div class="modal fade" id="addQuestionModal" tabindex="-1" aria-labelledby="addQuestionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-3 shadow-lg">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title" id="addQuestionLabel">Thêm Câu Hỏi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="addQuestionForm" action="add.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="cauhoi" class="form-label">Câu Hỏi</label>
              <textarea class="form-control" id="cauhoi" name="cauhoi"></textarea>
              <input type="file" class="form-control mt-2" id="cauhoi-img" name="cauhoi_img">
            </div>
            <div class="mb-3">
              <div class="form-group">
                <label for="a" class="form-label">Đáp án A</label>
                <input type="text" class="form-control mb-2" name="a" placeholder="Nhập đáp án A">
                <input type="file" class="form-control" name="a_img">
              </div>
              <div class="form-group">
                <label for="b" class="form-label">Đáp án B</label>
                <input type="text" class="form-control mb-2" name="b" placeholder="Nhập đáp án B">
                <input type="file" class="form-control" name="b_img">
              </div>
              <div class="form-group">
                <label for="c" class="form-label">Đáp án C</label>
                <input type="text" class="form-control mb-2" name="c" placeholder="Nhập đáp án C">
                <input type="file" class="form-control" name="c_img">
              </div>
              <div class="form-group">
                <label for="d" class="form-label">Đáp án D</label>
                <input type="text" class="form-control mb-2" name="d" placeholder="Nhập đáp án D">
                <input type="file" class="form-control" name="d_img">
              </div>
            </div>
            <div class="mb-3">
              <label for="dapan" class="form-label">Đáp Án Đúng</label>
              <select class="form-select" id="dapan" name="dapan">
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
              </select>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success"><i class="bi bi-plus-circle"></i> Thêm</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Sửa Câu Hỏi -->
  <div class="modal fade" id="editQuestionModal" tabindex="-1" aria-labelledby="editQuestionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-3 shadow-lg">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="editQuestionLabel">Sửa Câu Hỏi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editQuestionForm" action="edit.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" id="edit-id" name="id">
            <div class="mb-3">
              <label for="edit-cauhoi" class="form-label">Câu Hỏi</label>
              <textarea class="form-control" id="edit-cauhoi" name="cauhoi" required></textarea>
              <input type="file" class="form-control mt-2" id="edit-cauhoi-img" name="cauhoi_img">
            </div>
            <div class="mb-3">
              <div class="mb-2">
                <label for="a" class="form-label">Đáp án A</label>
                <input type="text" class="form-control" id="edit-a" name="a">
                <input type="file" class="form-control mt-2" name="a_img">
              </div>
              <div class="mb-2">
                <label for="b" class="form-label">Đáp án B</label>
                <input type="text" class="form-control" id="edit-b" name="b">
                <input type="file" class="form-control mt-2" name="b_img">
              </div>
              <div class="mb-2">
                <label for="c" class="form-label">Đáp án C</label>
                <input type="text" class="form-control" id="edit-c" name="c">
                <input type="file" class="form-control mt-2" name="c_img">
              </div>
              <div class="mb-2">
                <label for="d" class="form-label">Đáp án D</label>
                <input type="text" class="form-control" id="edit-d" name="d">
                <input type="file" class="form-control mt-2" name="d_img">
              </div>
            </div>
            <div class="mb-3">
              <label for="edit-dapan" class="form-label">Đáp Án Đúng</label>
              <select class="form-select" id="edit-dapan" name="dapan">
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary">Cập Nhật</button>
          </form>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal Xóa Câu Hỏi -->
  <div class="modal fade" id="deleteQuestionModal" tabindex="-1" aria-labelledby="deleteQuestionLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-3 shadow-lg">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title" id="deleteQuestionLabel">Xác nhận xóa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Bạn có chắc chắn muốn xóa câu hỏi này?</p>
          <form id="deleteQuestionForm" action="delete.php" method="POST">
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
      <h1>Quản Lý Câu Hỏi</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href=<?php echo $Home ?>>Trang Chủ</a></li>
          <li class="breadcrumb-item active">Quản Lý Câu Hỏi</li>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Danh Sách Câu Hỏi</h5>
              <button class="btn btn-success add-btn">Thêm Câu Hỏi</button>
              <!-- Bảng DataTable -->
              <table id="accountTable" class="display" style="width:100%">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Câu Hỏi</th>
                    <th>A</th>
                    <th>B</th>
                    <th>C</th>
                    <th>D</th>
                    <th>Đáp Án</th>
                    <th>Hành Động</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql = "
                    SELECT * FROM cauhoi
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
                      echo "
                      <tr>
                        <td>{$row['IDCAUHOI']}</td>
                        <td>" . formatData($row['CAUHOI']) . "</td>
                        <td>" . formatData($row['A']) . "</td>
                        <td>" . formatData($row['B']) . "</td>
                        <td>" . formatData($row['C']) . "</td>
                        <td>" . formatData($row['D']) . "</td>
                        <td>{$row['DAPAN']}</td>
                        <td>
                            <button class='btn btn-primary btn-sm edit-btn' 
                              data-id='{$row['IDCAUHOI']}' 
                              data-cauhoi='{$row['CAUHOI']}' 
                              data-a='{$row['A']}' 
                              data-b='{$row['B']}' 
                              data-c='{$row['C']}' 
                              data-d='{$row['D']}' 
                              data-dapan='{$row['DAPAN']}'
                              >Sửa</button>

                            <button class='btn btn-danger btn-sm delete-btn' 
                                    data-id='{$row['IDCAUHOI']}'>Xóa</button>
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
            "targets": [1, 2, 3, 4, 5],
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
      $('.add-btn').click(function () {
        $('#addQuestionModal').modal('show');
      });

      $('.edit-btn').click(function () {
        $('#edit-id').val($(this).data('id'));
        $('#edit-cauhoi').val($(this).data('cauhoi'));
        $('#edit-a').val($(this).data('a'));
        $('#edit-b').val($(this).data('b'));
        $('#edit-c').val($(this).data('c'));
        $('#edit-d').val($(this).data('d'));
        $('#edit-dapan').val($(this).data('dapan'));
        $('#editQuestionModal').modal('show');
      });

      $('.delete-btn').click(function () {
        $('#delete-id').val($(this).data('id'));
        $('#deleteQuestionModal').modal('show');
      });
    });
  </script>

  <script>
    $(document).ready(function () {
      $("#addQuestionForm").submit(function (event) {
        event.preventDefault();

        var formData = new FormData(this);

        $.ajax({
          url: $(this).attr("action"),
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (response) {
            alert(response.message);
            if (response.status === "success") {
              $("#addQuestionModal").modal("hide");
              location.reload();
            }
          },
          error: function () {
            alert("Có lỗi xảy ra!");
          }
        });
      });
    });
  </script>


</body>

</html>