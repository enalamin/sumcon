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
    <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/sumcon.css" media="all">

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
<div class="invoice-info">
  <div class="row">
    <div class="col-xs-12" style="text-align: center;">
      <table align="center">
        <tr>
          <td><h2 class="printheadertitle">Product Conversion</h2></td>
        </tr>
      </table>
    </div>
  </div>

</div><!-- /.row -->

<!-- Table row -->
<div class="row">
    <div class="col-xs-8 table-responsive">
      <div class="row invoice-info">
          <div class="col-xs-12" style="text-align: center;">
                <h2 >
                    Requisition
                </h2>
            </div>
        <div class="col-sm-6 invoice-col">
          <b>Mixing Requisition Number:</b> <?php echo $requisitionDetails[0]['requisition_number']?>

        </div><!-- /.col -->
        <div class="col-sm-6 invoice-col">
          <b>Mixing Requisition Date:</b> <?php echo $requisitionDetails[0]['requisition_date']?>
        </div><!-- /.col -->
      </div><!-- /.row -->

    <table class="table table-striped">
      <thead>
        <tr>
          <th>Serial #</th>
          <th>Product</th>
          <th>Qty</th>
          <th>Rate</th>
          <th>Amount (Tk)</th>
          <th>Remarks</th>
        </tr>
      </thead>
      <tbody>
           <?php
              $i=0;
              $grandTotal=0;
                  foreach ($requisitionDetails as $requisition){
          ?>

                  <tr>
                      <td><?php echo ++$i;?></td>
                      <td><?php echo $requisition["product_description"];?></td>
                      <td><?php echo number_format($requisition["quantity"],2).' '.$requisition["product_unit"];?></td>
                      <td><?php echo number_format($requisition["rate"],2);?></td>
                      <td><?php echo number_format(($requisition["rate"]*$requisition["quantity"]),2);?></td>
                      <td><?php echo $requisition["remarks"];?></td>

                  </tr>
          <?php
                 // $grandTotal += $invoice["itemtotal"];
                  }

          ?>
          </tbody>
      </table>
  </div><!-- /.col -->
  <div class="col-xs-4">
    <?php
    if($conversionDetails){
    ?>
    <div class="row">
      <div class="col-xs-12" style="text-align: center;">
        <h2 >Converted Product</h2>
      </div>
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
            <tr>
              <th>Product Name</th>
              <td><?php echo $conversionDetails[0]["product_description"];?></td>
            </tr>
            <tr>
              <th>Quantity</th>
              <td><?php echo number_format($conversionDetails[0]["quantity"],2).' '.$conversionDetails[0]["product_unit"];?></td>
            </tr>
            <tr>
              <th>Rate</th>
              <td><?php echo number_format($conversionDetails[0]["rate"],2);?></td>
            </tr>
            <tr>
              <th>Amount(TK)</th>
              <td><?php echo number_format(($conversionDetails[0]["rate"]*$conversionDetails[0]["quantity"]),2);?></td>
            </tr>
            <tr>
              <th>Location</th>
              <td><?php echo $conversionDetails[0]["location_name"];?></td>
            </tr>
        </table>
      </div><!-- /.col -->
    </div><!-- /.row -->
  <?php
    }
  ?>
</div>
</div><!-- /.row -->

      </section><!-- /.content -->
    </div><!-- ./wrapper -->

    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>dist/js/app.min.js"></script>
  </body>
</html>
