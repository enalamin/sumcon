<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="tf-8">
	<meta http-equi="X-UA-Compatible" content="IE=edge">
	<title>Sumcon Biotechnology | Product Mixing</title>
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
	<!-- iCheck -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/iCheck/flat/blue.css">
	<!-- Morris chart -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/morris/morris.css">
	<!-- jvectormap -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/jvectormap/jquery-jvectormap-1.2.2.css">
	<!-- Date Picker -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/datepicker/datepicker3.css">
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
    	<div class="content-wrapper">
    		<!-- Content Header (Page header) -->
            <section class="content-header">
    			<h1>
    				Inventory
                    <small>Product Mixing Requisition Entry</small>
    			</h1>
    			<ol class="breadcrumb">
    				<li><a href="<?php echo base_url()?>"><i class="fa fa-dashboard"></i> Home</a></li>
    				<li class="active">Inventory </li>
                    <li class="active">Product Mixing Requisition Entry</li>
    			</ol>
    		</section>

            <section class="content">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">Product Mixing Requisition Entry</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <form role="form"  action="<?php echo base_url()?>productmixingrequisition/mixingRequisitionCreate" method="post">
                                    <div class="row form-group">
                                        <div class="col-xs-4">
                                            <label>Requisition Number</label>
                                            <input type="text" class="form-control" placeholder="Enter ..." name="requisitionNumber" value="<?php echo $requisitionNumber; ?>">
                                        </div>
                                        <div class="col-xs-4">
                                            <label>Requisition Date</label>
                                            <input type="text" class="form-control" placeholder="Enter ..." id="datemask" name="datemask" value="<?php echo date('m/d/Y');?>">
                                        </div>
                                        <div class="col-xs-4">
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
                                    </div>
                                    
                                    <div class="row form-group">
                                        <div class="col-xs-12">
                                            <label>Requisition For</label>
                                        </div>
                                        
                                        <div class="col-xs-6">
                                            <div id="oldproductlist">
                                                <select class="form-control select2" name="productId" id="productId" >
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
                                            <div id="newproductinfo" style="display: none;">
                                                <div class="form-group">
                                                    <label>Product Name</label>
                                                    <input type="text" class="form-control" placeholder="Enter ..." name="productName" id="productName">
                                                </div>
                                                <div class="form-group">
                                                    <label>Product Model</label>
                                                    <input type="text" class="form-control" placeholder="Enter ..." name="productModel">
                                                </div>
                                                <div class="form-group">
                                                    <label>Product Description</label>
                                                    <textarea class="form-control" rows="3" placeholder="Enter ..." name="productDescription" id="newProductDescription"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <input type="checkbox" name="ckNewProduct" id="ckNewProduct" value="1"> Create New Product
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-12">
                                            <br>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-12">
                                            <label>Details</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
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
                                        <div class="col-xs-1">
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
                                        <div class="col-xs-2">
                                            <label>Rate</label>
                                            <input type="text" class="form-control" id="rate" name="rate" placeholder="Enter ...">
                                        </div>
                                        <div class="col-xs-4">
                                            <label>Remarks </label>
                                            <input type="text" class="form-control" id="remarks" name="remarks" placeholder="Enter ...">
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
                                                        <th>Rate</th>
                                                        <th>Remarks</th>
                                                        <th>&nbsp;</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="form-group" id="showControl" style="display: none;">
                                        <div class="col-xs-6">
                                            <input type="hidden" id="totalItemRow" name="totalItemRow" placeholder="Enter ...">
                                            <input id="btn_save" name="btn_save" type="submit" class="btn btn-primary btn-block" value="Save" />
                                        </div>
                                        <div class="col-xs-6">
                                            <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-block btn-danger" value="Cancel" />
                                        </div>
                                    </div>
                              </form>
                            </div><!-- /.box-body -->
                        </div>
                    </div>
                </div>
            </section>
    	</div><!-- /.content-wrapper -->
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
    <script src="<?php echo base_url(); ?>plugins/select2/select2.full.min.js"></script>
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
        $(function () {
            $("#example1").DataTable();
            $(".select2").select2();
            $("#datemask").datepicker();
            $("#productDescription").change(function(){
                var productId = parseInt($(this).val());
                if(productId>0){
                    $.ajax({
                        type: "POST",
                        url: '<?php echo base_url()?>productmixingrequisition/getproductrate/'+productId,
                        dataType: 'json',
                        complete: function(data){
                            var responses = data.responseText;
                            $("#rate").val(responses);
                        }
                    });
                } else{
                    alert("select Party");    
                }
            });          

            $("#productId").change(function(){
                var productId = parseInt($(this).val());
                if(productId>0){
                    $.ajax({
                        type: "POST",
                        url: '<?php echo base_url()?>productmixingrequisition/getproductrecipe/'+productId,
                        dataType: 'json',
                        complete: function(data){
                            var responses = jQuery.parseJSON(data.responseText);
                            if(responses.length>0){
                                $("#griddetails > tbody").html('');
                                for (var j = 0; j < responses.length; j++){                              
                                    var obj = responses[j];                              
                                    $("#griddetails").append("<tr><td>"+obj.product_description+"</td><td>"+obj.requir_quantity+" "+obj.product_unit+"</td><td>"+obj.product_rate+"</td><td></td>"+"<td><input type='hidden' name='productid[]' value='"+obj.requir_product_id+"'><input type='hidden' name='productQty[]' value='"+obj.requir_quantity+"'><input type='hidden' name='productRate[]' value='"+obj.product_rate+"'><input type='hidden' name='productRemarks[]' value=''><button type='button' class='removebutton' title='Remove this row'>X</button></td></tr>");
                                  
                                }
                                i= j;
                                $("#totalItemRow").val(i);
                                if(i>0){
                                    $("#showControl").show();
                                } else{
                                    $("#showControl").hide();
                                }
                            } else{
                                $("#griddetails > tbody").html('');
                            }
                        }
                    });
                } else{
                    alert("select Product");    
                }
            });          


            $("#btn_add").click(function(){
                var product=$("#productDescription").val(); 
                var productDescription=$("#productDescription option:selected").text(); 
                var productQuantity=$("#quantity").val(); 
                var productUnit=$("#unit option:selected").text(); 
                var productPackage=$("#rate").val(); 
                var productRmarks=$("#remarks").val(); 
                var currentContent = $("#griddetails").html();
                if(product!='' && productQuantity!='' && productQuantity>0){
                    $("#griddetails").append("<tr><td>"+productDescription+"</td><td>"+productQuantity+" "+productUnit+"</td><td>"+productPackage+"</td><td>"+productRmarks+"</td>"+"<td><input type='hidden' name='productid[]' value='"+product+"'><input type='hidden' name='productQty[]' value='"+productQuantity+"'><input type='hidden' name='productRate[]' value='"+productPackage+"'><input type='hidden' name='productRemarks[]' value='"+productRmarks+"'><button type='button' class='removebutton' title='Remove this row'>X</button></td></tr>");
                    restproductrow();
                    i++;
                    $("#totalItemRow").val(i);
                } else{
                    alert("check your entry");
                }

                if(i>0){
                    $("#showControl").show();
                } else{
                    $("#showControl").hide();
                }
            });

            $("#ckNewProduct").click(function(){
                $("#oldproductlist").toggle();
                $("#newproductinfo").toggle();
            });
        });
    
    	$(document).on('click', 'button.removebutton', function () {
    		if(confirm("Do you want to remove this?")){
    			$(this).closest('tr').remove();
    			i--;
    			if(i>0){
    				$("#showControl").show();
    			} else{
    				$("#showControl").hide();
    			}
    		}
    		return false;
    	});
    
        var claculate = function(){
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

    </script>

</body>

</html>



