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
                        <form id="frmgoodsreceive" name="frmgoodsreceive" action="<?php echo base_url()."sales/clculatelccommission/".$lcDetails[0]['lc_id']; ?>" method="post">
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
                                <input type="hidden" name="clientId" value="<?php echo $lcDetails[0]['client_id'];?>" >
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
                            <div class="col-xs-6 form-group">
                                <label>Commission Date</label>
                                <input type="text" class="form-control" placeholder="Enter ..." id="commissionDate" name="commissionDate" value="<?php echo date('m/d/Y');?>">
                            </div>
                            <div class="col-xs-6 form-group">
                                <label>Dollar Rate</label>
                                <input type="text" class="form-control" placeholder="Enter ..." id="dollartRate" name="dollartRate" value="<?php echo $lcDetails[0]['dollar_rate'];?>" >
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
                                            <th>Raet</th>
                                            <th>Amount</th>
                                            <th>Payee Name</th>
                                            <th>Commission In Kg</th>
                                            <th>Commission %</th>
                                            <th>Commission Amount </th>
                                            <th>&nbsp;</th>
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
                                            <td><?php echo $receive["receive_quantity"].' '.$receive["product_unit"];?><input type="hidden" name="invoiceQty[]" id="invoiceQty_<?php echo $receive["product_id"];?>" value="<?php echo $receive["receive_quantity"];?>" ></td>
                                            <td><?php echo $receive["unit_dollar_price"];?><input type="hidden" name="productsUnitPrice[]" id="productsUnitPrice_<?php echo $receive["product_id"];?>" value="<?php echo $receive["unit_dollar_price"];?>" ></td>
                                            <td><input type="text" class="form-control"  name="productAmount[]" id="productAmount_<?php echo $receive["product_id"];?>" value="<?php echo ($receive["receive_quantity"]*$receive["unit_dollar_price"]);?>" readonly></td>
                                            <td >
                                                <select id="employee_<?php echo $receive["product_id"];?>" name="employee[]"  class="form-control select2" style="width: 100%;">
                                                    <option value="">Select Payee</option>
                                                    <?php
                                                        if($clientList){
                                                            foreach ($clientList as $client) {
                                                                echo "<option value='".$client['client_id']."'>".$client['client_name']."</option>";
                                                            }
                                                        }
                                                    ?>
                                                </select>   
                                            </td>
                                            <td><input type="text" class="form-control"  name="commissionInKg[]" id="commissionInKg_<?php echo $receive["product_id"];?>" value="" onblur="checkvalidqty(<?php echo $receive["product_id"];?>)"></td>
                                            <td><input type="text" class="form-control"  name="commissionRate[]" id="commissionRate_<?php echo $receive["product_id"];?>" value="" onblur="checkvalidqty(<?php echo $receive["product_id"];?>)"></td>
                                            <td><input type="text" class="form-control"  name="commissionAmount[]" id="commissionAmount_<?php echo $receive["product_id"];?>" value="" ></td>
                                            <td><input id="btn_add_<?php echo $receive["product_id"];?>" name="btn_add[]" type="button" class="btn btn-primary btn-block" value="Add" onclick="addEmpCommission(<?php echo $receive["product_id"];?>,'<?php echo $receive["product_description"];?>')" /></td>
                                        </tr>
                                    <?php
                                        //$grandTotal += $invoice["itemtotal"];
                                        }
                                    ?>
                                    <tr>
                                        <td colspan="8">Total</td>
                                        <td ><input type="text" name="totalCommission" id="totalCommission" class="form-control" readonly="true"></td>
                                        <td >&nbsp;</td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                        
                    <div class="row form-group">
                            <div class="col-xs-12">
                                <table id="griddetails" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th width="20%">Product</th>
                                            <th>Quantity</th>
                                            <th>Sale value In Kg</th>
                                            <th>Total Sale value</th>
                                            <th>Payee</th>
                                            <th>Commission In Kg</th>
                                            <th>Commission %</th>
                                            <th>Commission Amount</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                         <tr>
                                             <td>Total<input type="hidden" id="totalItemRow" name="totalItemRow" placeholder="Enter ..."></td>
                                             <td></td>
                                             <td></td>
                                             <td></td>
                                             <td></td>
                                             <td></td>
                                             <td></td>
                                             
                                             <td><input type="text" class="form-control" id="commissionBdtAmountTotal" name="commissionBdtAmountTotal" value="" ></td>
                                             <td></td>
                                         </tr>
                                    </tfoot>
                                    
                                </table>
                            </div>
                        </div>
                        
                        <div class="row form-group" id="showControl" style="display: none;">
                            
                            <div class="col-xs-6">
                                <input id="btn_save" name="btn_save" type="submit" class="btn btn-primary btn-block" value="Save" />
                            </div>
                             <div class="col-xs-6">
                                 <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-block btn-danger" value="Cancel" />
                            </div>
                        </div>                  
                    </div><!-- /.box-body -->

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
                var totalCommission=0;
                var totalEmpCommission=i=0;

                $(function(){
                    $(".select2").select2();
                    $("#commissionDate").datepicker();

                });
                
            var checkvalidqty=function(productId){
                var dollartRate =  $("#dollartRate").val();
                var productAmount =  $("#productAmount_"+productId).val();
                var productQty =  $("#invoiceQty_"+productId).val();
                var commissionRate =  $("#commissionRate_"+productId).val();
                var commissionInKg =  $("#commissionInKg_"+productId).val();

                if(parseFloat(productAmount) > 0 && parseFloat(commissionRate) > 0 && dollartRate!=''){
                    var currentAmount = $("#commissionAmount_"+productId).val();
                    $("#commissionInKg_"+productId).val('');
                    $("#commissionInKg_"+productId).hide();
                    var commissionAmount = (parseFloat(productAmount)*parseFloat(commissionRate)/100)*parseFloat(dollartRate);
                    //totalCommission += commissionAmount;

                    $("#commissionAmount_"+productId).val(commissionAmount);
                    //$("#totalCommission").val(totalCommission);
                } else if(parseFloat(productAmount) > 0 && parseFloat(commissionInKg) > 0 && dollartRate!=''){
                    var currentAmount = $("#commissionAmount_"+productId).val();
                    $("#commissionRate_"+productId).val('');
                    $("#commissionRate_"+productId).hide();
                    var commissionAmount = parseFloat(productQty)*parseFloat(commissionInKg)*parseFloat(dollartRate);
                    //totalCommission += commissionAmount;

                    $("#commissionAmount_"+productId).val(commissionAmount);
                    //$("#totalCommission").val(totalCommission);
                }else {
                    $("#commissionRate_"+productId).val('');
                    $("#commissionRate_"+productId).show();
                    $("#commissionInKg_"+productId).val('');
                    $("#commissionInKg_"+productId).show();
                    $("#commissionAmount_"+productId).val('');
                } 
            };

            var addEmpCommission = function(productId,productDescription){
                var productQuantity=$("#invoiceQty_"+productId).val();
                var saleValuePerKg=$("#productsUnitPrice_"+productId).val();
                var saleValue=$("#productAmount_"+productId).val();
                var employeeId=$("#employee_"+productId).val();
                var employeeName=$("#employee_"+productId+" option:selected").text();
                var commissionPerKg=$("#commissionInKg_"+productId).val();
                var commissionPercent=$("#commissionRate_"+productId).val();
                var commissionBdtAmount=$("#commissionAmount_"+productId).val();
                var currentContent = $("#griddetails").html();
                if(productId!='' && commissionBdtAmount!='' && commissionBdtAmount>0 && employeeId!=''){
                    
                    totalCommission += parseFloat(commissionBdtAmount);
                    $("#griddetails").append("<tr>"
                        +"<td>"+productDescription+"<input type='hidden' name='comProductid[]' value='"+productId+"'></td>"
                        +"<td class='itemQty'>"+productQuantity+"<input type='hidden' name='comProductQty[]' value='"+productQuantity+"'></td>"
                        +"<td>"+saleValuePerKg+"<input type='hidden' name='productSaleValuekg[]' value='"+saleValuePerKg+"'></td>"
                        +"<td class='itemSaleValue'>"+saleValue+"<input type='hidden' name='productSaleValue[]' value='"+saleValue+"'></td>"
                        +"<td >"+employeeName+"<input type='hidden' name='comEmployeeid[]' value='"+employeeId+"'></td>"
                        +"<td>"+commissionPerKg+"<input type='hidden' name='productCommissionPerKg[]' value='"+commissionPerKg+"'></td>"
                        +"<td>"+commissionPercent+"<input type='hidden' name='productCommissionPercent[]' value='"+commissionPercent+"'></td>"
                        +"<td class='itemCommissionBdtAmount'>"+commissionBdtAmount+"<input type='hidden' name='productCommissionBdtAmount[]' value='"+commissionBdtAmount+"'></td>"
                        +"<td><button type='button' class='removebutton' title='Remove this row'>X</button></td></tr>");
                    //restproductrow();
                    i++;
                    $("#totalItemRow").val(i);
                }
                else{
                    alert("check your entry");
                }
                if(i>0){
                    $("#showControl").show();
                    
                    $("#commissionBdtAmountTotal").val(totalCommission.toFixed(2));
                }
                else{
                    $("#showControl").hide();
                }
            };

        
            $(document).on('click', 'button.removebutton', function () {
                if(confirm("Do you want to remove this?")){
                    var currentRowCommission = $(this).closest('tr').find('.itemCommissionBdtAmount').text();
                    $(this).closest('tr').remove();
                    i--;
                    totalCommission -= parseFloat(currentRowCommission);
                                     
                    $("#commissionBdtAmountTotal").val(totalCommission.toFixed(2));
                    
                }
                return false;
            });



           </script>
       </body>
</html>
