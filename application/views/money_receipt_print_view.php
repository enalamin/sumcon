<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sumcon Biotechnology  | Money Receipt</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/AdminLTE.min.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/sumcon.css" media="all">
    <style>
    @page {
      margin-top: 0%;
      margin-bottom: 0%
    }
    .money-receipt-level{
        font-style: italic;
        font-size: 16px;
        font-weight: 600;
    }
    </style>

  </head>
  <body onload="window.print();">
    <div class="wrapper">
      <!-- Main content -->
      <section class="invoice">
        <!-- title row -->
<!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header" style="padding-bottom:0px;">
                 <?php //include_once 'deliveryletterheadview.php';?>
                 <?php include_once 'selfletterheadview.php';?>
              </h2>
            </div><!-- /.col -->
          </div>
          <!-- info row -->
          <div class="invoice-info" style="margin-top:-20px;">
			<div class="row">
				<div class="col-xs-12" style="text-align: center;">
					<table align="center">
						<tr>
							<td><h2 class="printheadertitle">Money Receipt</h2></td>
						</tr>
					</table>
				</div>
			</div>
			<div class="row" style="border:1px solid;margin:0px 10px;">
				<div class="col-xs-12 table-responsive">
          <table class="table">
						<tr>
							<td >
								<font class="money-receipt-level">Money Receipt No:</font> <?php echo $collectionDetatils[0]["collection_no"];?>
							</td>

							<td >
								<font class="money-receipt-level">Date:</font> <?php echo date('d-m-Y',  strtotime($collectionDetatils[0]["collection_date"]));?><br>
							</td>
						</tr>


                     <?php
                        $i=0;
                        $grandTotal=0;
                        $chequeDetails = '<br />';
                        if($collectionDetatils[0]["collection_type"]=="cheque"){
                          foreach ($collectionDetatils as $collection) {
                            $grandTotal += $collection["collection_amount"];
                            $chequeDetails .= '<tr><td colspan="2">
                            Cheque No: <font > &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$collection["checque_no"].'&nbsp;&nbsp;&nbsp;</font>
                            Bank: <font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$collection["bank_name"].'&nbsp;&nbsp;&nbsp;</font>
          									Cheque Date: <font >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.($collection["checque_date"]!=='0000-00-00'?date('d-m-Y',  strtotime($collection["checque_date"])):"").'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
                            TAKA: <font >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.number_format($collection["collection_amount"],2).'/= &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>.
                            </td></tr>';
                          }
                        } else {
                          $grandTotal = $collectionDetatils[0]["collection_amount"];
                        }

                    ?>

                    <tr>
                      <td colspan="2"><font class="money-receipt-level">Received with the thanks from</font> <font >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $collectionDetatils[0]["client_name"];?> </td>
                    </tr>
                    <tr>
                      <td colspan="2"><font class="money-receipt-level">Address</font> <font >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $collectionDetatils[0]["client_office_address"];?> </td>
                    </tr>
                    <tr>
                      <td colspan="2"><font class="money-receipt-level">The Amount of Taka (in words)</font> <font >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo InWords($grandTotal,"");?> &nbsp;only.</td>
                    </tr>
                    <tr>
                      <td ><font class="money-receipt-level">Against</font> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $collectionDetatils[0]["on_account_of"]?$collectionDetatils[0]["on_account_of"]:"Previeous Sales"; ?> </td>
                      <td ><font class="money-receipt-level">By &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $collectionDetatils[0]["collection_type"]; ?></font></td>
                    </tr>
                    <tr>
                      <td ><font class="money-receipt-level">Taka</font> &nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($grandTotal,2); ?>/=</td>
                      <td ><font class="money-receipt-level">Remarks</font> &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $collectionDetatils[0]["remarks"]; ?></td>
                    </tr>
                    <?php echo $chequeDetails; ?>

                  </tbody>
                </table>
            </div><!-- /.col -->
          </div><!-- /.row -->
		<br />

		<div class="row">
          <div class="col-xs-4  text-left signatory" style="padding-left: 60px;" >
            Check By

          </div><!-- /.col -->
		  <div class="col-xs-4  text-center signatory">


          </div><!-- /.col -->
		  <div class="col-xs-4 text-right signatory" style="padding-right: 60px;">
             Authorized Signature
          </div><!-- /.col -->
        </div>
      </section><!-- /.content -->
    </div><!-- ./wrapper -->

    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>dist/js/app.min.js"></script>
  </body>
</html>
