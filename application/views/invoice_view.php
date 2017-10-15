<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sumcon Biotechnology | Invoice</title>
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
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/skins/_all-skins.min.css">


<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

	<?php include_once "header.php"; ?>
	<!-- Left side column. contains the logo and sidebar -->
	<?php include_once "sidebar.php"; ?>

	<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
        <?php
            if(is_array($invoiceDetails) && !empty($invoiceDetails))
            {
        ?>

    <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Invoice
            <small>#<?php echo $invoiceDetails[0]['invoice_no']?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">sales</a></li>
            <li class="active">Invoice</li>
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
          <div class="invoice-info" style="margin-top:-20px;">
			<div class="row">
               <div class="col-xs-12" style="text-align: center;">
					<table align="center">
						<tr>
							<td><h2 class="printheadertitle">invoice/bill</h2></td>
						</tr>
					</table>
                </div>
				</div>
			<div class="row">
				<div class="col-xs-12 table-responsive" >
					<table class="table">
						<tr>
							<td style="border: 1px solid;width:50%;">
								<address>
									<strong>Buyer:</strong><br>
									<strong><?php echo $invoiceDetails[0]['client_name']?></strong><br>
									<?php echo $invoiceDetails[0]['client_office_address']?><br>

									Phone: <?php echo $invoiceDetails[0]['client_contact_no']?><br>
									Email: <?php echo $invoiceDetails[0]['client_email']?>
								</address>
							</td>
							<td style="border: 1px solid;width:50%;">
								<b>Date:</b> <?php echo $invoiceDetails[0]['invoice_date']?><br>
								<b>Invoice Number:</b> <?php echo $invoiceDetails[0]['invoice_no']?><br>
							</td>
						</tr>
					</table>
				</div><!-- /.col -->
			</div>
          </div><!-- /.row -->
          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th style="border-left:1px solid;border-top:1px solid;border-bottom:1px solid;text-align:center;">SL. No</th>
                    <th style="border-left:1px solid;border-top:1px solid;border-bottom:1px solid;text-align:center;">Description</th>
                    <th style="border-left:1px solid;border-top:1px solid;border-bottom:1px solid;text-align:center;">Quantity/kgs</th>
                    <th style="border-left:1px solid;border-top:1px solid;border-bottom:1px solid;text-align:center;">Unit Price</th>
                    <th style="border-left:1px solid;border-top:1px solid;border-bottom:1px solid;border-right:1px solid;text-align:center;">Amount</th>
                  </tr>
                </thead>
                <tbody>
                     <?php
                        $i=0;
                        $grandTotal=0;
                            foreach ($invoiceDetails as $invoice){
                    ?>

                            <tr>
                                <td style="border-left:1px solid;border-top:1px solid;"><?php echo ++$i;?></td>
                                <td style="border-left:1px solid;border-top:1px solid;"><?php echo $invoice["product_description"];?></td>
                                <td style="border-left:1px solid;border-top:1px solid;text-align:right;"><?php echo number_format($invoice["quantity"],2);?> kg</td>
                                <td style="border-left:1px solid;border-top:1px solid;text-align:right;"><?php echo number_format($invoice["unit_price"],2);?></td>
                                <td style="border-left:1px solid;border-top:1px solid;border-right:1px solid;text-align:right;padding-right:5px;"><?php echo number_format($invoice["itemtotal"],2);?></td>

                            </tr>
                    <?php
                            $grandTotal += $invoice["itemtotal"];
                            }

                    ?>
					<!--<tr>
                                <td style="border-left:1px solid;border-top:0px solid;border-bottom:1px solid;">&nbsp;</td>
                                <td style="border-left:1px solid;border-top:0px solid;border-bottom:1px solid;">&nbsp;</td>
                                <td style="border-left:1px solid;border-top:0px solid;border-bottom:1px solid;">&nbsp;</td>
                                <td style="border-left:1px solid;border-top:0px solid;border-bottom:1px solid;">&nbsp;</td>
                                <td style="border-left:1px solid;border-top:0px solid;border-bottom:1px solid;border-right:1px solid;">&nbsp;</td>

                            </tr>-->
					<tr>
                                <td style="border-top:1px solid;" colspan="3"><b>In Word:-</b> <?php echo InWords($grandTotal, "Taka")?> &nbsp;only.</td>

                                <td style="border-left:1px solid;border-top:1px solid;border-bottom:1px solid;">Total Amount</td>
                                <td style="border-left:1px solid;border-top:1px solid;border-bottom:1px solid;border-right:1px solid;text-align:right;"><?php echo number_format($grandTotal,2);?></td>

                            </tr>
                    </tbody>
                </table>
            </div><!-- /.col -->
          </div><!-- /.row -->


		
    <br />
    <br />
    <div class="row">
      <div class="col-xs-4  text-left signatory" >
        Received By
      </div><!-- /.col -->
      <div class="col-xs-4  text-center signatory">
        Authorized Signature
      </div><!-- /.col -->
      <div class="col-xs-4 text-right signatory" >
        Store Incharge
      </div><!-- /.col -->
    </div>
		<br />
		<div class="row">
      <div class="col-xs-12  text-left " >
        <b>Entry By:</b> <?php echo $invoiceDetails[0]['created_by']; ?> &nbsp;&nbsp;&nbsp;<b>Approved By:</b> <?php echo $invoiceDetails[0]['approved_by']; ?>
      </div><!-- /.col -->
		  
    </div>


          <!-- this row will not appear when printing -->
          <div class="row no-print">
            <div class="col-xs-12">
              <a href="<?php echo base_url(); ?>/sales/printinvoice/<?php echo $invoiceDetails[0]['invoice_id']?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
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
