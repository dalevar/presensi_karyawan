<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <h4 class="font-weight-bold"><?= $title ?></h4>
                </div>
                <nav aria-label="breadcrumb">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex flex-wrap justift-content-between">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>"><i class="ri-home-4-line mr-1 float-left"></i>Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </nav>
                <div class="col-md-12 mt-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-wrap justify-content-end">
                                <button type="button" class="btn btn-primary mt-2 mb-2" data-toggle="modal" data-target="#tambahKaryawan">Tambah</button>
                            </div>

                            <?php if ($this->session->flashdata('berhasil')) : ?>
                                <div id="flash" data-flash="<?= $this->session->flashdata('berhasil') ?>" data-type="success"></div>
                            <?php elseif ($this->session->flashdata('gagal')) : ?>
                                <div id="flash" data-flash="<?= $this->session->flashdata('gagal') ?>" data-type="error"></div>
                            <?php endif; ?>

                            <table id="datatable" class="table data-table table-striped table-bordered" style="z-index: -1; overflow: auto;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Jabatan</th>
                                        <th>Tipe</th>
                                        <th>Tanggal Diterima</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($karyawan as $kr) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $kr->nama ?></td>
                                            <td><?= $kr->email ?></td>
                                            <td><?= $kr->jabatan ?></td>
                                            <td><?= $kr->tipe ?></td>
                                            <td><?= date('d/m/Y', strtotime($kr->tanggal_masuk)) ?></td>
                                            <td>
                                                <div class="btn-group dropright">
                                                    <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu" style="z-index: 1000;">
                                                        <a class="dropdown-item" data-toggle="modal" data-target="#editKaryawan<?= $kr->id ?>"> <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                            </svg>Edit Profile</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item text-danger" data-toggle="modal" data-target="#hapusKaryawan<?= $kr->id ?>"> <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                            </svg>Hapus</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
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


<div class="modal fade bd-example-modal-xl" id="tambahKaryawan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('admin/manageuser/tambahKaryawan') ?>" method="POST">
                    <div class="form-group">
                        <label for="" class="h6">Email</label>
                        <input type="text" class="form-control" name="email_karyawan">
                        <?= form_error('email_karyawan', '<small class="text-danger">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <label for="" class="h6">Nama</label>
                        <input type="text" class="form-control" name="nama_karyawan">
                        <?= form_error('nama_karyawan', '<small class="text-danger">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_masuk" class="h6">Tanggal Masuk</label>
                        <input type="date" class="form-control" name="tanggal_masuk">
                        <?= form_error('tanggal_masuk', '<small class="text-danger">', '</small>') ?>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="h6">Tipe</label>
                                <select name="tipe_id" id="" class="form-control">
                                    <option value="">--Pilih Tipe--</option>
                                    <?php foreach ($tipe as $tp) : ?>
                                        <option value="<?= $tp->id ?>"><?= $tp->tipe ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('tipe_id', '<small class="text-danger">', '</small>') ?>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="h6">Jabatan</label>
                                <select name="jabatan_id" id="" class="form-control">
                                    <option value="">--Pilih Jabatan--</option>
                                    <?php foreach ($jabatan as $jb) : ?>
                                        <option value="<?= $jb->id ?>"><?= $jb->jabatan ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('jabatan_id', '<small class="text-danger">', '</small>') ?>

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="h6">Tingkat Pendidikan</label>
                        <input type="text" class="form-control" name="tingkat_pendidikan">
                        <?= form_error('tingkat_pendidikan', '<small class="text-danger">', '</small>') ?>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="" class="h6">Catatan</label>
                                <textarea name="catatan" id="" rows="2" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="" class="h6">Role</label>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck5">
                                <label class="custom-control-label" for="customCheck5">Admin</label>
                            </div>
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>



<!-- Edit Karyawan -->
<?php $no = 0;
foreach ($karyawan as $kr) : $no++ ?>
    <div class="modal fade bd-example-modal-xl" id="editKaryawan<?= $kr->id ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Karyawan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('admin/manageuser/editKaryawan/' . $kr->id) ?>" method="POST">
                        <input type="hidden" id="editId" name="id" value="<?= $kr->id ?>">
                        <div class="form-group">
                            <label for="" class="h6">Email</label>
                            <input type="text" class="form-control" name="email_karyawan" value="<?= $kr->email; ?>">
                            <?= form_error('email_karyawan', '<small class="text-danger">', '</small>') ?>
                        </div>
                        <div class=" form-group">
                            <label for="" class="h6">Nama</label>
                            <input type="text" class="form-control" name="nama_karyawan" id="editNamaKaryawan" value="<?= $kr->nama; ?>">
                            <?= form_error('nama_karyawan', '<small class="text-danger">', '</small>') ?>

                        </div>
                        <div class="form-group">
                            <label for="tanggal_masuk" class="h6">Tanggal Masuk</label>
                            <input type="date" class="form-control" name="tanggal_masuk" id="editTanggalMasuk" value="<?= $kr->tanggal_masuk; ?>">
                            <?= form_error('tanggal_masuk', '<small class="text-danger">', '</small>') ?>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="h6">Tipe</label>
                                    <select name="tipe_id" id="Tipe" class="form-control">
                                        <option value="<?= $kr->tipe_id ?>"><?= $kr->tipe ?></option>
                                        <?php foreach ($tipe as $tp) : ?>
                                            <option value="<?= $tp->id ?>"><?= $tp->tipe ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?= form_error('tipe_id', '<small class="text-danger">', '</small>') ?>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="h6">Jabatan</label>
                                    <select name="jabatan_id" id="jabatan" class="form-control">
                                        <option value="<?= $kr->jabatan_id ?>"><?= $kr->jabatan ?></option>
                                        <?php foreach ($jabatan as $jb) : ?>
                                            <option value="<?= $jb->id ?>"><?= $jb->jabatan ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?= form_error('jabatan_id', '<small class="text-danger">', '</small>') ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="h6">Tingkat Pendidikan</label>
                            <input type="text" class="form-control" name="tingkat_pendidikan" id="editTingkatPendidikan" value="<?= $kr->tingkat_pendidikan; ?>">
                            <?= form_error('tingkat_pendidikan', '<small class="text-danger">', '</small>') ?>
                        </div>
                        <div class="form-group">
                            <label for="" class="h6">Catatan</label>
                            <textarea name="catatan" id="catatan" rows="2" class="form-control"><?= $kr->catatan ?></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<!-- End Edit -->

<!-- Hapus Karyawan -->
<?php $no = 0;
foreach ($karyawan as $kr) : $no++ ?>
    <div class="modal fade bd-example-modal-sm" id="hapusKaryawan<?= $kr->id ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">Hapus Karyawan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('admin/manageuser/hapusKaryawan/' . $kr->id) ?>" method="POST">
                        <input type="hidden" id="editId" name="id" value="<?= $kr->id ?>">
                        <div class="form-group">
                            <label for="" class="h6">Anda Yakin Hapus Data Karyawan ?</label>
                            <input type="text" class="form-control" name="nama_karyawan" id="editNamaKaryawan" value="<?= $kr->nama; ?>" readonly>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<!-- Hapus Karyawan -->



<script>
    $(document).ready(function() {
        // Fungsi untuk menampilkan modal edit saat tombol "Edit" diklik
        $('a[data-toggle="modal"]').click(function() {
            var targetModal = $(this).attr('data-target');
            $(targetModal).modal('show');
        });
    });

    //dropdown
    (function() {
        // hold onto the drop down menu                                             
        var dropdownMenu;

        // and when you show it, move it to the body                                     
        $(window).on('show.bs.dropdown', function(e) {

            // grab the menu        
            dropdownMenu = $(e.target).find('.dropdown-menu');

            // detach it and append it to the body
            $('body').append(dropdownMenu.detach());

            // grab the new offset position
            var eOffset = $(e.target).offset();

            // make sure to place it where it would normally go (this could be improved)
            dropdownMenu.css({
                'display': 'block',
                'top': eOffset.top + $(e.target).outerHeight(),
                'left': eOffset.left
            });
        });

        // and when you hide it, reattach the drop down, and hide it normally                                                   
        $(window).on('hide.bs.dropdown', function(e) {
            $(e.target).append(dropdownMenu.detach());
            dropdownMenu.hide();
        });
    })();
</script>