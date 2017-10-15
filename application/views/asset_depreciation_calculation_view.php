<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Sumcon Biotechnology | Asset</title>
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
        <small>Asset Depreciation Calculation</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?php echo base_url()?>"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active"><?php echo $this->session->userdata('activeSidebar');?></li>
        <li class="active">Asset Depreciation Calculation</li>
			</ol>
		</section>
    <section class="content">
      <div class="row">
        <!-- left column -->
            <div class="col-md-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Asset Depreciation Calculation for the year <?php echo (date('Y')-1).' - '.date('Y'); ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                <form role="form" action="<?php echo base_url()?>assetmanagement/calculatedepreciation" method="post">
                    <!-- select -->
                   <!-- text input -->
                  <div class="row form-group">
                    <div class="col-md-8">
                      <label>Asset Type</label>
                      <select class="select2 form-control" name="assetType" id="assetType" required >
                        <option value="">Select Asset Type</option>
                        <option value="Vehicle" <?php echo $assetType && $assetType=="Vehicle"?'selected':''; ?> >Vehicle</option>
                        <option value="Office Equipments" <?php echo $assetType && $assetType=="Office Equipments"?'selected':''; ?> >Office Equipments</option>
                        <option value="Electrical Equipments" <?php echo $assetType && $assetType=="Electrical Equipments"?'selected':''; ?>  >Electrical Equipments</option>
                        <option value="Office Decoration" <?php echo $assetType && $assetType=="Office Decoration"?'selected':''; ?> >Office Decoration</option>
                        <option value="Furniture & Fixture" <?php echo $assetType && $assetType=="Furniture & Fixture"?'selected':''; ?> >Furniture & Fixture</option>
                      </select>
                    </div>
                    <div class="col-md-2 form-group">
                      <label>&nbsp;</label>
                      <input id="btn_save" name="btn_save" type="submit" class="btn btn-primary btn-block" value="Show Report" />
                    </div>
                    <div class="col-md-2 form-group">
                        <label>&nbsp;</label>
                        <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-block btn-danger" value="Cancel" />
                    </div>
                  </div>
                </form>
                <?php
                  if(is_array($assetList) && !empty($assetList)){
                ?>
                <form name="frmdepreciation" id="frmdepreciation" action="<?php echo base_url();?>assetmanagement/savedepreciation" method="post">
                <input type="hidden" value="<?php echo $assetType;?>" name="depreciationAsset">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Qty.</th>
                        <th>Purchase Date</th>
                        <th>Purchase Value</th>
                        <th>Current Value</th>
                        <th>Additonal Value</th>
                        <th>Balance</th>
                        <th>Dep. Rate (%)</th>
                        <th>Depreciation</th>
                        <th>Banlce after Depreciation</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                        $tempType='';
                        $totalDepreciation = $totalTypeDepreciation = 0;
                        $totalPurchase = $totalTypePurchase = 0;
                        $totalCurrentValue = $totalTypeCurrentValue = 0;
                        $totalAddition = $totalTypeAddition = 0;
                        $totalBalance = $totalTypeBalance = 0;
                        $totalBalanceAfter = $totalTypeBalanceAfter = 0;

                        
                            foreach ($assetList as $asset){
                              $balanceforDepreciation = $asset["current_value"]+$asset["additional_expenses"];
                              $depreciation = $balanceforDepreciation*$asset["depreciation_rate"]/100;
                              $balanceAfterDepreciaton = $balanceforDepreciation-$depreciation;
                              
                              $totalTypeDepreciation += $depreciation;  
                              //$totalDepreciation += $depreciation;
                              $totalTypePurchase += $asset["purchase_value"];
                              $totalTypeCurrentValue += $asset["current_value"];
                              $totalTypeAddition += $asset["additional_expenses"];
                              $totalTypeBalance += $balanceforDepreciation;
                              $totalTypeBalanceAfter += $balanceAfterDepreciaton;

                    ?>
                            <tr>
                                <td><?php echo $asset["asset_name"];?>
                                  <input type="hidden" name="assetId[]" id="assetId_<?php echo $asset['asset_id']; ?>" value="<?php echo $asset["asset_id"];?>" >
                                </td>
                                <td><?php echo $asset["asset_quantity"];?>
                                  <input type="hidden" name="assetQty[]" id="assetQty_<?php echo $asset['asset_id']; ?>" value="<?php echo $asset["asset_quantity"];?>" >
                                </td>
                                <td><?php echo date('d-m-Y',strtotime($asset["purchase_date"]));?></td>
                                <td align="right"><?php echo number_format($asset["purchase_value"],2);?></td>
                                <td align="right"><input type="text" name="currentValue[]" id="currentValue_<?php echo $asset['asset_id']; ?>" value="<?php echo number_format($asset["current_value"],2);?>" style="width:80%;text-align: right;" readonly></td>
                                <td align="right"><input type="text" name="additionalValue[]" id="additionalValue_<?php echo $asset['asset_id']; ?>" value="<?php echo number_format($asset["additional_expenses"],2);?>" style="width:50%;text-align: right;" readonly></td>
                                <td align="right"><input type="text" name="balanceforDepreciation[]" id="balanceforDepreciation_<?php echo $asset['asset_id']; ?>" value="<?php echo $balanceforDepreciation;?>" style="width:80%;text-align: right;" readonly></td>
                                <td align="right"><input type="text" name="depreciationRate[]" id="depreciationRate_<?php echo $asset['asset_id']; ?>" value="<?php echo number_format($asset["depreciation_rate"],0);?>" style="width: 50px;text-align: right;"  onchange="calculatedepreciation(<?php echo $asset['asset_id']; ?>)" ></td>
                                <td align="right"><input type="text" name="depreciation[]" id="depreciation_<?php echo $asset['asset_id']; ?>" value="<?php echo $depreciation;?>" style="width:80%;text-align: right;" readonly></td>
                                <td align="right"><input type="text" name="balanceAfterDepreciaton[]" id="balanceAfterDepreciaton_<?php echo $asset['asset_id']; ?>" value="<?php echo $balanceAfterDepreciaton;?>" style="width:80%;text-align: right;" readonly></td>
                            </tr>
                    <?php
                            }
                           
                  
                    ?>
                            <tr>
                                <td colspan="3"><strong>Total</strong></td>
                                <td align="right"><strong><?php echo number_format($totalTypePurchase,2);?></strong></td>
                                <td align="right"><strong><?php echo number_format($totalTypeCurrentValue,2);?></strong></td>
                                <td align="right"><strong><?php echo number_format($totalTypeAddition,2);?></strong></td>
                                <td align="right"><strong><?php echo number_format($totalTypeBalance,2);?></strong></td>
                                <td align="right"><strong></strong></td>
                                <td align="right"><input type="text" name="totalTypeDepreciation" id="totalTypeDepreciation" value="<?php echo $totalTypeDepreciation;?>" style="width:80%;text-align: right;" readonly></td>
                                <td align="right"><input type="text" name="totalTypeBalanceAfter" id="totalTypeBalanceAfter" value="<?php echo $totalTypeBalanceAfter;?>" style="width:80%;text-align: right;" readonly></td>
                            </tr>
                           
                    </tbody>


                    <tfoot>

                    </tfoot>
                  </table>
                  <div class="row">
                    <div class="col-md-6 form-group">
                      
                      <input id="btn_save_dep" name="btn_save_dep" type="submit" class="btn btn-primary btn-block" value="Save" />
                    </div>
                    <div class="col-md-6 form-group">
                        
                        <input id="btn_cancel_dep" name="btn_cancel_dep" type="reset" class="btn btn-block btn-danger" value="Cancel" />
                    </div>
                  </div>
                  </form>
                  <?php
                        }
                    ?>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
          </div>
        </div>
      </section>
    	
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
      //  $("#example1").DataTable();
        $(".select2").select2();
        $("#expensesDate").datepicker();

      });

      var calculatedepreciation = function(assetId){
        var rate = $("#depreciationRate_"+assetId).val();
        var assetDep = $("#depreciation_"+assetId).val();
        var assetBalanceAfterDep = $("#balanceAfterDepreciaton_"+assetId).val();
        var prevTotalDeprecation = $("#totalTypeDepreciation").val();
        var prevTotalBalanceAfterDep = $("#totalTypeBalanceAfter").val();

        var balanceforDepreciation = $("#balanceforDepreciation_"+assetId).val();
        var depreciation = parseFloat(balanceforDepreciation)*parseFloat(rate)/100;
        var balanceAfterDepreciaton = parseFloat(balanceforDepreciation) - parseFloat(depreciation);
       // alert(balanceAfterDepreciaton);
        if(balanceAfterDepreciaton >= 0 && depreciation>=0 ){
          $("#depreciation_"+assetId).val(parseFloat(depreciation).toFixed(2));
          $("#balanceAfterDepreciaton_"+assetId).val(parseFloat(balanceAfterDepreciaton).toFixed(2));
          $("#totalTypeDepreciation").val(parseFloat(prevTotalDeprecation)+parseFloat(depreciation)-parseFloat(assetDep));
          $("#totalTypeBalanceAfter").val(parseFloat(prevTotalBalanceAfterDep)+parseFloat(balanceAfterDepreciaton)-parseFloat(assetBalanceAfterDep));

        } else{
          alert("invalid rate");
          $("#depreciationRate_"+assetId).focus();
        }
      };

      var checkValidity = function(assetId){
        var rate = $("#depreciationRate_"+assetId).val();
        alert(rate);
        if(parseFloat(rate)<=0){
          alert("invalid rate");
          $("#depreciationRate_"+assetId).focus(); 
          $("#depreciationRate_"+assetId).val(''); 
        }
      };
    </script>
</body>
</html>
