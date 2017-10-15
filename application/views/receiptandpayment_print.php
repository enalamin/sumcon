<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sumcon Biotechnology  | Receipt & Payment Statement</title>
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
        <!-- info row -->
        <div class="row invoice-info">
          <div class="col-xs-12" style="text-align: center;margin-top: -40px;">
                  <h2 >
                      Receipt & Payment Statement
                  </h2>

              <div>For the period of  <?php echo date('d-m-Y',  strtotime($fromDate))?> To <?php echo date('d-m-Y',  strtotime($toDate))?></div>
              </div>
        </div><!-- /.row -->

        <!-- Table row -->
        <div class="row">
          <div class="col-xs-12 table-responsive">
            <table class="table table-striped table-bordered producttable">
                <thead class="text-center">
                  <tr>
                    <th class="" ></th>
                    <th class="" >Amount</th>
                    <th class="text-right" >Amount</th>
                  </tr>
                </thead>
              <tbody>
                <tr>
                    <td><b>Receipt</b></td>
                    <td align=""></td>
                    <td align="right"></td>
                </tr>
                <tr>
                    <td><b>Opening Balance</b></td>
                    <td align=""></td>
                    <td align="right"><?php echo number_format($openingBalance,2); ?></td>
                </tr>
                <?php
                $temviewOrder=1;
                $totalExpenses = $totalReceipt = 0;
                foreach ($cashTransectionData as $transection){
                  //$netProfit += $transection['amount'];
                  //if($transection['drAmount']!=0)
                  if($temviewOrder!=$transection['vieworder'] && $transection['vieworder']>2){
                    $temviewOrder=$transection['vieworder'];
                    if($temviewOrder==3){
                      ?>
                      <tr>
                          <td><b>Bank Deposits</b></td>
                          <td align=""></td>
                          <td align="right"></td>
                      </tr>
                      <?php
                    }
                    if($temviewOrder==4){
                      ?>
                      <tr>
                          <td><b>Party payment</b></td>
                          <td align="right"></td>
                          <td align="right"></td>
                      </tr>

                      <?php
                    }
                    if($temviewOrder==5){
                      ?>
                      <tr>
                          <td><b>Advance / Loan Accounts</b></td>
                          <td align="right"></td>
                          <td align="right"></td>
                      </tr>

                      <?php
                    }
                  }

                  $totalExpenses += $transection['drAmount'];
                  $totalReceipt += $transection['crAmount'];
                  ?>
                  <tr>
                      <td><?php echo $transection["particulers"];?></td>
                      <td align="right"><?php echo $transection['drAmount']!=0?number_format($transection['drAmount'],2):"";?></td>
                      <td align="right"><?php echo $transection['crAmount']!=0?number_format($transection['crAmount'],2):"";?></td>
                  </tr>
                  <?php

                }
                ?>
                <tr>
                    <td><b>Expenses</b></td>
                    <td align="right"></td>
                    <td align="right"></td>
                </tr>
                <?php

                foreach ($expensesData as $transection){
                  $totalExpenses += $transection['amount'];
                  ?>
                  <tr>
                      <td> <?php echo $transection["head_name"];?></td>
                      <td align="right"><?php echo number_format($transection['amount'],2);?></td>
                      <td align="right"></td>
                  </tr>
                  <?php
                }
                $closingBalance= $openingBalance+$totalReceipt-$totalExpenses;
                ?>
                <tr>
                    <td><b>Total Paid</b></td>
                    <td align="right"><?php echo number_format($totalExpenses,2);?></td>
                    <td align="right"></td>
                </tr>
                <tr>
                    <td><b>Closing Balance</b></td>
                    <td align="right"><?php echo number_format($closingBalance,2);?></td>
                    <td align="right"></td>
                </tr>
                <tr>
                    <td><b>Grand Total</b></td>
                    <td align="right"><?php echo number_format(($closingBalance+$totalExpenses),2);?></td>
                    <td align="right"><?php echo number_format(($openingBalance+$totalReceipt),2);?></td>
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
