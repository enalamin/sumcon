<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sumcon Biotechnology | Trail Balance</title>
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
           Trial Balance
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Accounts</a></li>
            <li class="active">Trail Balance</li>
          </ol>
        </section>


        <!-- Main content -->
        <section >
            <div class="box-body">
                <form role="form" action="<?php echo base_url()?>accounts/trailbalance" method="post">

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
                <a href="<?php echo base_url(); ?>accounts/printtrailbalance<?php echo isset($fromDate)?"/".date('Y-m-d', strtotime($fromDate)):"";?><?php echo isset($toDate)?"/".date('Y-m-d', strtotime($toDate)):"";?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
            </div>
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-xs-12" style="text-align: center;">
                    <h2 >
                        Trail Balance
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
                        <th class="text-center" rowspan="2">Sl #</th>
                        <th class="text-center" rowspan="2">Account Head</th>
                        <!-- <th class="text-center" colspan="2">Opening Balance</th>
                        <th class="text-center" colspan="2">Current Period Balance</th> -->
                        <th class="text-center" colspan="2">Balance</th>
                  </tr>
                  <tr>
                    <!-- <th class="text-center">Debit</th>
                    <th class="text-center">Credit</th>
                    <th class="text-center">Debit</th>
                    <th class="text-center">Credit</th> -->
                    <th class="text-center">Debit</th>
                    <th class="text-center">Credit</th>
                  </tr>

                </thead>
                <tbody>

                    <?php
                        $i=0;
        						$totalOpenDrAmount=$totalOpenCrAmount=$totalDrAmount=$totalCrAmount=$totalCloseDrAmount=$totalCloseCrAmount=0;
        						$headsBalance = $openingHeadBalance = $closingHeadBalance = 0;
                    $openingDrBalance = $openingCrBalance = $printDrBalance = $printCrBalance = $closingDrBalance = $closingCrBalance = "";
        						foreach ($transectionData as $transection){

                      if($transection['accounts_type']=='Debit'){
        								$headsBalance = $transection['drAmount']-$transection['crAmount'];
                        $openingHeadBalance = $transection['openingDrAmount']-$transection['openingCrAmount'];
                        $closingHeadBalance = $openingHeadBalance+$headsBalance;

                        if($openingHeadBalance>0){
                          $totalOpenDrAmount += $openingHeadBalance;
                          $openingDrBalance = $openingHeadBalance;
                          $openingCrBalance='';
                        }
                        else {
                          $totalOpenCrAmount += abs($openingHeadBalance);
                          $openingCrBalance = abs($openingHeadBalance);
                          $openingDrBalance='';
                        }

                        if($headsBalance>0){
                          $totalDrAmount += $headsBalance;
                          $printDrBalance = $headsBalance;
                          $printCrBalance='';
                        }
                        else {
                          $totalCrAmount += abs($headsBalance);
                          $printCrBalance = abs($headsBalance);
                          $printDrBalance='';
                        }

                        if($closingHeadBalance>0){
                          $totalCloseDrAmount += $closingHeadBalance;
                          $closingDrBalance = $closingHeadBalance;
                          $closingCrBalance='';
                        }
                        else {
                          $totalCloseCrAmount += abs($closingHeadBalance);
                          $closingCrBalance = abs($closingHeadBalance);
                          $closingDrBalance='';
                        }

        							}else{
        								$headsBalance = $transection['crAmount']-$transection['drAmount'];
                        $openingHeadBalance = $transection['openingCrAmount']-$transection['openingDrAmount'];
                        $closingHeadBalance = $openingHeadBalance+$headsBalance;

                        if($openingHeadBalance>0){
                          $totalOpenCrAmount += $openingHeadBalance;
                          $openingCrBalance = $openingHeadBalance;
                          $openingDrBalance='';
                        }
                        else {
                          $totalOpenDrAmount += abs($openingHeadBalance);
                          $openingDrBalance = abs($openingHeadBalance);
                          $openingCrBalance='';
                        }

                        if($headsBalance>0){
                          $totalCrAmount += $headsBalance;
                          $printCrBalance = $headsBalance;
                          $printDrBalance='';
                        }
                        else {
                          $totalDrAmount += abs($headsBalance);
                          $printDrBalance = abs($headsBalance);
                          $printCrBalance='';
                        }

                        if($closingHeadBalance>0){
                          $totalCloseCrAmount += $closingHeadBalance;
                          $closingCrBalance = $closingHeadBalance;
                          $closingDrBalance='';
                        }
                        else {
                          $totalCloseDrAmount += abs($closingHeadBalance);
                          $closingDrBalance = abs($closingHeadBalance);
                          $closingCrBalance='';
                        }
        							}


                  ?>
                  <tr>
                      <td><?php echo ++$i;?></td>
                      <td align=""><?php echo $transection['head_name'];?></td>
                      <!-- <td align="right"><?php echo $openingDrBalance?number_format($openingDrBalance,2):'';?></td>
                      <td align="right"><?php echo $openingCrBalance?number_format($openingCrBalance,2):'';?></td>
                      <td align="right"><?php echo $printDrBalance?number_format($printDrBalance,2):'';?></td>
                      <td align="right"><?php echo $printCrBalance?number_format($printCrBalance,2):'';?></td> -->
                      <td align="right"><?php echo $closingDrBalance?number_format($closingDrBalance,2):'';?></td>
                      <td align="right"><?php echo $closingCrBalance?number_format($closingCrBalance,2):'';?></td>
                  </tr>
                    <?php
                           //$i++;
                            }

                    ?>
                            <tr>
                                <td>Total</td>
                                <td align=""></td>
                                <!-- <td align="right"><?php echo number_format($totalOpenDrAmount,2);?></td>
                                <td align="right"><?php echo number_format($totalOpenCrAmount,2);?></td>
                                <td align="right"><?php echo number_format($totalDrAmount,2);?></td>
                                <td align="right"><?php echo number_format($totalCrAmount,2);?></td>
                                 --><td align="right"><?php echo number_format($totalCloseDrAmount,2);?></td>
                                <td align="right"><?php echo number_format($totalCloseCrAmount,2);?></td>
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
