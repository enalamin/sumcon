<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Sumcon Biotechnology | Car</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.5 -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
	<!-- Font Awesome -->
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
				<?php echo $this->session->userdata('activeSidebar');?>
        <small>Asset entry</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?php echo base_url()?>"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active"><?php echo $this->session->userdata('activeSidebar');?></li>
        <li class="active">Asset entry</li>
			</ol>
		</section>
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-4">
          <div class="box box-default">
              <div class="box-header with-border">
                <h3 class="box-title">New Asset Entry</h3>
              </div><!-- /.box-header -->
              <div class="box-body">
                <form role="form" action="<?php echo base_url()?>assetmanagement/assetentry" method="post">
                    <!-- select -->
                   <!-- text input -->
                  <div class="form-group">
                    <label>Asset Type</label>
                    <select class="select2 form-control" name="assetType" id="assetType" >
                      <option value="">Select Asset Type</option>
                      <option value="Vehicle">Vehicle</option>
                      <option value="Office Equipments">Office Equipments</option>
                      <option value="Electrical Equipments">Electrical Equipments</option>
                      <option value="Office Decoration">Office Decoration</option>
                      <option value="Furniture & Fixture">Furniture & Fixture</option>
                    </select>
                  </div>
									<div class="form-group">
										<label>Asset Name</label>
                    <input type="text" class="form-control" placeholder="Enter ..." name="assetName" required>
                  </div>

                  <!-- textarea -->
                  <div class="form-group">
                    <label>Purchase Date</label>
                    <input type="text" class="form-control" placeholder="Enter ..." name="purchaseDate" id="purchaseDate" required>
                  </div>

                  <div class="form-group">
                    <label>Purchase value (BDT)</label>
                    <input type="text" class="form-control" placeholder="Enter ..." name="purchaseValue" required >
                  </div>
                  <div class="form-group">
                    <label>Current value (BDT)</label>
                    <input type="text" class="form-control" placeholder="Enter ..." name="currentValue" required >
                  </div>
                  <div class="form-group">
                    <label>Depreciation Rate (%)</label>
                    <input type="text" class="form-control" placeholder="Enter ..." name="depreciationRate"  required >
                  </div>
                   <div class="form-group">
                        <div class="col-xs-6">
                         <input id="btn_save" name="btn_save" type="submit" class="btn btn-primary btn-block" value="Save Asset" />
                        </div>
                         <div class="col-xs-6">
                             <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-block btn-danger" value="Cancel" />
                        </div>
                    </div>
                  </form>
                </div><!-- /.box-body -->
              </div>
            </div>
            <div class="col-md-8">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Asset List</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Asset Type</th>
                        <th>Name</th>
                        <th>Purchase Date</th>
                        <th>Purchase Value (BDT)</th>
                        <th>Current Value (BDT)</th>
                        <th>Depreciation Rate (%)</th>

                      </tr>
                    </thead>
                    <tbody>
                    <?php
                        if(is_array($assetList) && !empty($assetList)){
                            foreach ($assetList as $asset){
                    ?>
                            <tr>
                                <td><?php echo $asset["asset_type"];?></td>
                                <td><?php echo $asset["asset_name"];?></td>
                                <td><?php echo $asset["purchase_date"];?></td>
                                <td><?php echo $asset["purchase_value"];?></td>
                                <td><?php echo $asset["current_value"];?></td>
                                <td><?php echo $asset["depreciation_rate"];?></td>

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

                    </div></section>

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

<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>plugins/select2/select2.full.min.js"></script>
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
        $("#example1").DataTable();
        $(".select2").select2();
        $("#purchaseDate").datepicker();

      });
    </script>
</body>
</html>
