<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Sumcon Biotechnology | Sales</title>
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
	<style>
        .loader {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid blue;
            border-bottom: 16px solid blue;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
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
                <small>Party Rceceivable</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?php echo base_url()?>"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Party Rceceivable</li>
			</ol>
		</section>
        <section class="content">
        	<div class="row">
          	<!-- left column -->
             	<div class="col-md-12">
					<div class="box">
                		<div class="box-header">
                  			<h3 class="box-title">Party Rceceivable</h3>
                		</div><!-- /.box-header -->
                		<div class="box-body">
                  			<table id="example1" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Party ID</th>
										<th>Party Name</th>
										<th>Due Amount</th>
										<th></th>
										<th></th>
									</tr>
								</thead>
								<tbody>
                    			<?php
		                        if(is_array($transectionData) && !empty($transectionData)){
									foreach ($transectionData as $transection){
										if($transection['client_type']=='Debtor'){
                                            $dueAmount=$transection["opening_balance"]+$transection["invoicetotal"]+$transection['pay_amount']- ($transection['purchase_amount']+$transection['under_invoice_amount']);
                                        } else{
                                            $dueAmount=$transection["opening_balance"]-($transection["invoicetotal"]+$transection['pay_amount'])+($transection['purchase_amount']+$transection['under_invoice_amount']); 
                                        }

                                    /*$dueAmount = $transection["opening_balance"]+$transection["invoicetotal"]+$transection['pay_amount']-($transection['purchase_amount']+$transection['under_invoice_amount']+$transection['collection']+$transection['return_amount']+$transection['sales_discount']+$transection['source_tax']);*/
                                    $dueAmount = $dueAmount+$transection['misc_transection']-($transection['collection']+$transection['return_amount']+$transection['sales_discount']+$transection['source_tax']);
										if($dueAmount <= 0)
											continue;
	                    		?>
									<tr>
										<td><?php echo $transection["client_id"];?></a></td>
										<td><?php echo $transection["client_name"];?></td>
										<td><?php echo number_format($dueAmount,2);?></td>
										<td><a href="javascript:void(0);" class="btn btn-block btn-primary" onclick="salesDiscount(<?php echo $transection["client_id"];?>,'<?php echo $transection["client_name"];?>',<?php echo $dueAmount;?>)">Sales Discount</a></td>
										<td><a href="javascript:void(0);" class="btn btn-block btn-primary" onclick="sourceTax(<?php echo $transection["client_id"];?>,'<?php echo $transection["client_name"];?>',<?php echo $dueAmount;?>)">Source Tax</a></td>
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
            </div>
		</section>
		<!-- /.content -->

		<div class="modal fade" id="salesDiscount" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Adjust receivable against Sales Discount</h4>
					</div>
					<div class="modal-body">
						<form role="form" action="" method="post" name="frmSalesDiscount" id="frmSalesDiscount">

							<div class="row form-group">
								<div class="col-md-6">
									<label>Party Name</label><br/>
									<input type="hidden" class="form-control" placeholder="Enter ..." id="partyId" name="partyId" >
									<span id="receivableParty">Sumcon Biotechnology</span>
								</div>
								<div class="col-md-6">
									<label>Adjust Date</label>
									<input type="text" class="form-control" placeholder="Enter ..." id="adjustDate" value="<?php echo date('m/d/Y');?>" name="adjustDate" >
								</div>
							</div>
							<div class="row form-group">
								<div class="col-md-6">
									<label>Receivable Amount</label>
									<input type="text" class="form-control" placeholder="Enter ..." id="receivableAmount" name="receivableAmount" readonly >
								</div>
								<div class="col-md-6">
									<label>Discount Amount</label>
									<input type="text" class="form-control" placeholder="Enter ..." id="discountAmount" name="discountAmount" >
								</div>
							</div>

						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" onclick="saveSalesDiscount()">Save changes</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<div class="modal fade" id="sourceTax" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Adjust receivable against Source Tax</h4>
					</div>
					<div class="modal-body">
						<form role="form" action="" method="post" name="frmSourceTax" id="frmSourceTax">

							<div class="row form-group">
								<div class="col-md-6">
									<label>Party Name</label><br/>
									<input type="hidden" class="form-control" placeholder="Enter ..." id="sourcePartyId" name="sourcePartyId" >
									<span id="sourceReceivableParty"></span>
								</div>
								<div class="col-md-6">
									<label>Adjust Date</label>
									<input type="text" class="form-control" placeholder="Enter ..." id="sourceAdjustDate" value="<?php echo date('m/d/Y');?>" name="sourceAdjustDate" >
								</div>
							</div>
							<div class="row form-group">
								<div class="col-md-6">
									<label>Receivable Amount</label>
									<input type="text" class="form-control" placeholder="Enter ..." id="dueAmount" name="dueAmount" readonly >
								</div>
								<div class="col-md-6">
									<label>Discount Amount</label>
									<input type="text" class="form-control" placeholder="Enter ..." id="sourceTaxAmount" name="sourceTaxAmount" >
								</div>
							</div>

						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" onclick="saveSourceTax()">Save changes</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<div class="modal" id="loader" style="display: none">
			<div class="center">
				<div class="loader"></div>
			</div>
		</div>
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
        $("#example1").DataTable({
			"order": [[ 0, "asc" ]]
		});
		 $("#adjustDate").datepicker();
		 $("#sourceAdjustDate").datepicker();
      });
	  var salesDiscount = function (partyId,partyName,dueAmount) {
		  $("#partyId").val(partyId);
		  $("#receivableParty").html(partyName);
		  $("#receivableAmount").val(dueAmount);
		  $("#salesDiscount").modal({
			  show:true
		  });
	  };

	  var sourceTax = function (partyId,partyName,dueAmount) {
		  $("#sourcePartyId").val(partyId);
		  $("#sourceReceivableParty").html(partyName);
		  $("#dueAmount").val(dueAmount);
		  $("#sourceTax").modal({
			  show:true
		  });
	  };

	  var saveSalesDiscount = function () {
		  $.ajax({
			  type: "POST",
			  url: '<?php echo base_url()?>sales/adjustreceivable/salesdiscount',
			  data : $('#frmSalesDiscount').serialize(),
			  beforeSend: function () {
				  $("#loader").show();
			  },
			  success: function(response) {
				  //alert(response);
				  window.location='<?php echo base_url()?>sales/partyreceivable';
			  }
		  });
	  };
	  var saveSourceTax = function () {
		  $.ajax({
			  type: "POST",
			  url: '<?php echo base_url()?>sales/adjustreceivable/sourcetax',
			  data : $('#frmSourceTax').serialize(),
			  beforeSend: function () {
				  $("#loader").show();
			  },
			  success: function(response) {
				  //alert(response);
				  window.location='<?php echo base_url()?>sales/partyreceivable';
			  }
		  });
	  };
    </script>
</body>
</html>
