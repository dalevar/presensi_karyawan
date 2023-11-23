<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Presensi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        user_access();
        $this->load->model('PresensiModel');
    }


    public function index()
    {
        // if (!$this->session->userdata('id')) {
        //     redirect('auth');
        // }

        // Mengambil data dari URL
        $dataEncoded = $this->input->get('data');
        $filename = $this->input->get('filename');
        $is_wfh = $this->input->get('is_wfh');
        $is_sakit = $this->input->get('is_sakit');


        $data = json_decode(base64_decode($dataEncoded), true);

        // Memeriksa apakah data yang diperlukan ada dalam data yang diambil dari URL
        if (!isset($data['user_id']) || !isset($data['tanggal']) || !isset($data['created_by']) || !isset($data['created_on'])) {
            $this->session->set_flashdata('gagal', 'Data tidak lengkap');
            redirect('user/dashboard');
        }

        $user_id = $data['user_id'];
        $tanggal = $data['tanggal'];
        $created_by = $filename;
        $is_wfh = $is_wfh;
        $is_sakit = $is_sakit;
        $created_on = $data['created_on'];

        $existAbsen = PresensiModel::where('user_id', $user_id)
            ->where('tanggal', $tanggal)
            ->first();

        if ($existAbsen) {

            $this->session->set_flashdata('berhasil', 'Anda Telah Melakukan Absensi Hari ini pada jam ' . ' ' . $created_on);
        } else {
            $presensi = new PresensiModel();
            $presensi->user_id = $user_id;
            $presensi->tanggal = $tanggal;
            $presensi->created_by = $created_by;
            $presensi->is_wfh = $is_wfh;
            $presensi->is_sakit = $is_sakit;
            $presensi->created_on = $created_on;

            $presensiData = $presensi->getPresensiHariSebelumnya($user_id);
            // dd($presensiData);
            if (!empty($presensiData)) {
                $tanggalHariSebelumnya = date('Y-m-d', strtotime('-1 day'));
                $currentDate = date('Y-m-d');
                $tanggalPresensi = date('Y-m-d', strtotime($presensiData->created_on));
                $dataBatasWaktu = KonfigModel::where('nama', 'jam_masuk')->first();
                $batasWaktu = strtotime($dataBatasWaktu->nilai);

                // Ambil konfigurasi kali_keterlambatan
                $dataKaliKeterlambatan = KonfigModel::where('nama', 'kali_keterlambatan')->first();
                // dd($dataKaliKeterlambatan->nilai);

                if ($tanggalPresensi == $tanggalHariSebelumnya || date('w', strtotime($tanggalHariSebelumnya)) == 0) { //jika absen hari sebelumnya sama dengan hari ini atau hari sebelumnya adalah hari minggu maka absen masuk
                    if (strtotime($presensi->created_on) > $batasWaktu) {
                        // Jika absen dilakukan setelah jam 08:00:00
                        // Hitung keterlambatan dalam menit
                        $keterlambatanMenit = round((strtotime($presensi->created_on) - $batasWaktu) / 60);
                        // dd($keterlambatanMenit);
                        if ($keterlambatanMenit > 0) {
                            $keterlambatanMenit *= $dataKaliKeterlambatan->nilai;

                            // Simpan data keterlambatan ke dalam tabel presensi
                            $presensi->created_on = date('Y-m-d H:i:s', strtotime($presensi->created_on) + ($keterlambatanMenit * 30));
                        }
                        $presensi->save();
                        $this->session->set_flashdata('berhasil', 'Absen Anda Telah Masuk ');
                        redirect('user/dashboard');
                    } else {
                        // Jika absen dilakukan sebelum atau tepat pada jam 08:00:00
                        $presensi->save();
                        $this->session->set_flashdata('berhasil', 'Absen Anda Telah Masuk');
                        redirect('user/dashboard');
                    }
                } elseif ($tanggalPresensi != $tanggalHariSebelumnya) { //jika absen hari sebelumnya tidak sama dengan hari ini maka absen tidak hadir
                    if (strtotime($presensi->created_on) > $batasWaktu) {
                        // Jika absen dilakukan setelah jam 08:00:00
                        // Hitung keterlambatan dalam menit
                        $keterlambatanMenit = round((strtotime($presensi->created_on) - $batasWaktu) / 60);
                        // dd($keterlambatanMenit);
                        if ($keterlambatanMenit > 0) {
                            $keterlambatanMenit *= $dataKaliKeterlambatan->nilai;

                            // Simpan data keterlambatan ke dalam tabel presensi
                            $presensi->created_on = date('Y-m-d H:i:s', strtotime($presensi->created_on) + ($keterlambatanMenit * 30));
                        }
                        $presensi->save();
                        $this->session->set_flashdata('pemberitahuan', 'Absen Anda Telah Masuk');
                        redirect('user/dashboard');
                    }
                    // Jika absen dilakukan sebelum atau tepat pada jam 08:00:00
                    $presensi->save();
                    $this->session->set_flashdata('berhasil', 'Absen Anda Telah Masuk');
                    redirect('user/dashboard');
                }
            } else {
                $presensi->save();
                $this->session->set_flashdata('berhasil', 'Absen Anda Telah Masuk');
                redirect('user/dashboard');
            }
        }
    }


    public function tambahPresensiSakit()
    {
        // Ambil data dari permintaan POST
        $absenData = $this->input->post('absen');
        $filename = $this->input->post('filename');
        $is_wfh = $this->input->post('is_wfh');
        $is_sakit = $this->input->post('is_sakit');

        // Lakukan dekode data yang dikirim melalui URL
        $absen = json_decode(base64_decode($absenData), true);
        if (is_array($absen) && isset($absen['user_id'])) {
            $user_id = $absen['user_id'];
            $created_by = $filename;

            $presensiModel = new PresensiModel();
            $lastAttendanceDate = $presensiModel->getLastAttendanceDate($user_id);
            $secondLastAttendanceDate = $presensiModel->getSecondLastAttendanceDate($user_id);
            if ($lastAttendanceDate !== false && $secondLastAttendanceDate !== false) {

                $tanggalAwal = $secondLastAttendanceDate;
                $tanggalAkhir = date('Y-m-d');

                $gapTanggal = countTanggal($tanggalAwal, $tanggalAkhir); //Menghitung Selisih Tanggal lalu dikurangi 1
                $gapTanggalKurangSatu = $gapTanggal - 1;

                for ($i = 0; $i <= $gapTanggalKurangSatu; $i++) {
                    $tanggal = date('Y-m-d', strtotime("-$i day"));
                    $created_on = date('Y-m-d', strtotime("-$i day"));
                    // Periksa apakah tanggal adalah hari Minggu (ISO 7) atau sama dengan tanggal saat ini
                    if (date('N', strtotime($tanggal)) == 7 || $tanggal == date('Y-m-d')) {
                        continue; // Lewati tanggal ini
                    }
                    $presensi = new PresensiModel();
                    $presensi->user_id = $user_id;
                    $presensi->tanggal = $tanggal;
                    $presensi->created_by = $created_by;
                    $presensi->is_wfh = $is_wfh;
                    $presensi->is_sakit = $is_sakit;
                    $presensi->created_on = $created_on;

                    if ($presensi->save()) {
                        $response = ['success' => true, 'message' => 'Data presensi telah berhasil dimasukkan.'];
                    } else {
                        $response = ['success' => false, 'message' => $presensi->errors()];
                    }
                }
            }
        } else {
            // Handle kesalahan jika data tidak sesuai
            $response = ['success' => false, 'message' => 'Data tidak sesuai atau tidak lengkap'];
            echo json_encode($response);
        }
        // Keluarkan respons dalam format JSON
        echo json_encode($response);
    }

    public function tambahPresensiTidakHadir()
    {
        // Ambil data dari permintaan POST
        $absenData = $this->input->post('absen');
        $filename = $this->input->post('filename');
        $is_wfh = $this->input->post('is_wfh');
        $is_sakit = $this->input->post('is_sakit');

        // Lakukan dekode data yang dikirim melalui URL
        $absen = json_decode(base64_decode($absenData), true);
        if (is_array($absen) && isset($absen['user_id'])) {
            $user_id = $absen['user_id'];
            $created_by = $filename;
            $presensiModel = new PresensiModel();
            $lastAttendanceDate = $presensiModel->getLastAttendanceDate($user_id);
            $secondLastAttendanceDate = $presensiModel->getSecondLastAttendanceDate($user_id);
            if ($lastAttendanceDate !== false && $secondLastAttendanceDate !== false) {
                $tanggalAkhir = date('Y-m-d');

                $tanggalAwal = $secondLastAttendanceDate;
                // $tanggalAkhir = $lastAttendanceDate;

                $gapTanggal = countTanggal($tanggalAwal, $tanggalAkhir);
                $gapTanggalKurangSatu = $gapTanggal - 1;

                for ($i = 0; $i <= $gapTanggalKurangSatu; $i++) {
                    $tanggal = date('Y-m-d', strtotime("-$i day"));
                    $created_on = date('Y-m-d', strtotime("-$i day"));
                    if (date('N', strtotime($tanggal)) == 7 || $tanggal == date('Y-m-d')) {
                        continue; // Lewati tanggal ini
                    }

                    $presensi = new PresensiModel();
                    $presensi->user_id = $user_id;
                    $presensi->tanggal = $tanggal;
                    $presensi->created_by = $created_by;
                    $presensi->is_wfh = $is_wfh;
                    $presensi->is_sakit = $is_sakit;
                    $presensi->created_on = $created_on;


                    if ($presensi->save()) {
                        $response = ['success' => true, 'message' => 'Data presensi telah berhasil dimasukkan.'];
                    } else {
                        $response = ['success' => false, 'message' => $presensi->errors()];
                    }
                }
            }
        } else {
            // Handle kesalahan jika data tidak sesuai
            $response = ['success' => false, 'message' => 'Data tidak sesuai atau tidak lengkap'];
            echo json_encode($response);
        }
        // Keluarkan respons dalam format JSON
        echo json_encode($response);
    }
}
