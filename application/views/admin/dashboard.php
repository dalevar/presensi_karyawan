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
                                    <span class="mb-0 text-secondary font-weight-bold"><?= date('d-F-Y') ?></span>
                                </div>
                                <div class="card-body">
                                    <div class="ml-4">
                                        <?php if ($keterlambatan > 0) : ?>
                                            <button class="btn">
                                                <h2 class="text-warning font-weight-bold d-flex flex-wrap justify-content-end">
                                                    <?= $keterlambatan ?>
                                                    <span class="text-small text-secondary ml-2 "><i class="ri-user-line"></i></span>
                                                </h2>
                                            </button>
                                        <?php else : ?>
                                            <button class="btn">
                                                <h2 class="text-warning font-weight-bold d-flex flex-wrap justify-content-end">
                                                    -
                                                    <span class="text-small text-secondary ml-2 "><i class="ri-user-line"></i></span>

                                                </h2>

                                            </button>
                                        <?php endif; ?>

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
                                    <span class="mb-0 text-secondary font-weight-bold"><?= date('d-F-Y') ?></span>

                                    <!-- <p class="mb-0 text-secondary font-weight-bold">22/22/2022</p> -->
                                </div>
                                <div class="card-body">
                                    <div class="ml-4">
                                        <?php if ($tidakHadir > 0) : ?>
                                            <button class="btn">
                                                <h2 class="text-danger font-weight-bold d-flex flex-wrap justify-content-end">
                                                    <?= $tidakHadir ?>
                                                    <span class="text-small text-secondary ml-2 "><i class="ri-user-unfollow-line"></i></span>
                                                </h2>
                                            </button>
                                        <?php else : ?>
                                            <button class="btn">
                                                <h2 class="text-success font-weight-bold d-flex flex-wrap justify-content-end">
                                                    -
                                                    <span class="text-small text-success ml-2 "><i class="ri-user-follow-line"></i></span>
                                                </h2>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="card-body">
                            <div class="col-md-12">
                                <h4 class="d-flex justify-content-center">Data Presensi</h4>
                            </div>
                            <div class="col-md-12">
                                <ul class="nav nav-tabs" id="myTab-1" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="harian-tab" data-toggle="tab" href="#harian" role="tab" aria-controls="harian" aria-selected="true">Harian</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="bulanan-tab" data-toggle="tab" href="#bulanan" role="tab" aria-controls="bulanan" aria-selected="false">Bulanan</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content" id="myTabContent-2">


                                <div class="tab-pane fade show active" id="harian" role="tabpanel" aria-labelledby="harian-tab">
                                    <div class="col-md-12">
                                        <div class="d-flex flex-wrap justify-content-between align-items-center pr-3">
                                            <h5 class="card-title">List Presensi</h5>
                                        </div>
                                        <table class="table table-stripped table-borderless" id='table_karyawan'>
                                            <thead>
                                                <tr>
                                                    <th width='10%'>Hari Ini</th>
                                                    <th width='20%'>Jam</th>
                                                    <th>Nama</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $previousDate = '';
                                                $karyawanHadir = $presensiHariIni->pluck('created_by')->toArray();
                                                $karyawanList = $getKaryawan;
                                                // $namaKaryawan = array();
                                                // $jamPresensi = array();
                                                // Dapatkan semua karyawan
                                                $semuaKaryawan = KaryawanModel::all();
                                                // dd($semuaKaryawan);
                                                $tidakHadir = "<span class='text-secondary font-weight-bold'><i class='ri-close-circle-line'></i> Tidak Hadir</span>";

                                                $listKaryawan = count($semuaKaryawan);
                                                for ($i = 0; $i < $listKaryawan; $i++) {
                                                    $namaKaryawan = $semuaKaryawan[$i]->nama;
                                                    $ID = $semuaKaryawan[$i]->id;
                                                    // dd($ID);
                                                    $status = $tidakHadir;
                                                    $tanggalHari = date('d-M-Y');
                                                    $jamPresensi = "-";
                                                    $keterangan = "";

                                                    echo "<tr>";
                                                    foreach ($presensiHariIni as $presensi) {
                                                        // dd($presensi->created_by);
                                                        $tanggal = date('d-M-Y', strtotime($presensi->tanggal));
                                                        $batasWaktu = strtotime('08:00:00');
                                                        $waktuPresensi = strtotime(date('H:i:s', strtotime($presensi->created_on)));
                                                        $presensiJam = date('H:i:s', strtotime($presensi->created_on));
                                                        $batasPresensi = date('H:i:s', strtotime($presensi->tanggal));
                                                        $presensiCreated = date('Y-m-d', strtotime($presensi->created_on));
                                                        $isWFH = $presensi->is_wfh; // Ambil data is_wfh

                                                        // Periksa apakah tanggal sekarang sama dengan tanggal sebelumnya
                                                        if ($tanggal != $previousDate) {
                                                            echo "<td rowspan='" . $listKaryawan . "' class='text-center'>" . $tanggal . "</td>";
                                                        }
                                                        $previousDate = $tanggal; // Simpan tanggal sekarang untuk perbandingan selanjutnya
                                                        if ($ID == $presensi->created_by) {
                                                            if ($presensiJam <= $batasPresensi) {
                                                                $status = "<span class='text-success font-weight-bold'>Hadir</span>";
                                                                $jamPresensi = "<span class='text-success font-weight-bold'>" . date('H:i:s', $waktuPresensi) . " Pagi</span>";
                                                                if ($isWFH == 1) {
                                                                    $keterangan = "<span class='text-info font-weight-bold'><i class='ri-home-4-line'></i> WFH</span>";
                                                                }
                                                                break;
                                                            } elseif ($presensiJam > $batasPresensi) {
                                                                $status = "<span class='text-warning font-weight-bold'>Terlambat</span>";
                                                                $jamPresensi = "<span class='text-warning font-weight-bold'>" . date('H:i:s', $waktuPresensi) . " (" . floor(($waktuPresensi - $batasWaktu) / 60) . " Menit)</span>";
                                                                if ($isWFH == 1) {
                                                                    $keterangan = "<span class='text-info font-weight-bold'><i class='ri-home-4-line'></i> WFH</span>";
                                                                }
                                                                break;
                                                            }
                                                        } else {

                                                            $status = $tidakHadir;
                                                            $jamPresensi = '-';
                                                            $keterangan = '';
                                                        }
                                                    }


                                                    echo "<td>" . $jamPresensi . "</td>";
                                                    echo "<td>" . $namaKaryawan . "</td>";
                                                    echo "<td>" . $status . "<br>" . $keterangan . "</td>";
                                                }
                                                echo "</tr>";

                                                ?>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="bulanan" role="tabpanel" aria-labelledby="bulanan-tab">
                                    <div class="col-md-12">
                                        <div class="d-flex flex-wrap justify-content-between align-items-center pr-3">
                                            <h5 class="card-title">List Presensi</h5>
                                            <div class="form-group mb-0 vanila-daterangepicker d-flex flex-row justify-content-end">
                                                <div class="date-icon-set">
                                                    <select class="form-control mb-3" id='month' name='month'>
                                                        <?php for ($i = 1; $i <= 12; $i++) { ?>
                                                            <?= $selected = ($i == $month) ? 'selected' : ''; ?>
                                                            <option value="<?= $i ?>" <?= $selected ?>> <?= getIndonesianMonth(date("F", mktime(0, 0, 0, $i, 1, $year))) ?> </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <span class="mx-1"></span>
                                                <div class="date-icon-set">
                                                    <select class="form-control mb-3 " id="year" name="year">
                                                        <?php
                                                        // Loop untuk menampilkan opsi tahun
                                                        $tahunSekarang = date("Y");
                                                        for ($tahun = $tahunSekarang; $tahun >= $tahunSekarang - 2; $tahun--) {
                                                            // Tampilkan opsi tahun
                                                            $selected = ($tahun == $tahunSekarang) ? 'selected' : '';
                                                            echo "<option value='{$tahun}' $selected>{$tahun}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <span class="flex-grow-0 mx-2 my-1">
                                                    <button onclick='updateRekap()' class='btn-sm btn-secondary inline-block'><i class='ri-calendar-fill'></i></button>
                                                </span>
                                            </div>
                                        </div>
                                        <table id="datatable" class="table data-table table-striped table-bordered">
                                            <thead class="table-color-heading">
                                                <tr>
                                                    <th width="15%" class='text-center'>Tanggal Presensi</th>
                                                    <th>Nama</th>
                                                    <th width="25%">Status</th>
                                                    <th width="25%">Jam Presensi</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $year = isset($_GET['year']) ? $_GET['year'] : date('Y');
                                                $month = isset($_GET['month']) ? $_GET['month'] : date('n');
                                                // $tanggal = date("$year-$month");
                                                generateDataBulanan($year, $month);
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
</div>

<script>
    function updateRekap() {
        var selectedMonth = document.getElementById('month').value;
        var selectedYear = document.getElementById('year').value;
        window.location.href = 'dashboard?year=' + selectedYear + '&month=' + selectedMonth;
    }
</script>

<!-- <script>
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
</script> -->



<!-- <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <ul class="nav nav-tabs" id="myTab-1" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Harian</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Bulanan</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            <h4 class="card-title">Data Presensi</h4>
                            <h6 class="text-secondary text-left"><?= $monthName . ' ' . $year ?></h6>
                            <div class="d-flex mt-2 mb-4 float-right">
                                <div class="form-group mb-0 vanila-daterangepicker d-flex">
                                    <div class="col-md-6">
                                        <select class="form-control mb-3" id='bulan' name='bulan'>
                                            <?php for ($i = 1; $i <= 12; $i++) { ?>
                                                <?= $selected = ($i == $month) ? 'selected' : ''; ?>
                                                <option value="<?= $i ?>" <?= $selected ?>> <?= getIndonesianMonth(date("F", mktime(0, 0, 0, $i, 1, $year))) ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-5">
                                        <select class="form-control mb-3 " id="tahun" name="tahun">
                                            <?php
                                            // Loop untuk menampilkan opsi tahun
                                            $tahunSekarang = date("Y");
                                            for ($tahun = $tahunSekarang; $tahun >= $tahunSekarang - 2; $tahun--) {
                                                // Tampilkan opsi tahun
                                                $selected = ($tahun == $tahunSekarang) ? 'selected' : '';
                                                echo "<option value='{$tahun}' $selected>{$tahun}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <span class="mx-3"></span>
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
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $year = isset($_GET['year']) ? $_GET['year'] : date('Y');
                                $month = isset($_GET['month']) ? $_GET['month'] : date('n');
                                // $tanggal = date("$year-$month");
                                generateDataBulanan($year, $month);
                                // dd(generateDataBulanan($year, $month));
                                // // Data presensi dalam bentuk array asosiatif
                                // $presensi = $dataPresensi;
                                // $tanggalKerja = $tanggal;
                                // $karyawan = $getKaryawan;
                                // // dd($Karyawan);

                                // // $presensi = [
                                // //     ['tanggal' => '10/6/2023', 'nama' => 'John Doe', 'status' => 'Hadir'],
                                // //     ['tanggal' => '10/6/2023', 'nama' => 'Jane Smith', 'status' => 'Absen'],

                                // //     ['tanggal' => '10/5/2023', 'nama' => 'John Doe', 'status' => 'Hadir'],
                                // //     ['tanggal' => '10/5/2023', 'nama' => 'Jane Smith', 'status' => 'Absen'],
                                // //     // Tambahkan data lainnya sesuai kebutuhan
                                // // ];

                                // $currentDate = null;

                                // foreach ($tanggalKerja as $tanggal) {
                                //     // Inisialisasi daftar nama yang hadir pada tanggal ini
                                //     $namaHadir = array();
                                //     $status = array();

                                //     // Loop melalui setiap entri dalam data presensi
                                //     foreach ($presensi as $data) {
                                //         $idKaryawan = $data['created_by'];
                                //         $karyawan = $this->KaryawanModel->find($idKaryawan);

                                //         if (isset($data['tanggal']) && isset($data['created_by'])) {
                                //             // Mengambil tanggal presensi dari data presensi saat ini
                                //             $tanggalPresensi = date('Y-m-d', strtotime($data['tanggal']));
                                //             $createdOn = strtotime($data['created_on']);
                                //             $batasPresensi = strtotime($data['tanggal']);

                                //             $currentDate = date('Y-m-d');
                                //             $presensiCreated = date('Y-m-d', strtotime($data['created_on']));

                                //             // dd($tanggalPresensi);

                                //             // Jika tanggal presensi sama dengan tanggal kerja, tambahkan nama ke daftar nama yang hadir
                                //             if ($tanggalPresensi == $tanggal && $karyawan) {
                                //                 $namaHadir[] = $karyawan->nama;
                                //                 if ($createdOn <= $batasPresensi) {
                                //                     $status[] = 'Hadir';
                                //                 } elseif ($createdOn > $batasPresensi) {
                                //                     $status[] = 'Terlambat (' . floor(($createdOn - $batasPresensi) / 60) . ' menit)';
                                //                 } elseif ($presensiCreated >= $currentDate) {
                                //                     $status[] = 'Tidak Hadir';
                                //                 }
                                //             }
                                //         }
                                //     }

                                //     // // Tampilkan baris untuk setiap karyawan yang hadir pada tanggal tersebut
                                //     if (!empty($namaHadir)) {
                                //         for ($i = 0; $i < count($namaHadir); $i++) {
                                //             echo '<tr>';
                                //             // Tampilkan sel tanggal hanya pada baris pertama
                                //             if ($i === 0) {
                                //                 echo '<td rowspan="' . count($namaHadir) . '" class="tanggal">' . $tanggal . '</td>';
                                //             }
                                //             echo '<td class="nama">' . $namaHadir[$i] . '</td>';
                                //             echo '<td class="status">' . $status[$i] . '</td>';
                                //             echo '</tr>';
                                //         }
                                //     } else {
                                //         echo '<tr>';
                                //         echo '<td class="tanggal">' . $tanggal . '</td>';
                                //         echo '<td colspan="2" class="text-center">Belum Ada Presensi</td>';
                                //         echo '</tr>';
                                //     }

                                //     // Tampilkan tanggal dan daftar nama yang hadir
                                //     // echo '<tr>';
                                //     // echo '<td class="tanggal">' . $tanggal . '</td>';
                                //     // if (!empty($namaHadir)) {
                                //     //     echo '<td class="nama">' . implode('<br>', $namaHadir) . '</td>';
                                //     //     echo '<td class="status">' . implode('<br>', $status) . '</td>';
                                //     // } else {
                                //     //     echo '<td colspan="2" class="text-center">Belum Ada Absensi</td>';
                                //     // }
                                //     // echo '</tr>';
                                // }



                                // // foreach ($presensi as $data) {
                                // //     $tanggalPresensiBaru = date('Y-m-d', strtotime($data['tanggal']));
                                // //     if ($currentDate !== $data['tanggal']) {
                                // //         // Jika tanggal berbeda, cetak baris baru dengan tanggal
                                // //         // echo '<tr>';
                                // //         // echo '<td rowspan="5" class="tanggal">' . $data['tanggal'] . '</td>';
                                // //         // echo '<td class="nama">' . $data['nama'] . '</td>';
                                // //         // echo '<td>' . $data['status'] . '</td>';
                                // //         // echo '</tr>';
                                // //         // $currentDate = $data['tanggal'];
                                // //     } else {
                                // //         // Jika tanggal sama, tambahkan baris dengan nama dan status
                                // //         // echo '<tr>';
                                // //         // echo '<td class="nama">' . $data['nama'] . '</td>';
                                // //         // echo '<td>' . $data['status'] . '</td>';
                                // //         // echo '</tr>';
                                // //     }
                                // // }
                                ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div> -->