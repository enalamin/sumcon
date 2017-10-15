<!DOCTYPE html>

<html>

  <head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Sumcon Biotechnology | Product Mixing</title>

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





<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">



	<?php include_once "header.php"; ?>

	<!-- Left side column. contains the logo and sidebar -->

	<?php include_once "sidebar.php"; ?>



	<!-- Content Wrapper. Contains page content -->



<div class="content-wrapper">

        <?php

            if(is_array($requisitionDetails) && !empty($requisitionDetails))

            {

        ?>



    <!-- Content Header (Page header) -->

        <section class="content-header">

          <h1>Product Conversion (Mixing Requisition 

            <small>#<?php echo $requisitionDetails[0]['requisition_number']?></small>)

          </h1>

          <ol class="breadcrumb">

            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

            <li><a href="#">Inventory</a></li>

            <li class="active">Product Conversion</li>

          </ol>

        </section>



 

        <!-- Main content -->

        <section class="invoice">

          <!-- title row -->

          <form method="post" action="<?php echo base_url()?>productmixingrequisition/requisitionconversion/<?php echo $requisitionDetails[0]['requisition_number']?>">

          <!-- info row -->

          <div class="row invoice-info">
            <div class="col-sm-3 invoice-col">
              <b>Requisition Number:</b> <?php echo $requisitionDetails[0]['requisition_number']?><br>
            </div><!-- /.col -->
            <div class="col-sm-3 invoice-col">
      				<label>Location</label>
      				<select class="form-control select2" name="stockLocation" id="stockLocation" required>
      					<option value="">Select Location</option>
      					<?php
      						if(is_array($locationList)){
      							foreach ($locationList as $location){									
      					?>
      							<option value="<?php echo $location["location_id"];?>" <?php echo $requisitionDetails[0]['location_id']==$location["location_id"]?"selected":""; ?>><?php echo $location["location_name"];?></option>
                <?php
                    }
      						}
      					?>
      				</select>
            </div><!-- /.col -->
            <div class="col-sm-3 invoice-col">
              <b>Requisition Date:</b> <?php echo $requisitionDetails[0]['requisition_date']?><br>
            </div><!-- /.col -->
            <div class="col-sm-3 invoice-col">
              <b>Requisition For:</b> <?php echo $requisitionDetails[0]['req_product_desc']?><br>
            </div><!-- /.col -->
          </div><!-- /.row -->
          
          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Serial #</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Unit</th>
                    <th>Rate</th>
                    <th>Qty. Total</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $i=0;
                  $grandQty=0;
                  $grandTotal=0;
                  foreach ($requisitionDetails as $requisition){
                ?>
                  <tr>
                    <td><?php echo ++$i;?></td>
                    <td><?php echo $requisition["product_description"];?></td>
                    <td><?php echo $requisition["quantity"];?></td>
                    <td><?php echo $requisition["product_unit"];?></td>
                    <td><?php echo $requisition["rate"];?></td>
                    <td><?php echo number_format(($requisition["quantity"]*$requisition["rate"]),2);?></td>
                  </tr>
                <?php
                    $grandQty += $requisition["quantity"];
                    $grandTotal += ($requisition["quantity"]*$requisition["rate"]);
                  }
                    $newRate = $grandTotal/$grandQty;
                ?>
                  <tr>
                    <td>
                      <input type="checkbox" name="ckNewProduct" id="ckNewProduct" value="1"> Create New Product
                    </td>
                    <td>
                      <div id="oldproductlist">
                        <select class="form-control select2" name="productId" id="productId" >
                          <option value="">Select Product</option>
                          <?php
                            if(is_array($productList)){
                              foreach ($productList as $product){
                          ?>
                            <option value="<?php echo $product["product_id"];?>" <?php echo $requisitionDetails[0]['req_for_product_id']==$product["product_id"]?'selected':'';?> ><?php echo $product["product_description"];?></option>
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
                        <!-- textarea -->
                        <div class="form-group">
                          <label>Product Description</label>
                          <textarea class="form-control" rows="3" placeholder="Enter ..." name="productDescription" id="productDescription"></textarea>
                        </div>
                      </div>
                    </td>
                    <td style="vertical-align: middle;" ><input type="text" name="newQty" id="newQty" value="<?php echo $grandQty;?>"></td>
                    <td style="vertical-align: middle;" ><input type="text" name="unit" value="<?php echo $requisition["product_unit"];?>"></td>
                    <td style="vertical-align: middle;" ><input type="text" name="newRate" id="newRate" value="<?php echo number_format($newRate,2);?>" readonly></td>
                    <td style="vertical-align: middle;" ><input type="text" name="grandTotal" id="grandTotal" value="<?php echo number_format($grandTotal,2,'.','');?>" readonly> </td>
                  </tr>
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
	<script src="<?php echo base_url(); ?>plugins/select2/select2.full.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo base_url(); ?>dist/js/app.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="<?php echo base_url(); ?>dist/js/demo.js"></script>
  <script>
      $(function () {
    		$(".select2").select2();
        $("#productName").keyup(function(){
            $("#productDescription").val($("#productName").val());
        });

        $("#ckNewProduct").click(function(){
            $("#oldproductlist").toggle();
            $("#newproductinfo").toggle();
        });
        $("#newQty").change(function(){
          if(parseFloat($(this).val())>0){
            var rate = parseFloat($("#grandTotal").val())/parseFloat($(this).val());
            $("#newRate").val(rate.toFixed(2));
          } else {
            alert("Invalid Quantity");
          }
        });
      });
  </script>

</body>

</html>