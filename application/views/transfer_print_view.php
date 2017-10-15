<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sumcon Biotechnology  | Invoice</title>
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
        
        <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
                <?php include_once 'letterheadview.php';?>
              </h2>
            </div><!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">
              <div class="col-xs-12" style="text-align: center;">
                    <h2 >
                        Product Transfer
                    </h2>
              </div>
            <div class="col-sm-4 invoice-col">
              From
              <address>
                <strong><?php echo $transferDetails[0]['fromlocation']?></strong>
              </address>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
               T0
              <address>
                <strong><?php echo $transferDetails[0]['tolocation']?></strong>
              </address>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
              
              <b>Transfer Number:</b> <?php echo $transferDetails[0]['transfer_number']?><br>
              <b>Transfer Date:</b> <?php echo $transferDetails[0]['transfer_date']?><br>

            </div><!-- /.col -->
          </div><!-- /.row -->

          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Serial #</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Unit</th>
                    <th>Package</th>
                    <th>Remarks</th>
                  </tr>
                </thead>
                <tbody>
                     <?php
                        $i=0;
                        $grandTotal=0;
                            foreach ($transferDetails as $transfer){
                    ?>
                       
                            <tr>
                                <td><?php echo ++$i;?></td>
                                <td><?php echo $transfer["product_description"];?></td>
                                <td><?php echo $transfer["quantity"];?></td>
                                <td><?php echo $transfer["product_unit"];?></td>
                                <td><?php echo $transfer["package"];?></td>
                                <td><?php echo $transfer["remarks"];?></td>
                                
                            </tr>
                    <?php
                           // $grandTotal += $invoice["itemtotal"];
                            }
                        
                    ?>
                    </tbody>
                </table>
            </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->
    </div><!-- ./wrapper -->

    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>dist/js/app.min.js"></script>
  </body>
</html>

