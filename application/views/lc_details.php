<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sumcon Biotechnology | LC Details</title>
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
            			<h1>Proform Invoice(<small>#<?php echo $lcDetails[0]['pi_no']?></small>)</h1>
            			<ol class="breadcrumb">
            				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            				<li><a href="#">Lc Management</a></li>
            				<li class="active">Lc Details</li>
            			</ol>
                    </section>
                    <!-- Main content -->
                    <section class="invoice">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-xs-12">
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#documentRelease" <?php echo isset($lcBatchDetails[0]['status']) && $lcBatchDetails[0]['status']==0?'disabled':''; ?>
                                    >Document Release</button>
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#CandFExpenses" <?php echo isset($lcBatchDetails[0]['status']) && $lcBatchDetails[0]['status']==0?'':'disabled'; ?> >C & F Agent Expenses</button>
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#lcCosting" <?php echo isset($lcBatchDetails[0]['status']) && $lcBatchDetails[0]['status']==0?'':'disabled'; ?> >LC Costing</button>
                                <button type="button" class="btn btn-default" data-toggle="modal" onclick="showPIEdit()" <?php //echo isset($lcBatchDetails[0]['status']) && $lcBatchDetails[0]['status']==0?'':'disabled'; ?> >Proforma Invoice Edit</button>
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#lcBankAmenment" <?php echo isset($lcBatchDetails[0]['status']) && $lcBatchDetails[0]['status']==0?'':'disabled'; ?> >LC Amenment at Bank</button>
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
            						<b>Invoice Amount: $</b>  <?php echo number_format($lcDetails[0]['invoice_amount'],2);?><br>
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
                                    <b>All Expenses:</b> <br>
                                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#lcExpenses" <?php echo isset($lcBatchDetails[0]['status']) && $lcBatchDetails[0]['status']==0?'':'disabled'; ?> >Add LC Expenses</button>
                                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#billofEntry" <?php echo isset($lcBatchDetails[0]['status']) && $lcBatchDetails[0]['status']==0?'':'disabled'; ?> >Add Bill of Entry</button>
                                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#underInvoice" <?php echo isset($lcBatchDetails[0]['status']) && $lcBatchDetails[0]['status']==0?'':'disabled'; ?> >Add Assembly charge</button>
                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <td>Date</td>
                                            <td>Cost Name</td>
                                            <td align="right">Amount (BDT)</td>
                                            <td align="center">Receive Batch</td>
                                        </tr>
                                        <?php
                                        $totalBillofEntryAmount=0;
                                        $totalLcCosing = 0;
                                        $totalUnderInvoiceDollar = $totalUnderInvoiceBdt = 0;
                                        $totalPremium = $totalBankCharge = 0;
                                        if (isset($lcCosting)) {
                                            foreach ($lcCosting as $costing) {
                                                if($costing['costing_head']=='Bill of Enrty' && $lcBatchDetails[0]['batch_name']==$costing['receive_lc_batch']){
                                                    $totalBillofEntryAmount = $costing['amount'];
                                                }

                                                if($costing['costing_head']=='Under Invoice' && $lcBatchDetails[0]['batch_name']==$costing['receive_lc_batch']){
                                                    $totalUnderInvoiceDollar = $costing['dollar_amount'];
                                                    $totalUnderInvoiceBdt = $costing['amount'];
                                                }
                                                $totalLcCosing += $costing['amount'];

                                                if($costing['costing_head']=='Insurance Premium' && !$costing['receive_lc_batch']){
                                                    $totalPremium += $costing['amount'];                                                  
                                                }

                                                if($costing['costing_head']=='Bank Charges' && !$costing['receive_lc_batch']){
                                                    $totalBankCharge += $costing['amount'];                                                  
                                                }

                                        ?>
                                        <tr>
                                            <td><?php echo date('d-m-Y', strtotime($costing['cost_date'])); ?></td>
                                            <td> <?php echo $costing['costing_head'];?> </td>
                                            <td align="right"> <?php echo number_format($costing['amount'],2);?> </td>
                                            <td align="center"> <?php echo $costing['receive_lc_batch'];?> </td>
                                        </tr>
                                        <?php
                                            }
                                        ?>
                                        <tr>
                                            <td colspan="2">Total</td>
                                            <td align="right"> <?php echo number_format($totalLcCosing,2);?> </td>
                                            <td align="right">  </td>
                                        </tr>
                                        <?php
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
                                    <h3>Product Details</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 table-responsive">
                                    <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <td>Serial #</td>
                                            <td>Product</td>
                                            <td align="right">Invoice Qty </td>
                                            <td align="right">Unit Price $</td>
                                            <td align="right">Amount $</td>
                                            <td>Package Info </td>
                                            <td>Remarks</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $i=0;
                                        $grandTotal=0;
                                        foreach ($lcProductDetails as $receive){
                                            $itemTotal = $receive["lc_quantity"]*$receive["unit_dollar_price"];
                                    ?>
                                        <tr>
                                            <td><?php echo ++$i;?></td>
                                            <td><?php echo $receive["product_description"];?></td>
                                            <td align="right"><?php echo $receive["lc_quantity"];?> KG</td>
                                            <td align="right"><?php echo $receive["unit_dollar_price"];?></td>
                                            <td align="right">$ <?php echo number_format($itemTotal,2);?></td>
                                            <td><?php echo $receive["package"];?></td>
                                            <td><?php echo $receive["remarks"];?></td>
                                        </tr>
                                    <?php
                                        $grandTotal += $itemTotal;
                                        }
                                  ?>
                                         <tr>
                                            <td colspan="4">Total</td>
                                            <td align="right">$ <?php echo  number_format($grandTotal,2);?> </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
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
                                            <label>LC Value $</label>
                                            <input type="text" class="form-control" placeholder="Enter ..." id="lcValue" value="<?php echo $lcDetails[0]['invoice_amount'];?>" name="lcValue" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Document Release Date</label>
                                            <input type="text" class="form-control" placeholder="Enter ..." id="releaseDate" value="<?php echo date('m/d/Y');?>" name="releaseDate" >
                                        </div>
                                        <div class="form-group">
                                            <label>Docs Value $</label>
                                            <input type="text" class="form-control dollar-rate" placeholder="Enter ..." name="docsValue" id="docsValue" >
                                        </div>
                                        <div class="form-group">
                                            <label>rate $</label>
                                            <input type="text" class="form-control dollar-rate" placeholder="Enter ..." name="dollarRate" id="dollarRate" >
                                        </div>
                                        <table class="table table-bordered table-striped" >
                                            <tr>
                                                <th>Cost Head</th>
                                                <th>BDT Amount</th>
                                                <th>Account No</th>
                                            </tr>
                                            <tr>
                                                <td>Bank Charge</td>
                                                <td><input type="text" class="form-control" placeholder="Enter ..." name="bankChargeAmount" id="bankChargeAmount" ></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>LTR</td>
                                                <td><input type="text" class="form-control" placeholder="Enter ..." name="ltrAmount" id="ltrAmount" ></td>
                                                <td><input type="text" class="form-control" placeholder="Enter LTR Number" name="ltrAccount" id="ltrAccount" required="">
                                                <label>LTR Maturity Date</label>
                                                <input type="text" class="form-control" name="ltrMaturityDate" id="ltrMaturityDate" required="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Additional Charges</td>
                                                <td><input type="text" class="form-control" placeholder="Enter ..." name="additonalAmount" id="additonalAmount" ></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Cash Retairment</td>
                                                <td><input type="text" class="form-control" placeholder="Enter ..." name="cashRetairmentAmount" id="cashRetairmentAmount" ></td>
                                                <td></td>
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
                                            <label>Date</label>
                                            <input type="text" class="form-control" placeholder="Enter ..." id="candfDate" value="<?php echo date('m/d/Y');?>" name="candfDate" >
                                        </div>
                                        <table class="table table-bordered table-striped" >
                                            <tr>
                                                <th>Cost Head</th>
                                                <th>BDT Amount</th>
                                            </tr>
                                            <tr>
                                                <td>C & F Agent Expenses</td>
                                                <td><input type="text" class="form-control" placeholder="Enter ..." name="candfAmount" id="candfAmount" ></td>
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

                    <!-- All EXPENSES MODAL -->

                    <div class="modal fade" id="lcExpenses" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">LC Expenses</h4>
                                </div>
                                <div class="modal-body">
                                    <form role="form" action="" method="post" name="frmallexpenses" id="frmallexpenses">
                                        <div class="form-group">
                                            <label>LC Number</label>
                                            <input type="text" class="form-control" placeholder="Enter ..." value="<?php echo $lcDetails[0]['lc_no'];?>" name="expLcNo" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Date</label>
                                            <input type="text" class="form-control" placeholder="Enter ..." id="expensesDate" value="<?php echo date('m/d/Y');?>" name="expensesDate" >
                                        </div>
                                        <table class="table table-bordered table-striped" >
                                            <tr>
                                                <th>Cost Head</th>
                                                <th>BDT Amount</th>
                                                <th>Distribution Based on </th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control" placeholder="Enter Expenses Name..." name="headName" id="headName" required>
                                                </td>
                                                <td><input type="text" class="form-control" placeholder="Enter ..." name="headAmount" id="headAmount"  required></td>
                                                <td>
                                                    <select class="select2 form-control" style="width: 100%;" name="distributionBase" id="distributionBase" >
                                                        <option value="">Select Type</option>
                                                        <option value="amount">Product Amount</option>
                                                        <option value="quantity">Product Quantity</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="saveAllExpenses()">Save changes</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

                    <!-- Bill of Entry MODAL -->

                    <div class="modal fade" id="billofEntry" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Bill Of Entry</h4>
                                </div>
                                <div class="modal-body">
                                    <form role="form" action="" method="post" name="frmBillofEntry" id="frmBillofEntry">
                                        <div class="form-group">
                                            <label>LC Number</label>
                                            <input type="text" class="form-control" placeholder="Enter ..." value="<?php echo $lcDetails[0]['lc_no'];?>" name="billLcNo" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Date</label>
                                            <input type="text" class="form-control" placeholder="Enter ..." id="billofEntryDate" value="<?php echo date('m/d/Y');?>" name="billofEntryDate" >
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12 table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Serial #</th>
                                                            <th>Product</th>
                                                            <th>Invoice Qty </th>
                                                            <th>Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                        $i=0;
                                                        $grandTotal=0;
                                                        foreach ($lcReceiveProductDetails as $receive){
                                                    ?>

                                                        <tr>
                                                            <td><?php echo ++$i;?></td>
                                                            <td><?php echo $receive["product_description"];?><input type="hidden" name="billofEntryProductid[]" value="<?php echo $receive["product_id"];?>" ></td>
                                                            <td><?php echo $receive["receive_quantity"];?> KG</td>
                                                            <td><input type="text" name="billofEntryAmount[]" id="billofEntryAmount_<?php echo $receive["product_id"]; ?>" value="" onfocus="getCurrentValue(<?php echo $receive["product_id"];?>)" onchange="showTotalBillofEntry(<?php echo $receive["product_id"];?>)" ></td>
                                                        </tr>
                                                    <?php
                                                        //$grandTotal += $invoice["itemtotal"];
                                                        }
                                                    ?>
                                                    <tr>
                                                            <td colspan="3">Total</td>
                                                            
                                                            <td><input type="text" name="totalBillofEntryAmount" id="totalBillofEntryAmount" value="" readonly></td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div><!-- /.col -->
                                        </div><!-- /.row -->
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="savebillofentry()">Save changes</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

                    <!-- Under Invoice MODAL -->

                    <div class="modal fade" id="underInvoice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Assembly charge</h4>
                                </div>
                                <div class="modal-body">
                                    <form role="form" action="" method="post" name="frmUnderInvoice" id="frmUnderInvoice">
                                        <div class="form-group">
                                            <label>LC Number</label>
                                            <input type="text" class="form-control" placeholder="Enter ..." value="<?php echo $lcDetails[0]['lc_no'];?>" name="underLcNo" readonly>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-4">
                                                <label>Invoice Number</label>
                                                <input type="text" class="form-control" placeholder="Enter ..." id="underInvoiceNumber" value="" name="underInvoiceNumber" >
                                            </div>
                                            <div class="col-xs-4">
                                                <label>Invoice Date</label>
                                                <input type="text" class="form-control" placeholder="Enter ..." id="underInvoiceDate" value="<?php echo date('m/d/Y');?>" name="underInvoiceDate" >
                                            </div>
                                            <div class="col-xs-4">
                                                <label>Dollar Conversion Rate</label>
                                                <input type="text" class="form-control" placeholder="Enter ..." id="underInvoiceDollarRate" value="" name="underInvoiceDollarRate" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12 table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Serial #</th>
                                                            <th>Product</th>
                                                            <th>Invoice Qty </th>
                                                            <th>Unit Price $ </th>
                                                            <th>Amount $ </th>
                                                            <th>Amount BDT</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                        $i=0;
                                                        $grandTotal=0;
                                                        foreach ($lcReceiveProductDetails as $receive){
                                                    ?>

                                                        <tr>
                                                            <td><?php echo ++$i;?></td>
                                                            <td><?php echo $receive["product_description"];?><input type="hidden" name="invoiceProductid[]" value="<?php echo $receive["product_id"];?>" ></td>
                                                            <td><?php echo $receive["receive_quantity"];?> KG<input type="hidden" name="invoiceProductQty[]" id="invoiceProductQty_<?php echo $receive["product_id"];?>" value="<?php echo $receive["receive_quantity"];?>" ></td>
                                                            <td><input type="text" name="invoiceRate[]" id="invoiceRate_<?php echo $receive["product_id"]; ?>" value="" onchange="showTotal(<?php echo $receive["product_id"];?>)"></td>
                                                            <td><input type="text" name="invoiceAmountDollar[]" id="invoiceAmountDollar_<?php echo $receive["product_id"]; ?>" value="" readonly></td>
                                                            <td><input type="text" name="invoiceAmountBdt[]" id="invoiceAmountBdt_<?php echo $receive["product_id"]; ?>" value="" readonly></td>
                                                        </tr>
                                                    <?php
                                                        //$grandTotal += $invoice["itemtotal"];
                                                        }
                                                    ?>
                                                    <tr>
                                                            <td colspan="5">Total</td>
                                                            
                                                            <td><input type="text" name="totalUnderInvoiceAmount" id="totalUnderInvoiceAmount" value="" readonly></td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div><!-- /.col -->
                                        </div><!-- /.row -->
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="saveUnderInvoice()">Save changes</button>
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
                                <form role="form" action="" method="post" name="frmcosting" id="frmcosting">
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
                                        <div class="col-xs-6">
                                            <b>LC Number:</b> <?php echo $lcDetails[0]['lc_no'];?><br>
                                        </div>
                                        <div class="col-xs-6">
                                            <b>LC Current Status:</b> <?php echo $lcDetails[0]['status'];?> &nbsp;&nbsp;&nbsp;
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <b>Bank Name:</b> <?php echo $lcDetails[0]['bank_name'];?><br>
                                        </div>
                                        <div class="col-xs-6" >
                                             <b>Account Number:</b> <?php echo $lcDetails[0]['account_no'];?><br>
                                        </div>
                                    </div>
                            
                                    
                                    <?php
                                        if($lcProductDetails && count($lcProductDetails)>0){
                                    ?>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <h3>Calculation</h3>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 table-responsive">
                                            <table class="table table-striped">
                                                
                                                <tbody>
                                                    <tr>
                                                        <td>Product</td>
                                                        <td></td>
                                                        <?php
                                                        $grandLcToatal =0;
                                                        $totalReceiveQty = 0;
                                                        $productWiseCost = array();
                                                            for($i=0;$i<count($lcReceiveProductDetails);$i++){
                                                                echo "<td align='right'>".$lcReceiveProductDetails[$i]['product_description']."<input type='hidden' value='".$lcReceiveProductDetails[$i]['product_id']."' name='costProductId[]'></td>";
                                                                $productWiseCost[$i]=0;
                                                                $totalReceiveQty += $lcReceiveProductDetails[$i]['receive_quantity'];
                                                            }
                                                        ?>
                                                    </tr>
                                                    <tr>
                                                        <td>Invoice No</td>
                                                        <td><?php echo $lcReceiveProductDetails[0]['invoice_no']?></td>
                                                        <td colspan="<?php echo count($lcReceiveProductDetails);?>"></td>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td>Invoice Date</td>
                                                        <td><?php echo $lcReceiveProductDetails[0]['invoice_date']?></td>
                                                        <td colspan="<?php echo count($lcReceiveProductDetails);?>"></td>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td>Product Quantity</td>
                                                        <td align='right'><?php echo $totalReceiveQty[0]['totalQty'];?></td>
                                                        <?php
                                                            for($i=0;$i<count($lcReceiveProductDetails);$i++){
                                                                echo "<td align='right'>".$lcReceiveProductDetails[$i]['receive_quantity']."<input type='hidden' value='".$lcReceiveProductDetails[$i]['receive_quantity']."' name='costProductQty[]'></td>";
                                                            }
                                                        ?>
                                                    </tr>
                                                    <tr>
                                                        <td>Unit Price $</td>
                                                        <td></td>
                                                        <?php
                                                            $totalDollarAmount=0;
                                                            $totalBdtAmout = 0;
                                                            for($i=0;$i<count($lcReceiveProductDetails);$i++){
                                                                $totalDollarAmount += $lcReceiveProductDetails[$i]['unit_dollar_price']*$lcReceiveProductDetails[$i]['receive_quantity'];
                                                                echo "<td align='right'>".$lcReceiveProductDetails[$i]['unit_dollar_price']."</td>";
                                                            }
                                                            $totalBdtAmout = $totalDollarAmount*$lcReceiveProductDetails[0]['dollar_rate'];
                                                            $grandLcToatal += $totalBdtAmout; 
                                                        ?>
                                                    </tr>
                                                    <tr>
                                                        <td>Amount $</td>
                                                        <td align='right'><?php echo number_format($totalDollarAmount,2);?></td>
                                                        <?php
                                                            for($i=0;$i<count($lcReceiveProductDetails);$i++){
                                                                $dollarAmount = $lcReceiveProductDetails[$i]['receive_quantity']*$lcReceiveProductDetails[$i]['unit_dollar_price'];
                                                                echo "<td align='right'>".number_format($dollarAmount,2)."</td>";
                                                            }
                                                        ?>
                                                    </tr>
                                                    <tr>
                                                        <td>Conversion Rate</td>
                                                        <td align='right'><?php echo $lcReceiveProductDetails[0]['dollar_rate'];?></td>
                                                        <td colspan="<?php echo count($lcReceiveProductDetails);?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Amount BDT</td>
                                                        <td align='right'><?php echo number_format($totalBdtAmout,2);?></td>
                                                        <?php
                                                            for($i=0;$i<count($lcReceiveProductDetails);$i++){
                                                                $bdtAmount = $lcReceiveProductDetails[$i]['receive_quantity']*$lcReceiveProductDetails[$i]['unit_dollar_price']*$lcReceiveProductDetails[0]['dollar_rate'];
                                                                echo "<td align='right'>".number_format($bdtAmount,2)."</td>";
                                                                $productWiseCost[$i] += $bdtAmount;
                                                            }
                                                        ?>
                                                    </tr>
                                                    <tr>
                                                        <td>Bill of Entry amount</td>
                                                        <td align='right'><?php echo number_format($totalBillofEntryAmount,2);?></td>
                                                        <?php
                                                            for($i=0;$i<count($lcReceiveProductDetails);$i++){
                                                                
                                                                echo "<td align='right'>".number_format($lcReceiveProductDetails[$i]['bill_of_entry'],2)."</td>";
                                                                $productWiseCost[$i] += $lcReceiveProductDetails[$i]['bill_of_entry'];
                                                            }
                                                            $grandLcToatal += $totalBillofEntryAmount;
                                                        ?>
                                                    </tr>
                                                    <?php
                                                    $netExpenses=0;
                                                    if (isset($lcCostingSummery)) {
                                                        if ($totalPremium>0) {
                                                                $totalPremium = ($totalPremium*$totalDollarAmount)/$lcDetails[0]['invoice_amount'];
                                                                $netExpenses += $totalPremium;
                                                                $grandLcToatal += $totalPremium;
                                                             
                                                    ?>
                                                        <tr>                                                        
                                                            <td>Insurance Premium</td>
                                                            <td align='right'> <?php echo number_format($totalPremium,2);?> </td>
                                                            <?php
                                                                for($i=0;$i<count($lcReceiveProductDetails);$i++){
                                                                  
                                                                        $bdtAmount = $lcReceiveProductDetails[$i]['receive_quantity']*$lcReceiveProductDetails[$i]['unit_dollar_price']*$lcReceiveProductDetails[$i]['dollar_rate'];
                                                                        $itemExpeses = $totalPremium>0 && $totalBdtAmout>0?($totalPremium*$bdtAmount/$totalBdtAmout):0;
                                                                    
                                                                    echo "<td align='right'>".number_format($itemExpeses,2)."</td>";
                                                                    $productWiseCost[$i] += $itemExpeses;
                                                                }
                                                            ?>
                                                        </tr>        
                                                    <?php
                                                        }
                                                        foreach ($lcCostingSummery as $costing) {
                                                            if( in_array($costing['costing_head'], array('LC Margin','LTR','Bill of Enrty','Under Invoice','Cash Retairment Amount')))
                                                                continue;
                                                            if ($costing['costing_head']=='Bank Charges') {
                                                                $totalBankCharge = ($totalBankCharge*$totalDollarAmount)/$lcDetails[0]['invoice_amount'];
                                                                $totalBankCharge += $costing['amount'];
                                                                $netExpenses += $totalBankCharge;
                                                                $grandLcToatal += $totalBankCharge;
                                                        ?>
                                                            <tr>                                                        
                                                                <td> <?php echo $costing['costing_head'];?> </td>
                                                                <td align='right'> <?php echo number_format($totalBankCharge,2);?> </td>
                                                                <?php
                                                                    for($i=0;$i<count($lcReceiveProductDetails);$i++){
                                                                        
                                                                            $bdtAmount = $lcReceiveProductDetails[$i]['receive_quantity']*$lcReceiveProductDetails[$i]['unit_dollar_price']*$lcReceiveProductDetails[$i]['dollar_rate'];
                                                                            $itemExpeses = $totalBankCharge && $totalBdtAmout?($totalBankCharge*$bdtAmount/$totalBdtAmout):0;
                                                                        
                                                                        echo "<td align='right'>".number_format($itemExpeses,2)."</td>";
                                                                        $productWiseCost[$i] += $itemExpeses;
                                                                    }
                                                                ?>
                                                            </tr>
                                                        <?php
                                                            } else{
                                                                $netExpenses += $costing['amount'];
                                                                $grandLcToatal += $costing['amount'];
                                                    ?>
                                                            <tr>                                                        
                                                                <td> <?php echo $costing['costing_head'];?> </td>
                                                                <td align='right'> <?php echo number_format($costing['amount'],2);?> </td>
                                                                <?php
                                                                    for($i=0;$i<count($lcReceiveProductDetails);$i++){
                                                                        if($costing['distribution_base']=='amount'){
                                                                            $bdtAmount = $lcReceiveProductDetails[$i]['receive_quantity']*$lcReceiveProductDetails[$i]['unit_dollar_price']*$lcReceiveProductDetails[$i]['dollar_rate'];
                                                                            $itemExpeses = $totalBdtAmout?($costing['amount']*$bdtAmount/$totalBdtAmout):0;
                                                                        } else {
                                                                            $itemExpeses = $totalReceiveQty?($costing['amount']*$lcReceiveProductDetails[$i]["receive_quantity"]/$totalReceiveQty):0;
                                                                        }
                                                                        echo "<td align='right'>".number_format($itemExpeses,2)."</td>";
                                                                        $productWiseCost[$i] += $itemExpeses;
                                                                    }
                                                                ?>
                                                            </tr>
                                                    <?php
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                    
                                                    <tr>
                                                        <td>Assembly chargessembly charge $</td>
                                                        <td align='right'><?php echo number_format($totalUnderInvoiceDollar,2);?></td>
                                                        <?php
                                                            for($i=0;$i<count($lcReceiveProductDetails);$i++){
                                                                
                                                                echo "<td align='right'>".number_format($lcReceiveProductDetails[$i]['dollar_amount'],2)."</td>";
                                                            }
                                                        ?>
                                                    </tr>
                                                    <tr>
                                                        <td>Assembly charge Conversion Rate </td>
                                                        <td align='right'><?php echo number_format($lcReceiveProductDetails[0]['dollar_conversion_rate'],2);?></td>
                                                        <?php
                                                            for($i=0;$i<count($lcReceiveProductDetails);$i++){
                                                                
                                                                echo "<td align='right'>".number_format($lcReceiveProductDetails[$i]['dollar_conversion_rate'],2)."</td>";
                                                            }
                                                        ?>
                                                    </tr>
                                                    <tr>
                                                        <td>Assembly charge BDT</td>
                                                        <td align='right'><?php echo number_format($totalUnderInvoiceBdt,2);?></td>
                                                        <?php
                                                            for($i=0;$i<count($lcReceiveProductDetails);$i++){
                                                                
                                                                echo "<td align='right'>".number_format($lcReceiveProductDetails[$i]['invoice_amount'],2)."</td>";
                                                                $productWiseCost[$i] += $lcReceiveProductDetails[$i]['invoice_amount']; 
                                                            }
                                                            $grandLcToatal += $totalUnderInvoiceBdt;
                                                        ?>
                                                    </tr>
                                                    <tr>
                                                        <td>Grand Total BDT</td>
                                                        <td align='right'><?php echo number_format($grandLcToatal,2);?></td>
                                                        <?php
                                                            for($i=0;$i<count($lcReceiveProductDetails);$i++){
                                                                
                                                                echo "<td align='right'>".number_format($productWiseCost[$i],2)."</td>";
                                                               
                                                            }
                                                        ?>
                                                    </tr>
                                                    <tr>
                                                        <td>Rate / Unit</td>
                                                        <td align='right'></td>
                                                        <?php
                                                            for($i=0;$i<count($lcReceiveProductDetails);$i++){
                                                                $unitPrice = $lcReceiveProductDetails[$i]['receive_quantity']?($productWiseCost[$i]/$lcReceiveProductDetails[$i]['receive_quantity']):0;
                                                                echo "<td align='right'>".number_format($unitPrice,2)."<input type='hidden' value='".number_format($unitPrice,2)."' name='productUnitPrice[]'></td>";
                                                               
                                                            }
                                                        ?>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->
                                    <div class="row">
                                        <div class="col-xs-4"> LC close Type</div>
                                        <div class="col-xs-4"> 
                                            <select class="select select2" style="width: 100%" name="lcClosedType" id="lcClosedType">
                                                <option value="">Slect Option</option>
                                                <option value="partila">Partial</option>
                                                <option value="full">Full</option>              
                                            </select>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="saveCosting()">Save changes</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

                    <!-- PI Edit -->
                    <div class="modal fade" id="piEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Edit Proforma Invoice</h4>
                                </div>
                                <div class="modal-body">
                                    <form role="form" action="" method="post" name="frmPiEdit" id="frmPiEdit">
                                        
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="editPI()">Save changes</button>
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

               <!-- LC BANK AMENMENT MODAL -->

                    <div class="modal fade" id="lcBankAmenment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Lc Bank Charge Amenment</h4>
                                </div>
                                <div class="modal-body">
                                    <form role="form" action="" name="frmLcAmenment" id="frmLcAmenment" method="post">
                                        <div class="form-group">
                                            <label>LC Number</label>
                                            <input type="text" class="form-control" placeholder="Enter ..." id="amenmentlcNumber" value="<?php echo $lcDetails[0]['lc_no'];?>" name="amenmentlcNumber" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Date</label>
                                            <input type="text" class="form-control" placeholder="Enter ..." id="amenmentDate" value="<?php echo date('m/d/Y');?>" name="amenmentDate" >
                                        </div>
                                        
                                        <table class="table table-bordered table-striped" >
                                            <tr>
                                                <th>Cost Head</th>
                                                <th>BDT Amount</th>
                                                <th>Account No</th>
                                            </tr>
                                            <tr>
                                                <td>Bank Charge</td>
                                                <td><input type="text" class="form-control" placeholder="Enter ..." name="bankAmenmentAmount" id="bankAmenmentAmount" ></td>
                                                <td><?php echo $lcDetails[0]['account_no'];?></td>
                                            </tr>
                                            <tr>
                                                <td>LC Margin</td>
                                                <td><input type="text" class="form-control" placeholder="Enter ..." name="marginAmenmentAmount" id="marginAmenmentAmount" ></td>
                                                <td><?php echo $lcDetails[0]['account_no'];?></td>
                                            </tr>
                                            
                                        </table>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick='saveBankLcAmenment()'>Save changes</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->


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
           var totalUnderInvoiceAmount = 0;
           var totalUnderInvoiceDollar = 0;
           var totalBillofEntryAmount = 0;
           var oldValue='';
                $(function () {
                   $(".select2").select2();
                   $("#releaseDate").datepicker();
                   $("#amenmentDate").datepicker();
                   $("#candfDate").datepicker();
                   $("#receiveDate").datepicker();
                   $("#ltrMaturityDate").datepicker();
                   $("#billofEntryDate").datepicker();
                   $("#underInvoiceDate").datepicker();
                   $("#underInvoiceDate").datepicker();
                   $("#expensesDate").datepicker();
                   $("#productName").keyup(function(){
                       $("#productDescription").val($("#productName").val());
                   });

                   
                });
                
                var showPIEdit = function () {
                   $.ajax({
                       type: "POST",
                       url: '<?php echo base_url()?>lcmanagement/pidetailsedit/<?php echo $lcDetails[0]['lc_id'];?>',
                       data : $('#frmDocRelease').serialize(),
                       
                       success: function(response) {
                            $("#frmPiEdit").html(response);
                            $("#piEdit").modal('show');

                       }
                   });
                };
                var saveDocRelease = function () {
                    var docsValue = parseFloat($("#docsValue").val());
                    var dollarRate = parseFloat($("#dollarRate").val());
                    if($("#docsValue").val()=='' || dollarRate<=0){
                        alert("You need to enter valid document value");
                    } else if($("#dollarRate").val()=='' || dollarRate<=0){
                        alert("You need to enter valid dollar rate");
                    } else{
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
                        }
                    };

                var editPI = function () {
                   $.ajax({
                       type: "POST",
                       url: '<?php echo base_url()?>lcmanagement/updatepi/<?php echo $lcDetails[0]['lc_id'];?>',
                       data : $('#frmPiEdit').serialize(),
                       beforeSend: function () {
                           $("#loader").show();
                       },
                       success: function(response) {
                           window.location='<?php echo base_url()?>lcmanagement/lcdetails/<?php echo $lcDetails[0]['lc_id'];?>'
                       }
                   });
                };

                var saveBankLcAmenment = function () {
                   $.ajax({
                       type: "POST",
                       url: '<?php echo base_url()?>lcmanagement/lcbankamenment/<?php echo $lcDetails[0]['lc_id'];?>',
                       data : $('#frmLcAmenment').serialize(),
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
                var saveAllExpenses = function () {
                    if($("#headName").val()==''){
                        alert("Enter the Cost Head Name");
                        $("#headName").focus();
                    } else if($("#headAmount").val()==''){
                        alert("Enter the cost amount");
                        $("#headAmount").focus();
                    } else if($("#distributionBase").val()==''){
                        alert("Select Distribution Base");
                        $("#distributionBase").focus();
                    } else {
                        $.ajax({
                           type: "POST",
                           url: '<?php echo base_url()?>lcmanagement/allexpenses/<?php echo $lcDetails[0]['lc_id'];?>',
                           data : $('#frmallexpenses').serialize(),
                           beforeSend: function () {
                               $("#loader").show();
                           },
                           success: function(response) {
                               window.location='<?php echo base_url()?>lcmanagement/lcdetails/<?php echo $lcDetails[0]['lc_id'];?>'
                           }
                        });
                    }
                };
                var savebillofentry = function () {
                    if(totalBillofEntryAmount <= 0){
                        alert("You did not enter any amount!!");
                    } else {
                        $.ajax({
                           type: "POST",
                           url: '<?php echo base_url()?>lcmanagement/savebillofentry/<?php echo $lcDetails[0]['lc_id'];?>',
                           data : $('#frmBillofEntry').serialize(),
                           beforeSend: function () {
                               $("#loader").show();
                           },
                           success: function(response) {
                               window.location='<?php echo base_url()?>lcmanagement/lcdetails/<?php echo $lcDetails[0]['lc_id'];?>'
                           }
                        });
                    }
                };
                var saveUnderInvoice = function () {
                    if($("#underInvoiceNumber").val()==''){
                        alert("Enter the Invoice Number");
                        $("#underInvoiceNumber").focus();
                    } else if($("#underInvoiceDollarRate").val()==''){
                        alert("Enter the Dollar Conversion Rate");
                        $("#underInvoiceDollarRate").focus();
                    } else {
                        $.ajax({
                           type: "POST",
                           url: '<?php echo base_url()?>lcmanagement/saveUnderInvoice/<?php echo $lcDetails[0]['lc_id'];?>',
                           data : $('#frmUnderInvoice').serialize(),
                           beforeSend: function () {
                               $("#loader").show();
                           },
                           success: function(response) {
                               window.location='<?php echo base_url()?>lcmanagement/lcdetails/<?php echo $lcDetails[0]['lc_id'];?>'
                           }
                        });
                    }
                };

                var saveCosting = function () {
                    if($("#lcClosedType").val()==''){
                        alert("Select LC Close Option!");
                        $("#lcClosedType").focus();
                    } else{
                        $.ajax({
                           type: "POST",
                           url: '<?php echo base_url()?>lcmanagement/lcrateupdate/<?php echo $lcDetails[0]['lc_id'];?>',
                           data : $('#frmcosting').serialize(),
                           beforeSend: function () {
                               $("#loader").show();
                           },
                           success: function(response) {
                               window.location='<?php echo base_url()?>lcmanagement/lcdetails/<?php echo $lcDetails[0]['lc_id'];?>'
                           }
                        });
                    }
                };
                
                var getCurrentValue = function(productId){
                    oldValue = $("#billofEntryAmount_"+productId).val();
                };

                var showTotalBillofEntry = function(productId){
                    if(oldValue!=''){
                        totalBillofEntryAmount -= parseFloat(oldValue);
                    }
                    var billofEntryAmount = $("#billofEntryAmount_"+productId).val();
                    if(billofEntryAmount!=''){
                        totalBillofEntryAmount += parseFloat(billofEntryAmount);
                    }
                    $("#totalBillofEntryAmount").val(totalBillofEntryAmount.toFixed(2));
                };

                var showTotal= function(productId){
                    var productQty =  $("#invoiceProductQty_"+productId).val();
                    var unitPrice =  $("#invoiceRate_"+productId).val();
                    var dollarRate =  $("#underInvoiceDollarRate").val();
                    var privAmount = $("#invoiceAmountBdt_"+productId).val();
                    var privDollarAmount = $("#invoiceAmountDollar_"+productId).val();
                    if(privAmount!=''){
                       totalUnderInvoiceAmount -= parseFloat(privAmount);
                        totalUnderInvoiceDollar -= parseFloat(privDollarAmount);
                    }
                    if(parseFloat(productQty) >0 &&  parseFloat(dollarRate)>0 && unitPrice!=''){
                        
                        var productdollarAmount = parseFloat(productQty)*parseFloat(unitPrice);
                        var productBdtAmount = parseFloat(productdollarAmount)*parseFloat(dollarRate);
                        $("#invoiceAmountDollar_"+productId).val(productdollarAmount.toFixed(2)); 
                        $("#invoiceAmountBdt_"+productId).val(productBdtAmount.toFixed(2)); 
                        totalUnderInvoiceDollar += parseFloat(productdollarAmount);
                        totalUnderInvoiceAmount += parseFloat(productBdtAmount);
                        
                    } else{
                        alert("Check your Entry");
                        $("#invoiceAmountDollar_"+productId).val(''); 
                        $("#invoiceAmountBdt_"+productId).val(''); 
                        $("#invoiceRate_"+productId).val('');
                        $("#invoiceRate_"+productId).focus();
                    }
                    $("#totalUnderInvoiceAmount").val(totalUnderInvoiceAmount.toFixed(2));
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
