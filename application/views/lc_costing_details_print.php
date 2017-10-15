<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sumcon Biotechnology  | LC Costing </title>
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
   margin-top: 2%;
   margin-bottom: 2%;
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
        <div class="invoice-info" style="margin-top:-40px;">
          <?php
                        $totalBillofEntryAmount=0;
                        $totalLcCosing = 0;
                        $totalUnderInvoiceDollar = $totalUnderInvoiceBdt = $totalBankCharge= $totalPremium= 0;
                        if (isset($lcCosting)) {
                            foreach ($lcCosting as $costing) {
                                if($costing['costing_head']=='Bill of Enrty' && $lcBatchDetails[0]['batch_name']==$costing['receive_lc_batch']){
                                    $totalBillofEntryAmount = $costing['amount'];
                                }

                                if($costing['costing_head']=='Under Invoice' && $lcBatchDetails[0]['batch_name']==$costing['receive_lc_batch']){
                                    $totalUnderInvoiceDollar = $costing['dollar_amount'];
                                    $totalUnderInvoiceBdt = $costing['amount'];
                                }
                                $totalLcCosing += $costing['amount'];
                                if($costing['costing_head']=='Insurance Premium' && !$costing['receive_lc_batch']){
                                    $totalPremium += $costing['amount'];                                                  
                                }

                                if($costing['costing_head']=='Bank Charges' && !$costing['receive_lc_batch']){
                                    $totalBankCharge += $costing['amount'];                                                  
                                }
                            }
                        }
                    ?>
                    <div class="row">
                        <div class="col-xs-12">
                            <table align="center">
                              <tr>
                                <td><h2 class="printheadertitle">LC Costing Sheet</h2></td>
                              </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-xs-6 table-responsive">
                            <b>Proforma Invoice Number:</b> <?php echo $lcDetails[0]['pi_no'];?><br>
                        </div><!-- /.col -->
                        <div class="col-xs-6 table-responsive">
                            <b>Proforma Invoice Date:</b> <?php echo $lcDetails[0]['pi_date']?><br>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    <div class="row">
                        <div class="col-xs-6 table-responsive">
                            <b>Supplier Name:</b> <?php echo $lcDetails[0]['client_name'];?><br>
                        </div><!-- /.col -->
                        <div class="col-xs-6 table-responsive">
                            <b>Bank Info:</b> <?php echo $lcDetails[0]['bank_info'];?><br>
                        </div>
                        <div class="col-xs-6 table-responsive">
                            <b>Invoice Amount:</b> <?php echo $lcDetails[0]['invoice_amount'];?><br>
                        </div>
                    </div><!-- /.row -->
                    <div class="row">
                        <div class="col-xs-6">
                            <b>LC Number:</b> <?php echo $lcDetails[0]['lc_no'];?><br>
                            <b>LC Receive Batch:</b> <?php echo $lcBatchDetails[0]['batch_name'];?><br>
                        </div>
                        <div class="col-xs-6">
                            <b>LC Current Status:</b> <?php echo $lcDetails[0]['status'];?> &nbsp;&nbsp;&nbsp;
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <b>Bank Name:</b> <?php echo $lcDetails[0]['bank_name'];?><br>
                        </div>
                        <div class="col-xs-6" >
                             <b>Account Number:</b> <?php echo $lcDetails[0]['account_no'];?><br>
                        </div>
                    </div>
                    <?php
                        if($lcReceiveProductDetails && count($lcReceiveProductDetails)>0){
                    ?>
                        <div class="row">
                            <div class="col-xs-12">
                                <h4 class="modal-title">Costing Details</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 table-responsive">
                                <table class="table table-striped producttable">
                                    <tr>
                                        <td>Product</td>
                                        <td></td>
                                        <?php
                                        $grandLcToatal =0;
                                        $totalReceiveQty=0;
                                        $productWiseCost = array();
                                            for($i=0;$i<count($lcReceiveProductDetails);$i++){
                                                echo "<td align='right'>".$lcReceiveProductDetails[$i]['product_description']."<input type='hidden' value='".$lcReceiveProductDetails[$i]['product_id']."' name='costProductId[]'></td>";
                                                $productWiseCost[$i]=0;
                                                $totalReceiveQty += $lcReceiveProductDetails[$i]['receive_quantity'];
                                            }
                                        ?>
                                    </tr>
                                    <tr>
                                        <td>Invoice No</td>
                                        <td><?php echo $lcReceiveProductDetails[0]['invoice_no']?></td>
                                        <td colspan="<?php echo count($lcReceiveProductDetails);?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Invoice Date</td>
                                        <td><?php echo $lcReceiveProductDetails[0]['invoice_date']?></td>
                                        <td colspan="<?php echo count($lcReceiveProductDetails);?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Product Quantity</td>
                                        <td align='right'><?php echo $totalReceiveQty;?></td>
                                        <?php
                                            for($i=0;$i<count($lcReceiveProductDetails);$i++){
                                                echo "<td align='right'>".$lcReceiveProductDetails[$i]['receive_quantity']."</td>";
                                            }
                                        ?>
                                    </tr>
                                    <tr>
                                        <td>Unit Price $</td>
                                        <td></td>
                                        <?php
                                            $totalDollarAmount=0;
                                            $totalBdtAmout = 0;
                                            for($i=0;$i<count($lcReceiveProductDetails);$i++){
                                                $totalDollarAmount += $lcReceiveProductDetails[$i]['unit_dollar_price']*$lcReceiveProductDetails[$i]['receive_quantity'];
                                                echo "<td align='right'>".$lcReceiveProductDetails[$i]['unit_dollar_price']."</td>";
                                            }
                                            $totalBdtAmout = $totalDollarAmount*$lcReceiveProductDetails[0]['dollar_rate'];
                                            $grandLcToatal += $totalBdtAmout; 
                                        ?>
                                    </tr>
                                    <tr>
                                        <td>Amount $</td>
                                        <td align='right'><?php echo number_format($totalDollarAmount,2);?></td>
                                        <?php
                                            for($i=0;$i<count($lcReceiveProductDetails);$i++){
                                                $dollarAmount = $lcReceiveProductDetails[$i]['receive_quantity']*$lcReceiveProductDetails[$i]['unit_dollar_price'];
                                                echo "<td align='right'>".number_format($dollarAmount,2)."</td>";
                                            }
                                        ?>
                                    </tr>
                                    <tr>
                                        <td>Conversion Rate</td>
                                        <td align='right'><?php echo $lcReceiveProductDetails[0]['dollar_rate'];?></td>
                                        <td colspan="<?php echo count($lcReceiveProductDetails);?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Amount BDT</td>
                                        <td align='right'><?php echo number_format($totalBdtAmout,2);?></td>
                                        <?php
                                            for($i=0;$i<count($lcReceiveProductDetails);$i++){
                                                $bdtAmount = $lcReceiveProductDetails[$i]['receive_quantity']*$lcReceiveProductDetails[$i]['unit_dollar_price']*$lcReceiveProductDetails[$i]['dollar_rate'];
                                                echo "<td align='right'>".number_format($bdtAmount,2)."</td>";
                                                $productWiseCost[$i] += $bdtAmount;
                                            }
                                        ?>
                                    </tr>
                                    <tr>
                                        <td>Bill of Entry amount</td>
                                        <td align='right'><?php echo number_format($totalBillofEntryAmount,2);?></td>
                                        <?php
                                            for($i=0;$i<count($lcReceiveProductDetails);$i++){
                                                
                                                echo "<td align='right'>".number_format($lcReceiveProductDetails[$i]['bill_of_entry'],2)."</td>";
                                                $productWiseCost[$i] += $lcReceiveProductDetails[$i]['bill_of_entry'];
                                            }
                                            $grandLcToatal += $totalBillofEntryAmount;
                                        ?>
                                    </tr>
                                    <?php
                                        $netExpenses=0;
                                        if (isset($lcCostingSummery)) {
                                            if ($totalPremium>0) {
                                                                $totalPremium = ($totalPremium*$totalDollarAmount)/$lcDetails[0]['invoice_amount'];
                                                                $netExpenses += $totalPremium;
                                                                $grandLcToatal += $totalPremium;
                                                             
                                                    ?>
                                                        <tr>                                                        
                                                            <td>Insurance Premium</td>
                                                            <td align='right'> <?php echo number_format($totalPremium,2);?> </td>
                                                            <?php
                                                                for($i=0;$i<count($lcReceiveProductDetails);$i++){
                                                                    $bdtAmount = $lcReceiveProductDetails[$i]['receive_quantity']*$lcReceiveProductDetails[$i]['unit_dollar_price']*$lcReceiveProductDetails[$i]['dollar_rate'];    
                                                                    $itemExpeses = $totalPremium?($totalPremium*$bdtAmount/$totalBdtAmout):0;
                                                                    
                                                                    echo "<td align='right'>".number_format($itemExpeses,2)."</td>";
                                                                    $productWiseCost[$i] += $itemExpeses;
                                                                }
                                                            ?>
                                                        </tr>        
                                                    <?php
                                                        }
                                            foreach ($lcCostingSummery as $costing) {
                                                if( in_array($costing['costing_head'], array('LC Margin','LTR','Bill of Enrty','Under Invoice','Cash Retairment Amount')))
                                                    continue;

                                               if ($costing['costing_head']=='Bank Charges') {
                                                                $totalBankCharge = ($totalBankCharge*$totalDollarAmount)/$lcDetails[0]['invoice_amount'];
                                                                $totalBankCharge += $costing['amount'];
                                                                $netExpenses += $totalBankCharge;
                                                                $grandLcToatal += $totalBankCharge;
                                                        ?>
                                                            <tr>                                                        
                                                                <td> <?php echo $costing['costing_head'];?> </td>
                                                                <td align='right'> <?php echo number_format($totalBankCharge,2);?> </td>
                                                                <?php
                                                                    for($i=0;$i<count($lcReceiveProductDetails);$i++){
                                                                        
                                                                            $bdtAmount = $lcReceiveProductDetails[$i]['receive_quantity']*$lcReceiveProductDetails[$i]['unit_dollar_price']*$lcReceiveProductDetails[$i]['dollar_rate'];
                                                                            $itemExpeses = $totalBankCharge?($totalBankCharge*$bdtAmount/$totalBdtAmout):0;
                                                                        
                                                                        echo "<td align='right'>".number_format($itemExpeses,2)."</td>";
                                                                        $productWiseCost[$i] += $itemExpeses;
                                                                    }
                                                                ?>
                                                            </tr>
                                                        <?php
                                                            } else{
                                                                $netExpenses += $costing['amount'];
                                                                $grandLcToatal += $costing['amount'];
                                                    ?>
                                                            <tr>                                                        
                                                                <td> <?php echo $costing['costing_head'];?> </td>
                                                                <td align='right'> <?php echo number_format($costing['amount'],2);?> </td>
                                                                <?php
                                                                    for($i=0;$i<count($lcReceiveProductDetails);$i++){
                                                                        if($costing['distribution_base']=='amount'){
                                                                            $bdtAmount = $lcReceiveProductDetails[$i]['receive_quantity']*$lcReceiveProductDetails[$i]['unit_dollar_price']*$lcReceiveProductDetails[$i]['dollar_rate'];
                                                                            $itemExpeses = $totalBdtAmout?($costing['amount']*$bdtAmount/$totalBdtAmout):0;
                                                                        } else {
                                                                            $itemExpeses = $totalReceiveQty?($costing['amount']*$lcReceiveProductDetails[$i]["receive_quantity"]/$totalReceiveQty):0;
                                                                        }
                                                                        echo "<td align='right'>".number_format($itemExpeses,2)."</td>";
                                                                        $productWiseCost[$i] += $itemExpeses;
                                                                    }
                                                                ?>
                                                            </tr>
                                                    <?php
                                                            }
                                        }
                                    }
                                    ?>
                                            
                                    <tr>
                                        <td>Assembly charge $</td>
                                        <td align='right'><?php echo number_format($totalUnderInvoiceDollar,2);?></td>
                                        <?php
                                            for($i=0;$i<count($lcReceiveProductDetails);$i++){
                                                
                                                echo "<td align='right'>".number_format($lcReceiveProductDetails[$i]['dollar_amount'],2)."</td>";
                                            }
                                        ?>
                                    </tr>
                                    <tr>
                                        <td>Assembly charge Conversion Rate </td>
                                        <td align='right'><?php echo number_format($lcReceiveProductDetails[0]['dollar_conversion_rate'],2);?></td>
                                        <?php
                                            for($i=0;$i<count($lcReceiveProductDetails);$i++){
                                                
                                                echo "<td align='right'>".number_format($lcReceiveProductDetails[$i]['dollar_conversion_rate'],2)."</td>";
                                            }
                                        ?>
                                    </tr>
                                    <tr>
                                        <td>Assembly charge BDT</td>
                                        <td align='right'><?php echo number_format($totalUnderInvoiceBdt,2);?></td>
                                        <?php
                                            for($i=0;$i<count($lcReceiveProductDetails);$i++){
                                                
                                                echo "<td align='right'>".number_format($lcReceiveProductDetails[$i]['invoice_amount'],2)."</td>";
                                                $productWiseCost[$i] += $lcReceiveProductDetails[$i]['invoice_amount']; 
                                            }
                                            $grandLcToatal += $totalUnderInvoiceBdt;
                                        ?>
                                    </tr>
                                    <tr>
                                        <td>Grand Total BDT</td>
                                        <td align='right'><?php echo number_format($grandLcToatal,2);?></td>
                                        <?php
                                            for($i=0;$i<count($lcReceiveProductDetails);$i++){
                                                
                                                echo "<td align='right'>".number_format($productWiseCost[$i],2)."</td>";
                                               
                                            }
                                        ?>
                                    </tr>
                                    <tr>
                                        <td>Rate / Unit</td>
                                        <td align='right'></td>
                                        <?php
                                            for($i=0;$i<count($lcReceiveProductDetails);$i++){
                                                $unitPrice = $lcReceiveProductDetails[$i]['receive_quantity']?($productWiseCost[$i]/$lcReceiveProductDetails[$i]['receive_quantity']):0;
                                                echo "<td align='right'>".number_format($unitPrice,2)."<input type='hidden' value='".number_format($unitPrice,2)."' name='productUnitPrice[]'></td>";
                                               
                                            }
                                        ?>
                                    </tr>
                                </table>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                      <?php } ?>
			  </div><!-- /.row -->


		
      </section><!-- /.content -->
    </div><!-- ./wrapper -->

    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>dist/js/app.min.js"></script>
  </body>
</html>
