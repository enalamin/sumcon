<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sumcon Biotechnology | Employee Ledger</title>
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
           Employee Wise Expenses
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Accounts</a></li>
            <li class="active">Employee Wise Expenses</li>
          </ol>
        </section>


        <!-- Main content -->
        <section >
            <div class="box-body">
                <form role="form" action="<?php echo base_url()?>accounts/employeeexpenses" method="post">
                    <div class="col-md-3">
                        <label>Pay To</label>
                        <select class="form-control select2" name="party" id="party" required>
                        	<option value="">Select Party</option>
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
                  <div class="col-md-3">
                    <label>Employee</label>
                    <select class="form-control select2" name="employee" id="employee" required>
                    	<option value="">Select Employee</option>
                      <?php
                      	if(is_array($employeeList)){
                        	foreach ($employeeList as $employee){
                      ?>
                      			<option value="<?php echo $employee["employee_id"];?>"><?php echo $employee["employee_name"];?></option>
                      <?php
                      		}
                        }
                      ?>
                      </select>
                  </div>
                  <div class="col-md-2">
                    <label>From Date</label>
                      <input type="text" class="form-control" placeholder="Date From" name="fromDate" id="fromDate" value="<?php echo $fromDate?>" required>
                  </div>
                   <div class="col-md-2">
                    <label>To Date</label>
                       <input type="text" class="form-control" placeholder="Date To" name="toDate" id="toDate" value="<?php echo $toDate?>" required>
                  </div>

                  <div class="col-md-2 form-group">
                      <label>&nbsp;</label>
                      <input id="btn_save" name="btn_save" type="submit" class="btn btn-primary btn-block" value="Show Report" />
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
                <a href="<?php echo base_url(); ?>accounts/printemployeeexpenses<?php echo "/".$employeeDetails[0]['employee_id'];?><?php echo isset($fromDate)?"/".date('Y-m-d', strtotime($fromDate)):"";?><?php echo isset($toDate)?"/".date('Y-m-d', strtotime($toDate)):"";?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
            </div>
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-xs-12" style="text-align: center;">
                <h2 >Employee Wise Expenses</h2>

                <div><h3>Employee Name:  <?php echo $employeeDetails[0]['employee_name']; ?></h3></div>
                <div>For the period of  <?php echo date('d-m-Y',  strtotime($fromDate))?> To <?php echo date('d-m-Y',  strtotime($toDate))?></div>
                </div>
          </div><!-- /.row -->

          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped table-bordered">
                  <thead class="text-center">
                  <tr>
                        <th class="text-center">Date</th>
                        <th class="text-center">Voucher Type</th>
                        <th class="text-center">Voucher No.</th>
                        <th class="text-center">Party Name</th>
                        <th class="text-center">particulers</th>
                        <th class="text-center">Dr. Amount</th>
                        <th class="text-center">Cr. Amount</th>
                        <th class="text-center">Balance</th>
                  </tr>

                </thead>
                <tbody>
                <?php
                  $currentBalance = 0;
                  echo $openingBalance;
                  if($employeeDetails[0]['client_id']!=118){
                    $currentBalance += ($employeeDetails[0]['entry_balance']+$openingBalance);
                ?>
                  <tr>
                      <td class="text-center" colspan="3">Opening Banalce</td>
                      <td class="text-center"></td>
                      <td class="text-center"></td>
                      <td class="text-center"></td>
                      <td class="text-center"></td>
                      <td align="right"><?php echo number_format($currentBalance,2);?></td>
                  </tr>
                <?php
                  }
                
                    $i=0;
        						$totalDrAmount = $totalCrAmount = 0;

        						foreach ($transectionData as $transection){
                      $totalDrAmount += $transection['drAmount'];
                      $totalCrAmount += $transection['crAmount'];
      								$currentBalance += $transection['drAmount']-$transection['crAmount'];
                      if($transection["drAmount"]==0 && $transection["crAmount"]==0)
                        continue;
                ?>
                  <tr>
                      <td><?php echo date('d-m-Y', strtotime($transection["voucher_date"]));?></td>
                      <td align=""><?php echo $transection['voucher_type'];?></td>
                      <td align="center"><?php echo $transection["voucher_number"];?></td>
                      <td align=""><?php echo $transection["client_name"];?></td>
                      <td align=""><?php echo $transection["particulers"];?></td>
                      <td align="right"><?php echo number_format($transection["drAmount"],2);?></td>
                      <td align="right"><?php echo number_format($transection["crAmount"],2)?></td>
                      <td align="right"><?php echo number_format($currentBalance,2);?></td>
                  </tr>
                    <?php

                           // $grandTotal += $invoice["itemtotal"];
                            }

                    ?>
                            <tr>
                                <td>Total</td>
                                <td align=""></td>
                                <td align="right"></td>
                                <td align="right"></td>
                                <td align="right"></td>
                                <td align="right"><?php echo number_format($totalDrAmount,2);?></td>
                                <td align="right"><?php echo number_format($totalCrAmount,2);?></td>
                                <td align="right"><?php echo number_format($currentBalance,2);?></td>
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
    <script src="<?php echo base_url(); ?>plugins/select2/select2.full.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker.js"></script>
<script>
    $(function(){
        $("#fromDate").datepicker();
        $("#toDate").datepicker();
        $(".select2").select2();
    });

    $("#party").change(function(){
        var options="<option value=''>Select Employee</option>";
        $.ajax({
                url: '<?php echo base_url()?>employee/getemployees/'+$(this).val(),
                dataType: 'json',
                complete: function(data){
                    var responses = JSON.parse(data.responseText);
                    for(var employee in responses){
                        options += "<option value='"+responses[employee].employee_id+"'>"+responses[employee].employee_name+"</option>";
                    }
                    $("#employee").html(options);
                }
        });
    });

</script>
</body>
</html>
