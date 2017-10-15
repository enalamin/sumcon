<?php

defined('BASEPATH') OR exit('No direct script access allowed');

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Sumcon Biotechnology | Sales Commission</title>
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
    <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/select2/select2.min.css">
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
                Sales<small>Calculate Sales Contact</small>
            </h1>

			<ol class="breadcrumb">
				<li><a href="<?php echo base_url()?>"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Calculate Sales Contact</li>
			</ol>
		</section>
        <section class="content">
            <div class="row">
                <form name="frmCommission" method="post" action="<?php echo base_url()."sales/invoiceforcommission"?>">
                    <div class="col-md-6">
                        <label>Party Name</label>
                        <select class="form-control select2 " name="client" id="client" required>
                            <option value="">Select Party</option>
                            <?php
                                if(is_array($clientList)){
                                    foreach ($clientList as $client){
                            ?>
                                    <option value="<?php echo $client["client_id"];?>"><?php echo $client["client_name"];?></option>
                            <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Invoice Number</label>
                        <input type="text" name="invoiceNumber" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label>&nbsp;</label>
                        <input id="btn_save" name="btn_save" type="submit" class="btn btn-primary btn-block" value="Show" />
                    </div>
                </form>
            </div>
            <?php 
                if($invoiceList){
            ?>
            <div class="row">
            <!-- left column -->
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">
                            <?php
                                if(isset($listTitel))
                                    echo $listTitel;
                            ?>
                            </h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Invoice Number</th>
                                        <th>Invoice Date</th>
                                        <th>Client Name</th>
                                        <th>Contact Number</th>
                                        <th>Invoice Amount</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    if(is_array($invoiceList) && !empty($invoiceList)){
                                        foreach ($invoiceList as $invoice){                                            
                                ?>
                                    <tr>
                                        <td><a href="<?php echo base_url(); ?>sales/viewinvoice/<?php echo $invoice["invoice_id"];?>"><?php echo $invoice["invoice_no"];?></a></td>
                                        <td><?php echo $invoice["invoice_date"];?></td>
                                        <td><?php echo $invoice["client_name"];?></td>
                                        <td><?php echo $invoice["client_contact_no"];?></td>
                                        <td><?php echo number_format($invoice["net_total"],2);?></td>
                                        <td>
                                            <a href="<?php echo base_url(); ?>sales/calcualtesalescommission/<?php echo $invoice["invoice_id"];?>" class="btn btn-block btn-primary">Calculate Sales Commission</a>
                                        </td>
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
            <?php
                }            
            ?>
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
<script src="<?php echo base_url(); ?>plugins/select2/select2.full.min.js"></script>


<!-- AdminLTE for demo purposes -->

<script src="<?php echo base_url(); ?>dist/js/demo.js"></script>

<!-- page script -->

    <script>

      $(function () {
        $(".select2").select2();
        $("#example1").DataTable({
            "bLengthChange": false
        });

        

      });

    </script>

</body>

</html>



