<!-- Backend Bundle JavaScript -->
<script src="<?= base_url('assets') ?>/js/backend-bundle.min.js"></script>
<!-- Chart Custom JavaScript -->
<script src="<?= base_url('assets') ?>/js/customizer.js"></script>

<script src="<?= base_url('assets') ?>/js/sidebar.js"></script>

<!-- Flextree Javascript-->
<script src="<?= base_url('assets') ?>/js/flex-tree.min.js"></script>
<script src="<?= base_url('assets') ?>/js/tree.js"></script>

<!-- Table Treeview JavaScript -->
<script src="<?= base_url('assets') ?>/js/table-treeview.js"></script>

<!-- SweetAlert JavaScript -->
<script src="<?= base_url('assets') ?>/js/sweetalert.js"></script>

<!-- Vectoe Map JavaScript -->
<script src="<?= base_url('assets') ?>/js/vector-map-custom.js"></script>

<!-- Chart Custom JavaScript -->
<script src="<?= base_url('assets') ?>/js/chart-custom.js"></script>
<script src="<?= base_url('assets') ?>/js/charts/01.js"></script>
<script src="<?= base_url('assets') ?>/js/charts/02.js"></script>

<!-- slider JavaScript -->
<script src="<?= base_url('assets') ?>/js/slider.js"></script>

<!-- Emoji picker -->
<script src="<?= base_url('assets') ?>/vendor/emoji-picker-element/index.js" type="module"></script>


<!-- app JavaScript -->
<script src="<?= base_url('assets') ?>/js/app.js"></script>

<!-- Sweetalerts 2-->
<script src="<?= base_url('assets/js/sweetalert2/') ?>cdn.jsdelivr.net_npm_sweetalert2@11_dist_sweetalert2.min.js"></script>


<script>
    // $(document).ready(function() {
    //     let flashMessage = $("#flash").data("flash");


    //     if (flashMessage) {
    //         Swal.fire({
    //             icon: 'error',
    //             title: flashMessage,
    //             showConfirmButton: true,
    //             showClass: {
    //                 popup: 'animate__animated animate__headShake'
    //             },
    //             hideClass: {
    //                 popup: 'animate__animated animate__bounceOutUp'
    //             },
    //             width: 400,
    //             customClass: {
    //                 popup: 'alert-popup' // Nama kelas CSS baru untuk custom styling
    //             },
    //             // timer: 4000
    //         });
    //         // Menambahkan margin-bottom
    //         $(".alert-popup").css("padding-bottom", "40px");

    //     }
    // });

    $(document).ready(function() {
        let flashElement = $('#flash');
        let flashMessage = flashElement.data('flash');
        let flashType = flashElement.data('type');

        if (flashMessage) {
            let title = (flashType === 'success') ? 'Berhasil' : 'Gagal';

            Swal.fire({
                icon: flashType,
                title: title,
                text: flashMessage,
            });

            // Menghapus flash data 'gagal' setelah menampilkannya
            <?php $this->session->unset_userdata('gagal'); ?>
        }
    });
</script>
</body>

</html>