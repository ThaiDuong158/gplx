<?php include '../Condition/auth.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Đăng Ký - Hệ Thống GPLX</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <?php include '../Layout/AdminLayout/linkscss.php' ?>

</head>

<body>

  <main>
    <div class="container">
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href=<?php echo $Home; ?> class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">GPLX System</span>
                </a>
              </div>

              <div class="card mb-3">
                <div class="card-body">
                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Tạo Tài Khoản</h5>
                    <p class="text-center small">Nhập thông tin cá nhân để tạo tài khoản</p>
                  </div>

                  <form class="row g-3 needs-validation" action="handleRegister.php" method="POST" novalidate>
                    <div class="col-6">
                      <label for="yourLastName" class="form-label">Họ</label>
                      <input type="text" name="ho" class="form-control" id="yourLastName" required>
                      <div class="invalid-feedback">Vui lòng nhập họ!</div>
                    </div>

                    <div class="col-6">
                      <label for="yourFirstName" class="form-label">Tên</label>
                      <input type="text" name="ten" class="form-control" id="yourFirstName" required>
                      <div class="invalid-feedback">Vui lòng nhập tên!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Email</label>
                      <input type="email" name="email" class="form-control" id="yourEmail" required>
                      <div class="invalid-feedback">Vui lòng nhập địa chỉ Email!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourPhone" class="form-label">Số Điện Thoại</label>
                      <input type="text" name="sdt" class="form-control" id="yourPhone" required>
                      <div class="invalid-feedback">Vui lòng nhập số điện thoại!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Tên Đăng Nhập</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text">@</span>
                        <input type="text" name="username" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Vui lòng nhập tên đăng nhập.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Mật Khẩu</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Vui lòng nhập mật khẩu!</div>
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" name="terms" type="checkbox" id="acceptTerms" required>
                        <label class="form-check-label" for="acceptTerms">Tôi đồng ý với <a href="#">điều khoản và điều kiện</a></label>
                        <div class="invalid-feedback">Bạn phải đồng ý trước khi gửi.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Tạo Tài Khoản</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Đã có tài khoản? <a href=<?php echo $Login; ?>>Đăng Nhập</a></p>
                    </div>
                  </form>

                </div>
              </div>

              <div class="credits">
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
              </div>

            </div>
          </div>
        </div>
      </section>
    </div>
  </main>

  <?php include '../Layout/AdminLayout/linksjs.php' ?>
</body>

</html>
