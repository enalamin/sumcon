<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Sumcon Biotechnology | Client</title>
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
				Sales
                                <small>client entry</small>

			</h1>
			<ol class="breadcrumb">
				<li><a href="<?php echo base_url()?>"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Sales</li>
        <li class="active">client entry</li>
			</ol>
		</section>
                <section class="content">
                    <div class="row">
                      <!-- left column -->
                      <div class="col-md-4">
                        <div class="box box-default">
                    <div class="box-header with-border">
                      <h3 class="box-title">New Client Entry</h3>
                      
                    </div><!-- /.box-header -->
                    <div class="box-body">
          					<?php $action = ($clientDetails && $clientDetails[0]['client_id']>0? "/".$clientDetails[0]['client_id']:"");?>
                      <form role="form" action="<?php echo base_url()?>client/create_client<?php echo $action;?>" method="post">
                          <!-- select -->
                         <!-- text input -->
                        <div class="form-group">
                          <label>Client Name</label>
                          <input type="text" class="form-control" placeholder="Enter ..." name="clientName" value="<?php echo $clientDetails && $clientDetails[0]['client_id']>0? $clientDetails[0]['client_name']:""; ?>" required>
                        </div>

                        <!-- textarea -->
                        <div class="form-group">
                          <label>Office Address</label>
                          <textarea class="form-control" rows="3" placeholder="Enter ..." name="clientOfficeAddress" required><?php echo $clientDetails && $clientDetails[0]['client_id']>0? $clientDetails[0]['client_office_address']:""; ?></textarea>
                        </div>
                        <div class="form-group">
                          <label>Delivery Address</label>
                          <textarea class="form-control" rows="3" placeholder="Enter ..." name="clientDeliveryAddress" ><?php echo $clientDetails && $clientDetails[0]['client_id']>0? $clientDetails[0]['client_delivery_address']:""; ?></textarea>
                        </div>
                        <div class="form-group">
                          <label>Contact Number</label>
                          <input type="text" class="form-control" placeholder="Enter ..." name="clientContactNo" value="<?php echo $clientDetails && $clientDetails[0]['client_id']>0? $clientDetails[0]['client_contact_no']:""; ?>"  required>
                        </div>
                        <div class="form-group">
                          <label>Type</label>
                          <select class="select2 form-control" name="clientType" id="clientType" required>
                            <option value="">Select Type</option>
                            <option value="Debtor" <?php echo $clientDetails && $clientDetails[0]['client_type']=='Debtor'?'selected':''; ?> >Debtor</option>
                            <option value="Creditor" <?php echo $clientDetails && $clientDetails[0]['client_type']=='Creditor'?'selected':''; ?> >Creditor</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label>Client Section</label>
                          <select class="select2 form-control" name="clientSection" id="clientSection" required>
                            <option value="">Select Section</option>
                            <option value="Party" <?php echo $clientDetails && $clientDetails[0]['client_section']=='Party'?'selected':''; ?> >Party</option>
                            <option value="Advance from / to" <?php echo $clientDetails && $clientDetails[0]['client_section']=='Advance from / to'?'selected':''; ?> >Advance from / to</option>
                            <option value="Commission" <?php echo $clientDetails && $clientDetails[0]['client_section']=='Commission'?'selected':''; ?> >Commission</option>
                            
                          </select>
                        </div>
                        <div class="form-group">
                          <label>Balance</label>
                          <input type="text" class="form-control" placeholder="Enter ..." name="clientBalance">
                        </div>
                        <div class="form-group">
                          <label>Email </label>
                          <input type="email" class="form-control" placeholder="Enter ..." name="clientEmail" value="<?php echo $clientDetails && $clientDetails[0]['client_id']>0? $clientDetails[0]['client_email']:""; ?>">
                        </div>
                        <div class="form-group">
                          <label>Web Address </label>
                          <input type="text" class="form-control" placeholder="Enter ..." name="clientWeb" value="<?php echo $clientDetails && $clientDetails[0]['client_id']>0? $clientDetails[0]['client_web']:""; ?>">
                        </div>



                    <div class="form-group">
                        <div class="col-xs-6">
                         <input id="btn_save" name="btn_save" type="submit" class="btn btn-primary btn-block" value="Save Client" />
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
                  <h3 class="box-title">Client List</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Client ID</th>
                        <th>Client Name</th>
                        <th>Contact Number</th>
                        <th>Email</th>
                        <th>Type</th>
                        <th>Section</th>
                        <th></th>

                      </tr>
                    </thead>
                    <tbody>
                    <?php
                        if(is_array($clientList) && !empty($clientList)){
                            foreach ($clientList as $client){
                    ?>
                            <tr>
                                <td><?php echo $client["client_id"];?></td>
                                <td><?php echo $client["client_name"];?></td>
                                <td><?php echo $client["client_contact_no"];?></td>
                                <td><?php echo $client["client_email"];?></td>
                                <td><?php echo $client["client_type"];?></td>
                                <td><?php echo $client["client_section"];?></td>
								<td>
									<?php
										if($this->session->userdata('userType')=="admin"){
									?>
                                    <a href="<?php echo base_url(); ?>client/editclient/<?php echo $client["client_id"];?>" class="btn btn-block btn-primary">Edit</a>
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
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->

<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>dist/js/demo.js"></script>
<!-- page script -->
    <script>
      $(function () {
        $("#example1").DataTable();

      });
    </script>
</body>
</html>
