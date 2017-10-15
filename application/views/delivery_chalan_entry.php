<!DOCTYPE html>

<html>

  <head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Sumcon Biotechnology | Delivery Challan</title>

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

            <li class="active">Delivery Challan</li>

          </ol>

        </section>



 

        <!-- Main content -->

        <section class="invoice">

          <!-- title row -->

          

          <!-- info row -->

          <div class="row invoice-info">

            <div class="col-sm-4 invoice-col">

              To

              <address>

                <strong><?php echo $invoiceDetails[0]['client_name']?></strong><br>

                <?php echo $invoiceDetails[0]['client_office_address']?><br>

                

                Phone: <?php echo $invoiceDetails[0]['client_contact_no']?><br>

                Email: <?php echo $invoiceDetails[0]['client_email']?>

              </address>

            </div><!-- /.col -->

            <div class="col-sm-4 invoice-col">

              

            </div><!-- /.col -->

            <div class="col-sm-4 invoice-col">

              

              <b>Invoice Number:</b> <?php echo $invoiceDetails[0]['invoice_no']?><br>

              <b>Invoice Date:</b> <?php echo $invoiceDetails[0]['invoice_date']?><br>



            </div><!-- /.col -->

          </div><!-- /.row -->

        <form role="form"  action="<?php echo base_url()?>sales/deliverychallan/<?php echo $invoiceDetails[0]['invoice_id']?>" method="post">

            <div class="row">

				<div class="col-xs-3">

				  <label>Delivery Challan Number</label>

				  <input type="text" class="form-control" placeholder="Enter ..." name="challanNumber" value="<?php echo $challanNo;?>">

				  <input type="hidden" class="form-control" placeholder="Enter ..." name="clientId" value="<?php echo $invoiceDetails[0]['client_id']?>">

				</div>

				 <div class="col-xs-3">			 

					<label>Location</label>

					<select class="form-control select2" name="stockLocation" id="stockLocation" required>

						<option value="">Select Location</option>

						<?php

							if(is_array($locationList)){

								foreach ($locationList as $location){									

						?>

								<option value="<?php echo $location["location_id"];?>" ><?php echo $location["location_name"];?></option>

						<?php

								

								}

							}

						?>

					</select>                        

				</div>

				<div class="col-xs-2">

					<label>Delivery Date</label>

					<input type="text" class="form-control" placeholder="Enter ..." id="datemask" value="<?php echo date('m/d/Y');?>" name="datemask">

				</div>

				<div class="col-xs-4">

					<label>Delivery Address</label>

					<textarea name="deliveryAddress" id="deliveryAddress" class="form-control" required><?php echo $invoiceDetails[0]["client_delivery_address"];?></textarea>

				</div>

			</div>

			<div class="row">

				<div class="col-xs-3">

				  <label>Vehicle No</label>

				  <input type="text" class="form-control" placeholder="Enter ..." name="vehicleNo" value="">				  

				</div>

				 <div class="col-xs-3">			 

					<label>Driver Name</label>

					<input type="text" class="form-control" placeholder="Enter ..." name="driverName" value="">

				</div>

				<div class="col-xs-2">

					<label>Gate Pass No</label>

					<input type="text" class="form-control" placeholder="Enter ..." name="gatePassNo" value="">

				</div>

				<div class="col-xs-4">

					

				</div>

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

                                <th>Quantity Delivered</th>

                                

                                <th>Quantity(current delivery)</th>

                                <th>Package Info </th>

                                <th>Remarks</th>

                            </tr>

                        </thead>

                        <tbody>

                        <?php

                            $i=0;

                            $grandTotal=0;

                            foreach ($invoiceDetails as $invoice){

                        ?>

                       

                            <tr>

                                <td><?php echo ++$i;?></td>

                                <td><?php echo $invoice["product_description"];?><input type="hidden" name="productid[]" value="<?php echo $invoice["product_id"];?>" ></td>

                                <td><?php echo $invoice["quantity"];?><input type="hidden" name="invoiceQty[]" id="invoiceQty_<?php echo $invoice["product_id"];?>" value="<?php echo $invoice["quantity"];?>" ></td>

                                <td><?php echo $invoice["product_unit"];?><input type="hidden" name="productsUnitPrice[]" id="productsUnitPrice_<?php echo $invoice["product_id"];?>" value="<?php echo $invoice["product_rate"];?>" ></td>

                                <td><?php echo $invoice["delivered_qty"];?><input type="hidden" name="prevdeliveryQty[]" id="prevdeliveryQty_<?php echo $invoice["product_id"];?>" value="<?php echo $invoice["delivered_qty"];?>" ></td>

                                

                                <td><input type="<?php echo $invoice["quantity"]>$invoice["delivered_qty"]?"text":"hidden"; ?>" name="deliveryQty[]" id="deliveryQty_<?php echo $invoice["product_id"];?>" value="" onblur="checkvalidqty(<?php echo $invoice["product_id"];?>)"></td>

                                <td><input type="<?php echo $invoice["quantity"]>$invoice["delivered_qty"]?"text":"hidden"; ?>" name="deliveryPackage[]" value="" ></td>

                                <td><input type="<?php echo $invoice["quantity"]>$invoice["delivered_qty"]?"text":"hidden"; ?>" name="deliverRemarks[]" value="" ></td>

                            </tr>

                        <?php

                            $grandTotal += $invoice["itemtotal"];

                            }

                        ?>

                        </tbody>

                    </table>

                </div><!-- /.col -->

            </div><!-- /.row -->

            <div class="form-group" id="showControl" >

                <div class="col-xs-6">

                    <input type="hidden" id="totalItemRow" name="totalItemRow" placeholder="Enter ...">

                    <input id="btn_save" name="btn_save" type="submit" class="btn btn-primary btn-block" value="Save Delivery" />

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

    </script>

       

</body>

</html>