<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Sumcon Biotechnology | Order</title>
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

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
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
                                <small>Invoice Edit</small>
				
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?php echo base_url()?>"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Sales</li>
                                <li class="active">Invoice Edit</li>
			</ol>
		</section>
                <section class="content">
                    <div class="row">
                      <!-- left column -->
                      <div class="col-md-12">
                        <div class="box box-default">
                    <div class="box-header with-border">
                      <h3 class="box-title">Invoice Edit</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <form role="form"  action="<?php echo base_url()?>sales/invoice" method="post">
                          <div class="col-xs-5">
                            <label>Invoice Number</label>
                            <input type="text" class="form-control" placeholder="Enter ..." name="invoiceNumber" value="<?php echo $invoiceNumber; ?>">
                          </div>
                           <div class="col-xs-2">
                          </div>
                          <div class="col-xs-5">
                              <label>Invoice Date</label>s
                              <input type="text" class="form-control" placeholder="Enter ..." id="datemask" value="<?php echo date('m/d/Y');?>" name="datemask">
                          </div>
                          <!-- select -->
                         <!-- text input -->
                        <div class="form-group">
                            <div class="col-xs-12">
                                <label>Client Name</label>
                                <select class="form-control select2" name="client" id="client" required>
                                        <option value="">Select Client</option>
                                      <?php
                                          if(is_array($clientList)){
                                              foreach ($clientList as $client){
                                      ?>
                                              <option value="<?php echo $client["client_id"];?>" ><?php echo $client["client_name"];?></option>
                                      <?php
                                              }
                                          }
                                      ?>
                                    </select>
                            </div>
                        </div>
                         <div class="form-group">
                            <div class="col-xs-12">
                            
                                <label>Client Address</label>
                                <textarea name="clientAddress" id="clientAddress" class="form-control" required></textarea>
                            </div>
                        </div>
                         
                        <div class="form-group">
                            <div class="col-xs-12">
                                <label>Available deliveries for invoice</label>
                                
                            </div>
							
							<div class="col-xs-12" id="deliveryList">
                                
                                
                            </div>
							
                        </div>
                        
                         <div class="form-group">
                            <div class="col-xs-12">
                                <br>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-xs-12">
                                <label>Invoice Details</label>
                                
                            </div>
                        </div>
                                                
                        <div class="form-group">
                            <div class="col-xs-12">
                                <br>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-xs-12">
                                <table id="griddetails" class="table table-bordered table-hover" >
                                <thead>
                                  <tr>
                                    
                                    <th>Description</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Unit Price</th>
                                    <th>Amount</th>
                                    <th>&nbsp;</th>
                                    
                                  </tr>
								  
								  
                                </thead>
                                <tbody>
                                </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group" id="showControl" style="display:none;">
                        <div class="col-xs-12" style="text-align: right; padding-right: 100px;">
                            <label> Invoice Total</label>
                            <input type="text" id="invoiceTotal" name="invoiceTotal" value="">
                            <br/><br/>    <br/>        
                        </div>
                         
                        <div class="col-xs-6">
                            <input type="hidden" id="totalItemRow" name="totalItemRow" value="" placeholder="Enter ...">
                            <input id="btn_save" name="btn_save" type="submit" class="btn btn-primary btn-block" value="Save Invoice" />
                        </div>
                         <div class="col-xs-6">
                             <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-block btn-danger" value="Cancel" />
                        </div>
                        </div>
                    
                  </form>
                </div><!-- /.box-body -->
              </div>
            </div>
                      
                    
                    </div></section>
                          
		<!-- /.content -->
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
       
      $(function () {
        $("#example1").DataTable();
        $(".select2").select2();
         //Datemask dd/mm/yyyy
        //$("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
       $("#datemask").datepicker();
        $("#quantity").change(function(){
            calculate();
        });
        $("#unitprice").change(function(){
            calculate();
        });
        $("#btn_add").click(function(){
            var i = parseInt($("#totalItemRow").val());
			var invoiceTotal = parseFloat($("#invoiceTotal").val());
            var product=$("#productDescription").val(); 
            var productDescription=$("#productDescription option:selected").text(); 
            var productQuantity=$("#quantity").val(); 
            var productUnit=$("#unit option:selected").text(); 
            var productPrice=$("#unitprice").val(); 
            var productAmount=$("#amount").val(); 
            var currentContent = $("#griddetails").html();
            if(product!='' && productAmount!='' && productAmount>0){
                invoiceTotal += parseFloat(productAmount);                
                $("#griddetails").append("<tr><td>"+productDescription+"</td><td>"+productQuantity+"</td><td>"+productUnit+"</td><td>"+productPrice+"</td><td>"+productAmount+"</td>"
                +"<td><input type='hidden' name='productid[]' value='"+product+"'><input type='hidden' name='productQty[]' value='"+productQuantity+"'><input type='hidden' name='productPrice[]' value='"+productPrice+"'></td></tr>");
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
        //$("#griddetails").DataTable();
        $("#client").change(function(){
            var clientId = parseInt($(this).val());
            if(clientId>0){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url()?>client/getclientaddress/'+clientId,
                    dataType: 'json',
                    complete: function(data){
                        var responses = data.responseText;
                        $("#clientAddress").val(responses);
                    }
                });
				
				$.ajax({
                    type: "POST",
                    url: '<?php echo base_url()?>sales/getdeliverylist/'+clientId,
                    dataType: 'json',
                    complete: function(data){
                        var responses = data.responseText;
						$("#deliveryList").html("");
                        $("#deliveryList").html(responses);
                    }
                });
            }
            else
                alert("select Client");
    
        });
            
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
    }
    </script>
</body>
</html>

