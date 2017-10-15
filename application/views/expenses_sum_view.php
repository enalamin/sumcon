<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sumcon Biotechnology | Expenses</title>
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
    <!-- Date Picker -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/datepicker/datepicker3.css">
	<!-- Daterange picker -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/daterangepicker/daterangepicker-bs3.css">
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
           Expenses Report
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Accounts</a></li>
            <li class="active">Expenses Report</li>
          </ol>
        </section>


        <!-- Main content -->
        <section >
            <div class="box-body">
                <form role="form" action="<?php echo base_url()?>accounts/expenses" method="post">

                  <div class="col-md-4">
                    <label>From Date</label>
                      <input type="text" class="form-control" placeholder="Date From" name="fromDate" id="fromDate" value="<?php echo $fromDate?>" required>
                  </div>
                   <div class="col-md-4">
                    <label>To Date</label>
                       <input type="text" class="form-control" placeholder="Date To" name="toDate" id="toDate" value="<?php echo $toDate?>" required>
                  </div>

                  <div class="col-md-2 form-group">
                      <label>&nbsp;</label>
                      <input id="btn_save" name="btn_save" type="submit" class="btn btn-primary btn-block" value="Show Report" />
                  </div>
                  <div class="col-md-2 form-group">
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
          <div class="row no-print">
            <div class="col-xs-12">
                <a href="<?php echo base_url(); ?>accounts/printexpenses<?php echo isset($fromDate)?"/".date('Y-m-d', strtotime($fromDate)):"";?><?php echo isset($toDate)?"/".date('Y-m-d', strtotime($toDate)):"";?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
            </div>
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-xs-12" style="text-align: center;">
                    <h2 >
                        Expenses Report
                    </h2>

                <div>For the period of  <?php echo date('d-m-Y',  strtotime($fromDate))?> To <?php echo date('d-m-Y',  strtotime($toDate))?></div>
                </div>
          </div><!-- /.row -->

          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped table-bordered">
                  <thead class="text-center">
                    <tr>
                      <th class="" >Sl #</th>
                      <th class="" >Account Head</th>
                      <th class="text-right" >Amount</th>
                    </tr>
                  </thead>
                <tbody>

                    <?php
                        $i=0;
        						$totalAmount=0;

        						foreach ($transectionData as $transection){
                      $totalAmount += $transection['amount'];
                      ?>
                  <tr>
                      <td><?php echo ++$i;?></td>
                      <td align=""><?php echo $transection['head_name'];?></td>
                      <td align="right"><?php echo number_format($transection['amount'],2);?></td>
                  </tr>
                    <?php
                          // $i++;
                            }

                    ?>
                            <tr>
                                <td>Total</td>
                                <td align=""></td>
                                <td align="right"><?php echo number_format($totalAmount,2);?></td>
                            </tr>
                    </tbody>
                </table>
            </div><!-- /.col -->
          </div><!-- /.row -->
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
<script>
    $(function(){
        $("#fromDate").datepicker();
        $("#toDate").datepicker();
    });
</script>
</body>
</html>
