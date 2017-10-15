<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Sumcon Biotechnology | Proforma List</title>
		<!-- Tell the browser to be responsive to screen width -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!-- Bootstrap 3.3.5 -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
		<!-- Font Awesome -->
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
		<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/select2/select2.min.css">
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
						Purchase
        				<small>LC List For Approve Goods Receive</small>
					</h1>
					<ol class="breadcrumb">
						<li><a href="<?php echo base_url()?>"><i class="fa fa-dashboard"></i> Home</a></li>
						<li class="active">Purchase</li>
        				<li class="active">LC List For Approve Goods Receive</li>
					</ol>
				</section>
    			<section class="content">
        			<div class="row">
            			<div class="col-md-12">
                			<div class="box">
	                			<div class="box-header">
	                  				<h3 class="box-title">LC List</h3>
	                			</div><!-- /.box-header -->
	                			<div class="box-body">
	                  				<table id="example1" class="table table-bordered table-striped">
	                    				<thead>
	                      					<tr>
												<th>LC Number</th>
												<th>PI Number</th>
	                        					<th>supplier Name [ID]</th>
	                        					<th>Receive Date</th>
	                                            <th>Receive Qty (KG)</th>
                        					</tr>
	                    				</thead>
	                    				<tbody>
	                    				<?php
	                        				if(is_array($lcList) && !empty($lcList)){
	                            				foreach ($lcList as $lc){
	                    				?>
	                            				<tr>
													<td><?php echo $lc["lc_no"];?></td>
	                                				<td><?php echo $lc["pi_no"];?></td>
	                                				<td><?php echo $lc["client_name"]."[".$lc["client_id"]."]";?></td>
					                                <td><?php echo $lc["receive_date"];?></td>
	                                                <td><?php echo $lc["receive_quantity"];?></td>
	                                				<td><a href="<?php echo base_url()?>purchase/approvelcreceive/<?php echo $lc["lc_id"].'/'.$lc["receive_lc_batch"];?>" class="btn btn-block btn-primary">Approve Receive Goods</a></td>
	                            				</tr>
					                    <?php
					                            }
					                        }
					                    ?>
	                    				</tbody>
                					</table>
              					</div><!-- /.box-body -->
            				</div><!-- /.box -->
          				</div>
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
	<script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>plugins/select2/select2.full.min.js"></script>
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
	
</body>
</html>
