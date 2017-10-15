<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Sumcon Biotechnology | Transfer Voucher</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.5 -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<!-- Ionicons -->
	<!-- link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" -->
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
				Accounts
        <small>Transfer entry</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?php echo base_url()?>"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active"><a href="<?php echo base_url()?>accounts">Accounts</a></li>
        <li class="active">Transfer Voucher entry</li>
			</ol>
		</section>
    <section class="content">
	    <div class="row">
				<div class="col-md-12">
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">Transfer Voucher Entry</h3>
						</div>
						<div class="box-body">
							<form role="form" id="frmVoucher"  action="<?php echo base_url()?>accounts/voucher_save/transfer" method="post">
								<div class="row  form-group">
									<div class="col-xs-4">
										<label>Voucher Number</label>
	                  <input type="text" class="form-control" placeholder="Enter ..." name="voucherNumber" value="<?php echo $voucherNumber;?>">
	                </div>

	                <div class="col-xs-4">
		                <label>Vouher Date</label>
	                  <input type="text" class="form-control" placeholder="Enter ..." id="datemask" value="<?php echo date('m/d/Y');?>" name="datemask">
	                </div>
									<div class="col-xs-4" >
										<label>Amount</label>
										<input type="text" class="form-control" id="amount" name="amount" value="" required>

									</div>
								</div>
								<div class="row">
								<div class="col-xs-12" style="background:#aadd55;">
									<div class="row form-group">
										<div class="col-xs-12">
											<h3>Transfer From</h3>
										</div>
									</div>
									<div class="row form-group">
										<div class="col-xs-12">
	                  	<label>From Type</label>
	                    <select class="form-control select2" name="transferFrom" id="transferFrom" required>
	                    	<option value="">Select Type</option>
	                    	<option value="Cash">Cash</option>
												<option value="Cheque">Bank</option>
	                    </select>
	                  </div>
									</div>
									<div id="fromBankInfo" class="row form-group" style="display:none;">
											<div class="col-xs-3">
											  <label>Bank Name</label><br />
											  <select class="form-control select2" name="fromBank" id="fromBank"  style="width: 100%">
	                          <option value="">Select Bank</option>
	                            <?php
	                                if(is_array($bankList)){
	                                    foreach ($bankList as $bank){
	                            ?>
	                                    <option value="<?php echo $bank["bank_id"];?>" ><?php echo $bank["bank_name"];?></option>
	                            <?php
	                                    }
	                                }
	                            ?>
	                        </select>
											</div>
											<div class="col-xs-3">
											  <label>Account No</label><br />
												<select class="form-control select2" name="fromAccountNo" id="fromAccountNo"  style="width: 100%">
	                          <option value="">Select Bank Account</option>
	                      </select>
											</div>
											<div class="col-xs-3">
											  <label>Cheque No</label>
											  <input type="text" class="form-control" placeholder="Enter ..." name="fromChequeNo" >
											</div>

											<div class="col-xs-3">
											  <label>Cheque Date</label>
											  <input type="text" class="form-control" placeholder="Enter ..." name="fromChequeDate" id="fromChequeDate" >
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12" style="background:#77dd11;">
										<div class="row form-group">
											<div class="col-xs-12">
												<h3>Transfer To</h3>
											</div>
										</div>
										<div class="row form-group">
											<div class="col-xs-12">
		                  	<label>To Type</label>
		                    <select class="form-control select2" name="transferTo" id="transferTo" required>
		                    	<option value="">Select Type</option>
		                    	<option value="Cash">Cash</option>
													<option value="Cheque">Bank</option>
		                    </select>
		                  </div>
										</div>
										<div id="toBankInfo" class="row form-group" style="display:none;">
											<div class="col-xs-3">
											  <label>Bank Name</label><br />
											  <select class="form-control select2" name="toBank" id="toBank"  style="width: 100%" >
	                          <option value="">Select Bank</option>
	                            <?php
	                                if(is_array($bankList)){
	                                    foreach ($bankList as $bank){
	                            ?>
	                                    <option value="<?php echo $bank["bank_id"];?>" ><?php echo $bank["bank_name"];?></option>
	                            <?php
	                                    }
	                                }
	                            ?>
	                        </select>
											</div>

											<div class="col-xs-3">
											  <label>Account No</label><br />
												<select class="form-control select2" name="toAccountNo" id="toAccountNo"  style="width: 100%">
	                          <option value="">Select Bank Account</option>
	                      </select>
											</div>

										</div>

									</div>
								</div>
                <div class="row form-group">
                    <div class="col-xs-12">
											<label>Voucher Description</label>
                      <textarea name="voucherDescription" id="voucherDescription" class="form-control" ></textarea>
                    </div>
                </div>

							<div class="row form-group">

                    <div class="col-xs-6">
                        <input type="hidden" id="totalItemRow" name="totalItemRow" placeholder="Enter ...">
                        <input id="btn_save" name="btn_save" type="submit" class="btn btn-primary btn-block" value="Save Voucher" />
                    </div>
                     <div class="col-xs-6">
                         <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-block btn-danger" value="Cancel" />
                    </div>
                </div>

                  </form>
                </div><!-- /.box-body -->
              </div>
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
<script src="<?php echo base_url(); ?>plugins/select2/select2.full.min.js"></script>
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
       var i=0;
       var voucherDrTotal = voucherCrTotal = 0;
      $(function () {
        $("#example1").DataTable();
        $(".select2").select2();
         //Datemask dd/mm/yyyy
        //$("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
       	$("#datemask").datepicker();
				$("#fromChequeDate").datepicker();
				$("#transferFrom").change(function(){
					if($("#transferFrom").val()=="Cheque")
						$("#fromBankInfo").show();
					else{
						$("#fromBankInfo").hide();
					}
				});

				$("#transferTo").change(function(){
					if($("#transferTo").val()=="Cheque")
						$("#toBankInfo").show();
					else{
						$("#toBankInfo").hide();
					}
				});



				$("#fromBank").change(function(){
					var options="<option value=''>Select Bank Account</option>";
					$.ajax({
							url: '<?php echo base_url()?>bank/getaccounts/'+$(this).val(),
							dataType: 'json',
							complete: function(data){
									var responses = JSON.parse(data.responseText);
									for(var account in responses){
										options += "<option value='"+responses[account].account_no+"'>"+responses[account].account_no+"</option>";
									}
									$("#fromAccountNo").html(options);
							}
					});
				});

				$("#toBank").change(function(){
					var options="<option value=''>Select Bank Account</option>";
					$.ajax({
							url: '<?php echo base_url()?>bank/getaccounts/'+$(this).val(),
							dataType: 'json',
							complete: function(data){
									var responses = JSON.parse(data.responseText);
									for(var account in responses){
										options += "<option value='"+responses[account].account_no+"'>"+responses[account].account_no+"</option>";
									}
									$("#toAccountNo").html(options);
							}
					});
				});


      });
	$(document).on('click', 'button.removebutton', function () {
		if(confirm("Do you want to remove this?")){
			var currentRowDr = $(this).closest('tr').find('.itemDrTotal').text();
			var currentRowCr = $(this).closest('tr').find('.itemCrTotal').text();
			$(this).closest('tr').remove();
			voucherDrTotal -= parseFloat(currentRowDr);
			voucherCrTotal -= parseFloat(currentRowCr);
			i--;
			if(i>0){
				$("#showControl").show();
				$("#voucherDrTotal").val(voucherDrTotal.toFixed(2));
				$("#voucherCrTotal").val(voucherCrTotal.toFixed(2));
			}
			else{
				$("#showControl").hide();
			}
		}
		return false;
	});

    function resetrow()
    {
        $("#accountsHead").val("");
        $("#particulars").val("");
        $("#amountDr").val("");
				$("#amountCr").val("");
				$("#amountCr").prop("disabled",false);
				$("#amountDr").prop("disabled",false);
    }
    </script>
</body>
</html>
