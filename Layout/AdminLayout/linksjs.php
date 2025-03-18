<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
                class="bi bi-arrow-up-short"></i></a>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>

<!-- Vendor JS Files -->
<script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/chart.js/chart.umd.js"></script>
<script src="assets/vendor/echarts/echarts.min.js"></script>
<script src="assets/vendor/quill/quill.js"></script>
<script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="assets/vendor/tinymce/tinymce.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>

<script>
        $(document).ready(function() {
                // Lấy đường dẫn hiện tại của trang
                let currentPath = window.location.pathname;

                // Lặp qua tất cả các thẻ <a> trong #sidebar
                $('#sidebar a').each(function() {
                        let link = $(this).attr('href');

                        // Nếu đường dẫn trùng khớp với trang hiện tại, xóa class 'collapsed' khỏi thẻ <a>
                        if (link === currentPath) {
                                $(this).removeClass('collapsed');
                        }
                });
        });
</script>