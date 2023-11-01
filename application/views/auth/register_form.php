<div class="wrapper">
    <section class="login-content">
        <div class="container h-100">
            <div class="row align-items-center justify-content-center h-100">
                <div class="col-md-5">
                    <div class="card p-3">
                        <div class="card-body">

                            <div class="auth-logo">
                                <img src="../assets/images/logo.png " class="img-fluid rounded-normal darkmode-logo d-none" alt="logo">
                                <img src="../assets/images/logo-dark.png" class="img-fluid rounded-normal light-logo" alt="logo">
                            </div>

                            <?php if ($this->session->flashdata('berhasil')) : ?>
                                <div id="flash" data-flash="<?= $this->session->flashdata('berhasil') ?>" data-type="success"></div>
                            <?php elseif ($this->session->flashdata('info')) : ?>
                                <div id="flash" data-flash="<?= $this->session->flashdata('info') ?>" data-type="info"></div>
                            <?php endif; ?>

                            <h3 class="mb-3 font-weight-bold text-center">Sign Up</h3>
                            <p class="text-center text-secondary mb-4">Choose your account as Admin</p>
                            <!-- <ul class="nav nav-tabs" id="myTab-1" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="config-tab" data-toggle="tab" href="#config" role="tab" aria-controls="config" aria-selected="true">Config</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="signup-tab" data-toggle="tab" href="#signup" role="tab" aria-controls="signup" aria-selected="false">Sign Up</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent-2">
                                <div class="tab-pane fade show active" id="config" role="tabpanel" aria-labelledby="config-tab">
                                    <form action="" method="">
                                        <label for="">Nama : </label>
                                        <input type="text" class="form-control">

                                        <div class="float-right pt-3">
                                            <button class="btn btn-primary btn-sm">Next <i class="ri-arrow-right-line"></i></button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="signup" role="tabpanel" aria-labelledby="signup-tab">
                                    <div class="social-btn d-flex justify-content-around align-items-center mb-4 p-4">
                                        <?= $login_button ?>
                                    </div>
                                    <a href="#config" class="text-secondary"><i class="ri-arrow-left-line"></i> Back</a>

                                </div>
                            </div> -->
                            <div class="social-btn d-flex justify-content-around align-items-center mb-4 p-4">
                                <?= $login_button ?>
                            </div>

                            <!-- <div class="card-header pt-3 pb-2" style="box-shadow: -5px 5px -5px -5px rgba(0,0,0,0.3);">
                                <ul class="nav nav-tabs justify-content-between" id="myTab-1" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="config-tab" data-toggle="tab" href="#config" role="tab" aria-controls="config" aria-selected="true">Config</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="user_admin-tab" data-toggle="tab" href="#user_admin" role="tab" aria-controls="user_admin" aria-selected="false">User Admin</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="done-tab" data-toggle="tab" href="#done" role="tab" aria-controls="done" aria-selected="false">Done</a>
                                    </li>
                                </ul>
                            </div> -->
                            <!-- <div class="card-header" style="box-shadow: 5px 8px 10px 10px rgba(0,0,0,0.3);">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="config" role="tabpanel">
                                        <form action="">
                                            <label for="">Domain Url : </label>
                                            <input type="text" class="form-control">
                                            <label for=""></label>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="user_admin" role="tabpanel">
                                        <h2>Step 2: Admin Account</h2>
                                    </div>
                                    <div class="tab-pane fade" id="done" role="tabpanel">
                                        <h2>Step 3: Done</h2>
                                    </div>
                                </div>
                            </div> -->
                            <!-- <div class="card-header blur-shadow bg-transparent pt-3 pb-2">
                                <ul class="nav justify-content-between nav-wizard" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active fw-semi-bold" href="#bootstrap-wizard-tab1" data-bs-toggle="tab" data-wizard-step="1" aria-selected="true" role="tab">
                                            <span class="nav-item-circle-parent">
                                                <span class="nav-item-circle">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                </span>
                                            </span>
                                            <span class="d-none d-md-block mt-1 fs--1">Config</span>
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab2" data-bs-toggle="tab" data-wizard-step="2" aria-selected="false" tabindex="-1" role="tab">
                                            <span class="nav-item-circle-parent">
                                                <span class="nav-item-circle">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                </span>
                                            </span>
                                            <span class="d-none d-md-block mt-1 fs--1">Admin Account</span>
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab2" data-bs-toggle="tab" data-wizard-step="2" aria-selected="false" tabindex="-1" role="tab">
                                            <span class="nav-item-circle-parent">
                                                <span class="nav-item-circle">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z" />
                                                    </svg>

                                                </span>
                                            </span>
                                            <span class="d-none d-md-block mt-1 fs--1">Done</span>
                                        </a>
                                    </li>
                                </ul>
                            </div> -->



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>