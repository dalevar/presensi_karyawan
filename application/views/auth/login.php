<div class="wrapper">
    <section class="login-content">
        <div class="container h-100">
            <div class="row align-items-center justify-content-center h-100">
                <div class="col-md-5">
                    <div class="card p-3">
                        <div class="card-body">
                            <div class="auth-logo">
                                <img src="<?= base_url('assets') ?>/images/logo.png " class="img-fluid  rounded-normal  darkmode-logo" alt="logo">
                                <img src="<?= base_url('assets') ?>/images/logo-dark.png" class="img-fluid rounded-normal light-logo" alt="logo">
                            </div>
                            <h3 class="mb-3 font-weight-bold text-center">Sign In</h3>
                            <p class="text-center text-secondary mb-4">Log in to your account to continue</p>

                            <!-- <div id="flash" data-flash="<?= $this->session->flashdata('flash') ?>"></div> -->
                            <?php if ($this->session->flashdata('berhasil')) : ?>
                                <div id="flash" data-flash="<?= $this->session->flashdata('berhasil') ?>" data-type="success"></div>

                            <?php elseif ($this->session->flashdata('gagal')) : ?>
                                <div id="flash" data-flash="<?= $this->session->flashdata('gagal') ?>" data-type="error"></div>

                            <?php endif; ?>

                            <div class="social-btn d-flex justify-content-around align-items-center mb-4">
                                <?= $login_button ?>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>