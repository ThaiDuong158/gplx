<style>
  .header-social-links .dropdown ul a {
    padding: 10px 20px;
    font-size: 15px;
    text-transform: none;
    color: var(--nav-dropdown-color);
  }

  .header-social-links .dropdown ul a:hover,
  .header-social-links .dropdown ul .active:hover,
  .header-social-links .dropdown ul li:hover>a {
    color: var(--nav-dropdown-hover-color) !important;
  }
</style>

<header id="header" class="header d-flex align-items-center fixed-top">
  <div class="container-fluid position-relative d-flex align-items-center justify-content-between">
    <a href=<?PHP echo $Home ?> class="logo d-flex align-items-center me-auto me-xl-0">
      <img src="assets/img/logo/favicon-32x32.png" alt="">
      <h1 class="sitename">VLUTE</h1>
    </a>

    <nav id="navmenu" class="navmenu">
      <ul>
        <li><a href=<?php echo $AdminQLTK ?>>ADMIN</a></li>
        <li><a href=<?php echo $AdminQLTK ?>>ĐĂNG KÝ THI</a></li>
        <li><a href=<?php echo $AdminQLTK ?>>THANH TOÁN</a></li>
        <li><a href=<?php echo $AdminQLTK ?>>THI LÝ THUYẾT</a></li>
        <li><a href=<?php echo $AdminQLTK ?>>KẾT QUẢ</a></li>
      </ul>
      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>

    <div class="header-social-links">
      <ul class="list-group list-group-horizontal">
        <?php
        if (!isset($_SESSION['user_id'])) {
          echo '
              <li class="list-group-item border-0 bg-transparent">
                <a href=' . $Login . ' class="login">
                  Đăng Nhập
                </a>
              </li>
              <li class="list-group-item border-0 bg-transparent">
                <a href=' . $Register . ' class="register">
                  Đăng Ký
                </a>
              </li>
            ';
        } else {
          echo '
            <li class="list-group-item border-0 bg-transparent" style="
                height: 60px;
            ">
              <div class="dropdown">
                <a class="btn" data-bs-toggle="dropdown" aria-expanded="false">
                  <img src="/assets/img/logo.png" class="border rounded-circle" style="
                    width: 35px;
                    border-color:var(--accent-color)!important;
                  " alt="">
                  <span>Dropdown</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li><a class="dropdown-item" href=' . $UserInfo . '>Cập Nhật Thông Tin</a></li>
                  <li><a class="dropdown-item" href=' . $Logout . '>Đăng Xuất</a></li>
                </ul>
              </div>
            </li>
          ';
        }
        ?>
      </ul>
    </div>
  </div>
</header>