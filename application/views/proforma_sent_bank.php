<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sumcon Biotechnology | Cheque Deposit</title>
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
	<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/select2/select2.min.css">


<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

	<?php include_once "header.php"; ?>
	<!-- Left side column. contains the logo and sidebar -->
	<?php include_once "sidebar.php"; ?>

	<!-- Content Wrapper. Contains page content -->

	<div class="content-wrapper">
        <?php
            if(is_array($proformaDetails) && !empty($proformaDetails))
            {
        ?>
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>Proform Invoice(<small>#<?php echo $proformaDetails[0]['pi_no']?></small>)</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li><a href="#">Lc Management</a></li>
				<li class="active">Lc Sent to bank</li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="invoice">
			<!-- title row -->
			<form method="post" action="<?php echo base_url()?>lcmanagement/lcsenttobank/<?php echo $proformaDetails[0]['lc_id'];?>">

				<div class="row ">
					<div class="col-xs-12 table-responsive text-center">
						<h3 style="text-decoration: underline;">Proform Invoice Info</h3>
					</div><!-- /.col -->
				</div><!-- /.row -->
				<div class="row ">
					<div class="col-xs-6 table-responsive">
						<b>Proforma Invoice Number:</b> <?php echo $proformaDetails[0]['pi_no'];?><br>
					</div><!-- /.col -->
					<div class="col-xs-6 table-responsive">
						<b> Date:</b> <?php echo $proformaDetails[0]['pi_date']?><br>
					</div><!-- /.col -->
				</div><!-- /.row -->
				<div class="row">
					<div class="col-xs-6 table-responsive">
						<b>Supplier Name:</b> <?php echo $proformaDetails[0]['client_name'];?><br>
					</div><!-- /.col -->
					<div class="col-xs-6 table-responsive">
						<b>Bank Info:</b> <?php echo $proformaDetails[0]['bank_info'];?><br>
					</div><!-- /.col -->
				</div><!-- /.row -->
				<div class="row">
					<div class="col-xs-6 table-responsive">
						<b>Invoice Amount:</b> <?php echo $proformaDetails[0]['invoice_amount'];?><br>
					</div><!-- /.col -->
					<div class="col-xs-6 table-responsive">

					</div><!-- /.col -->
				</div><!-- /.row  -->
				<div class="row ">
					<div class="col-xs-12 table-responsive text-center">
						<h3 style="text-decoration: underline;">Sent TO Bank</h3>
					</div><!-- /.col -->
				</div><!-- /.row -->
				<div class="row">
					<div class="col-xs-4 form-group">
						<label>Bank Name</label>
						<select class="form-control select2" name="bank" id="bank" required="">
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
					</div><!-- /.col -->
					<div class="col-xs-4 form-group">
						<label>Account Number</label>
            <select class="form-control select2" name="accountNo" id="accountNo" required>
                <option value="">Select Bank Account</option>
            </select>
					</div><!-- /.col -->
					<div class="col-xs-4 form-group" >
						 <label>Sent Date</label>
            <input type="text" class="form-control" placeholder="Enter ..." id="datemask" value="<?php echo date('m/d/Y');?>" name="datemask" required>

					</div><!-- /.col -->
				</div><!-- /.row -->
				<div class="form-group" id="showControl" >
					<div class="col-xs-6">
						<input type="hidden" id="totalItemRow" name="totalItemRow" placeholder="Enter ...">
						<input id="btn_save" name="btn_save" type="submit" class="btn btn-primary btn-block" value="Save" />
					</div>
					 <div class="col-xs-6">
						 <input id="btn_cancel" name="btn_cancel" type="button" onclick="gochequekList()" class="btn btn-block btn-danger" value="Cancel" />
					</div>
				</div>
			</form>
        </section><!-- /.content -->
        <?php
            }
        ?>
        <div class="clearfix"></div>
	</div><!-- /.content-wrapper -->

<?php include_once 'footer.php';?>


</div><!-- ./wrapper -->
 <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url(); ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url(); ?>plugins/fastclick/fastclick.min.js"></script>
	<script src="<?php echo base_url(); ?>plugins/select2/select2.full.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url(); ?>dist/js/demo.js"></script>
    <script>
      $(function () {
		$(".select2").select2();
         $("#productName").keyup(function(){
            $("#productDescription").val($("#productName").val());
        });
        $("#ckNewProduct").click(function(){
            //if($("#ckNewProduct").is(':checked')){
                $("#oldproductlist").toggle();
                $("#newproductinfo").toggle();
            //}
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

      function gochequekList()
      {
          window.location = '<?php echo base_url()?>chequemanagement';
      }

    </script>
</body>
</html>
