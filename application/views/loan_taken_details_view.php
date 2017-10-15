<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sumcon Biotechnology | Product Loan</title>
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


<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

	<?php include_once "header.php"; ?>
	<!-- Left side column. contains the logo and sidebar -->
	<?php include_once "sidebar.php"; ?>

	<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
        <?php
            if(is_array($loanDetails) && !empty($loanDetails))
            {
        ?>

    <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Loan Taken 
            <small>#<?php echo $loanDetails[0]['loan_number']?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Inventory</a></li>
            <li class="active">Product Loan Taken</li>
          </ol>
        </section>

 
        <!-- Main content -->
        <section class="invoice">
          <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
                <?php include_once 'letterheadview.php';?>
              </h2>
            </div><!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">
              <div class="col-xs-12" style="text-align: center;">
                    <h2 >
                        Loan Taken
                    </h2>
                </div> 
            <div class="col-sm-4 invoice-col">
              From
              <address>
                <strong><?php echo $loanDetails[0]['client_name']?></strong><br >
                <?php echo $loanDetails[0]['client_office_address']?><br >
                Contact No: <?php echo $loanDetails[0]['client_contact_no']?></strong><br >
                Email: <?php echo $loanDetails[0]['client_email']?>
              </address>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
              
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
              
              <b>Loan Number:</b> <?php echo $loanDetails[0]['loan_number']?><br>
              <b>Loan Date:</b> <?php echo $loanDetails[0]['loan_taken_date']?><br>

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
                    <th>Package</th>
                    <th>Remarks</th>
                  </tr>
                </thead>
                <tbody>
                     <?php
                        $i=0;
                        $grandTotal=0;
                            foreach ($loanDetails as $loan){
                    ?>
                       
                            <tr>
                                <td><?php echo ++$i;?></td>
                                <td><?php echo $loan["product_description"];?></td>
                                <td><?php echo $loan["quantity"];?></td>
                                <td><?php echo $loan["product_unit"];?></td>
                                <td><?php echo $loan["package"];?></td>
                                <td><?php echo $loan["remarks"];?></td>
                                
                            </tr>
                    <?php
                           // $grandTotal += $invoice["itemtotal"];
                            }
                        
                    ?>
                    </tbody>
                </table>
            </div><!-- /.col -->
          </div><!-- /.row -->

          <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-6">
              
            </div><!-- /.col -->
            <div class="col-xs-6">
              
              <div class="table-responsive">
               
              </div>
            </div><!-- /.col -->
          </div><!-- /.row -->

          <!-- this row will not appear when printing -->
          <div class="row no-print">
            <div class="col-xs-12">
              <a href="<?php echo base_url(); ?>/productloantaken/printloantaken/<?php echo $loanDetails[0]['loan_number']?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
            </div>
          </div>
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
</body>
</html>