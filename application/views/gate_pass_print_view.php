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
    <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/sumcon.css" media="all">
  </head>
  <body onload="window.print();">
    <div class="wrapper">
      <!-- Main content -->
      <section class="invoice">
        <!-- title row -->
        <div class="row">
          <div class="col-xs-12">
            <h2 class="page-header">
                 <?php //include_once 'getpassletterheadview.php';?>
                 <?php include_once 'letterheadview.php';?>
            </h2>
          </div><!-- /.col -->
        </div>
        <!-- info row -->
        <div class="invoice-info" style="margin-top:-20px;">
          <div class="row">
            <div class="col-xs-12" style="text-align: center;">
              <table align="center">
                <tr>
                  <td><h2 class="printheadertitle">Gate Pass</h2></td>
                </tr>
              </table>
            </div>
          </div>
          <br />

          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table">
                <tr>
                  <td style="border: 1px solid;width:50%;">
                      To<br>
                      <strong><?php echo $deliveryDetails[0]['client_name']?></strong><br>
                      <?php echo $deliveryDetails[0]['delivery_address']?><br>

                      Phone: <?php echo $deliveryDetails[0]['client_contact_no']?><br>
                      Email: <?php echo $deliveryDetails[0]['client_email']?>

                  </td>
                  <td style="border: 1px solid;width:50%;">
                    <b>Date:</b> <?php $deliveryDateTime = new DateTime($deliveryDetails[0]['delivery_time']);
                    echo $deliveryDateTime->format('d-m-Y');?><br>
                    <b>Challan Number:</b> <?php echo $deliveryDetails[0]['challan_no']?>
                  </td>
                </tr>
        </table>
      </div><!-- /.col -->
    </div>

        </div><!-- /.row -->
    <br />

        <!-- Table row -->
        <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th style="border-left:1px solid;border-top:1px solid;border-bottom:1px solid;">Sl. No</th>
                    <th style="border-left:1px solid;border-top:1px solid;border-bottom:1px solid;">Description of Goods</th>
		                <th style="border-left:1px solid;border-top:1px solid;border-bottom:1px solid;">Package</th>
                    <th style="border-left:1px solid;border-top:1px solid;border-bottom:1px solid; text-align:right;">Quantity/Kgs</th>
                    <th style="border-left:1px solid;border-top:1px solid;border-bottom:1px solid;border-right:1px solid;">Remarks</th>
                  </tr>
                </thead>
                <tbody>
                     <?php
                        $i=0;
                        $grandTotal=0;
                            foreach ($deliveryDetails as $delivery){
                    ?>

                            <tr>
                                <td style="border-left:1px solid;"><?php echo ++$i;?></td>
                                <td style="border-left:1px solid;"><?php echo $delivery["product_description"];?></td>
				                        <td style="border-left:1px solid;"><?php echo $delivery["package_info"];?></td>
                                <td style="border-left:1px solid;text-align:right;"><?php echo number_format($delivery["qty"],2);?> Kg</td>
                                <td style="border-left:1px solid;border-right:1px solid;"><?php echo $delivery["remarks"];?></td>

                            </tr>
                    <?php
                            $grandTotal += $delivery["qty"];
                            }

                    ?>
					              <tr>
                            <td style="border-left:1px solid;border-top:1px solid;border-bottom:1px solid;">&nbsp;</td>
                            <td style="border-left:0px solid;border-top:1px solid;border-bottom:1px solid;">Total</td>
                            <td style="border-left:1px solid;border-top:1px solid;border-bottom:1px solid;">&nbsp;</td>
                            <td style="border-left:1px solid;border-top:1px solid;border-bottom:1px solid;text-align:right;"><?php echo number_format($grandTotal,2);?> Kg</td>
                            <td style="border-left:1px solid;border-top:1px solid;border-bottom:1px solid;border-right:1px solid;">&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
            </div><!-- /.col -->
          </div><!-- /.row -->


		<br />
		<br />

		<div class="row">
      <!-- accepted payments column -->
      <div class="col-xs-4 text-left signatory">
        Store Incharge
      </div><!-- /.col -->
      <div class="col-xs-4  text-center signatory">
        Received By

      </div><!-- /.col -->
    <div class="col-xs-4  text-right signatory">
        Authorized Signature

      </div><!-- /.col -->
    </div>
    <br />
    <div class="row">
      <div class="col-xs-4  text-left " >
        <b>Entry By:</b> <?php echo $deliveryDetails[0]['entry_by']; ?>
      </div><!-- /.col -->
      <div class="col-xs-4  text-center signatory">
        
      </div><!-- /.col -->
      <div class="col-xs-4 text-right" >
        
      </div><!-- /.col -->
    </div>

  </section><!-- /.content -->
    </div><!-- ./wrapper -->

    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>dist/js/app.min.js"></script>
  </body>
</html>
