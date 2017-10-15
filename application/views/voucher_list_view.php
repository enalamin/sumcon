<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Sumcon Biotechnology | Sales</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.5 -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Theme style -->
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
			<h1>
				Accounts
        		<small>Voucher List</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?php echo base_url()?>"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active"><a href="<?php echo base_url()?>accounts">Accounts</a></li>
        		<li class="active">Voucher List</li>
			</ol>
		</section>
        <section class="content">
        	<div class="row">
                <form name="frmVoucher" method="post" action="<?php echo base_url()."accounts/voucherlist"?>">
                	<div class="col-md-3">
                        <label>Voucher Type</label>
                        <select class="form-control select2 " name="voucherType" id="voucherType" >
                            <option value="">Select Type</option>
                            <option value="receipt" <?php echo $voucherType && $voucherType=='receipt'? 'selected':''; ?> >Receipt</option>
                            <option value="payment" <?php echo $voucherType && $voucherType=='payment'? 'selected':''; ?>>Payment</option>
                            <option value="journal" <?php echo $voucherType && $voucherType=='journal'? 'selected':''; ?>>Journal</option>
                            <option value="transfer" <?php echo $voucherType && $voucherType=='transfer'? 'selected':''; ?>>Transfer</option>
                        </select>
                    </div>
                	<div class="col-md-3">
                        <label>Voucher Date</label>
                        <input type="text" name="voucherDate" id="voucherDate" class="form-control" value="<?php echo $voucherDate ? date('m/d/Y', strtotime($voucherDate)):''; ?>" >
                    </div>                    
                    <div class="col-md-3">
                        <label>Voucher Number</label>
                        <input type="text" name="voucherNumber" class="form-control" value="<?php echo $voucherNumber; ?>" >
                    </div>
                    <div class="col-md-3">
                        <label>&nbsp;</label>
                        <input id="btn_save" name="btn_save" type="submit" class="btn btn-primary btn-block" value="Show" />
                    </div>
                </form>
            </div>
            <?php
            	if(is_array($voucherList) && !empty($voucherList)){
            ?>
	            <div class="row">
					<!-- left column -->
	                 <div class="col-md-12">
	                    <div class="box">
	                		<div class="box-header">
	                  			<h3 class="box-title">Voucher List</h3>
	                		</div><!-- /.box-header -->
	                		<div class="box-body">
	                  			<table id="example1" class="table table-bordered table-striped">
	                    			<thead>
	                      				<tr>
	                        				<th>Voucher Number</th>
	                        				<th>Voucher Date</th>
											<th>Vooucher Type</th>
	                        				<th>Party Name</th>
	                        				<th></th>
	                      				</tr>
	                    			</thead>
	                    			<tbody>
				                    <?php
				                        foreach ($voucherList as $voucher){
				                    ?>

			                            <tr>
			                                <td>
			                                	<a href="<?php echo base_url(); ?>accounts/voucherdetails/<?php echo $voucher["voucher_id"];?>"><?php echo $voucher["voucher_number"].'('.date('Ym',  strtotime($voucher["voucher_date"])).')';?></a>
			                            	</td>
			                                <td><?php echo date('d-m-Y',  strtotime($voucher["voucher_date"]));?></td>
											<td><?php echo $voucher["voucher_type"];?></td>
			                                <td><?php echo $voucher["client_name"];?></td>
			                                <td>
			                                	<a href="<?php echo base_url(); ?>accounts/voucherdetails/<?php echo $voucher["voucher_id"];?>" class="btn btn-block btn-primary">View Details</a>
											</td>
			                            </tr>
				                    <?php
				                        }
				                    ?>
	                    			</tbody>
							    </table>
	                		</div><!-- /.box-body -->
	              		</div><!-- /.box -->
					</div>
	            </div>
            <?php
            	}
            ?>
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
<script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.min.js"></script>

<!-- Sparkline -->
<script src="<?php echo base_url(); ?>plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo base_url(); ?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url(); ?>plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url(); ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo base_url(); ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url(); ?>plugins/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->

<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>dist/js/demo.js"></script>
<!-- page script -->
    <script>
      $(function () {
        $("#example1").DataTable({
			"order": [[ 1, "desc" ]]
		});
		$("#voucherDate").datepicker();

      });
    </script>
</body>
</html>
