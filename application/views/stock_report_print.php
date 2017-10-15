<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sumcon Biotechnology  | Delivery</title>
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
<style type="text/css">
  @page {
   size: landscape;
   margin-top: 2%;
   margin-bottom: 2%;
   margin-left: 1%;
   margin-right: 1%;
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
        <div class="row invoice-info">
            <div class="col-xs-12" style="text-align: center;margin-top: -40px;">
                    <h2 >
					Stock Report
				</h2>
				<?php
					if($locationName)
						echo "<div>Location:".$locationName."</div>";
				?>
				<div>

				</div>
                <div>
                    <?php
                        if(isset($fromDate)){
                            echo "For the period of  ".date('d-m-Y',  strtotime($fromDate))." To ".date('d-m-Y',  strtotime($toDate));
                        }
                        else{
                            echo "Upto ".date('d-m-Y');
                        }
                    ?>

                </div>
        </div><!-- /.row -->

        <!-- Table row -->
        <div class="row"  style="font-size: 6pt;">
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped table-bordered" align="center" style="width: 96%;">
                  <thead class="text-center">
                  <tr>
                        <th rowspan="2" class="text-center">Sl#</th>
                        <th rowspan="2" class="text-center">Product</th>
                        <th rowspan="2" class="text-center">Opening</th>
                        <th colspan="8" class="text-center">Receive</th>
                        <th colspan="6" class="text-center">Out</th>
                        <th rowspan="2" class="text-center">Balance (Kg)</th>
                        <th rowspan="2" class="text-center">Loan (Kg)</th>
                        <th rowspan="2" class="text-center">With Loan</th>
                        <th rowspan="2" class="text-center">Rate</th>
                        <th rowspan="2" class="text-center">Amount</th>

                  </tr>
                  <tr>
                        <th>Conve.</th>
                        <th >Trans.</th>
                        <th >Purchase</th>
                        <th >S.Return</th>
                        <th >Loan</th>
                        <th >Samle</th>
                        <th >LC</th>
                        <th >Total</th>
                        <th>Conve.</th>
                        <th >Trans.</th>
                        <th >Sales</th>
                        <th >Loan</th>
                        <th >Sample</th>
                        <th >Total</th>

                  </tr>
                </thead>
                <tbody>
                      <?php
                        $i=0;
                        $grandReceive = $grandOut = $grandBalanceQty = $grandAmount = $grandBalanceWithLoan = $grandLoanQty =  $grandAmountC=0;
                            foreach ($stockData as $stock){
                               // $receiveTotal = $outTotal=$currentBalance=0;
                                $receiveTotal = $stock["conversion"]+$stock["transfer"]+$stock["purchase"]+$stock["salesreturn"]+$stock["loantaken"]+$stock["samplereturn"]+$stock["lc"];
                                $outTotal = $stock["conversionout"]+$stock["transferout"]+$stock["sales"]+$stock["loangiven"]+$stock["freesample"];

                                $receiveTotalAmount = $stock["conversionAmount"]+$stock["transferAmount"]+$stock["purchaseAmount"]+$stock["salesreturnAmount"]+$stock["loantakenAmount"]+$stock["samplereturnAmount"]+$stock["lcAmount"];
                                $outTotalAmount = $stock["conversionoutAmount"]+$stock["transferoutAmount"]+$stock["salesAmount"]+$stock["loangivenAmount"]+$stock["freesampleAmount"];
                                $currentBalance = $stock["openingbalance"]+$receiveTotal-$outTotal;
                                $currentBalanceAmount = $stock["openingbalanceAmount"]+$receiveTotalAmount-$outTotalAmount;
                                
                                $loanBalance= $stock["loanbalance"]+$stock["loangiven"]-$stock["loantaken"];
                                $loanBalanceAmount= $stock["loanbalanceAmount"]+$stock["loangivenAmount"]-$stock["loantakenAmount"];
                                $currentBalanceWithLoan = $currentBalance + $loanBalance;
                                $currentBalanceAmountC = $currentBalanceWithLoan*round($productRate[$stock["product_id"]],2);
                                $currentBalanceAmount= $currentBalanceWithLoan*round($stock["product_rate"],2);
                                //$currentBalanceAmount = $currentBalanceAmount+$loanBalanceAmount;
                                //$currentRate = $currentBalanceWithLoan>0?($currentBalanceAmount/$currentBalanceWithLoan):$stock["product_rate"];
                                if($stock["openingbalance"]==0 && $receiveTotal==0 && $outTotal==0 && $currentBalance==0 && $loanBalance==0){
                                    continue;
                                }
                                $grandReceive += $receiveTotal; 
                                $grandOut += $outTotal; 
                                $grandBalanceQty += $currentBalance; 
                                $grandLoanQty += $loanBalance;
                                $grandBalanceWithLoan += $currentBalanceWithLoan;
                                $grandAmount += $currentBalanceAmount; 
                                $grandAmountC += $currentBalanceAmountC; 
                    ?>
                       
                            <tr>
                                <td align="right"><?php echo ++$i;?></td>
                                 <td ><?php echo $stock["product_description"];?></td>
                                <td align="right"><?php echo number_format($stock["openingbalance"],2);?></td>
                                <td align="right"><?php echo $stock["conversion"]==0?'-':number_format($stock["conversion"],2);?></td>
                                <td align="right"><?php echo $stock["transfer"]==0?'-':number_format($stock["transfer"],2);?></td>
                                <td align="right"><?php echo $stock["purchase"]==0?'-':number_format($stock["purchase"],2);?></td>
                                <td align="right"><?php echo $stock["salesreturn"]==0?'-':number_format($stock["salesreturn"],2);?></td>
                                <td align="right"><?php echo $stock["loantaken"]==0?'-':number_format($stock["loantaken"],2);?></td>
                                <td align="right"><?php echo $stock["samplereturn"]==0?'-':number_format($stock["samplereturn"],2);?></td>
                                <td align="right"><?php echo $stock["lc"]==0?'-':number_format($stock["lc"],2);?></td>
                                <td align="right"><?php echo number_format($receiveTotal,2);?></td>
                                <td align="right"><?php echo $stock["conversionout"]==0?'-':number_format($stock["conversionout"],2);?></td>
                                <td align="right"><?php echo $stock["transferout"]==0?'-':number_format($stock["transferout"],2);?></td>
                                <td align="right"><?php echo $stock["sales"]==0?'-':number_format($stock["sales"],2);?></td>
                                <td align="right"><?php echo $stock["loangiven"]==0?'-':number_format($stock["loangiven"],2);?></td>
                                <td align="right"><?php echo $stock["freesample"]==0?'-':number_format($stock["freesample"],2);?></td>
                                <td align="right"><?php echo number_format($outTotal,2);?></td>
                                <td align="right"><?php echo number_format($currentBalance,2);?></td>
                                <td align="right"><?php echo number_format($loanBalance,2);?></td>
                                <td align="right"><?php echo number_format($currentBalanceWithLoan,2);?></td>
                                <td align="right"><?php echo number_format($productRate[$stock['product_id']],2);?></td>
                                <!-- <td align="right"><?php echo number_format($stock["product_rate"],2);?></td> -->
                                <td align="right"><?php echo number_format($currentBalanceAmountC,2);?></td>
                            </tr>
                       
                                <?php
                           // $grandTotal += $invoice["itemtotal"];
                            }

                    ?>
                    <tr>
                            <td colspan="2">Total</td>
                            <td align="right"></td>
                            <td align="right"></td>
                            <td align="right"></td>
                            <td align="right"></td>
                            <td align="right"></td>
                            <td align="right"></td>
                            <td align="right"></td>
                            <td align="right"></td>
                            <td align="right"><?php echo number_format($grandReceive,2);?></td>
                            <td align="right"></td>
                            <td align="right"></td>
                            <td align="right"></td>
                            <td align="right"></td>
                            <td align="right"></td>
                            <td align="right"><?php echo number_format($grandOut,2);?></td>
                            <td align="right"><?php echo number_format($grandBalanceQty,2);?></td>
                            <td align="right"><?php echo number_format($grandLoanQty,2);?></td>
                            <td align="right"><?php echo number_format($grandBalanceWithLoan,2);?></td>
                            <td align="right"></td>
                            <td align="right"><?php echo number_format($grandAmountC,2);?></td>
                    </tr>
                    </tbody>
                </table>
          </div><!-- /.col -->
        </div><!-- /.row -->

        <div class="row">
          <!-- accepted payments column -->
          <div class="col-xs-6">

          </div><!-- /.col -->
          <div class="col-xs-6">

            <div class="table-responsive">

            </div>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </section><!-- /.content -->
    </div><!-- ./wrapper -->

    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>dist/js/app.min.js"></script>
  </body>
</html>
