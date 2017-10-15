<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sumcon Biotechnology  | Asset Depreciation</title>
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
	<link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/sumcon.css" media="all">
<style type="text/css">
  @page {
   size: landscape;
   margin: 2%
}
.producttable>tbody>tr>th, .producttable>tfoot>tr>th, .producttable>thead>tr>td, .producttable>tbody>tr>td, .producttable>tfoot>tr>td {
    line-height: 1;
    border: 1px solid #6b6565;

}
</style>

  </head>
  <body onload="window.print();">
    <div class="wrapper">
      <!-- Main content -->
      <section class="invoice">
        <!-- title row -->
        <div class="row">
          <div class="col-xs-12">
            <h2 class="page-header">
                <?php include_once 'selfletterheadview.php';?>
            </h2>
          </div><!-- /.col -->
        </div>
        <!-- info row -->
        <div class="invoice-info" style="margin-top:-20px;">
            <div class="col-xs-12" style="text-align: center; margin-top: -50px;">
                <h3 >Asset Depriciation</h3>
                <strong><?php echo $assetType; ?></strong>
                <strong>Depreciation for the Year <?php echo ($depreceationYear-1).' - '.$depreceationYear; ?></strong>
            </div>
            <table id="example1" class="table table-bordered table-striped producttable">

                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Qty.</th>
                        <th>Purchase Date</th>
                        <th>Purchase Value</th>
                        <th>Current Value</th>
                        <th>Additonal Value</th>
                        <th>Balce</th>
                        <th>Dep. Rate  (%)</th>
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
	    </div><!-- /.row -->


		
      </section><!-- /.content -->
    </div><!-- ./wrapper -->

    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>dist/js/app.min.js"></script>
  </body>
</html>
