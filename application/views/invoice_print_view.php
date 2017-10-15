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
   <style type="text/css">
  @page {
    margin-top: 0%;
    margin-bottom: 0%
}
.producttable>tbody>tr>th, .producttable>tfoot>tr>th, .producttable>thead>tr>td, .producttable>tbody>tr>td, .producttable>tfoot>tr>td {
    line-height: 0;
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
            <div class="col-xs-12 table-responsive"  >
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
					
					<tr>
                                <td style="border-top:1px solid;" colspan="3" ><b>In Word:-</b> <?php echo InWords($grandTotal, "Taka")?> &nbsp;only.</td>

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


      </section><!-- /.content -->
    </div><!-- ./wrapper -->

    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>dist/js/app.min.js"></script>
  </body>
</html>
