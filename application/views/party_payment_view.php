<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Sumcon Biotechnology | Payment Entry</title>
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
        <small>Payment entry</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?php echo base_url()?>"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Purchase</li>
        <li class="active">Payment entry</li>
			</ol>
		</section>
                <section class="content">
                    <div class="row">
                      <!-- left column -->
                      <div class="col-md-4">
                        <div class="box box-default">
                    <div class="box-header with-border">
                      <h3 class="box-title">New Party Payment Entry</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                      <form role="form" action="<?php echo base_url()?>purchase/createPayment" method="post">
                          <!-- select -->
                         <!-- text input -->
                        <div class="form-group">
                         <label>Party Name</label>
                                <select class="form-control select2" name="party" id="party" required>
                                        <option value="">Select Party</option>
                                      <?php
                                          if(is_array($partyList)){
                                              foreach ($partyList as $party){
                                      ?>
                                              <option value="<?php echo $party["client_id"];?>"><?php echo $party["client_name"];?></option>
                                      <?php
                                              }
                                          }
                                      ?>
                                    </select>
                        </div>
                        <label>Payment Date</label>
                        <input type="text" class="form-control" placeholder="Enter ..." id="datemask" value="<?php echo date('m/d/Y');?>" name="datemask" required>


                        <div class="form-group">
                          <label>Pay Type </label>
                          <select class="form-control select2" name="payType" id="payType" required>
                            <option value="cash">Cash</option>
                            <option value="cheque">Cheque</option>
                          </select>
                        </div>

												<div id="bankInfo" style="display:none">
													<div class="row">
														<div class="form-group col-md-6">
														  <label>Bank Name</label><br />
														  <select class="select select2" name="bank" id="bank" >
						                      <option value="">Select Bank</option>
						                        <?php
						                            if(is_array($bankList)){
						                                foreach ($bankList as $bank){
						                        ?>
						                                <option value="<?php echo $bank["bank_id"];?>"><?php echo $bank["bank_name"];?></option>
						                        <?php
						                                }
						                            }
						                        ?>
						                  </select>
														</div>
														<div class="form-group  col-md-6">
														  <label>Account Number</label><br />
															<select class="form-control select2" name="accountNo" id="accountNo" >
				                          <option value="">Select Bank Account</option>
				                      </select>
														</div>
														<div class="form-group col-md-6">
														  <label>Cheque No</label>
														  <input type="text" class="form-control" placeholder="Enter ..." name="chequeNo" id="chequeNo" >
														</div>
														<div class="form-group  col-md-6">
														  <label>Cheque Date</label>
														  <input type="text" class="form-control" placeholder="Enter ..." name="chequeDate" id="chequeDate" >
														</div>


													</div>
												</div>
												<div class="form-group">
                          <label>Pay Amount</label>
                          <input type="text" class="form-control" placeholder="Enter ..." name="payAmount" required>
                        </div>
                        <div class="form-group">
                          <label>Remarks</label>
                          <input type="text" class="form-control" placeholder="Enter ..." name="remarks">
                        </div>


                    <div class="form-group">
                        <div class="col-xs-6">
                         <input id="btn_save" name="btn_save" type="submit" class="btn btn-primary btn-block" value="Save Payment" />
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
                  <h3 class="box-title">Party Payment List</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Party Name [ID]</th>
                        <th>Payment Date</th>
                        <th>Pay Amount</th>
                        <th>Pay Type</th>
                        <th>Remarks</th>

                      </tr>
                    </thead>
                    <tbody>
                    <?php
                        if(is_array($payments) && !empty($payments)){
                            foreach ($payments as $payment){
                    ?>
                            <tr>

                                <td><?php echo $payment["client_name"]."[".$payment["client_id"]."]";?></td>
                                <td><?php echo $payment["payment_date"];?></td>
                                <td><?php echo $payment["pay_amount"];?></td>
                                <td><?php echo $payment["pay_type"];?></td>
                                <td><?php echo $payment["remarks"];?></td>
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
<!-- page script -->
    <script>
      $(function () {
            $("#example1").DataTable();
            $(".select2").select2();
            $("#datemask").datepicker();
						$("#chequeDate").datepicker();
						$("#payType").change(function(){
							if($("#payType").val()=="cheque")
								$("#bankInfo").show();
							else{
								$("#bankInfo").hide();
							}
						});
						$("#bank").change(function(){
							var options="<option value=''>Select Bank Account</option>";
							$.ajax({
									url: '<?php echo base_url()?>bank/getaccounts/'+$(this).val(),
									dataType: 'json',
									complete: function(data){
											var responses = JSON.parse(data.responseText);
											for(var account in responses){
												options += "<option value='"+responses[account].account_no+"'>"+responses[account].account_no+"</option>";
											}
											$("#accountNo").html(options);
									}
							});
						});
      });
    </script>
</body>
</html>
