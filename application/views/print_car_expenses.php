<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sumcon Biotechnology  | Car Wise Expenses</title>
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
              <h2 >Car Wise Expenses</h2>
              <div><h3>Car Number:  <?php echo $carDetails[0]['car_number']; ?></h3></div>
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
                        <th class="text-center">CNG</th>
                        <th class="text-center">Maintenance</th>
                        <th class="text-center">Repair</th>
                        <th class="text-center">Octane</th>
                        <th class="text-center">Toll & Parking</th>
                        

                  </tr>

                </thead>
                <?php
                  $currentBalance = 0;
                 ?>
                <tbody>

                <?php
                $i=0;
                $totalcngAmount = $totalMaintennanceAmount = $totalOctaneAmount = $totalTollAmount = $totalRepair = 0;

                foreach ($transectionData as $transection){
                    $totalcngAmount += $transection['cng'];
                    $totalMaintennanceAmount += $transection['maintenance'];
                    $totalRepair += $transection['repair'];
                    $totalOctaneAmount += $transection['octane'];
                    $totalTollAmount += $transection['toll'];
                  ?>
                  <tr>
                      <td><?php echo date('d-m-Y', strtotime($transection["voucher_date"]));?></td>
                      <td align="right"><?php echo number_format($transection["cng"],2);?></td>
                      <td align="right"><?php echo number_format($transection["maintenance"],2)?></td>
                      <td align="right"><?php echo number_format($transection["repair"],2)?></td>
                      <td align="right"><?php echo number_format($transection["octane"],2)?></td>
                      <td align="right"><?php echo number_format($transection["toll"],2)?></td>
                  </tr>
                    <?php

                           // $grandTotal += $invoice["itemtotal"];
                            }

                    ?>
                            <tr>
                                <td>Total</td>
                                <td align="right"><?php echo number_format($totalcngAmount,2);?></td>
                                <td align="right"><?php echo number_format($totalMaintennanceAmount,2);?></td>
                                <td align="right"><?php echo number_format($totalRepair,2);?></td>
                                <td align="right"><?php echo number_format($totalOctaneAmount,2);?></td>
                                <td align="right"><?php echo number_format($totalTollAmount,2);?></td>
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
