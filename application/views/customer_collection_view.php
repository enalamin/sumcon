<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Sumcon Biotechnology | Collection Entry</title>
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
				Sales
        <small>collection entry</small>

			</h1>
			<ol class="breadcrumb">
				<li><a href="<?php echo base_url()?>"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Sales</li>
        <li class="active">collection entry</li>
			</ol>
		</section>
    <section class="content">
      <div class="row">
                      <!-- left column -->
      <div class="col-md-12">
      	<div class="box box-default">
      		<div class="box-header with-border">
            <h3 class="box-title">New Collection Entry</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <form role="form" id="formCollection" action="<?php echo base_url()?>sales/create_collection" method="post">
							<div class="row">
                  <div class="form-group col-md-6">
                    <label>Collection Number</label>
                    <input type="text" class="form-control" placeholder="Enter ..." name="collectionNumber" value="<?php echo $collectionNo; ?>" required>
                  </div>
									<div class="form-group col-md-6">
										<label>Collection Date</label>
	                  <input type="text" class="form-control" placeholder="Enter ..." id="datemask" value="<?php echo date('m/d/Y');?>" name="datemask" required>
							    </div>
							</div>
							<div class="row">
                  <div class="form-group col-md-12">
                   <label>Client Name</label>
                          <select class="form-control select2" name="client" id="client" required>
                              <option value="">Select Client</option>
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
							<div class="row">
                  <div class="form-group col-md-6">
							      <label>On Account of </label>
                    <input type="text" class="form-control" placeholder="Enter ..." name="accountof">
			  					</div>
                  <div class="form-group col-md-6">
                    <label>Collection Type </label>
                    <select class="form-control select2" name="collectionType" id="collectionType" required>
                      <option value="cash">Cash</option>
                      <option value="cheque">Cheque</option>
                    </select>
                  </div>
							</div>
							<div class="row">
								<div class="form-group col-md-6">
									<label>Collection Amount</label>
									<input type="text" class="form-control" placeholder="Enter ..." name="collectionAmount" id="collectionAmount" required>
								</div>
								<div class="form-group col-md-6">
									<label>Remarks </label>
									<input type="text" class="form-control" placeholder="Enter ..." name="remarks">
								</div>
							</div>
							<div id="bankInfo" style="display:none">
								<div class="row">
									<div class="form-group col-md-3">
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
									<div class="form-group col-md-3">
									  <label>Cheque No</label>
									  <input type="text" class="form-control" placeholder="Enter ..." name="chequeNo" id="chequeNo" >
									</div>
									<div class="form-group  col-md-3">
									  <label>Cheque Date</label>
									  <input type="text" class="form-control" placeholder="Enter ..." name="chequeDate" id="chequeDate" >
									</div>
									<div class="form-group  col-md-2">
									  <label>Cheque Amount</label>
									  <input type="text" class="form-control" placeholder="Enter ..." name="chequeAmount" id="chequeAmount" >
									</div>
									<div class="form-group  col-md-1">
										<label>&nbsp; </label>
										<input id="btn_add" name="btn_add" type="button" class="btn btn-primary btn-block" value="Add" />
									</div>
								</div>
								<div class="row form-group">
										<div class="col-xs-12">
												<br>
										</div>
								</div>

								<div class="row form-group">
										<div class="col-xs-12">
												<table id="griddetails" class="table table-bordered table-hover">
												<thead>
													<tr>
														<th>Bank Name</th>
														<th>Cheque No</th>
														<th>Cheque Date</th>
														<th>Cheque Amount</th>
														<th>&nbsp;</th>
													</tr>
												</thead>
												<tbody>
												</tbody>
												</table>
										</div>
								</div>
								<div class="form-group" >
										<div class="col-xs-10 text-right">
											<label>Total Cheque Amount</label>
										</div>
										<div class="col-xs-2">
											<input type="text"  id="totalChequeAmount" name="totalChequeAmount" readonly>
										</div>

								</div>
							</div>

              <div class="form-group">
                  <div class="col-xs-6">
										<input type="hidden" id="totalItemRow" name="totalItemRow">
                   <input id="btn_save" name="btn_save" type="submit" class="btn btn-primary btn-block" value="Save Collection" />
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
			  var i=0;
				var totalChequeAmount = 0;
      $(function () {
            $("#example1").DataTable();
            $(".select2").select2();
            $("#datemask").datepicker();
            $("#chequeDate").datepicker();
						$("#collectionType").change(function(){
							if($("#collectionType").val()=="cheque")
								$("#bankInfo").show();
							else{
								$("#bankInfo").hide();
							}
						});

						$("#btn_add").click(function(){
								var bankId=$("#bank").val();
								var bankName=$("#bank option:selected").text();
								var chequeNumber=$("#chequeNo").val();
								var chequeDate=$("#chequeDate").val();
								var chequeAmount=$("#chequeAmount").val();
								if(bankId!='' && chequeNumber!='' && chequeDate!='' && chequeAmount>0){

										$("#griddetails").append("<tr><td>"+bankName+"</td><td>"+chequeNumber+"</td><td>"+chequeDate+"</td><td class='chequeAmount'>"+chequeAmount+"</td>"
										+"<td><input type='hidden' name='bankIds[]' value='"+bankId+"'><input type='hidden' name='chequeNumbers[]' value='"+chequeNumber+"'><input type='hidden' name='chequeDates[]' value='"+chequeDate+"'><input type='hidden' name='chequeAmounts[]' value='"+chequeAmount+"'><button type='button' class='removebutton' title='Remove this row'>X</button></td></tr>");
										restrow();
										i++;
										totalChequeAmount += parseFloat(chequeAmount);
										$("#totalItemRow").val(i);
										$("#totalChequeAmount").val(totalChequeAmount);
								}
								else{
										alert("check your entry");
								}
								if(i>0){
										$("#showControl").show();
								}
								else{
										$("#showControl").hide();
								}
						});

						$("#formCollection").submit(function(event){
							var collectionAmount= parseFloat($("#collectionAmount").val());
							if($("#collectionType").val()=="cheque" && totalChequeAmount>0 && collectionAmount!=totalChequeAmount){
								event.preventDefault();
								alert("!!! Collection Amount and Cheque Amounts are not equal !!!");
							}
						});

      });
			$(document).on('click', 'button.removebutton', function () {
				if(confirm("Do you want to remove this?")){
					var currentChequeAmount = $(this).closest('tr').find('.chequeAmount').text();
					$(this).closest('tr').remove();
					i--;
					totalChequeAmount -= parseFloat(currentChequeAmount);
					$("#totalChequeAmount").val(totalChequeAmount);
					if(i>0){
						$("#showControl").show();
					}
					else{
						$("#showControl").hide();
					}
				}
				return false;
			});
			function restrow(){
		        $("#bank").val("");
	        	$("#chequeNo").val("");
	          $("#chequeDate").val("");
	        	$("#chequeAmount").val("");
					}
    </script>
</body>
</html>
