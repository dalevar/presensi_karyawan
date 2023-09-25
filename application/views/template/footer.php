	<!-- Wrapper End-->
	<footer class="iq-footer">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-6">
					<ul class="list-inline mb-0">
						<li class="list-inline-item"><a href="../backend/privacy-policy.html">Privacy Policy</a></li>
						<li class="list-inline-item"><a href="../backend/terms-of-service.html">Terms of Use</a></li>
					</ul>
				</div>
				<div class="col-lg-6 text-right">
					<span class="mr-1">
						Copyright
						<script>
							document.write(new Date().getFullYear())
						</script>© <a href="#" class="">Datum</a>
						All Rights Reserved.
					</span>
				</div>
			</div>
		</div>
	</footer> <!-- Backend Bundle JavaScript -->
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

	<script src="<?= base_url('assets/calendar') ?>/fullcalendar.min.js"></script>
	<script src="<?= base_url('assets/calendar') ?>/index.global.min.js"></script>
	<script src="<?= base_url('assets/calendar') ?>/id.global.js"></script>


	<script>
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

		//Hapus
		$(document).ready(function() {
			$('#btnHapus').click(function(e) {
				e.preventDefault();

				let id = $(this).data('id');


				Swal.fire({
					title: 'Anda Yakin ?',
					text: "Data Akan dihapus!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Ya, Hapus!'
				}).then((result) => {
					if (result.isConfirmed) {

						Swal.fire(
							'Deleted!',
							'Your file has been deleted.',
							'success'
						)
						$(this).closest('form').submit();
					}
				});
			});
		});

		// Logout
		$(document).ready(function() {
			$("#btnLogout").on("click", function(e) {
				e.preventDefault(); // Mencegah aksi default dari tautan/logout

				Swal.fire({
					title: 'Logout',
					text: 'Apakah Anda yakin ingin logout?',
					icon: 'question',
					showCancelButton: true,
					confirmButtonText: 'Ya',
					cancelButtonText: 'Tidak',
					customClass: {
						popup: 'logout-popup' // Nama kelas CSS baru untuk custom styling
					}
				}).then((result) => {
					if (result.isConfirmed) {
						window.location.href = $(this).attr("href"); // Redirect ke halaman logout jika dikonfirmasi
					}
				});

				// Menambahkan margin-bottom ke popup
				$(".logout-popup").css("margin-bottom", "20px");
			});
		});
	</script>
	</body>

	</html>