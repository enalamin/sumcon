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
                        <!-- title row -->
                        <div class="row">
                            <div class="col-xs-12">
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#documentRelease">Document Release</button>
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#CandFExpenses">C & F Agent Expenses</button>
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#goodsReceive">Goodes Receive In Wear House</button>
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#lcCosting">LC Costing</button>
                            </div>
                        </div>
            				<div class="row ">
            					<div class="col-xs-12 table-responsive text-center">
            						<h3 style="text-decoration: underline;">LC Details</h3>
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
            					<div class="col-xs-6 table-responsive">
            						<b>Supplier Name:</b> <?php echo $lcDetails[0]['client_name'];?><br>
            					</div><!-- /.col -->
            					<div class="col-xs-6 table-responsive">
            						<b>Bank Info:</b> <?php echo $lcDetails[0]['bank_info'];?><br>
            					</div>
                                <div class="col-xs-6 table-responsive">
            						<b>Invoice Amount:</b> <?php echo $lcDetails[0]['invoice_amount'];?><br>
            					</div>
            				</div><!-- /.row -->
            				<div class="row">
            					<div class="col-xs-6 form-group">
            						<b>LC Number:</b> <?php echo $lcDetails[0]['lc_no'];?><br>
            					</div>
                                <div class="col-xs-6 form-group">
            						<b>LC Current Status:</b> <?php echo $lcDetails[0]['status'];?> &nbsp;&nbsp;&nbsp;
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 form-group">
                                	<b>Bank Name:</b> <?php echo $lcDetails[0]['bank_name'];?><br>
                                </div>
                                <div class="col-xs-6 form-group" >
                                	 <b>Account Number:</b> <?php echo $lcDetails[0]['account_no'];?><br>
                                </div>
                            </div>
                            <div class="row">
                    	       <div class="col-xs-6 form-group">
                                   <b>History</b> <br>
                                   <table class="table table-bordered table-striped">
                                       <tr>
                                           <td>Date</td>
                                           <td>Status</td>
                                           <td>Description</td>
                                       </tr>
                                       <?php
                                       if (isset($lcHistory)) {
                                           foreach ($lcHistory as $history) {
                                       ?>
                                       <tr>
                                           <td><?php echo date('d-m-Y', strtotime($history['event_date'])); ?></td>
                                           <td> <?php echo $history['status'];?> </td>
                                           <td> <?php echo $history['description'];?> </td>
                                       </tr>
                                       <?php
                                            }
                                        }
                                        ?>
                                    </table>
                                </div>
                                <div class="col-xs-6 form-group">
                                    <b>Costing:</b> <br>
                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <td>Date</td>
                                            <td>Cost Name</td>
                                            <td>Amount</td>
                                        </tr>
                                        <?php
                                        if (isset($lcCosting)) {
                                            foreach ($lcCosting as $costing) {
                                        ?>
                                        <tr>
                                            <td><?php echo date('d-m-Y', strtotime($costing['cost_date'])); ?></td>
                                            <td> <?php echo $costing['costing_head'];?> </td>
                                            <td> <?php echo number_format($costing['amount'],2);?> </td>
                                        </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </table>
                         	    </div>
                            </div>
                            <?php
                                if($lcProductDetails && count($lcProductDetails)>0){
                            ?>
                            <div class="row">
                                <div class="col-xs-12">
                                    <h3>Recived Goods</h3>
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
                                                <th>Unit Price $</th>
                                                <th>Package Info </th>
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
                                                <td><?php echo $receive["product_description"];?><input type="hidden" name="productid[]" value="<?php echo $receive["product_id"];?>" ></td>
                                                <td><?php echo $receive["lc_quantity"];?> KG</td>
                                                <td><?php echo $receive["unit_dollar_price"];?></td>
                                                <td><?php echo $receive["package"];?></td>
                                                <td><?php echo $receive["remarks"];?></td>
                                            </tr>
                                        <?php
                                            //$grandTotal += $invoice["itemtotal"];
                                            }
                                        ?>

                                        </tbody>
                                    </table>
                                </div><!-- /.col -->
                            </div><!-- /.row -->
                            <?php } ?>

                   </section><!-- /.content -->

                   <!-- DOCMENT RELEASE MODAL -->

                    <div class="modal fade" id="documentRelease" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Document Release</h4>
                                </div>
                                <div class="modal-body">
                                    <form role="form" action="" name="frmDocRelease" id="frmDocRelease" method="post">
                                        <div class="form-group">
                                            <label>LC Number</label>
                                            <input type="text" class="form-control" placeholder="Enter ..." id="lcNumber" value="<?php echo $lcDetails[0]['lc_no'];?>" name="lcNumber" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Document Release Date</label>
                                            <input type="text" class="form-control" placeholder="Enter ..." id="releaseDate" value="<?php echo date('m/d/Y');?>" name="releaseDate" >
                                        </div>
                                        <table class="table table-bordered table-striped" >
                                            <tr>
                                                <th>Cost Head</th>
                                                <th> $ Amount</th>
                                                <th>$ rate</th>
                                                <th>BDT Amount</th>
                                            </tr>
                                            <tr>
                                                <td>Bank Charge</td>
                                                <td><input type="text" class="form-control" placeholder="Enter ..." name="bankChargeDollar" id="bankChargeDollar" required onchange="calculateAmount('bankCharge')"></td>
                                                <td><input type="text" class="form-control dollar-rate" placeholder="Enter ..." name="bankChargeDollarRate" id="bankChargeDollarRate" required onchange="calculateAmount('bankCharge')"></td>
                                                <td><input type="text" class="form-control" placeholder="Enter ..." name="bankChargeAmount" id="bankChargeAmount" readonly></td>
                                            </tr>
                                            <tr>
                                                <td>LTR</td>
                                                <td><input type="text" class="form-control" placeholder="Enter ..." name="ltrDollar" id="ltrDollar" required onchange="calculateAmount('ltr')"></td>
                                                <td><input type="text" class="form-control dollar-rate" placeholder="Enter ..." name="ltrDollarRate" id="ltrDollarRate" required onchange="calculateAmount('ltr')"></td>
                                                <td><input type="text" class="form-control" placeholder="Enter ..." name="ltrAmount" id="ltrAmount" readonly></td>
                                            </tr>
                                            <tr>
                                                <td>Additional Charges</td>
                                                <td><input type="text" class="form-control" placeholder="Enter ..." name="additonalDollar" id="additonalDollar" required onchange="calculateAmount('additonal')"></td>
                                                <td><input type="text" class="form-control dollar-rate" placeholder="Enter ..." name="additonalDollarRate" id="additonalDollarRate" required onchange="calculateAmount('additonal')"></td>
                                                <td><input type="text" class="form-control" placeholder="Enter ..." name="additonalAmount" id="additonalAmount" readonly></td>
                                            </tr>
                                        </table>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick='saveDocRelease()'>Save changes</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

                    <!-- C&F AGENT EXPENSES MODAL -->

                    <div class="modal fade" id="CandFExpenses" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">C & F Agent Expenses</h4>
                                </div>
                                <div class="modal-body">
                                    <form role="form" action="" method="post" name="frmcandf" id="frmcandf">
                                        <div class="form-group">
                                            <label>LC Number</label>
                                            <input type="text" class="form-control" placeholder="Enter ..." value="<?php echo $lcDetails[0]['lc_no'];?>" name="lcNo" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Document Release Date</label>
                                            <input type="text" class="form-control" placeholder="Enter ..." id="candfDate" value="<?php echo date('m/d/Y');?>" name="candfDate" >
                                        </div>
                                        <table class="table table-bordered table-striped" >
                                            <tr>
                                                <th>Cost Head</th>
                                                <th> $ Amount</th>
                                                <th>$ rate</th>
                                                <th>BDT Amount</th>
                                            </tr>
                                            <tr>
                                                <td>C & F Agent Expenses</td>
                                                <td><input type="text" class="form-control" placeholder="Enter ..." name="candfDollar" id="candfDollar" required onchange="calculateAmount('candf')" ></td>
                                                <td><input type="text" class="form-control dollar-rate" placeholder="Enter ..." name="candfDollarRate" id="candfDollarRate" required onchange="calculateAmount('candf')" ></td>
                                                <td><input type="text" class="form-control" placeholder="Enter ..." name="candfAmount" id="candfAmount" readonly></td>
                                            </tr>
                                        </table>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="saveCandF()">Save changes</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

                    <!-- GOODS RECEIVED MODAL -->

                    <div class="modal fade" id="goodsReceive" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Goodes Receive In Wear House</h4>
                                </div>
                                <div class="modal-body">
                                    <form role="form" action="" method="post" name="frmgoodsreceive" id="frmgoodsreceive">

                                        <div class="row form-group">
                                            <div class="col-md-3">
                                                <label>LC Number</label>
                                                <input type="text" class="form-control" placeholder="Enter ..." id="lcNumber" value="<?php echo $lcDetails[0]['lc_no'];?>" name="lcNumber" readonly>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Goods Receive Date</label>
                                                <input type="text" class="form-control" placeholder="Enter ..." id="receiveDate" value="<?php echo date('m/d/Y');?>" name="receiveDate" >
                                            </div>
                                            <div class="col-md-6">
                                                <label>Store Location</label>
                								<select class="form-control select2" name="stockLocation" id="stockLocation" required style="width:100%">
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
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-md-5">
                                                <label>Product</label><br>
                                                <select class="form-control select2" name="productDescription" id="productDescription" style="width:100%" >
                                                    <option value="">Select Product</option>
                                                    <?php
                                                    if(is_array($productList)){
                                                        foreach ($productList as $product){
                                                    ?>
                                                        <option value="<?php echo $product["product_id"];?>"><?php echo $product["product_description"];?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label>Quantity </label>
                                                <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Enter ...">
                                            </div>
                                            <div class="col-md-2">
                                                <label> unit </label>
                                                <select class="form-control select2" id="unit" name="unit">
                                                    <option>KG</option>
                                                    <option>Pice</option>
                                                    <option>CM</option>
                                                    <option>MM</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label>package info </label>
                                                <input type="text" class="form-control" id="package" name="package" placeholder="Enter ...">
                                            </div>
                                            <div class="col-xs-1">
                                                <label>&nbsp; </label>
                                                <input id="btn_add" name="btn_add" type="button" class="btn btn-primary btn-block" value="Add" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <br>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <table id="griddetails" class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Description</th>
                                                            <th>Quantity</th>
                                                            <th>Package Info</th>
                                                            <th>&nbsp;</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <input type="hidden" id="totalItemRow" name="totalItemRow" placeholder="Enter ...">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="saveGoodsReceive()">Save changes</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

                    <!-- COSTING MODAL -->

                    <div class="modal fade" id="lcCosting" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">LC Costing </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row form-group">
                                        <div class="col-md-6">
                                            <label>L/C No:</label>&nbsp;&nbsp;&nbsp;<?php echo $lcDetails[0]['lc_no'];?>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Issue Date:</label>&nbsp;&nbsp;&nbsp;<?php echo "";?>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-xl-12">
                                            <label>Supplier:</label>&nbsp;&nbsp;&nbsp;<?php echo $lcDetails[0]['lc_no'];?>
                                        </div>

                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-6">
                                            <label>PI No:</label>&nbsp;&nbsp;&nbsp;<?php echo $lcDetails[0]['lc_no'];?>
                                        </div>
                                        <div class="col-md-6">
                                            <label>PI Date:</label>&nbsp;&nbsp;&nbsp;<?php echo "";?>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-6">
                                            <label>Invoice No:</label>
                                            <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Enter ...">
                                        </div>
                                        <div class="col-md-6">
                                            <label>invoice Date:</label>
                                            <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Enter ...">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-6">
                                            <label>Bill of Entry No:</label>
                                            <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Enter ...">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Bill of Entry Date:</label>
                                            <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Enter ...">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Bill of Entry Amount:</label>
                                            <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Enter ...">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-4">
                                            <label>Invice Value (US $)</label>
                                            <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Enter ...">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Conversion Rate</label>
                                            <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Enter ...">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Invice Value (BDT)</label>
                                            <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Enter ...">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-4">
                                            <label>Total Expenses</label>
                                            <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Enter ...">
                                        </div>
                                        <div class="col-md-4">
                                            <label>C & F Agent Expenses</label>
                                            <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Enter ...">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Transport Charges</label>
                                            <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Enter ...">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-4">
                                            <label>Un Loading  Charges</label>
                                            <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Enter ...">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Other Port Charges</label>
                                            <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Enter ...">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Total Cost</label>
                                            <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Enter ...">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-4">
                                            <label>Assembly charge (US $)</label>
                                            <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Enter ...">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Assembly charge Convertion Rate</label>
                                            <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Enter ...">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Assembly charge (BDT)</label>
                                            <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Enter ...">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-4">
                                            <label>Grand Total</label>
                                            <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Enter ...">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Total Quantity</label>
                                            <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Enter ...">
                                        </div>
                                        <div class="col-md-4">

                                        </div>
                                    </div>
                                    <?php
                                        if($lcProductDetails && count($lcProductDetails)>0){
                                    ?>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <h3>Recived Goods</h3>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Serial #</th>
                                                        <th>Product</th>
                                                        <th>Invoice Qty</th>
                                                        <th>Rate </th>
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
                                                        <td><?php echo $receive["product_description"];?><input type="hidden" name="productid[]" value="<?php echo $receive["product_id"];?>" ></td>
                                                        <td><?php echo $receive["lc_quantity"].' '.$receive["product_unit"];?><input type="hidden" name="productqty[]" value="<?php echo $receive["lc_quantity"];?>" ></td>
                                                        <td><input type="text" name="productrate[]" value="" ></td>
                                                    </tr>
                                                <?php
                                                    //$grandTotal += $invoice["itemtotal"];
                                                    }
                                                ?>

                                                </tbody>
                                            </table>
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->
                                    <?php } ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="saveGoodsReceive()">Save changes</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

                    <div class="modal" id="loader" style="display: none">
                        <div class="center">
                            <div class="loader"></div>
                        </div>
                    </div>
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
                   $("#releaseDate").datepicker();
                   $("#candfDate").datepicker();
                   $("#receiveDate").datepicker();
                   $("#productName").keyup(function(){
                       $("#productDescription").val($("#productName").val());
                   });

                   $("#btn_add").click(function(){
                       var product=$("#productDescription").val();
                       var productDescription=$("#productDescription option:selected").text();
                       var productQuantity=$("#quantity").val();
                       var productUnit=$("#unit option:selected").text();
                       var productPackage=$("#package").val();
                       var currentContent = $("#griddetails").html();

                       if(product!='' && productQuantity!='' && productQuantity>0){
                           $("#griddetails").append("<tr><td>"+productDescription+"</td><td>"+productQuantity+" "+productUnit+"</td><td>"+productPackage+"</td>"
                           +"<td><input type='hidden' name='productid[]' value='"+product+"'><input type='hidden' name='productQty[]' value='"+productQuantity+"'><input type='hidden' name='productPackge[]' value='"+productPackage+"'><button type='button' class='removebutton' title='Remove this row'>X</button></td></tr>");
                           restproductrow();
                           i++;
                           $("#totalItemRow").val(i);
                       }else{
                           alert("check your entry");
                       }

                       if(i>0){
                           $("#showControl").show();
                       }else{
                           $("#showControl").hide();
                       }
                   });
               });
               $(document).on('click', 'button.removebutton', function () {
                   if(confirm("Do you want to remove this?")){
                       $(this).closest('tr').remove();
                       i--;
                       if(i>0){
                           $("#showControl").show();
                           $("#invoiceTotal").val(invoiceTotal.toFixed(2));
                       }else{
                           $("#showControl").hide();
                       }
                   }
                   return false;
               });
               var calculate = function(){
                   var productQuantity=$("#quantity").val();
                   var productPrice=$("#unitprice").val();
                   var amount = parseInt(productQuantity)*parseFloat(productPrice);
                   if(!isNaN(amount)){
                       amount = parseFloat(amount).toFixed(2);
                       $("#amount").val(amount);
                   }
               };
               var restproductrow = function(){
                   $("#productDescription").val("");
                   $("#quantity").val("");
                   $("#unitprice").val("");
                   $("#amount").val("");
               };
               var calculateAmount = function(costType){
                   var dollarAmount = $("#"+costType+"Dollar").val();
                   var dollarRate = $("#"+costType+"DollarRate").val();
                   var bdtAmount = parseFloat(dollarAmount)*parseFloat(dollarRate);
                   if(!isNaN(bdtAmount)){
                       $("#"+costType+"Amount").val(bdtAmount);
                   }
               };
               var saveDocRelease = function () {
                   $.ajax({
                       type: "POST",
                       url: '<?php echo base_url()?>lcmanagement/documentrelease/<?php echo $lcDetails[0]['lc_id'];?>',
                       data : $('#frmDocRelease').serialize(),
                       beforeSend: function () {
                           $("#loader").show();
                       },
                       success: function(response) {
                           window.location='<?php echo base_url()?>lcmanagement/lcdetails/<?php echo $lcDetails[0]['lc_id'];?>'
                       }
                   });
               };
               var saveCandF = function () {
                   $.ajax({
                       type: "POST",
                       url: '<?php echo base_url()?>lcmanagement/candfagent/<?php echo $lcDetails[0]['lc_id'];?>',
                       data : $('#frmcandf').serialize(),
                       beforeSend: function () {
                           $("#loader").show();
                       },
                       success: function(response) {
                           window.location='<?php echo base_url()?>lcmanagement/lcdetails/<?php echo $lcDetails[0]['lc_id'];?>'
                       }
                   });
               };
               var saveGoodsReceive = function () {
                   $.ajax({
                       type: "POST",
                       url: '<?php echo base_url()?>lcmanagement/goodsreceive/<?php echo $lcDetails[0]['lc_id'];?>',
                       data : $('#frmgoodsreceive').serialize(),
                       beforeSend: function () {
                           $("#loader").show();
                       },
                       success: function(response) {
                           //alert(response);
                           window.location='<?php echo base_url()?>lcmanagement/lcdetails/<?php echo $lcDetails[0]['lc_id'];?>'
                       }
                   });
               };
           </script>
       </body>
</html>
