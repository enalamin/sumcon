<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sumcon Biotechnology  | Product Loan Ledger</title>
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
         size: portrait;
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
        <div class="row invoice-info">

            <div class="col-xs-12" style="text-align: center;margin-top: -40px;">
              <h2  >
                Product Loan Ledger
              </h2>
                           
              <!-- <span>Party Name: <?php echo $clientDetails[0]["client_name"];?></span><br /> -->
              <span>Product: <?php echo $productDetails[0]["product_description"];?></span><br />
              <span><?php echo $fromDate ? "Date from ".$fromDate." to ".$toDate : "";?></span>
             </div>
          </div><!-- /.row -->



          <!-- Table row -->

          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped table-bordered producttable">
                  <thead class="text-center">
                    <tr>
                        <th class="text-center">Sl #</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Party Name</th>
                        <th class="text-center">Transaction Reference</th>
                        <th class="text-center">Location</th>
                        <th class="text-center">Receive Qty.</th>
                        <th class="text-center">Out Qty.</th>
                        <th class="text-center">Balance Qty.</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>                                
                        <td><?php $i=0; echo ++$i;?></td>
                        <td align="" colspan="6">Opening Balance</td>
                        <td align="right"><?php echo number_format($openingBalance,2). ' kg' ?></td>
                    </tr>
                    <?php
                        $totalinQty = $totaloutQty = 0;
                        $blanceQty = $openingBalance ;
                        foreach ($transectionData as $transection){
                          $totalinQty += $transection["trn_state"]=='in'? $transection['quantity']:0;
                          $totaloutQty += $transection["trn_state"]=='out'? $transection['quantity']:0;
                          $blanceQty = $openingBalance+$totaloutQty - $totalinQty;
                    ?>
                    <tr>                                
                        <td><?php echo ++$i;?></td>
                        <td align=""><?php echo date('d-m-Y', strtotime($transection['trn_date']));?></td>
                        <td align=""><?php echo $transection['client_name'];?></td>
                        <td align=""><?php echo $transection['trn_type']." # ".$transection['referrence_number'];?></td>
                        <td align=""><?php echo $transection["location_name"];?></td>
                        <td align="right"><?php echo $transection["trn_state"]=='in'? number_format($transection["quantity"],2).' kg':'';?></td>
                        <td align="right"><?php echo $transection["trn_state"]=='out'? number_format($transection["quantity"],2).' kg':'';?></td>
                        <td align="right"><?php echo number_format($blanceQty,2). ' kg' ?></td>
                    </tr>

                    <?php

                        }
                    ?>

                    <tr>                                
                      <td>Total</td>
                      <td align="" colspan="4"></td>
                      <td align="right"><?php echo number_format($totalinQty,2).' kg';?></td>
                      <td align="right"><?php echo number_format($totaloutQty,2).' kg';?></td>
                      <td align="right"></td>
                    </tr>
                  </tbody>
                </table>

            </div><!-- /.col -->

          </div><!-- /.row -->
   </section><!-- /.content -->
    </div><!-- ./wrapper -->

    <script src="<?php echo base_url(); ?>dist/js/app.min.js"></script>
  </body>
</html>
