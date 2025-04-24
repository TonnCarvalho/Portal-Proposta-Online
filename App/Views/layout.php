<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
	<title>Proposta Online</title>

	<script defer type="module" src="alpine/alpine.js"></script>

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome Icons -->
	<link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
	<!-- Select2 -->
	<link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
	<!-- Toastr -->
	<link rel="stylesheet" href="/plugins/toastr/toastr.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="/css/adminlte.min.css">
</head>

<?php if ($_SERVER['REQUEST_URI'] === '/atualizar-usuario'): ?>
	<?= $this->content() ?>
	<?php die() ?>
<?php endif ?>

<?php if (
	$_SERVER['REQUEST_URI'] != '/'
	&& $_SERVER['REQUEST_URI'] != '/login'
	&& $_SERVER['REQUEST_URI'] != '/?login=error'
	&& $_SERVER['REQUEST_URI'] != '/recuperar-senha'
) : ?>

	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">
			<?php include('menu.php') ?>
			<?= $this->content() ?>
			<!-- REQUIRED SCRIPTS -->

			<!-- jQuery -->
			<script src="/plugins/jquery/jquery.min.js"></script>
			<!-- Bootstrap -->
			<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
			<!-- AdminLTE -->
			<script src="/js/adminlte.js"></script>
			<!-- OPTIONAL SCRIPTS -->
			<script src="/plugins/jquery-mask/jquery.mask.min.js"></script>

			<!-- AdminLTE for demo purposes -->
			<script src="/js/demo.js"></script>
			<!-- Select2 -->
			<script src="/plugins/select2/js/select2.min.js"></script>

		<?php else : ?>
			<?= $this->content() ?>
		</div>
	</body>
<?php endif ?>

</html>