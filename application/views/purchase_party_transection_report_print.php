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

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
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
                        Purchase Party Transaction Details
                    </h2>
                <div>Party Name:  <?php echo $clientDetails[0]['client_name']; ?></div>
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
                        <th class="text-center">Cr. Amount</th>
                        <th class="text-center">Dr. Amount</th>
                        <th class="text-center">Balance</th>

                  </tr>

                </thead>
                <tbody>
                    <tr>
                        <td colspan="3">Opening Balance</td>
                        <td align="right"></td>
                        <td align="right"></td>
                        <td align="right"><?php echo $openingBalance;?></td>
                    </tr>
                    <?php
                        $i=0;
                        $totalPurchase = $totalPay = 0;
                        $currentBalance = $openingBalance;
                        foreach ($transectionData as $transection){

                            $transectionType='';
                            $currentBalance += $transection['purchase_amount']-$transection['pay_amount'];
                            $totalPurchase += $transection['purchase_amount'];
                            $totalPay += $transection['pay_amount'];
                            
                    ?>

                            <tr>
                                <td><?php echo date('d-m-Y',  strtotime($transection["transection_date"]));?></td>
                                <td align=""><?php echo $transection["transectionType"];?></td>
                                <td align="right"><?php echo $transection["transectionNumber"];?></td>
                                <td align="right"><?php echo $transection["purchase_amount"] ? number_format($transection["purchase_amount"],2):"";?></td>
                                <td align="right"><?php echo $transection["pay_amount"] ? number_format($transection["pay_amount"],2):"";?></td>
                                <td align="right"><?php echo number_format($currentBalance,2);?></td>

                            </tr>
                    <?php
                           // $grandTotal += $invoice["itemtotal"];
                            }

                    ?>
                            <tr>
                                <td>Total</td>
                                <td align=""></td>
                                <td align="right"></td>
                                <td align="right"><?php echo number_format($totalPurchase,2);?></td>
                                <td align="right"><?php echo number_format($totalPay,2);?></td>
                                <td align="right"><?php echo number_format($currentBalance,2);?></td>

                            </tr>
                    </tbody>
                </table>          </div><!-- /.col -->
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
