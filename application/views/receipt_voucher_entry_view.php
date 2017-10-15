<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Sumcon Biotechnology | Receipt Voucher</title>
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
				Accounts
        <small>Voucher entry</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?php echo base_url()?>"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active"><a href="<?php echo base_url()?>accounts">Accounts</a></li>
        <li class="active">Receipt Voucher entry</li>
			</ol>
		</section>
    <section class="content">
	    <div class="row">
				<div class="col-md-12">
					<div class="box box-default" style="background-color:#88d0e2;">
						<div class="box-header with-border">
							<h3 class="box-title">Receipt Voucher Entry</h3>
						</div>
						<div class="box-body">
							<form role="form"  action="<?php echo base_url()?>accounts/voucher_save/receipt" method="post">
								<div class="row">
									<div class="col-xs-4">
										<label>Voucher Number</label>
	                  <input type="text" class="form-control" placeholder="Enter ..." name="voucherNumber" value="<?php echo $voucherNumber; ?>">
	                </div>
	               	<div class="col-xs-4 text-center">
										<label> Receipt Voucher</label>
	                </div>
	                <div class="col-xs-4">
		                <label>Vouher Date</label>
	                  <input type="text" class="form-control" placeholder="Enter ..." id="datemask" value="<?php echo date('m/d/Y');?>" name="datemask">
	                </div>
								</div>
								<div class="row form-group">
									<div class="col-xs-8">
                  	<label>Recive From</label>
                    <select class="form-control select2" name="party" id="party" required>
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
										<div class="col-xs-4">
	                  	<label>Recive Type</label>
	                    <select class="form-control select2" name="transectionType" id="transectionType" required>
	                    	<option value="">Select Receive Type</option>
	                      <option value="Cash">Cash</option>
												<option value="Cheque">Cheque</option>
                      </select>

                    </div>
                  </div>
									<div id="bankInfo" class="row form-group" style="display:none">
										<div class="col-xs-3">
										  <label>Bank Name</label><br />
										  <select class="form-control select2" name="bank" id="bank" >
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
										  <label>Cheque No</label>
										  <input type="text" class="form-control" placeholder="Enter ..." name="checqueNo" >
										</div>
										<div class="col-xs-3">
										  <label>Account No</label><br/>
											<select class="form-control select2" name="accountNo" id="accountNo" >
                          <option value="">Select Bank Account</option>
                      </select>
										</div>
										<div class="col-xs-3">
										  <label>Cheque Date</label>
										  <input type="text" class="form-control" placeholder="Enter ..." name="checqueDate" id="checqueDate" >
										</div>
									</div>
                  <div class="row form-group">
                      <div class="col-xs-12">
												<label>Voucher Description</label>
                        <textarea name="voucherDescription" id="voucherDescription" class="form-control" ></textarea>
                      </div>
                  </div>

  								<div class="row form-group">
                      <div class="col-xs-12 text-center">
                          <label>Voucher Details</label>
                      </div>
                  </div>
                  <div class="row form-group">
                     <div class="col-xs-3">
                        <label>Accounts Head/Credit</label>
                        <select class="form-control select2" name="accountsHead" id="accountsHead" >
                            <option value="">Select Accounts Head</option>
														<?php
															if(is_array($chartOfAccountsList) && !empty($chartOfAccountsList)){
																foreach ($chartOfAccountsList as $accountsHead){
														?>
																	<option value="<?php echo $accountsHead["accounts_head_id"];?>"><?php echo $accountsHead["head_name"];?></option>
														<?php
																}
															}
														?>
												</select>
                    </div>
                   	<div class="col-xs-6">
                      <label>Particulars </label>
                      <input type="text" class="form-control" id="particulars" name="particulars" placeholder="Enter ...">
                    </div>
                    <div class="col-xs-2">
											<label>Amount </label>
                      <input type="text" class="form-control" id="amount" name="amount" placeholder="Enter ...">
                    </div>
										<div class="col-xs-1">
                			<label>&nbsp; </label>
                      <input id="btn_add" name="btn_add" type="button" class="btn btn-primary btn-block" value="Add" />
                    </div>
                  </div>
      						<div class="row form-group">
                  	<div class="col-xs-12">
											<br>
                    </div>
                  </div>

                  <div class="form-group" id="showControl" style="display: none;">
										<div class="row">
											<div class="col-xs-12">
												<table id="griddetails" class="table table-bordered table-hover">
													<thead>
														<tr>
															<th>Accounts Head/Credit</th>
	                            <th>Particulars</th>
	                            <th>Amount</th>
	                            <th>&nbsp;</th>
														</tr>
	                        </thead>
	                        <tbody>
	                        </tbody>
	                  		</table>
	                    </div>
	                  </div>
                  	<div class="col-xs-12" style="text-align: right; padding-right: 100px;">
                      <label> Voucher Total</label>
											<input type="text" id="voucherTotal" name="voucherTotal" value="">
                      <br/><br/>    <br/>
                    </div>

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
       var voucherTotal=0;
      $(function () {
        $("#example1").DataTable();
        $(".select2").select2();
         //Datemask dd/mm/yyyy
        //$("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
       	$("#datemask").datepicker();
				$("#checqueDate").datepicker();
				$("#transectionType").change(function(){
					if($("#transectionType").val()=="Cheque")
						$("#bankInfo").show();
					else{
						$("#bankInfo").hide();
					}
				});

        $("#btn_add").click(function(){
            var accountsHeadId=$("#accountsHead").val();
            var accountsHeadName=$("#accountsHead option:selected").text();
            var particulars=$("#particulars").val();
            var voucherAmount=$("#amount").val();
            var currentContent = $("#griddetails").html();
            if(accountsHeadId!='' && voucherAmount!='' && voucherAmount>0){
                voucherTotal += parseFloat(voucherAmount);
                $("#griddetails").append("<tr><td>"+accountsHeadName+"</td><td>"+particulars+"</td><td class='itemTotal'>"+voucherAmount+"</td>"
                +"<td><input type='hidden' name='accountHeadId[]' value='"+accountsHeadId+"'><input type='hidden' name='transectionDescription[]' value='"+particulars+"'><input type='hidden' name='transectionAmount[]' value='"+voucherAmount+"'><button type='button' class='removebutton' title='Remove this row'>X</button></td></tr>");
                resetrow();
                i++;
                $("#totalItemRow").val(i);
            }
            else{
                alert("check your entry");
            }
            if(i>0){
                $("#showControl").show();
                $("#voucherTotal").val(voucherTotal.toFixed(2));
            }
            else{
                $("#showControl").hide();
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
	$(document).on('click', 'button.removebutton', function () {
		if(confirm("Do you want to remove this?")){
			var currentRowTotal = $(this).closest('tr').find('.itemTotal').text();
			$(this).closest('tr').remove();
			voucherTotal -= parseFloat(currentRowTotal);
			i--;
			if(i>0){
				$("#showControl").show();
				$("#voucherTotal").val(voucherTotal.toFixed(2));
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
        $("#amount").val("");
    }
    </script>
</body>
</html>
