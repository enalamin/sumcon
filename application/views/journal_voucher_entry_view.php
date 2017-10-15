<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Sumcon Biotechnology | Order</title>
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

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
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
        <li class="active">Journal Voucher entry</li>
			</ol>
		</section>
    <section class="content">
	    <div class="row">
				<div class="col-md-12">
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">Journal Voucher Entry</h3>
						</div>
						<div class="box-body">
							<form role="form" id="frmVoucher"  action="<?php echo base_url()?>accounts/voucher_save/journal" method="post">
								<div class="row">
									<div class="col-xs-4">
										<label>Voucher Number</label>
	                  <input type="text" class="form-control" placeholder="Enter ..." name="voucherNumber" value="<?php echo $voucherNumber;?>">
	                </div>
	               	<div class="col-xs-4 text-center">
										<label> Journal Voucher</label>
	                </div>
	                <div class="col-xs-4">
		                <label>Vouher Date</label>
	                  <input type="text" class="form-control" placeholder="Enter ..." id="datemask" value="<?php echo date('m/d/Y');?>" name="datemask">
	                </div>
								</div>
								<div class="row form-group">
									<div class="col-xs-12">
                  	<label>Party</label>
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
									</div>
									<div id="bankInfo" class="row form-group" >
											<div class="col-xs-3">
											  <label>Bank Name</label>
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
											  <label>Account No</label><br />
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
                     <div class="col-xs-2">
                        <label>Accounts Head</label>
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
										<div class="col-xs-2">
											 <label>Car</label>
											 <select class="form-control select2" name="car" id="car" >
													 <option value="">Select Car</option>
													 <?php
														 if(is_array($carList) && !empty($carList)){
															 foreach ($carList as $car){
													 ?>
																 <option value="<?php echo $car["car_id"];?>"><?php echo $car["car_name"].'['.$car["car_number"].']';?></option>
													 <?php
															 }
														 }
													 ?>
											 </select>
									 </div>
									 <div class="col-xs-2">
											<label>Employee</label>
											<select class="form-control select2" name="employee" id="employee" >
													<option value="">Select Employee</option>
													<?php
														if(is_array($employeeList) && !empty($employeeList)){
															foreach ($employeeList as $employee){
													?>
																<option value="<?php echo $employee["employee_id"];?>"><?php echo $employee["employee_name"];?></option>
													<?php
															}
														}
													?>
											</select>
									</div>
                   	<div class="col-xs-3">
                      <label>Particulars </label>
                      <input type="text" class="form-control" id="particulars" name="particulars" placeholder="Enter ...">
                    </div>
                    <div class="col-xs-1">
											<label>Amount Dr. </label>
                      <input type="text" class="form-control" id="amountDr" name="amountDr" placeholder="Enter ...">
                    </div>
										<div class="col-xs-1">
											<label>Amount Cr. </label>
                      <input type="text" class="form-control" id="amountCr" name="amountCr" placeholder="Enter ...">
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
															<th>Accounts Head</th>
															<th>Car</th>
															<th>Employee</th>
	                            <th>Particulars</th>
	                            <th>Amount Dr.</th>
															<th>Amount Cr.</th>
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
											<input type="text" id="voucherDrTotal" name="voucherDrTotal" value="">
											&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="text" id="voucherCrTotal" name="voucherCrTotal" value="">
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
       var voucherDrTotal = voucherCrTotal = 0;
      $(function () {
        $("#example1").DataTable();
        $(".select2").select2();
         //Datemask dd/mm/yyyy
        //$("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
       	$("#datemask").datepicker();
				$("#checqueDate").datepicker();
        $("#btn_add").click(function(){
            var accountsHeadId=$("#accountsHead").val();
            var accountsHeadName=$("#accountsHead option:selected").text();
						var carId=$("#car").val();
            var carName=$("#car option:selected").text();
						var employeeId=$("#employee").val();
            var employeeName=$("#employee option:selected").text();

            var particulars=$("#particulars").val();
            var voucherDrAmount=$("#amountDr").val()==''? '0':$("#amountDr").val();
						var voucherCrAmount=$("#amountCr").val()==''? '0':$("#amountCr").val();
            var currentContent = $("#griddetails").html();
            if(accountsHeadId!='' ){
                voucherDrTotal += parseFloat(voucherDrAmount);
								voucherCrTotal += parseFloat(voucherCrAmount);
                $("#griddetails").append("<tr><td>"+accountsHeadName+"</td><td>"+carName+"</td><td>"+employeeName+"</td><td>"+particulars+"</td><td class='itemDrTotal'>"+voucherDrAmount+"</td><td class='itemCrTotal'>"+voucherCrAmount+"</td>"
                +"<td><input type='hidden' name='accountHeadId[]' value='"+accountsHeadId+"'><input type='hidden' name='carId[]' value='"+carId+"'><input type='hidden' name='employeeId[]' value='"+employeeId+"'><input type='hidden' name='transectionDescription[]' value='"+particulars+"'><input type='hidden' name='transectionDrAmount[]' value='"+voucherDrAmount+"'><input type='hidden' name='transectionCrAmount[]' value='"+voucherCrAmount+"'><button type='button' class='removebutton' title='Remove this row'>X</button></td></tr>");
                resetrow();
                i++;
                $("#totalItemRow").val(i);
            }
            else{
                alert("check your entry");
            }
            if(i>0){
                $("#showControl").show();
								$("#voucherDrTotal").val(voucherDrTotal.toFixed(2));
								$("#voucherCrTotal").val(voucherCrTotal.toFixed(2));
            }
            else{
                $("#showControl").hide();
            }
        });

				$("#amountDr").blur(function(){
					var drAmount = $(this).val();
					if(drAmount && parseFloat(drAmount)>0){
						$("#amountCr").val('');
						$("#amountCr").prop("disabled",true);
					}	else {
						$("#amountCr").prop("disabled",false);
					}
				});

				$("#amountCr").blur(function(){
					var crAmount = $(this).val();
					if(crAmount && parseFloat(crAmount)>0){
						$("#amountDr").val('');
						$("#amountDr").prop("disabled",true);
					} else {
						$("#amountDr").prop("disabled",false);
					}
				});
				$("#frmVoucher").submit(function(event){
					if(voucherDrTotal>0 && voucherDrTotal!=voucherCrTotal){
						event.preventDefault();
						alert("!!! Debit and Credit Amonts are not equal !!!");
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
				/*$("#party").change(function(){
					var options="<option value=''>Select Employee</option>";
					$.ajax({
							url: '<?php echo base_url()?>employee/getemployees/'+$(this).val(),
							dataType: 'json',
							complete: function(data){
									var responses = JSON.parse(data.responseText);
									for(var employee in responses){
										options += "<option value='"+responses[employee].employee_id+"'>"+responses[employee].employee_name+"</option>";
									}
									$("#employee").html(options);
							}
					});
				});*/

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
