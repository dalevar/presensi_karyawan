<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title><?= $title; ?></title>

	<!-- Favicon -->
	<link rel="shortcut icon" href="<?= base_url('assets') ?>/images/favicon.ico" />

	<link rel="stylesheet" href="<?= base_url('assets') ?>/css/backend-plugin.min.css">
	<link rel="stylesheet" href="<?= base_url('assets') ?>/css/backend.css?v=1.0.0">

	<link rel="stylesheet" href="<?= base_url('assets') ?>/css/remixicon/remixicon.css">


	<!-- jquery -->
	<!-- <script src="<?= base_url('assets/js/') ?>code.jquery.com_jquery-3.7.1.min.js"></script> -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


	<!-- Sweetalert 2 -->
	<link rel="stylesheet" href="<?= base_url('assets') ?>/js/sweetalert2/cdn.jsdelivr.net_npm_sweetalert2@11_dist_sweetalert2.min.css">

	<!-- CALENDAR -->
	<link rel="stylesheet" href="<?= base_url('assets/calendar/src/calendar-gc.css') ?>">



	<!-- FULLCALENDAR -->
	<!-- <script src="<?= base_url('assets/fullcalendar/dist/index.global.js') ?>"></script>
	<script src="<?= base_url('assets/fullcalendar/packages/core/index.global.js') ?>"></script>
	<script src="<?= base_url('assets/fullcalendar/packages/core/locales/id.global.min.js') ?>"></script>
	<script src="<?= base_url('assets/fullcalendar/packages/daygrid/index.global.min.js') ?>"></script> -->
	<!-- <style>
		.circle {
			background: red;
			border: 1px solid blue;
			padding: 10px;
			border-radius: 50%;
		}

		td {
			padding: 20px;
			border: 1px solid grey;
		}


		.sunday {
			color: red;
		}

		.with-circle {
			position: relative;
		}

		.with-circle::before {
			content: "\2022";
			/* Unicode character for a bullet */
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			background-color: #ffcc00;
			/* Yellow background color */
			width: 18px;
			height: 18px;
			border-radius: 50%;
			text-align: center;
			line-height: 18px;
			color: #fff;
			/* Text color inside the circle */
			font-weight: bold;
			cursor: pointer;
		}
	</style> -->

</head>

<body class=" color-light ">
	<!-- loader Start -->
	<div id="loading">
		<div id="loading-center">
		</div>
	</div>
	<!-- loader END -->
	<!-- Wrapper Start -->
	<div class="wrapper">