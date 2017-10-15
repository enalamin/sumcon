<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sumcon Biotechnology  | Income Statement</title>
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
                      Income Statement
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
                    <th class="" >Particulars</th>
                    <th class="" >Notes</th>
                    <th class="text-right" >Amount</th>
                  </tr>
                </thead>
              <tbody>

                  <?php
                      $i=0;
                  $salesAmount=$netProfit=$costOfGoodsSold=$adminExpenses=$sellingExpenses=$financeExpenses=$tax=0;

                  foreach ($salesData as $transection){
                    $salesAmount += $transection['amount'];
                  }
                    ?>
                <tr>
                    <td>Sales</td>
                    <td align=""></td>
                    <td align="right"><?php echo number_format($salesAmount,2);?></td>
                </tr>
                  <?php
                  foreach ($costofGoodsSoldData as $transection){
                    $costOfGoodsSold += $transection['amount'];
                  }
                  $netProfit=$salesAmount-$costOfGoodsSold;
                  ?>
                  <tr>
                      <td>Less: Cost of Goods Sold</td>
                      <td align="">1</td>
                      <td align="right" style="border-bottom:1px solid;"><?php echo number_format($costOfGoodsSold,2);?></td>
                  </tr>
                  <tr>
                      <td>Gross Profit</td>
                      <td align=""></td>
                      <td align="right"><?php echo number_format($netProfit,2);?></td>
                  </tr>
                  <?php
                  foreach ($otherInfocomeData as $transection){
                    $netProfit += $transection['amount'];
                    ?>
                    <tr>
                        <td>Add: <?php echo $transection["head_name"];?></td>
                        <td align=""></td>
                        <td align="right"><?php echo number_format($transection['amount'],2);?></td>
                    </tr>
                    <?php
                  }
                  ?>
                  <tr>
                      <td>Operating Profit</td>
                      <td align=""></td>
                      <td align="right"><?php echo number_format($netProfit,2);?></td>
                  </tr>
                  <tr>
                      <td>Less Expenses</td>
                      <td align=""></td>
                      <td align="right"></td>
                  </tr>
                  <?php
                  foreach ($adminExpensesData as $transection){
                    $adminExpenses += $transection['amount'];
                  }
                  ?>
                  <tr>
                      <td>Administrative</td>
                      <td align="">2</td>
                      <td align="right"><?php echo number_format($adminExpenses,2);?></td>
                  </tr>
                  <?php
                  foreach ($sellingExpensesData as $transection){
                    $sellingExpenses += $transection['amount'];
                  }
                  ?>
                  <tr>
                      <td>Selling</td>
                      <td align="">3</td>
                      <td align="right"><?php echo number_format($sellingExpenses,2);?></td>
                  </tr>
                  <?php
                  foreach ($financeExpensesData as $transection){
                    $financeExpenses += $transection['amount'];
                  }
                  $totalExpenses = $adminExpenses+$sellingExpenses+$financeExpenses;
                  $netProfit -= $totalExpenses;
                  ?>
                  <tr>
                      <td>Financial</td>
                      <td align="">4</td>
                      <td align="right"><?php echo number_format($financeExpenses,2);?></td>
                  </tr>

                  <tr>
                      <td></td>
                      <td align=""></td>
                      <td align="right"><?php echo number_format($totalExpenses,2);?></td>
                  </tr>
                  <tr>
                      <td>Net Profit before Tax</td>
                      <td align=""></td>
                      <td align="right"><?php echo number_format($netProfit,2);?></td>
                  </tr>
                  <?php
                  foreach ($taxExpensesData as $transection){
                    $tax += $transection['amount'];
                  }
                  $netProfit -= $tax;
                  ?>
                  <tr>
                      <td>Tax</td>
                      <td align=""></td>
                      <td align="right"><?php echo number_format($tax,2);?></td>
                  </tr>
                  <tr>
                      <td>Net Profit before Tax</td>
                      <td align=""></td>
                      <td align="right"><?php echo number_format($netProfit,2);?></td>
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
