<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sumcon Biotechnology | Product Wise Sales</title>
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
	<!-- Daterange picker -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/daterangepicker/daterangepicker-bs3.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/select2/select2.min.css">


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
           Product Loan Receive Report
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Inventory</a></li>
            <li class="active">Product Loan Receive Report</li>
          </ol>
        </section>

 
        <!-- Main content -->
        <section >
            <div class="box-body">
                        <form role="form" action="<?php echo base_url()?>productloantaken/productloanreceivedetails" method="post">
                        <div class="col-md-3">
                        <label>Client Name</label>
                                <select class="form-control select2" name="client" id="client" >
                                        <option value="">Select Client</option>
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
                        <!-- text input -->
                        <div class="col-md-3">
                        <label>Product Name</label>
                                <select class="form-control select2" name="product" id="product" >
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
                          <label>From Date</label>
                            <input type="text" class="form-control" placeholder="Date From" name="fromDate" id="fromDate" required>
                        </div>
                         <div class="col-md-2">
                          <label>To Date</label>
                             <input type="text" class="form-control" placeholder="Date To" name="toDate" id="toDate" required>
                        </div>
                        
                        <div class="col-md-1 form-group">
                            <label>&nbsp;</label>
                            <input id="btn_save" name="btn_save" type="submit" class="btn btn-primary btn-block" value="Show" />
                        </div>
                        <div class="col-md-1 form-group">
                            <label>&nbsp;</label>
                            <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-block btn-danger" value="Cancel" />
                        </div>


                        
                  </form>
                </div>
        </section>
        <?php
            if(isset($transectionData))
            {
        ?>
        <section class="invoice">
          <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
                <img src="<?php echo base_url()."images/sumcon_ltd_logo.jpg";?>" style="width: 180px;height: 46px;">
                <small class="pull-right">Date: <?php echo date('d-m-Y');?></small>
              </h2>
            </div><!-- /.col -->
          </div>
          
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-xs-12" style="text-align: center;">
                    <h2 >
                        Product Loan Receive Report
                    </h2>
					<span>Date from <?php echo $fromDate;?> to <?php echo $toDate;?></span>
					
			</div> 
          </div><!-- /.row -->

          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped table-bordered">
                  <thead class="text-center">
                  <tr>
                        <th class="text-center">Sl #</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Product</th>
                        <th class="text-center">Party Name</th>
                        <th class="text-center">Sample #</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Package</th>
                        <th class="text-center">Remarks</th>
                    
                  </tr>
                  
                </thead>
                <tbody>
                    
                      <?php
                        $i=0;
                            $totalSalesQty = $totalSalesAmaount=0 ;
                            foreach ($transectionData as $transection){
                                    $totalSalesQty += $transection['quantity'];
                                    
                    ?>
                       
                            <tr>                                
                                <td><?php echo ++$i;?></td>
                                <td align=""><?php echo $transection['loan_taken_date'];?></td>
                                <td align=""><?php echo $transection['product_description'];?></td>
                                <td align=""><?php echo $transection["client_name"];?></td>
                                <td align=""><?php echo $transection["loan_number"];?></td>
                                <td align="right"><?php echo $transection["quantity"].' kg';?></td>
                                <td align="right"><?php echo $transection["package"];?></td>
                                <td align="right"><?php echo $transection["remarks"];?></td>
                                
                                
                            </tr>
                    <?php
                           // $grandTotal += $invoice["itemtotal"];
                            }
                        
                    ?>
                            <tr>                                
                                <td>Total</td>
                                <td align="" colspan="4"></td>
                                
                                <td align="right"><?php echo number_format($totalSalesQty,2);?></td>
                                <td align="right"></td>
                                <td align="right"></td>
                                
                            </tr>
                    </tbody>
                </table>
            </div><!-- /.col -->
          </div><!-- /.row -->

          
          <!-- this row will not appear when printing -->
          
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
    <script src="<?php echo base_url(); ?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>plugins/select2/select2.full.min.js"></script>
<script>
    $(function(){
        $("#fromDate").datepicker();
        $("#toDate").datepicker();
		$(".select2").select2();
    });
</script>
</body>
</html>