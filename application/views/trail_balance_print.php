<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sumcon Biotechnology  | Trial Balance</title>
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
                  <h2 >
                      Trail Balance
                  </h2>

              <div>For the period of  <?php echo date('d-m-Y',  strtotime($fromDate))?> To <?php echo date('d-m-Y',  strtotime($toDate))?></div>
              </div>
        </div><!-- /.row -->

        <!-- Table row -->
        <div class="row">
          <div class="col-xs-12 table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="text-center">
                <tr>
                      <th class="text-center" rowspan="2">Sl #</th>
                      <th class="text-center" rowspan="2">Account Head</th>
                      <!-- <th class="text-center" colspan="2">Opening Balance</th>
                      <th class="text-center" colspan="2">Current Period Balance</th> -->
                      <th class="text-center" colspan="2">Balance</th>
                </tr>
                <tr>
                  <!-- <th class="text-center">Debit</th>
                  <th class="text-center">Credit</th>
                  <th class="text-center">Debit</th>
                  <th class="text-center">Credit</th> -->
                  <th class="text-center">Debit</th>
                  <th class="text-center">Credit</th>
                </tr>

              </thead>
              <tbody>

                  <?php
                      $i=0;
                  $totalOpenDrAmount=$totalOpenCrAmount=$totalDrAmount=$totalCrAmount=$totalCloseDrAmount=$totalCloseCrAmount=0;
                  $headsBalance = $openingHeadBalance = $closingHeadBalance = 0;
                  $openingDrBalance = $openingCrBalance = $printDrBalance = $printCrBalance = $closingDrBalance = $closingCrBalance = "";
                  foreach ($transectionData as $transection){

                    if($transection['accounts_type']=='Debit'){
                      $headsBalance = $transection['drAmount']-$transection['crAmount'];
                      $openingHeadBalance = $transection['openingDrAmount']-$transection['openingCrAmount'];
                      $closingHeadBalance = $openingHeadBalance+$headsBalance;

                      if($openingHeadBalance>0){
                        $totalOpenDrAmount += $openingHeadBalance;
                        $openingDrBalance = $openingHeadBalance;
                        $openingCrBalance='';
                      }
                      else {
                        $totalOpenCrAmount += abs($openingHeadBalance);
                        $openingCrBalance = abs($openingHeadBalance);
                        $openingDrBalance='';
                      }

                      if($headsBalance>0){
                        $totalDrAmount += $headsBalance;
                        $printDrBalance = $headsBalance;
                        $printCrBalance='';
                      }
                      else {
                        $totalCrAmount += abs($headsBalance);
                        $printCrBalance = abs($headsBalance);
                        $printDrBalance='';
                      }

                      if($closingHeadBalance>0){
                        $totalCloseDrAmount += $closingHeadBalance;
                        $closingDrBalance = $closingHeadBalance;
                        $closingCrBalance='';
                      }
                      else {
                        $totalCloseCrAmount += abs($closingHeadBalance);
                        $closingCrBalance = abs($closingHeadBalance);
                        $closingDrBalance='';
                      }

                    }else{
                      $headsBalance = $transection['crAmount']-$transection['drAmount'];
                      $openingHeadBalance = $transection['openingCrAmount']-$transection['openingDrAmount'];
                      $closingHeadBalance = $openingHeadBalance+$headsBalance;

                      if($openingHeadBalance>0){
                        $totalOpenCrAmount += $openingHeadBalance;
                        $openingCrBalance = $openingHeadBalance;
                        $openingDrBalance='';
                      }
                      else {
                        $totalOpenDrAmount += abs($openingHeadBalance);
                        $openingDrBalance = abs($openingHeadBalance);
                        $openingCrBalance='';
                      }

                      if($headsBalance>0){
                        $totalCrAmount += $headsBalance;
                        $printCrBalance = $headsBalance;
                        $printDrBalance='';
                      }
                      else {
                        $totalDrAmount += abs($headsBalance);
                        $printDrBalance = abs($headsBalance);
                        $printCrBalance='';
                      }

                      if($closingHeadBalance>0){
                        $totalCloseCrAmount += $closingHeadBalance;
                        $closingCrBalance = $closingHeadBalance;
                        $closingDrBalance='';
                      }
                      else {
                        $totalCloseDrAmount += abs($closingHeadBalance);
                        $closingDrBalance = abs($closingHeadBalance);
                        $closingCrBalance='';
                      }
                    }


                ?>
                <tr>
                    <td><?php echo ++$i;?></td>
                    <td align=""><?php echo $transection['head_name'];?></td>
                    <!-- <td align="right"><?php echo $openingDrBalance?number_format($openingDrBalance,2):'';?></td>
                    <td align="right"><?php echo $openingCrBalance?number_format($openingCrBalance,2):'';?></td>
                    <td align="right"><?php echo $printDrBalance?number_format($printDrBalance,2):'';?></td>
                    <td align="right"><?php echo $printCrBalance?number_format($printCrBalance,2):'';?></td> -->
                    <td align="right"><?php echo $closingDrBalance?number_format($closingDrBalance,2):'';?></td>
                    <td align="right"><?php echo $closingCrBalance?number_format($closingCrBalance,2):'';?></td>
                </tr>
                  <?php
                         $i++;
                          }

                  ?>
                          <tr>
                              <td>Total</td>
                              <td align=""></td>
                              <!-- <td align="right"><?php echo number_format($totalOpenDrAmount,2);?></td>
                              <td align="right"><?php echo number_format($totalOpenCrAmount,2);?></td>
                              <td align="right"><?php echo number_format($totalDrAmount,2);?></td>
                              <td align="right"><?php echo number_format($totalCrAmount,2);?></td> -->
                              <td align="right"><?php echo number_format($totalCloseDrAmount,2);?></td>
                              <td align="right"><?php echo number_format($totalCloseCrAmount,2);?></td>
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
