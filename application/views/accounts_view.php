<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Sumcon Biotechnology | Accounts</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.5 -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">

	<link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/AdminLTE.min.css">
	<!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/skins/_all-skins.min.css">
	<!-- iCheck -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/iCheck/flat/blue.css">
	<!-- Morris chart -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/morris/morris.css">
	<!-- jvectormap -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/jvectormap/jquery-jvectormap-1.2.2.css">
	<!-- Date Picker -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/datepicker/datepicker3.css">
	<!-- Daterange picker -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/daterangepicker/daterangepicker-bs3.css">
	<!-- bootstrap wysihtml5 - text editor -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

	<?php include_once "header.php"; ?>
	<!-- Left side column. contains the logo and sidebar -->
	<?php include_once "sidebar.php"; ?>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>Accounts</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Accounts</li>
			</ol>
		</section>

		<section class="content">
			<div class="row">
				<div class="col-xs-12"><h3>Setup Entry</h3></div>
			</div>
			<div class="row">
				<div class="col-xs-3"><h4><a href="<?php echo  base_url();?>client">Party Entry</a></h4></div>
				<div class="col-xs-3"><h4><a href="<?php echo  base_url();?>bank">Bank Entry</a></h4></div>
				<div class="col-xs-3"><h4><a href="<?php echo  base_url();?>bank/account">Bank Account Entry</a></h4></div>
				<div class="col-xs-3"><h4><a href="<?php echo  base_url();?>car">Car Entry</a></h4></div>
				<div class="col-xs-3"><h4><a href="<?php echo  base_url();?>employee">Employee Entry</a></h4></div>
			</div>
			<div class="row">
				<div class="col-xs-12"><h3>Vouchers</h3></div>
			</div>
			<div class="row">
				<div class="col-xs-3"><h4><a href="<?php echo  base_url();?>accounts/voucher/receipt">Receipt Voucher</a></h4></div>
				<div class="col-xs-3"><h4><a href="<?php echo  base_url();?>accounts/voucher/payment">Paymet Voucher</a></h4></div>
				<div class="col-xs-3"><h4><a href="<?php echo  base_url();?>accounts/voucher/journal">Journal Voucher</a></h4></div>
				<div class="col-xs-3"><h4><a href="<?php echo  base_url();?>accounts/voucher/transfer">Transfer Voucher</a></h4></div>
			</div>
			<div class="row">
				<div class="col-xs-12"><h3>List</h3></div>
			</div>
			<div class="row">
				<div class="col-xs-3"><h4><a href="<?php echo  base_url();?>chartofaccounts">Chart of Accounts</a></h4></div>
				<div class="col-xs-3"><h4><a href="<?php echo  base_url();?>accounts/voucherapprove">Approve Voucher</a></h4></div>
				<div class="col-xs-3"><h4><a href="<?php echo  base_url();?>accounts/vouchercount">Voucher Counts</a></h4></div>
				<div class="col-xs-3"></div>
			</div>
			<div class="row">
				<div class="col-xs-12"><h3>Reports</h3></div>
			</div>
			<div class="row">
				<div class="col-xs-3"><h4><a href="<?php echo  base_url();?>chartofaccounts/listofaccounts">Accounts Head</a></h4></div>
				<div class="col-xs-3"><h4><a href="<?php echo  base_url();?>accounts/accountsledger">Accounts Ledger</a></h4></div>
				<div class="col-xs-3"><h4><a href="<?php echo  base_url();?>accounts/accountssubledger">Accounts Sub Ledger</a></h4></div>
				<div class="col-xs-3"><h4><a href="<?php echo  base_url();?>accounts/voucherlist">Voucher list </a></h4></div>
				<div class="col-xs-3"><h4><a href="<?php echo  base_url();?>accounts/cashbook">Cash Book</a></h4></div>
				<div class="col-xs-3"><h4><a href="<?php echo  base_url();?>accounts/bankbook">Bank Book</a></h4></div>
				<div class="col-xs-3"><h4><a href="<?php echo  base_url();?>accounts/journal">Journal Report</a></h4></div>
				<div class="col-xs-3"><h4><a href="<?php echo  base_url();?>accounts/expenses">Expenses Report</a></h4></div>
				<div class="col-xs-3"><h4><a href="<?php echo  base_url();?>accounts/bankloan">Bank Loan Account/LTR Ledger</a></h4></div>
				<div class="col-xs-3"><h4><a href="<?php echo  base_url();?>accounts/trailbalance">Trail Balance</a></h4></div>
				<div class="col-xs-3"><h4><a href="<?php echo  base_url();?>accounts/incomestatement">Income Statement</a></h4></div>
				<div class="col-xs-3"><h4><a href="<?php echo  base_url();?>accounts/balancesheet">Banlance Sheet</a></h4></div>
				<div class="col-xs-3"><h4><a href="<?php echo  base_url();?>accounts/notes">Notes Report</a></h4></div>
				<div class="col-xs-3"><h4><a href="<?php echo  base_url();?>accounts/receiptandpayment">Receipt & Payment Statement</a></h4></div>
				<div class="col-xs-3"><h4><a href="<?php echo  base_url();?>accounts/employeeexpenses">  Employee ledger</a></h4></div>
				<div class="col-xs-3"><h4><a href="<?php echo  base_url();?>accounts/carexpenses">Car wise Expenses</a></h4></div>
			</div>
		</section>

		<!-- /.content -->
	</div><!-- /.content-wrapper -->
	<?php include_once 'footer.php';?>


</div><!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="<?php echo base_url(); ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
	$.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.5 -->
<script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>

<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url(); ?>dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>dist/js/demo.js"></script>
</body>
</html>
