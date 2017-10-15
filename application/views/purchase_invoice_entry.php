<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sumcon Biotechnology | Purchase Invoice</title>
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


<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

	<?php include_once "header.php"; ?>
	<!-- Left side column. contains the logo and sidebar -->
	<?php include_once "sidebar.php"; ?>

	<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
        <?php
            if(is_array($receiveDetails) && !empty($receiveDetails))
            {
        ?>

    <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Invoice
            <small>#<?php echo $receiveDetails[0]['receive_number']?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Purchase</a></li>
            <li class="active">Purchase Invoice</li>
          </ol>
        </section>


        <!-- Main content -->
        <section class="invoice">
          <!-- title row -->
        <form role="form"  action="<?php echo base_url()?>purchase/createpurchaseinvoice/<?php echo $receiveDetails[0]['receive_number']?>" method="post">
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              From
              <address>
                <strong><?php echo $receiveDetails[0]['client_name']?></strong><br>
                <?php echo $receiveDetails[0]['client_office_address']?><br>

                Phone: <?php echo $receiveDetails[0]['client_contact_no']?><br>
                Email: <?php echo $receiveDetails[0]['client_email']?>
              </address>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">

            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">

				<b>Receive Number:</b> <?php echo $receiveDetails[0]['receive_number']?><br>
				<b>Receive Date:</b> <?php echo $receiveDetails[0]['receive_date']?><br>

				<b>Receive Location:</b>
				<select class="form-control select2" name="stockLocation" id="stockLocation" required>
					<option value="">Select Location</option>
					<?php
						if(is_array($locationList)){
							foreach ($locationList as $location){
					?>
							<option value="<?php echo $location["location_id"];?>" <?php echo $receiveDetails[0]['location_id']==$location["location_id"]?"selected":""; ?> ><?php echo $location["location_name"];?></option>
					<?php

							}
						}
					?>
				</select>    <br>

            </div><!-- /.col -->
          </div><!-- /.row -->

            <div class="col-xs-3">
              <label>Purchase Invoice Number</label>
              <input type="text" class="form-control" placeholder="Enter ..." name="invoiceNumber" value="<?php echo $invoiceNumber;?>">
              <input type="hidden" class="form-control" placeholder="Enter ..." name="partyId" value="<?php echo $receiveDetails[0]['party_id']?>">
            </div>

            <div class="col-xs-2">
                <label>Invoice Date</label>
                <input type="text" class="form-control" placeholder="Enter ..." id="datemask" value="<?php echo date('m/d/Y');?>" name="datemask">
            </div>
            <div class="col-xs-6">
                    <label>Purchase Type</label>
                    <select class="form-control select2" name="purchaseType" id="purchaseType" >
                        <option value="Local">Local</option>
                        <option value="Import">Import</option>
                    </select>
            </div>

            <!-- Table row -->
            <div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Serial #</th>
                                <th>Product</th>
                                <th>Invoice Qty</th>
                                <th>Unit</th>
                                <th>Rate</th>
                                <th>Amount</th>
                                <th>Package Info </th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $i=0;
                            $grandTotal=0;
                            foreach ($receiveDetails as $receive){
                        ?>

                            <tr>
                                <td><?php echo ++$i;?></td>
                                <td><?php echo $receive["product_description"];?><input type="hidden" name="productid[]" value="<?php echo $receive["product_id"];?>" ></td>
                                <td><?php echo $receive["quantity"];?><input type="hidden" name="invoiceQty[]" id="invoiceQty_<?php echo $receive["product_id"];?>" value="<?php echo $receive["quantity"];?>" ></td>
                                <td><?php echo $receive["product_unit"];?></td>
                                <td><input type="text" name="productRate[]" id="productRate_<?php echo $receive["product_id"];?>" value="" required onblur="calculateTotal(<?php echo $receive["product_id"];?>)"></td>
                                <td><input type="text" name="productAmount[]" id="productAmount_<?php echo $receive["product_id"];?>" value="" readonly></td>
                                <td><?php echo $receive["package"];?></td>
                                <td><?php echo $receive["remarks"];?></td>
                            </tr>
                        <?php
                            //$grandTotal += $invoice["itemtotal"];
                            }
                        ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Invoice Total</td>
                                <td><input type="text" name="invoiceTotal" id="invoiceTotal" value="" ></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="form-group" id="showControl" >
                <div class="col-xs-6">
                    <input type="hidden" id="totalItemRow" name="totalItemRow" value="<?php echo $i;?>">
                    <input id="btn_save" name="btn_save" type="submit" class="btn btn-primary btn-block" value="Save Invoice" />
                </div>
                 <div class="col-xs-6">
                     <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-block btn-danger" value="Cancel" />
                </div>
            </div>
        </form>

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
    <script>
        function activeEntry(productId)
        {
            if($("#ckProduct_"+productId).is(':checked')){
                $("#deliveryQty_"+productId).attr("readonly",false);
                $("#deliveryQty_"+productId).focus();
            }
            else{
                $("#deliveryQty_"+productId).attr("readonly",true);
                $("#deliveryQty_"+productId).val("");
            }

        }
        function checkvalidqty(productId)
        {
            var currentQty =  $("#deliveryQty_"+productId).val();
            var previousQty =  $("#prevdeliveryQty_"+productId).val();
            var invoiceQty =  $("#invoiceQty_"+productId).val();
            if(parseFloat(invoiceQty) < parseFloat(currentQty)+parseFloat(previousQty))
            {
                alert("Delivery qty is higher then the invoice quantity!!");
                $("#deliveryQty_"+productId).focus();
            }

        }
        function calculateTotal(productId)
        {
            if($("#productRate_"+productId).val()!='')
            {
                var currentTotal= $("#invoiceTotal").val()!=''?$("#invoiceTotal").val():0;
                var currentProductTotal = $("#productAmount_"+productId).val()!=''?$("#productAmount_"+productId).val():0;
                currentTotal = parseFloat(currentTotal)-parseFloat(currentProductTotal);

                var quantity = $("#invoiceQty_"+productId).val();
                var rate = $("#productRate_"+productId).val();
                var newAmount = parseFloat(quantity)*parseFloat(rate);
                currentTotal += parseFloat(newAmount);
                $("#productAmount_"+productId).val(newAmount);
                $("#invoiceTotal").val(currentTotal);
            }

        }
    </script>

</body>
</html>
