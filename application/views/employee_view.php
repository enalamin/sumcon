<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Sumcon Biotechnology | Employee</title>
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
        <small>Employee entry</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?php echo base_url()?>"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active"><?php echo $this->session->userdata('activeSidebar');?></li>
        <li class="active">Employee entry</li>
			</ol>
		</section>
		<section class="content">
        <div class="row">
          <!-- left column -->
          <div class="col-md-4">
            <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">New Employee Entry</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
              <form role="form" action="<?php echo base_url()?>employee/create_employee" method="post">
                <div class="form-group" style="display: none;">
                  <label>Company Name</label>
									<select class="form-control select2" name="company" id="company" required>
											<option value="">Select Company</option>
												<?php
														if(is_array($clientList)){
																foreach ($clientList as $client){
												?>
																<option value="<?php echo $client["client_id"];?>" <?php echo $client["client_id"]=='118'?'selected':''; ?> ><?php echo $client["client_name"];?></option>
												<?php
																}
														}
												?>
										</select>
                </div>
								<div class="form-group">
									<label>Employee Name</label>
                  <input type="text" class="form-control" placeholder="Enter ..." name="employeeName" required>
                </div>

								<div class="form-group">
									<label>Designation</label>
                  <input type="text" class="form-control" placeholder="Enter ..." name="designation" >
                </div>

                <!-- textarea -->
                <div class="form-group">
                  <label>Address</label>
                  <textarea class="form-control" rows="3" placeholder="Enter ..." name="officeAddress" ></textarea>
                </div>

                <div class="form-group">
                  <label>Contact Number</label>
                  <input type="text" class="form-control" placeholder="Enter ..." name="contactNo" required>
                </div>
								<div class="form-group">
                  <label>Email</label>
                  <input type="email" class="form-control" placeholder="Enter ..." name="email" >
                </div>
                <div class="form-group">
                    <div class="col-xs-6">
                     <input id="btn_save" name="btn_save" type="submit" class="btn btn-primary btn-block" value="Save Employee" />
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
                  <h3 class="box-title">Employee List</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Employee Name</th>
												<th>Contact Number</th>
												<th>Email</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                        if(is_array($employeeList) && !empty($employeeList)){
                            foreach ($employeeList as $employee){
                              if($employee['client_id']!=118)
                                continue;
                    ?>
                            <tr>
                                <td><?php echo $employee["employee_name"];?></td>
																<!-- <td><?php echo $employee["client_name"];?></td> -->
                                <td><?php echo $employee["contact_no"];?></td>
																<td><?php echo $employee["email"];?></td>
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
<script src="<?php echo base_url(); ?>plugins/select2/select2.full.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->

<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>dist/js/demo.js"></script>
<!-- page script -->
    <script>
      $(function () {
        $("#example1").DataTable();
				$(".select2").select2();
      });
    </script>
</body>
</html>
