<div class="iq-sidebar  sidebar-default  ">
	<div class="iq-sidebar-logo d-flex align-items-end justify-content-between">
		<a href="<?= base_url('admin/dashboard') ?>" class="header-logo">
			<img src="<?= base_url('assets') ?>/images/logo.png" class="img-fluid rounded-normal light-logo" alt="logo">
			<img src="<?= base_url('assets') ?>/images/logo-dark.png" class="img-fluid rounded-normal d-none sidebar-light-img" alt="logo">
			<span>PRESENSI <i class="ri-building-2-fill"></i></span>
		</a>
		<div class="side-menu-bt-sidebar-1">
			<svg xmlns="http://www.w3.org/2000/svg" class="text-light wrapper-menu" width="30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
			</svg>
		</div>
	</div>
	<div class="data-scrollbar" data-scroll="1">
		<nav class="iq-sidebar-menu">
			<ul id="iq-sidebar-toggle" class="side-menu">
				<li class="sidebar-layout <?= $this->uri->segment(2) == 'dashboard' ? 'active' : '' ?>">
					<a href="<?= base_url('admin/dashboard') ?>" class="svg-icon">
						<i class="">
							<svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
							</svg>
						</i>
						<span class="ml-2">Dashboard</span>
					</a>
				</li>
				<li class="px-3 pt-3 pb-2">
					<span class="text-uppercase small font-weight-bold">Pages</span>
				</li>

				<li class=" sidebar-layout <?= $this->uri->segment(2) == 'tipe_jabatan' || $this->uri->segment(2) == 'Tipe_jabatan' ?  'active' : '' ?>">
					<a href="<?= base_url('admin/tipe_jabatan') ?>" class="svg-icon">
						<i class="">
							<svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">

								<path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />

							</svg>
						</i><span class="ml-2">Tipe & Jabatan</span>
					</a>
				</li>

				<li class=" sidebar-layout <?= $this->uri->segment(2) == 'Laporan' || $this->uri->segment(2) == 'laporan' ? 'active' : '' ?>">

					<a href="<?= base_url('admin/Laporan') ?>" class="svg-icon">
						<i class="">
							<svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">

								<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />


							</svg>
						</i><span class="ml-2">Laporan</span>
					</a>
				</li>
				<li class="px-3 pt-3 pb-2">
					<span class="text-uppercase small font-weight-bold">Components</span>
				</li>
				<li class=" sidebar-layout <?= $this->uri->segment(2) == 'konfigurasi' || $this->uri->segment(2) == 'Konfigurasi' ? 'active' : '' ?>">
					<a href="<?= base_url('admin/konfigurasi') ?>" class="svg-icon">
						<i class="">
							<svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
								<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
							</svg>
						</i>
						<span class="ml-2">Konfigurasi</span>
					</a>
				</li>
				<li class=" sidebar-layout <?= $this->uri->segment(2) == 'manageuser' || $this->uri->segment(2) == 'ManageUser' ? 'active' : '' ?>">
					<a href="<?= base_url('admin/ManageUser') ?>" class="svg-icon">
						<i class="">
							<svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
							</svg>
						</i><span class="ml-2">Management Users</span>
					</a>
				</li>

			</ul>
		</nav>
		<div class="pt-5 pb-5"></div>
	</div>
</div>
<div class="iq-top-navbar">
	<div class="iq-navbar-custom">
		<nav class="navbar navbar-expand-lg navbar-light p-0">
			<div class="side-menu-bt-sidebar">
				<svg xmlns="http://www.w3.org/2000/svg" class="text-secondary wrapper-menu" width="30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
				</svg>
			</div>
			<div class="d-flex align-items-center">
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-label="Toggle navigation">
					<svg xmlns="http://www.w3.org/2000/svg" class="text-secondary" width="30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
					</svg>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav ml-auto navbar-list align-items-center">

						<li class="nav-item nav-icon dropdown">
							<a href="#" class="nav-item nav-icon dropdown-toggle pr-0 search-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<img src="<?= base_url('assets') ?>/images/user/1.jpg" class="img-fluid avatar-rounded" alt="user">
								<span class="mb-0 ml-2 user-name"><?= $user['first_name'] . ' ' . $user['last_name'] ?></span>
							</a>
							<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">

								<li class="dropdown-item d-flex svg-icon">
									<svg class="svg-icon mr-0 text-secondary" id="h-03-p" width="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
									</svg>
									<a href="../app/user-account-setting.html">Account Settings</a>
								</li>
								<li class="dropdown-item  d-flex svg-icon border-top">
									<svg class="svg-icon mr-0 text-secondary" id="h-05-p" width="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
									</svg>
									<a href="<?= base_url('auth/logout') ?>" id="btnLogout">Logout</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>
	</div>
</div>