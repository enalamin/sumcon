<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sumcon Biotechnology | Product Mixing</title>
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
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/sumcon.css" media="all">
</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
  	   <?php include_once "header.php"; ?>
       <!-- Left side column. contains the logo and sidebar -->
       <?php include_once "sidebar.php"; ?>
       <!-- Content Wrapper. Contains page content -->
       <div class="content-wrapper">
        <?php
            if(is_array($requisitionDetails) && !empty($requisitionDetails)){
        ?>
        <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
              Mixing Requisition
              <small>#<?php echo $requisitionDetails[0]['requisition_number']?></small>
            </h1>
            <ol class="breadcrumb">
              <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
              <li><a href="#">Inventory</a></li>
              <li class="active">Product Mixing Requisition</li>
            </ol>
          </section>
          <!-- Main content -->
          <section class="invoice">
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

          <!-- Table row -->
          <div class="row">
              <div class="col-xs-8 table-responsive">
                <div class="row invoice-info">
                    <div class="col-xs-12" style="text-align: center;">
                          <h2 >
                              Requisition
                          </h2>
                      </div>
                  <div class="col-sm-4 invoice-col">
                    <b>Requisition Number:</b> <?php echo $requisitionDetails[0]['requisition_number']?>

                  </div><!-- /.col -->
                  <div class="col-sm-4 invoice-col">
                    <b>Requisition Date:</b> <?php echo $requisitionDetails[0]['requisition_date']?>
                  </div><!-- /.col -->
                  <div class="col-sm-4 invoice-col">
                    <b>Requisition for:</b> <?php echo $requisitionDetails[0]['req_product_desc']?>
                  </div>
                </div><!-- /.row -->

              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Serial #</th>
                    <th>Product</th>
                    <th style="text-align: right;">Qty</th>
                    <th style="text-align: right;">Rate</th>
                    <th style="text-align: right;">Amount (Tk)</th>
                    <th>Remarks</th>
                  </tr>
                </thead>
                <tbody>
                     <?php
                        $i=0;
                        $grandTotal=0;
                        $totalQty = 0;
                            foreach ($requisitionDetails as $requisition){
                              $productAmount = $requisition["rate"]*$requisition["quantity"];
                    ?>

                            <tr>
                                <td><?php echo ++$i;?></td>
                                <td><?php echo $requisition["product_description"];?></td>
                                <td align="right"><?php echo number_format($requisition["quantity"],2).' '.$requisition["product_unit"];?></td>
                                <td align="right"><?php echo number_format($requisition["rate"],2);?></td>
                                <td align="right"><?php echo number_format(($productAmount),2);?></td>
                                <td><?php echo $requisition["remarks"];?></td>
                            </tr>
                    <?php
                            $grandTotal += $productAmount;
                            $totalQty += $requisition["quantity"];
                            }

                    ?>
                    <tr>
                        <td colspan="2">Total</td>
                        <td align="right"><?php echo number_format($totalQty,2);?></td>
                        <td></td>
                        <td align="right"><?php echo number_format(($grandTotal),2);?></td>
                        <td></td>
                    </tr>
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

          <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-6">

            </div><!-- /.col -->
            <div class="col-xs-6">

              <div class="table-responsive">

              </div>
            </div><!-- /.col -->
          </div><!-- /.row -->

          <!-- this row will not appear when printing -->
          <div class="row no-print">
            <div class="col-xs-12">
              <a href="<?php echo base_url(); ?>/productmixingrequisition/printmixingrequisition/<?php echo $requisitionDetails[0]['requisition_number']?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
            </div>
          </div>
        </section><!-- /.content -->
        <?php
            }
        ?>
        <div class="clearfix"></div>
      </div><!-- /.content-wrapper -->
      <?php include_once 'footer.php';?>
  </div><!-- ./wrapper -->
 <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url(); ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url(); ?>plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url(); ?>dist/js/demo.js"></script>
</body>
</html>
