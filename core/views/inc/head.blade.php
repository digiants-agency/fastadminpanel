<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="robots" content="noindex" />

<link rel="shortcut icon" href="/vendor/fastadminpanel/images/favicon.png" type="image/x-icon">

<link href="/vendor/fastadminpanel/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<script src="/vendor/fastadminpanel/js/vendor/vue.js"></script>
<script src="/vendor/fastadminpanel/js/vendor/vue-router.js"></script>
<script src="/vendor/fastadminpanel/js/vendor/vue-demi.js"></script>
<script src="/vendor/fastadminpanel/js/vendor/pinia.js"></script>
<script src="/vendor/fastadminpanel/js/observer.js"></script>
<script src="/vendor/fastadminpanel/js/req.js"></script>

<script src="/vendor/fastadminpanel/vue-select/vue-select.js"></script>
<link rel="stylesheet" href="/vendor/fastadminpanel/vue-select/vue-select.css">

<script src="/vendor/fastadminpanel/ckeditor/ckeditor-MyCustomUploadAdapterPlugin.js"></script>
<script src="/vendor/fastadminpanel/ckeditor/ckeditor.js"></script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

@if (Platform::mobile())
	<link rel="stylesheet" href="<?php include 'vendor/fastadminpanel/css/converter-mobile.php' ?>">
	<link rel="stylesheet" href="/vendor/fastadminpanel/css/ckeditor-mobile.css" />
@else
	<link rel="stylesheet" href="<?php include 'vendor/fastadminpanel/css/converter-desktop.php' ?>">
	<link rel="stylesheet" href="/vendor/fastadminpanel/css/ckeditor.css" />
@endif

<title>{{ __('fastadminpanel.admin_panel') }}</title>