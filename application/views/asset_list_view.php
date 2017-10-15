<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Sumcon Biotechnology | Car</title>
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
				<?php echo $this->session->userdata('activeSidebar');?>
        <small>Asset entry</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?php echo base_url()?>"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active"><?php echo $this->session->userdata('activeSidebar');?></li>
        <li class="active">Asset entry</li>
			</ol>
		</section>
    <section class="content">
      <div class="row">
        <!-- left column -->
            <div class="col-md-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Asset List</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Asset Type</th>
                        <th>Name</th>
                        <th>Purchase Date</th>
                        <th>Purchase Value (BDT)</th>
                        <th>Depreciation Rate (%)</th>
                        <th>Current Value (BDT)</th>
                        <th>&nbsp;</th>

                      </tr>
                    </thead>
                    <tbody>
                    <?php
                        if(is_array($assetList) && !empty($assetList)){
                            foreach ($assetList as $asset){
                    ?>
                            <tr>
                                <td><?php echo $asset["asset_type"];?></td>
                                <td><?php echo $asset["asset_name"];?></td>
                                <td><?php echo date('d-m-Y',strtotime($asset["purchase_date"]));?></td>
                                <td><?php echo number_format($asset["purchase_value"],2);?></td>
                                
                                <td><?php echo number_format($asset["depreciation_rate"],0);?></td>
                                <td><?php echo number_format($asset["current_value"],2);?></td>
                                <td>
                                  <button type="button" class="btn btn-primary" onclick="showModal(<?php echo $asset['asset_id'];?>)">Add Asset Value</button>

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
        </div>
      </section>
    	<!-- /.content -->
      <div class="modal fade" id="additonalExpenses" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Add asset value</h4>
                  </div>
                  <div class="modal-body">
                      <form role="form" action="" method="post" name="frmexpenses" id="frmexpenses">
                          <div class="form-group">
                              <label>Asset Type</label>
                              <input type="text" class="form-control" placeholder="Enter ..." value="" name="modAssetType" id="modAssetType" readonly>
                              <input type="hidden" class="form-control" placeholder="Enter ..." value="" name="modAssetId" id="modAssetId" >
                          </div>
                          <div class="form-group">
                              <label>Asset Name</label>
                              <input type="text" class="form-control" placeholder="Enter ..." value="" name="modAssetName" id="modAssetName" readonly>
                          </div>
                          <div class="row form-group">
                              <div class="col-md-4">
                                <label>Purchase Date</label>
                                <input type="text" class="form-control" placeholder="Enter ..." value="" name="modPurchaseDate" id="modPurchaseDate" readonly>
                              </div>
                              <div class="col-md-4">
                                <label>Purchase Value</label>
                                <input type="text" class="form-control" placeholder="Enter ..." value="" name="modPurchaseValue" id="modPurchaseValue" readonly>
                              </div>
                              <div class="col-md-4">
                                <label>Current Value</label>
                                <input type="text" class="form-control" placeholder="Enter ..." value="" name="modCurrentValue" id="modCurrentValue" readonly>
                              </div>
                          </div>
                          <div class="form-group">
                              <label>Date</label>
                              <input type="text" class="form-control" placeholder="Enter ..." id="expensesDate" value="<?php echo date('m/d/Y');?>" name="expensesDate" >
                          </div>
                          <table class="table table-bordered table-striped" >
                              <tr>
                                  <th>Expenses Description</th>
                                  <th>BDT Amount</th>
                              </tr>
                              <tr>
                                  <td><input type="text" class="form-control" placeholder="Enter ..." name="expDescription" id="expDescription" ></td>
                                  <td><input type="text" class="form-control" placeholder="Enter ..." name="expensesAmount" id="expensesAmount" ></td>
                              </tr>
                          </table>
                      </form>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary" onclick="saveExpenses()">Save changes</button>
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

<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>plugins/select2/select2.full.min.js"></script>
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
        $("#expensesDate").datepicker();

      });

      var showModal = function(assetId){
        
        if(assetId>0){
            $.ajax({
              type: "POST",
              url: '<?php echo base_url()?>assetmanagement/getassetdetails/'+assetId,
              dataType: 'json',
              complete: function(data){
                  var responses = $.parseJSON(data.responseText);
                  if(responses.length>0){
                      $("#griddetails > tbody").html('');
                      for (var j = 0; j < responses.length; j++){                              
                        var obj = responses[j];   
                        var currentValue= parseFloat(obj.current_value)+parseFloat(obj.additional_expenses);                           
                        $("#modAssetId").val(obj.asset_id);  
                        $("#modAssetType").val(obj.asset_type);  
                        $("#modAssetName").val(obj.asset_name);  
                        $("#modPurchaseDate").val(obj.purchase_date);  
                        $("#modPurchaseValue").val(obj.purchase_value);  
                        $("#modCurrentValue").val(currentValue);  
                        $("#additonalExpenses").modal('show');                     
                      }
                      i= j;
                      $("#totalItemRow").val(i);
                      if(i>0){
                          $("#showControl").show();
                      } else{
                          $("#showControl").hide();
                      }
                  } else{
                      $("#griddetails > tbody").html('');
                  }
              }
          });
        } 
      };

      var saveExpenses = function () {
        if($("#expDescription").val()==''){
            alert("Enter Expenses Description");
            $("#expDescription").focus();
        } else if($("#expensesAmount").val()==''){
            alert("Enter Expenses Amount");
            $("#expensesAmount").focus();
        } else {
          $.ajax({
             type: "POST",
             url: '<?php echo base_url()?>assetmanagement/addexpense',
             data : $('#frmexpenses').serialize(),
             beforeSend: function () {
                 $("#loader").show();
             },
             success: function(response) {
                 window.location='<?php echo base_url()?>assetmanagement/assetlist'
             }
          });
        }
      };
    </script>
</body>
</html>
