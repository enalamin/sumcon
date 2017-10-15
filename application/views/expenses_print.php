<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sumcon Biotechnology  | Bank Book</title>
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
                      Expenses Report
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
                    <th class="" >Sl #</th>
                    <th class="" >Account Head</th>
                    <th class="text-right" >Amount</th>
                  </tr>
                </thead>
              <tbody>

                  <?php
                      $i=0;
                  $totalAmount=0;

                  foreach ($transectionData as $transection){
                    $totalAmount += $transection['amount'];
                    ?>
                <tr>
                    <td><?php echo ++$i;?></td>
                    <td align=""><?php echo $transection['head_name'];?></td>
                    <td align="right"><?php echo number_format($transection['amount'],2);?></td>
                </tr>
                  <?php
                         //$i++;
                          }

                  ?>
                          <tr>
                              <td>Total</td>
                              <td align=""></td>
                              <td align="right"><?php echo number_format($totalAmount,2);?></td>
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
