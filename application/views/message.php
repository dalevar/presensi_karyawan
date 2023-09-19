<?php if ($this->session->has_userdata('berhasil')) { ?>
    <div class="alert alert-success alert-dismissible col-md-8">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <i class="icon fa fa-check"></i> <strong>Berhasil!</strong> <?= $this->session->flashdata('berhasil') ?>

    </div>
<?php } ?>

<?php if ($this->session->has_userdata('gagal')) { ?>
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <i class="icon fa fa-ban"></i> Gagal! <?= strip_tags(str_replace('</p>', '', $this->session->flashdata('gagal'))); ?>

    </div>
<?php } ?>