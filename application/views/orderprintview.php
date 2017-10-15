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
                <i class="fa fa-globe"></i> Sumcon Biotechnology.
                <small class="pull-right">Date: <?php echo date('d-m-Y');?></small>
            </h2>
          </div><!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
          <div class="col-sm-4 invoice-col">
            From
            <address>
                <strong>Sumcon Biotechnology.</strong><br>
                Dhaka,Bangladesh<br>
                Phone: **********<br>
                Email: info@sumcon.com
            </address>
          </div><!-- /.col -->
          <div class="col-sm-4 invoice-col">
            To
            <address>
               <strong><?php echo $orderDetails[0]['client_name']?></strong><br>
                <?php echo $orderDetails[0]['client_office_address']?><br>
                
                Phone: <?php echo $orderDetails[0]['client_contact_no']?><br>
                Email: <?php echo $orderDetails[0]['client_email']?>
            </address>
          </div><!-- /.col -->
          <div class="col-sm-4 invoice-col">
            <b>Order Number:</b> <?php echo $orderDetails[0]['order_number']?><br>
            <b>Order Date:</b> <?php echo $orderDetails[0]['order_date']?><br>

          </div><!-- /.col -->
        </div><!-- /.row -->

        <!-- Table row -->
        <div class="row">
          <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
              <tr>
                    <th>Serial #</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Unit</th>
                    <th>Unit Price</th>
                    <th>Subtotal</th>
                  </tr>
                </thead>
                <tbody>
                     <?php
                        $i=0;
                        $grandTotal=0;
                            foreach ($orderDetails as $order){
                    ?>
                       
                            <tr>
                                <td><?php echo ++$i;?></td>
                                <td><?php echo $order["product_name"];?></td>
                                <td><?php echo $order["quantity"];?></td>
                                <td><?php echo $order["product_unit"];?></td>
                                <td><?php echo $order["unit_price"];?></td>
                                <td><?php echo number_format($order["itemtotal"],2);?></td>
                                
                            </tr>
                    <?php
                            $grandTotal += $order["itemtotal"];
                            }
                        
                    ?>
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
              <table class="table">
                
                <tr>
                  <th>Total:</th>
                  <td><?php echo number_format($grandTotal,2);?></td>
                </tr>
              </table>
            </div>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </section><!-- /.content -->
    </div><!-- ./wrapper -->

    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>dist/js/app.min.js"></script>
  </body>
</html>

