<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sumcon Biotechnology | Cheque Deposit</title>
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
	<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/select2/select2.min.css">
    <!-- Date Picker -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/datepicker/datepicker3.css">
	<!-- Daterange picker -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/daterangepicker/daterangepicker-bs3.css">

    <style>
        .loader {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid blue;
            border-bottom: 16px solid blue;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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
                if(is_array($lcDetails) && !empty($lcDetails)) {
            ?>
                    <!-- Content Header (Page header) -->
                    <section class="content-header">
            			<h1>LC (<small>#<?php echo $lcDetails[0]['lc_no']?></small>)</h1>
            			<ol class="breadcrumb">
            				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            				<li><a href="#">Purchase</a></li>
            				<li class="active">Lc Goods Receive</li>
            			</ol>
                    </section>
                    <!-- Main content -->
                    <section class="invoice">
                        <form id="frmgoodsreceive" name="frmgoodsreceive" action="<?php echo base_url()."purchase/receivelcgoods/".$lcDetails[0]['lc_id']; ?>" method="post">
                        <!-- title row -->
                    	<div class="row ">
        					<div class="col-xs-12 table-responsive text-center">
        						<h3 style="text-decoration: underline;">LC Info</h3>
        					</div><!-- /.col -->
        				</div><!-- /.row -->
                        <div class="row">
                            <div class="col-xs-6 table-responsive">
                                <b>LC Number:</b> <?php echo $lcDetails[0]['lc_no'];?><br>
                            </div>
                            <div class="col-xs-6 table-responsive">
                                <b>LC Current Status:</b> <?php echo $lcDetails[0]['status'];?> &nbsp;&nbsp;&nbsp;
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 table-responsive">
                                <b>Supplier Name:</b> <?php echo $lcDetails[0]['client_name'];?><br>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
        				<div class="row ">
        					<div class="col-xs-6 table-responsive">
        						<b>Proforma Invoice Number:</b> <?php echo $lcDetails[0]['pi_no'];?><br>
        					</div><!-- /.col -->
        					<div class="col-xs-6 table-responsive">
        						<b>Proforma Invoice Date:</b> <?php echo $lcDetails[0]['pi_date']?><br>
        					</div><!-- /.col -->
        				</div><!-- /.row -->
        				
        				
                        <div class="row">
                            <div class="col-xs-4 form-group">
                                <label>Receive Date</label>
                                <input type="text" class="form-control" placeholder="Enter ..." id="receiveDate" name="receiveDate" value="<?php echo date('m/d/Y');?>">
                            </div>
                            <div class="col-xs-4 form-group">
                                <label>Receive Location</label>
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
                            <div class="col-xs-4 form-group">
                                <label>Receive Type</label>
                                <select class="form-control select2" name="receiveType" id="receiveType" required>
                                    <option value="">Select Receive Type</option>
                                    <option value="full">Fully Receive</option>
                                    <option value="partial">Partially Receive</option>
                                    
                                </select>
                            </div>
                        </div>
                        <?php
                            if($lcProductDetails && count($lcProductDetails)>0){
                        ?>
                        <div class="row">
                            <div class="col-xs-12">
                                <h3>LC Goods</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Serial #</th>
                                            <th>Product</th>
                                            <th>Invoice Qty </th>
                                            <th>Package Info </th>
                                            <th>Received Qty</th>
                                            <th>Receive Qty</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $i=0;
                                        $grandTotal=0;
                                        foreach ($lcProductDetails as $receive){
                                    ?>

                                        <tr>
                                            <td><?php echo ++$i;?></td>
                                            <td><?php echo $receive["product_description"];?><input type="hidden" name="productid[]" value="<?php echo $receive["product_id"];?>" ><input type="hidden" name="productunitprice[]" value="<?php echo $receive["unit_dollar_price"];?>" ></td>
                                            <td><?php echo $receive["lc_quantity"];?><input type="hidden" name="receiyvedQty[]" value="<?php echo $receive["lc_quantity"];?>" > KG</td>
                                            <td><?php echo $receive["package"];?></td>
                                            <td><?php echo $receive["receive_quantity"];?></td>
                                            <td><input type="text" name="receiveQty[]" value="" ></td>
                                            <td><input type="text" name="remarks[]" value="" ></td>
                                        </tr>
                                    <?php
                                        //$grandTotal += $invoice["itemtotal"];
                                        }
                                    ?>

                                    </tbody>
                                </table>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                        <div class="row form-group">
                            <div class="col-xs-6">
                                <input id="btn_save" name="btn_save" type="submit" class="btn btn-primary btn-block" value="Save" />
                            </div>
                            <div class="col-xs-6">
                                 <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-block btn-danger" value="Cancel" />
                            </div>
                        </div>
                        <?php } ?>
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
           <!-- daterangepicker -->
           <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
           <script src="<?php echo base_url(); ?>plugins/daterangepicker/daterangepicker.js"></script>
           <!-- datepicker -->
           <script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker.js"></script>
           <script src="<?php echo base_url(); ?>plugins/select2/select2.full.min.js"></script>
           <!-- AdminLTE App -->
           <script src="<?php echo base_url(); ?>dist/js/app.min.js"></script>
           <!-- AdminLTE for demo purposes -->
           <script src="<?php echo base_url(); ?>dist/js/demo.js"></script>
           <script>
                var i=0;
                $(function () {
                   $(".select2").select2();
                   $("#receiveDate").datepicker();
                });
           </script>
       </body>
</html>
