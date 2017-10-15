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
    <!-- Date Picker -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/datepicker/datepicker3.css">


    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php include_once "header.php"; ?>
            <!-- Left side column. contains the logo and sidebar -->
            <?php include_once "sidebar.php"; ?>

            <div class="content-wrapper">
            <?php
                if(is_array($sampleDetails) && !empty($sampleDetails)) {
            ?>
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Free Sample
                        <small>#<?php echo $sampleDetails[0]['sample_number']?></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Inventory</a></li>
                        <li class="active">Sample Return</li>
                    </ol>
                </section>
                <section class="invoice">
                    <form role="form"  action="<?php echo base_url()?>freesample/samplereturn/<?php echo $sampleDetails[0]['sample_number']?>" method="post">
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                To
                                <address>
                                    <strong><?php echo $sampleDetails[0]['client_name']?></strong><br>
                                    <?php echo $sampleDetails[0]['client_office_address']?><br>
                                    Phone: <?php echo $sampleDetails[0]['client_contact_no']?><br>
                                    Email: <?php echo $sampleDetails[0]['client_email']?>
                                </address>
                            </div><!-- /.col -->

                            <div class="col-sm-4 invoice-col">
                                <b>Sample Number:</b> <?php echo $sampleDetails[0]['sample_number']?><br>
                                <b>Sample Date:</b> <?php echo $sampleDetails[0]['sample_delivery_date']?><br>
                            </div><!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                <label>Return Date</label>
            					<input type="text" class="form-control" placeholder="Enter ..." id="datemask" value="<?php echo date('m/d/Y');?>" name="datemask">
                            </div><!-- /.col -->
                        </div><!-- /.row -->

                         <div class="row">
                             <div class="col-xs-12 table-responsive">
                                 <table class="table table-striped">
                                     <thead>
                                         <tr>
                                            <th>Serial #</th>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Used Quantity</th>
                                            <th>Rrturn Quantity</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $i=0;
                                        $grandTotal=0;
                                        foreach ($sampleDetails as $sample){
                                    ?>
                                    <tr>
                                        <td><?php echo ++$i;?></td>
                                        <td><?php echo $sample["product_description"];?><input type="hidden" name="productid[]" value="<?php echo $sample["product_id"];?>" ></td>
                                        <td><?php echo $sample["quantity"];?><input type="hidden" name="invoiceQty[]" id="invoiceQty_<?php echo $sample["product_id"];?>" value="<?php echo $sample["quantity"];?>" > Kg</td>
                                        <td><input type="text" name="usedQuantity[]" value="" ></td>
                                        <td><input type="text" name="returnQuantity[]" value="" ></td>
                                        <td><input type="text" name="deliverRemarks[]" value="" ></td>
                                    </tr>
                                <?php
                                    $grandTotal += $sample["quantity"];
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    <div class="form-group" id="showControl" >
                        <div class="col-xs-6">
                            <input type="hidden" id="totalItemRow" name="totalItemRow" placeholder="Enter ...">
                            <input id="btn_save" name="btn_save" type="submit" class="btn btn-primary btn-block" value="Save" />
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
    <!-- datepicker -->
    <script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker.js"></script>
    <script>
    $(function(){
        $("#datemask").datepicker();
    });
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
