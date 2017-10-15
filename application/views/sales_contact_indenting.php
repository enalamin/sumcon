<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Sumcon Biotechnology | Sales Contact for Indenting</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.5 -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/AdminLTE.min.css">
	<!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/skins/_all-skins.min.css">
	<!-- iCheck -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/iCheck/flat/blue.css">
	<!-- Morris chart -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/morris/morris.css">
	<!-- jvectormap -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/jvectormap/jquery-jvectormap-1.2.2.css">
	<!-- Date Picker -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/datepicker/datepicker3.css">
	<!-- Daterange picker -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/daterangepicker/daterangepicker-bs3.css">
	<!-- bootstrap wysihtml5 - text editor -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/select2/select2.min.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

	<?php include_once "header.php"; ?>
	<!-- Left side column. contains the logo and sidebar -->
	<?php include_once "sidebar.php"; ?>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Sales
        		<small>Sales contact for Indenting</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?php echo base_url()?>"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Sales</li>
        		<li class="active">Sales contact for Indenting</li>
			</ol>
		</section>
        <section class="content">
        	<form role="form" action="<?php echo base_url()?>sales/salescontactforindenting" method="post">	
            	<div class="box box-default">
                	<div class="box-header with-border">
              			<h3 class="box-title">Sales contact for Indenting</h3>
                	</div><!-- /.box-header -->
        			<div class="box-body">
        				<div class="row form-group ">
        					<div class="col-xs-6">
								<label>Proforma Invoice No</label>
								<input type="text" class="form-control" placeholder="Enter ..." id="pino" name="pino" required>
							</div>
	              			<div class="col-xs-6">
								<label>Date</label>
	                     		<input type="text" class="form-control" placeholder="Enter ..." id="datemask" value="<?php echo date('m/d/Y');?>" name="datemask" required>
							</div>
						</div>
                		<div class="row form-group">
                			<div class="col-xs-6">
                         		<label>Supplier Name</label>
								<select class="form-control select2" name="supplier" id="supplier" required>
								    <option value="">Select Supplier</option>
								    <?php
								        if(is_array($clientList)){
								            foreach ($clientList as $client){
								    ?>
								            <option value="<?php echo $client["client_id"];?>"><?php echo $client["client_name"];?></option>
								    <?php
								            }
								        }
								    ?>
								</select>
                        	</div>
                            <div class="col-xs-3">
                                <label>Dollar Conversion Rate</label>
                                <input type="text" class="form-control" placeholder="Enter ..." id="dollarRate" name="dollarRate" onchange="calculateCommission()" required>
                            </div>
                            <div class="col-xs-3">
                                <label>Commission Date</label>
                                <input type="text" class="form-control" placeholder="Enter ..." id="commissionDate" value="<?php echo date('m/d/Y');?>" name="commissionDate" required>
                            </div>
						</div>					
						
	                    <div class="row form-group">
                            <div class="col-xs-12">
                                <label>Invoice Details</label>

                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Sale value In Kg $</th>
                                            <th>Actual value In Kg $</th>
                                            <th>Total Sale value</th>
                                            <th>Total Actual value</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                <select class="form-control select2" name="productDescription" id="productDescription" >
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
                                            </td>
                                            <td><input type="text" class="form-control" id="quantity" name="quantity" placeholder="Enter ..." onchange="calculate()" ></td>
                                            <td><input type="text" class="form-control" id="saleValuePerKg" name="saleValuePerKg" placeholder="Enter ..." onchange="calculateSaleVlue()"></td>
                                            <td><input type="text" class="form-control" id="actualValuePerKg" name="actualValuePerKg" placeholder="Enter ..." onchange="calculateActualVlue()"></td>
                                            <td><input type="text" class="form-control" id="saleValue" name="saleValue" placeholder="Enter ..." readonly></td>
                                            <td><input type="text" class="form-control" id="actualValue" name="actualValue" placeholder="Enter ..." readonly></td>
                                        </tr>
                                        <tr>
                                            <th>Payee</th>
                                            <th>Commission In Kg($)</th>
                                            <th>Commission %</th>
                                            <th>Commission Amount $</th>
                                            <th>Commission Amount BDT</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                <select id="employee" name="employee"  class="form-control select2">
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
                                            <td><input type="text" class="form-control" id="commissionPerKg" name="commissionPerKg" placeholder="Enter ..." onchange="calculateCommission()"></td>
                                            <td><input type="text" class="form-control" id="commissionPercent" name="commissionPercent" placeholder="Enter ..." onchange="calculateCommission()"></td>
                                            <td><input type="text" class="form-control" id="commissionDollarAmount" name="commissionDollarAmount" placeholder="Enter ..." readonly></td>
                                            <td><input type="text" class="form-control" id="commissionBdtAmount" name="commissionBdtAmount" placeholder="Enter ..." readonly></td>
                                            <td><input id="btn_add" name="btn_add" type="button" class="btn btn-primary btn-block" value="Add" /></td>
                                        </tr>
                                    
                                </table>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12">
                                <br>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-xs-12">
                                <table id="griddetails" class="table table-bordered table-hover">
	                                <thead>
	                                	<tr>
		                                    <th width="20%">Product</th>
		                                    <th>Quantity</th>
                                            <th>Sale value In Kg $</th>
                                            <th>Actual value In Kg $</th>
                                            <th>Total Sale value</th>
                                            <th>Total Actual value</th>
		                                    <th>Employee</th>
		                                    <th>Commission In Kg($)</th>
		                                    <th>Commission %</th>
                                            <th>Commission Amount $</th>
		                                    <th>Commission Amount BDT</th>
		                                    <th>&nbsp;</th>
	                                  	</tr>
	                                </thead>
	                                <tbody>
	                                </tbody>
                                    <tfoot>
                                         <tr>
                                             <td>Total<input type="hidden" id="totalItemRow" name="totalItemRow" placeholder="Enter ..."></td>
                                             <td><input type="text" class="form-control" id="quantityTotal" name="quantityTotal" value="" ></td>
                                             <td></td>
                                             <td></td>
                                             <td><input type="text" class="form-control" id="saleValueTotal" name="saleValueTotal" value="" ></td>
                                             <td><input type="text" class="form-control" id="actualValueTotal" name="actualValueTotal" value="" ></td>
                                             <td></td>
                                             <td></td>
                                             <td></td>
                                             <td><input type="text" class="form-control" id="commissionDollarAmountTotal" name="commissionDollarAmountTotal" value="" ></td>
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
              	</div>
			</form>
        </section>
	<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
	<?php include_once 'footer.php';?>


</div><!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="<?php echo base_url(); ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
	$.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.5 -->
<script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/select2/select2.full.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url(); ?>plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo base_url(); ?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url(); ?>plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url(); ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo base_url(); ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url(); ?>plugins/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->

<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>dist/js/demo.js"></script>
<!-- page script -->
    <script>
    var i=0;
   	var totalSaleValue=totalActualValue=totalCommissionDollarAmount=totalCommissionBdtAmount = totalQty=totalEmpCommission=0;
  	$(function () {
        $("#example1").DataTable();
        $(".select2").select2();
        $("#datemask").datepicker();
        $("#commissionDate").datepicker();
        $("#quantity").change(function(){
            calculate();
        });
        $("#unitprice").change(function(){
            calculate();
        });
        $("#btn_add").click(function(){
            var product=$("#productDescription").val();
            var productDescription=$("#productDescription option:selected").text();
            var productQuantity=$("#quantity").val();
            var saleValuePerKg=$("#saleValuePerKg").val();
            var actualValuePerKg=$("#actualValuePerKg").val();
            var saleValue=$("#saleValue").val();
            var actualValue=$("#actualValue").val();
            var employeeId=$("#employee").val();
            var employeeName=$("#employee option:selected").text();
            var commissionPerKg=$("#commissionPerKg").val();
            var commissionPercent=$("#commissionPercent").val();
            var commissionDollarAmount=$("#commissionDollarAmount").val();
            var commissionBdtAmount=$("#commissionBdtAmount").val();
            var currentContent = $("#griddetails").html();
            if(product!='' && commissionBdtAmount!='' && commissionBdtAmount>0){
                totalQty += parseFloat(productQuantity);
                totalSaleValue += parseFloat(saleValue);
                totalActualValue += parseFloat(actualValue);
                totalCommissionDollarAmount += parseFloat(commissionDollarAmount);
                totalCommissionBdtAmount += parseFloat(commissionBdtAmount);
                $("#griddetails").append("<tr>"
                    +"<td>"+productDescription+"<input type='hidden' name='productid[]' value='"+product+"'></td>"
                    +"<td class='itemQty'>"+productQuantity+"<input type='hidden' name='productQty[]' value='"+productQuantity+"'></td>"
                    +"<td>"+saleValuePerKg+"<input type='hidden' name='productSaleValuekg[]' value='"+saleValuePerKg+"'></td>"
                    +"<td>"+actualValuePerKg+"<input type='hidden' name='productActualValuekg[]' value='"+actualValuePerKg+"'></td>"
                    +"<td class='itemSaleValue'>"+saleValue+"<input type='hidden' name='productSaleValue[]' value='"+saleValue+"'></td>"
                    +"<td class='itemActualValue'>"+actualValue+"<input type='hidden' name='productActualValue[]' value='"+actualValue+"'></td>"
                    +"<td >"+employeeName+"<input type='hidden' name='employeeid[]' value='"+employeeId+"'></td>"
                    +"<td>"+commissionPerKg+"<input type='hidden' name='productCommissionPerKg[]' value='"+commissionPerKg+"'></td>"
                    +"<td>"+commissionPercent+"<input type='hidden' name='productCommissionPercent[]' value='"+commissionPercent+"'></td>"
                    +"<td class='itemCommissionDollarAmount'>"+commissionDollarAmount+"<input type='hidden' name='productCommissionDollarAmount[]' value='"+commissionDollarAmount+"'></td>"
                    +"<td class='itemCommissionBdtAmount'>"+commissionBdtAmount+"<input type='hidden' name='productCommissionBdtAmount[]' value='"+commissionBdtAmount+"'></td>"
                    +"<td><button type='button' class='removebutton' title='Remove this row'>X</button></td></tr>");
                restproductrow();
                i++;
                $("#totalItemRow").val(i);
            }
            else{
                alert("check your entry");
            }
            if(i>0){
                $("#showControl").show();
                $("#quantityTotal").val(totalQty.toFixed(2));
                $("#saleValueTotal").val(totalSaleValue.toFixed(2));
                $("#actualValueTotal").val(totalActualValue.toFixed(2));
                $("#commissionDollarAmountTotal").val(totalCommissionDollarAmount.toFixed(2));
                $("#commissionBdtAmountTotal").val(totalCommissionBdtAmount.toFixed(2));
            }
            else{
                $("#showControl").hide();
            }
        });			
  	});
  	$(document).on('click', 'button.removebutton', function () {
		if(confirm("Do you want to remove this?")){
			var currentRowTotal = $(this).closest('tr').find('.itemTotal').text();
			$(this).closest('tr').remove();
			invoiceTotal -= parseFloat(currentRowTotal);
			i--;
			if(i>0){
				$("#showControl").show();
				$("#invoiceTotal").val(invoiceTotal.toFixed(2));
			}
			else{
				$("#showControl").hide();
			}
		}
		return false;
	});
    function calculate()
    {
        calculateSaleVlue();
        calculateActualVlue();
        calculateCommission();
    }
    function restproductrow()
    {
        $("#productDescription").val("");
        $("#quantityTotal").val('');
        $("#saleValueTotal").val('');
        $("#actualValueTotal").val('');
        $("#commissionDollarAmountTotal").val('');
        $("#commissionBdtAmountTotal").val('');
    }

    var calculateSaleVlue = function(){
        var quantity = $("#quantity").val();
        var saleValuePerKg = $("#saleValuePerKg").val();
        if(quantity!='' && saleValuePerKg !=''){
            var saleValue = parseFloat(quantity)*parseFloat(saleValuePerKg);
            $("#saleValue").val(saleValue.toFixed(2));
        } else {
             $("#saleValue").val('');
        }
    };

    var calculateActualVlue = function(){
        var quantity = $("#quantity").val();
        var actualValuePerKg = $("#actualValuePerKg").val();
        if(quantity!='' && actualValuePerKg !=''){
            var actualValue = parseFloat(quantity)*parseFloat(actualValuePerKg);
            $("#actualValue").val(actualValue.toFixed(2));
        } else {
            $("#actualValue").val('');
        }
    };

    var calculateCommission = function(){
        var quantity = $("#quantity").val();
        var commissionPerKg = $("#commissionPerKg").val();
        var commissionPercent = $("#commissionPercent").val();
        if(quantity!='' && commissionPerKg !=''){
            $("#commissionPercent").val('');
            $("#commissionPercent").hide();
            var commissionDollarAmount = parseFloat(quantity)*parseFloat(commissionPerKg);
            $("#commissionDollarAmount").val(commissionDollarAmount.toFixed(2));
            var dollarRate = $("#dollarRate").val();
            var commissionBdtAmount='';
            if(dollarRate!=''){
                commissionBdtAmount = parseFloat(commissionDollarAmount)*parseFloat(dollarRate);
            }
            $("#commissionBdtAmount").val(commissionBdtAmount.toFixed(2));
        }else if(quantity!='' && commissionPercent !=''){
            $("#commissionPerKg").val('');
            $("#commissionPerKg").hide();
            var commissionDollarAmount = parseFloat(quantity)*parseFloat(commissionPercent)/100;
            $("#commissionDollarAmount").val(commissionDollarAmount.toFixed(2));
            var dollarRate = $("#dollarRate").val();
            var commissionBdtAmount='';
            if(dollarRate!=''){
                commissionBdtAmount = parseFloat(commissionDollarAmount)*parseFloat(dollarRate);
            }
            $("#commissionBdtAmount").val(commissionBdtAmount.toFixed(2));
        } else{
            $("#commissionDollarAmount").val('');
            $("#commissionBdtAmount").val('');
            $("#commissionPerKg").show();
            $("#commissionPercent").show();
        }
    };

    var calculateEmployeeCommission = function(){
        var employeeCommission = 0;
        var employeeCommissionRate = $("#empCommissionRate").val();
        //alert(employeeCommissionRate);

        if(totalCommissionBdtAmount<=0){
            alert("You need to calculate the Sales Commission!!");
        } else if(parseFloat(employeeCommissionRate)<=0){
            alert("Invalid commission Rate");
            $("#empCommissionRate").val('');
            $("#empCommissionRate").focus();
        } else{
            employeeCommission = totalCommissionBdtAmount*employeeCommissionRate/100;
            $("#empCommissionAmount").val(employeeCommission);
        }
    };
    </script>
</body>
</html>
