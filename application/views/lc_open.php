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
    				<li class="active">Lc Open</li>
    			</ol>
        </section>
        <!-- Main content -->
        <section class="invoice">
		      <form method="post" action="<?php echo base_url()?>lcmanagement/openlc/<?php echo $proformaDetails[0]['lc_id'];?>">
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
              <b>Supplier Bank Info:</b> <?php echo $proformaDetails[0]['bank_info'];?><br>
	          </div><!-- /.col -->
         </div><!-- /.row -->
		     <div class="row">
					<div class="col-xs-4 table-responsive">
						<b>Invoice Amount:</b> <?php echo $proformaDetails[0]['invoice_amount'];?><br>
					</div><!-- /.col -->
					<div class="col-xs-4 table-responsive">
            <b>Bank Name:</b> <?php echo $proformaDetails[0]['bank_name'];?><br>
					</div><!-- /.col -->
          <div class="col-xs-4 table-responsive">
            <b>Account:</b> <?php echo $proformaDetails[0]['account_no'];?><br>
					</div><!-- /.col -->
				</div><!-- /.row  -->
				<div class="row ">
					<div class="col-xs-12 table-responsive text-center">
						<h3 style="text-decoration: underline;">Open LC</h3>
					</div><!-- /.col -->
				</div><!-- /.row -->
				<div class="row">
					<div class="col-xs-6 form-group">
						<label>LC No</label>
            <input type="text" class="form-control" placeholder="Enter ..."  name="lcNo" required>
					</div>
					<div class="col-xs-6 form-group" >
						 <label>Open Date</label>
            <input type="text" class="form-control" placeholder="Enter ..." id="datemask" value="<?php echo date('m/d/Y');?>" name="datemask" required>
					</div>

				</div>

        <div class="row form-group">
            <div class="col-xs-12">
                <label>Costing Details</label>
            </div>
        </div>
        <div class="row form-group">
          <div class="col-xs-6">
            <table class="table table-bordered table-striped" >
              <tr>
                <th>Cost Head</th>
                <th>BDT Amount</th>
              </tr>
              <tr>
                <td>Bank Charge</td>
                <td><input type="text" class="form-control" placeholder="Enter ..." name="bankChargeAmount" id="bankChargeAmount" ></td>
              </tr>
              <tr>
                <td>LC Margin</td>
                <td><input type="text" class="form-control" placeholder="Enter ..." name="lcMarginAmount" id="lcMarginAmount" ></td>
              </tr>
              <tr>
                <td>Insurance Premium</td>
                <td><input type="text" class="form-control" placeholder="Enter ..." name="premiumAmount" id="premiumAmount" ></td>
              </tr>
            </table>
          </div>
        </div>
        <div class="row form-group" id="showControl" >
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

      });

      var calculateAmount = function(costType){
        var dollarAmount = $("#"+costType+"Dollar").val();
        var dollarRate = $("#"+costType+"DollarRate").val();
        var bdtAmount = parseFloat(dollarAmount)*parseFloat(dollarRate);
        if(!isNaN(bdtAmount))
          $("#"+costType+"Amount").val(bdtAmount);
      };

      function gochequekList()
      {
          window.location = '<?php echo base_url()?>chequemanagement';
      }

    </script>
</body>
</html>
