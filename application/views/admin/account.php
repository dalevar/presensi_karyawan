<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-md-5">
                    <div class="card p-3">
                        <div class="card-body">
                            <div class="auth-logo">
                                <img src="../assets/images/logo.png " class="img-fluid rounded-normal darkmode-logo d-none" alt="logo">
                                <img src="../assets/images/logo-dark.png" class="img-fluid rounded-normal light-logo" alt="logo">
                            </div>
                            <h3 class="mb-3 font-weight-bold text-center">Sign In</h3>
                            <p class="text-center text-secondary mb-4">Log in to your account to continue</p>
                            <?php $this->view('message') ?>
                            <form method="post" action="<?= base_url('admin/account') ?>">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="text-secondary">Email</label>
                                            <input class="form-control" type="text" name="email" placeholder="Enter Email">
                                            <?= form_error('email', '<small class="text-danger">', '</small>') ?>

                                        </div>
                                    </div>
                                    <div class="col-lg-12 mt-2">
                                        <div class="form-group">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <label class="text-secondary">Password</label>
                                            </div>
                                            <input class="form-control" type="password" name="password1" placeholder="Enter Password">
                                            <?= form_error('password1', '<small class="text-danger">', '</small>') ?>

                                        </div>
                                    </div>
                                    <div class="col-lg-12 mt-2">
                                        <div class="form-group">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <label class="text-secondary">Confirm Password</label>
                                            </div>
                                            <input class="form-control" type="password" name="password2" placeholder="*********">
                                            <?= form_error('password2', '<small class="text-danger">', '</small>') ?>

                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block mt-2">Log In</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>