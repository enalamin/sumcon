<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sumcon Biotechnology | Money Receipt</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <!--link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/sumcon.css" media="all">
<style>
.money-receipt-level{
    font-style: italic;
    font-size: 16px;
    font-weight: 600;
}
</style>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

	<?php include_once "header.php"; ?>
	<!-- Left side column. contains the logo and sidebar -->
	<?php include_once "sidebar.php"; ?>

	<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
        <?php
            //if(is_array($deliveryDetails) && !empty($deliveryDetails))
            {
        ?>

    <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Money Receipt
            <small>#<?php echo $collectionDetatils[0]["collection_no"];?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">sales</a></li>
            <li class="active">Money Receipt</li>
          </ol>
        </section>


        <!-- Main content -->
        <section class="invoice">
          <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
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

			<div class="row" style="border:1px solid;">
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
                          //print_r($collectionDetatils);
                          foreach ($collectionDetatils as $collection) {
                            $grandTotal += $collection["collection_amount"];
                            $chequeDetails .= '<tr><td colspan="2">
                            Cheque No: <font > &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$collection["checque_no"].'&nbsp;&nbsp;&nbsp;</font>
                            Bank: <font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$collection["bank_name"].'&nbsp;&nbsp;&nbsp;</font>
          									Cheque Date: <font >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.($collection["checque_date"]!=='0000-00-00'?date('d-m-Y',  strtotime($collection["checque_date"])):"").'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
                            TAKA: <font >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.number_format($collection["collection_amount"],2).'/= &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
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
    <br />
		<div class="row">
          <div class="col-xs-4  text-left signatory" >
            Check By

          </div><!-- /.col -->
		  <div class="col-xs-4  text-center signatory">


          </div><!-- /.col -->
		  <div class="col-xs-4 text-right signatory" >
             Authorized Signature
          </div><!-- /.col -->
        </div>

          <!-- this row will not appear when printing -->
          <div class="row no-print">
            <div class="col-xs-12">
              <a href="<?php echo base_url(); ?>/sales/printmoneyreceipt/<?php echo $collectionDetatils[0]["collection_no"];?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
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
