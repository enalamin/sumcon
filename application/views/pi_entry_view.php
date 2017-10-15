<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Sumcon Biotechnology | Payment Entry</title>
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
				LC Management
        		<small>Proforma Invoice Info entry for LC</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?php echo base_url()?>"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">LC Management</li>
        		<li class="active">Proforma Invoice Info entry for LC</li>
			</ol>
		</section>
        <section class="content">
        	<form role="form" action="<?php echo base_url()?>lcmanagement/createpi" method="post">	
            	<div class="box box-default">
                	<div class="box-header with-border">
              			<h3 class="box-title">Proforma Invoice Info entry for LC</h3>
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
                			<div class="col-xs-12">
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
						</div>					
						
						<div class="row form-group">
                			<div class="col-xs-6">
								<label>Supplier Bank Info</label>
								<textarea class="form-control" rows="3" placeholder="Enter ..." name="bankInfo" ></textarea>
                  			</div>
	                        <div class="col-xs-6">
                          		<label>Remarks</label>
                          		<input type="text" class="form-control" placeholder="Enter ..." name="remarks">
	                        </div>
                        </div>
	                    
	                    <div class="row form-group">
                            <div class="col-xs-12">
                                <label>Invoice Details</label>

                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-3">
                                <label>Product</label>
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
                            </div>
                            <div class="col-xs-2">
                                <label>Quantity </label>
                                <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Enter ...">
                            </div>
                            <div class="col-xs-1">
                                <label> unit </label>
                                <select class="form-control select2" id="unit" name="unit">
                                	<option>KG</option>
                                    <option>Pice</option>
                                    <option>CM</option>
                                    <option>MM</option>
                                </select>
                            </div>
                            <div class="col-xs-1">
                                <label>unit price ($)</label>
                                <input type="text" class="form-control" id="unitprice" name="unitprice" placeholder="Enter ...">
                            </div>
                          	<div class="col-xs-2">
                                <label>Amount ($)</label>
                                <input type="text" class="form-control" id="amount" name="amount" placeholder="Enter ...">
                            </div>
                            <div class="col-xs-2">
                                <label>Package Info</label>
                                <input type="text" class="form-control" id="package" name="package" placeholder="Enter ...">
                            </div>
                             <div class="col-xs-1">
                                <label>&nbsp; </label>
                                <input id="btn_add" name="btn_add" type="button" class="btn btn-primary btn-block" value="Add" />
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
		                                    <th>Description</th>
		                                    <th>Quantity</th>
		                                    <th>Unit</th>
		                                    <th>Unit Price($)</th>
		                                    <th>Amount ($)</th>
		                                    <th>Package Info</th>
		                                    <th>&nbsp;</th>
	                                  	</tr>
	                                </thead>
	                                <tbody>
	                                </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row form-group" id="showControl" style="display: none;">
                        	<div class="col-xs-12" style="text-align: right; padding-right: 100px;">
                            	<label> Invoice Total $</label>
                            	<input type="text" id="invoiceTotal" name="invoiceTotal" value="" >
                            	<br/><br/>
                        	</div>
	                        <div class="col-xs-6">
	                            <input type="hidden" id="totalItemRow" name="totalItemRow" placeholder="Enter ...">
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
   	var invoiceTotal=0;
  	$(function () {
        $("#example1").DataTable();
        $(".select2").select2();
        $("#datemask").datepicker();
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
            var productUnit=$("#unit option:selected").text();
            var productPrice=$("#unitprice").val();
            var productAmount=$("#amount").val();
            var productPackage=$("#package").val();
            var currentContent = $("#griddetails").html();
            if(product!='' && productAmount!='' && productAmount>0){
                invoiceTotal += parseFloat(productAmount);
                $("#griddetails").append("<tr><td>"+productDescription+"</td><td>"+productQuantity+"</td><td>"+productUnit+"</td><td>"+productPrice+"</td><td class='itemTotal'>"+productAmount+"</td><td>"+productPackage+"</td>"
                +"<td><input type='hidden' name='productid[]' value='"+product+"'><input type='hidden' name='productQty[]' value='"+productQuantity+"'><input type='hidden' name='productPrice[]' value='"+productPrice+"'><input type='hidden' name='productPackge[]' value='"+productPackage+"'><button type='button' class='removebutton' title='Remove this row'>X</button></td></tr>");
                restproductrow();
                i++;
                $("#totalItemRow").val(i);
            }
            else{
                alert("check your entry");
            }
            if(i>0){
                $("#showControl").show();
                $("#invoiceTotal").val(invoiceTotal.toFixed(2));
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
        var productQuantity=$("#quantity").val();
        var productPrice=$("#unitprice").val();
        var amount = parseInt(productQuantity)*parseFloat(productPrice);
        if(!isNaN(amount)){
            amount = parseFloat(amount).toFixed(2);
        $("#amount").val(amount);
        }
    }
    function restproductrow()
    {
        $("#productDescription").val("");
        $("#quantity").val("");
        $("#unit").val("");
        $("#unitprice").val("");
        $("#amount").val("");
        $("#package").val("");
    }
    </script>
</body>
</html>
