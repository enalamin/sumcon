<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sumcon Biotechnology  | Party Ledger</title>
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

  </head>
  <body onload="window.print();">
    <div class="wrapper">
      <!-- Main content -->
      <section class="invoice">
        <!-- title row -->
        <div class="row">
          <div class="col-xs-12">
            <h2 class="page-header">
                <img src="<?php echo base_url()."images/sumcon_ltd_logo.jpg";?>" style="width: 180px;height: 46px;">
                <small class="pull-right">Date: <?php echo date('d-m-Y');?></small>
            </h2>
          </div><!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-xs-12" style="text-align: center;">
                <h2 >Party Ledger</h2>
                <div><h3>Party Name:  <?php echo $clientDetails[0]['client_name']; ?></h3></div>
                <div>For the period of  <?php echo date('d-m-Y',  strtotime($fromDate))?> To <?php echo date('d-m-Y',  strtotime($toDate))?></div>
            </div>
        </div><!-- /.row -->
          <!-- Table row -->
        <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped table-bordered">
                <thead class="text-center">
                  <tr>
                    <th class="text-center">Date</th>
                    <th class="text-center">Transect Type</th>
                    <th class="text-center">Reference No.</th>
                    <th class="text-center">Dr. Amount</th>
                    <th class="text-center">Cr. Amount</th>
                    <th class="text-center">Balance</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                      <td colspan="3" align="center"><b>Opening Balance</b></td>
                      <td align="right"></td>
                      <td align="right"></td>
                      <td align="right"><?php echo number_format($openingBalance,2);?></td>
                  </tr>
                <?php
                  $i=0;
                  $totalSales = $totalCollection = $totalPay = $totalPurchase = 0;
                  $currentBalance = $openingBalance;
                  foreach ($transectionData as $transection){
                    $transectionType='';

                    $currentBalance += $clientDetails[0]['client_type']=='Debtor'?$transection['net_total']-$transection['collection_amount']:$transection['collection_amount']-$transection['net_total'];
                    $totalSales += $transection['net_total'];
                    $totalCollection += $transection['collection_amount'];
                 ?>
                  <tr>
                      <td><?php echo date('d-m-Y', strtotime($transection["transection_date"]));?></td>
                      <td align=""  style="text-transform: capitalize;"><?php echo $transection['transectionType'];?></td>
                      <td align="center"><?php echo $transection["transectionNumber"];?></td>
                      <td align="right"><?php echo $transection["net_total"]?number_format($transection["net_total"],2):'';?></td>
                      <td align="right"><?php echo $transection["collection_amount"]?number_format($transection["collection_amount"],2):'';?></td>
                      <td align="right"><?php echo number_format($currentBalance,2);?></td>
                  </tr>
                  <?php
                      }
                  ?>
                    <tr>
                        <td>Total</td>
                        <td align=""></td>
                        <td align="right"></td>
                        <td align="right"><?php echo number_format($totalSales,2);?></td>
                        <td align="right"><?php echo number_format($totalCollection,2);?></td>
                        <td align="right"><?php echo number_format($currentBalance,2);?></td>
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
