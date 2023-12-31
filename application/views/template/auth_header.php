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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>


    <!-- Sweetalert 2 -->
    <link rel="stylesheet" href="<?= base_url('assets') ?>/js/sweetalert2/cdn.jsdelivr.net_npm_sweetalert2@11_dist_sweetalert2.min.css">
    <style>
        #loginForm {
            display: none;
        }
    </style>

</head>

<body class=" ">
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <!-- loader END -->