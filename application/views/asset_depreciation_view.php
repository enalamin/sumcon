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
        <small>Asset Depreciation</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?php echo base_url()?>"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active"><?php echo $this->session->userdata('activeSidebar');?></li>
        <li class="active">Asset Depreciation</li>
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
                <form role="form" action="<?php echo base_url()?>assetmanagement/depreciation" method="post">
                    <!-- select -->
                   <!-- text input -->
                  <div class="row form-group">
                    <div class="col-md-5">
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
                    <div class="col-md-3 form-group">
                      <label>Year</label>
                      <select class="select2 form-control" name="depreceationYear" id="depreceationYear" required >
                        <option value="">Select Deprecation Year</option>
                        <option value="2017" <?php echo $depreceationYear && $depreceationYear=="2017"?'selected':''; ?> >2016 - 2017</option>
                        <option value="2018" <?php echo $depreceationYear && $depreceationYear=="2018"?'selected':''; ?> >2017 - 2018</option>
                        <option value="2019" <?php echo $depreceationYear && $depreceationYear=="2019"?'selected':''; ?> >2018 - 2019</option>
                        <option value="2020" <?php echo $depreceationYear && $depreceationYear=="2020"?'selected':''; ?> >2019 - 2020</option>
                        <option value="2021" <?php echo $depreceationYear && $depreceationYear=="2021"?'selected':''; ?> >2020 - 2021</option>
                        <option value="2022" <?php echo $depreceationYear && $depreceationYear=="2022"?'selected':''; ?> >2021 - 2022</option>
                        <option value="2023" <?php echo $depreceationYear && $depreceationYear=="2023"?'selected':''; ?> >2022 - 2023</option>
                        <option value="2024" <?php echo $depreceationYear && $depreceationYear=="2024"?'selected':''; ?> >2023 - 2024</option>
                        <option value="2025" <?php echo $depreceationYear && $depreceationYear=="2025"?'selected':''; ?> >2024 - 2025</option>
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
                <div class="row no-print">
                  <div class="col-xs-12">
                    <a href="<?php echo base_url(); ?>assetmanagement/depreciationprint/<?php echo $assetType.'/'.$depreceationYear;?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
                  </div>
                </div>
                <div class="col-xs-12" style="text-align: center; margin-top: -50px;">
                    <h3 >Asset Depriciation</h3>
                    <strong><?php echo $assetType; ?></strong>
                    <strong>Depreciation for the Year <?php echo ($depreceationYear-1).' - '.$depreceationYear; ?></strong>
                </div>
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Qty.</th>
                        <th>Purchase Date</th>
                        <th>Purchase Value</th>
                        <th>Current Value</th>
                        <th>Additonal Value</th>
                        <th>Balce</th>
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
                             
                              $totalTypeDepreciation += $asset["depreciation"];  
                              //$totalDepreciation += $depreciation;
                              $totalTypePurchase += $asset["purchase_value"];
                              $totalTypeCurrentValue += $asset["current_value"];
                              $totalTypeAddition += $asset["additional_value"];
                              $totalTypeBalance += $asset["balance_before_depreciation"];
                              $totalTypeBalanceAfter += $asset["balance_after_depreciation"];

                    ?>
                            <tr>
                                <td><?php echo $asset["asset_name"];?></td>
                                <td><?php echo $asset["asset_qty"];?></td>
                                <td><?php echo date('d-m-Y',strtotime($asset["purchase_date"]));?></td>
                                <td align="right"><?php echo number_format($asset["purchase_value"],2);?></td>
                                <td align="right"><?php echo number_format($asset["current_value"],2);?></td>
                                <td align="right"><?php echo number_format($asset["additional_value"],2);?></td>
                                <td align="right"><?php echo number_format($asset["balance_before_depreciation"],2);?></td>
                                <td align="right"><?php echo number_format($asset["depreciation_rate"],0);?></td>
                                <td align="right"><?php echo number_format($asset["depreciation"],2);?></td>
                                <td align="right"><?php echo number_format($asset["balance_after_depreciation"],2);?></td>
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
                                <td align="right"><strong><?php echo number_format($totalTypeDepreciation,2);?></strong></td>
                                <td align="right"><strong><?php echo number_format($totalTypeBalanceAfter,2);?></strong></td>
                            </tr>
                            <!-- <tr>
                                <td colspan="2"><strong>Grand Total</strong></td>
                                <td align="right"><strong><?php echo number_format($totalPurchase,2);?></strong></td>
                                <td align="right"><strong><?php echo number_format($totalCurrentValue,2);?></strong></td>
                                <td align="right"><strong><?php echo number_format($totalAddition,2);?></strong></td>
                                <td align="right"><strong><?php echo number_format($totalBalance,2);?></strong></td>
                                <td align="right"><strong></strong></td>
                                <td align="right"><strong><?php echo number_format($totalDepreciation,2);?></strong></td>
                                <td align="right"><strong><?php echo number_format($totalBalanceAfter,2);?></strong></td>
                            </tr> -->
                    
                    </tbody>


                    <tfoot>

                    </tfoot>
                  </table>
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

      
    </script>
</body>
</html>
