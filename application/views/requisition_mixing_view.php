<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Sumcon Biotechnology | Product Mixing  </title>
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
    				Inventory 
                    <small>Product Mixing Requisition</small>
    			</h1>
    			<ol class="breadcrumb">
    				<li><a href="<?php echo base_url()?>"><i class="fa fa-dashboard"></i> Home</a></li>
    				<li class="active">Inventory</li>
                    <li class="active">Product Mixing Requisition List</li>
    			</ol>
    		</section>
            <section class="content">
                <div class="row">
                <!-- left column -->
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">
                                <?php
                                    if(isset($listTitel))
                                        echo $listTitel;
                                    else
                                        echo "Product Mixing Requisition List";
                                ?> 
                                </h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Requisition Number</th>
                                            <th>Requisition Date</th>
                                            <th>Quantity</th>
                                            <th>Requisition For Product</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        if(is_array($productMixingList) && !empty($productMixingList)){
                                            foreach ($productMixingList as $mixing){
                                    ?>
                                        <tr>
                                            <td><a href="<?php echo base_url(); ?>productmixingrequisition/viewsmixingrequisition/<?php echo $mixing["requisition_number"];?>"  ><?php echo $mixing["requisition_number"];?></a></td>
                                            <td><?php echo $mixing["requisition_date"];?></td>
                                            <td><?php echo $mixing["totalqty"];?></td>
                                            <td><?php echo $mixing["req_product_desc"];?></td>
                                            <td> 
                                            <?php 
                                                if($mixing["status"]==0){
                                            ?>
                                                <a href="<?php echo base_url(); ?>productmixingrequisition/updaterequisition/<?php echo $mixing["requisition_number"];?>/1"  class="btn btn-block btn-primary"> Approve </a>
                                            <?php
                                                } elseif ($mixing["status"]==1) {
                                            ?>
                                                <a href="<?php echo base_url(); ?>productmixingrequisition/requisitionconversion/<?php echo $mixing["requisition_number"];?>"  class="btn btn-block btn-primary"> Convert to New product</a>
                                            <?php
                                                }
                                            ?>
                                            </td>
                                        </tr>
                                    <?php
                                            }
                                        }
                                    ?>
                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>
                </div>
            </section>
    	</div><!-- /.content-wrapper -->
    	<?php include_once 'footer.php';?>
    </div><!-- ./wrapper -->
    
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
        });

    </script>

</body>

</html>



