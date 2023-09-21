<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mb-4 mt-1">
                <h4 class="font-weight-bold">Dashboard</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page"><i class="ri-home-4-line mr-1 float-left"></i>Home</li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="row">
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-header d-flex flex-wrap ">
                                <div class="header-title">
                                    <h5 class="card-title">Terlambat Hari ini</h5>
                                    <span class="mb-0 text-secondary font-weight-bold"><?= date('d-m-Y') ?></span>

                                    <!-- <p class="mb-0 text-secondary font-weight-bold">22/22/2022</p> -->
                                </div>
                                <div class="card-body">
                                    <div class="ml-4">
                                        <h2 class="text-warning font-weight-bold d-flex flex-wrap justify-content-end">24</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-header d-flex flex-wrap ">
                                <div class="header-title">
                                    <h5 class="card-title">Tidak Masuk Hari ini</h5>
                                    <span class="mb-0 text-secondary font-weight-bold"><?= date('d-m-Y') ?></span>

                                    <!-- <p class="mb-0 text-secondary font-weight-bold">22/22/2022</p> -->
                                </div>
                                <div class="card-body">
                                    <div class="ml-4">
                                        <h2 class="text-danger font-weight-bold d-flex flex-wrap justify-content-end">24</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Data Presensi</h4>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            <div class="d-flex flex-wrap justify-content-between align-items-center mt-2 mb-4 float-right">
                                <div class="form-group mb-0 vanila-daterangepicker d-flex flex-row">
                                    <div class="date-icon-set">
                                        <div class="form-group">
                                            <input type="date" class="form-control " id="exampleInputdate">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="datatable" class="table data-table table-striped table-bordered">
                            <thead class="table-color-heading">
                                <tr>
                                    <th width="20%">Tanggal Presensi</th>
                                    <th>Nama</th>
                                    <th width="25%">Status</th>
                                    <th width="15%">Jumlah Tidak Masuk</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    $(document).ready(function() {
        // Fungsi untuk mengisi tabel dengan data presensi
        function isiTabelPresensi() {
            // Ambil tanggal saat ini
            var tanggalSaatIni = new Date();
            var tahun = tanggalSaatIni.getFullYear();
            var bulan = tanggalSaatIni.getMonth() + 1; // Perhatikan bahwa bulan dimulai dari 0 (Januari) hingga 11 (Desember)
            var hari = tanggalSaatIni.getDate();

            // Format tanggal dengan "d-m-Y"
            var tanggalFormat = (hari < 10 ? '0' : '') + hari + "/" + (bulan < 10 ? '0' : '') + bulan + "/" + tahun;

            // Mulai mengisi tabel
            var tabel = $("#datatable tbody");
            tabel.empty(); // Hapus data yang ada

            $.ajax({
                url: "<? base_url('admin/dashboard/presensi') ?>",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    // // Loop melalui data dan tambahkan baris ke tabel
                    // for (var i = 0; i < data.length; i++) {
                    //     var row = $("<tr>");
                    //     row.append($("<td>").text(tanggalFormat));
                    //     row.append($("<td>").text(data[i].nama_karyawan));
                    //     row.append($("<td>").text(data[i].status_hadir));
                    //     row.append($("<td>").text(data[i].jumlah_tidak_masuk));
                    //     tabel.append(row);
                    // }
                },
                error: function() {
                    // Handle kesalahan jika terjadi
                    console.error("Terjadi kesalahan dalam permintaan AJAX: " + textStatus, errorThrown);
                }
            });

            // Contoh sederhana: Tambahkan satu baris ke tabel
            var row = $("<tr>");
            row.append($("<td>").text(tanggalFormat));
            row.append($("<td>").text("Nama Karyawan"));
            row.append($("<td>").text("Status Hadir"));
            row.append($("<td>").text("0")); // Jumlah Tidak Masuk
            tabel.append(row);
        }

        // Panggil fungsi isiTabelPresensi saat halaman dimuat
        isiTabelPresensi();
    });
</script>