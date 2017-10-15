<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sumcon Biotechnology | Income Statement</title>
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
  <style type="text/css">
    .balance-sheet-head{
      font-size: 16px;
      font-weight: 600;
      text-transform: uppercase;
    }

    .balance-sheet-sub-head{
      font-size: 15px;
      font-weight: 600;
    }
  </style>
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
           Balance Sheet
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Accounts</a></li>
            <li class="active">Balance Sheet</li>
          </ol>
        </section>
        <!-- Main content -->
        <section >
            <div class="box-body">
                <form role="form" action="<?php echo base_url()?>accounts/balancesheet" method="post">

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
            if(isset($fixedAsset))
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
          <!-- div class="row no-print">
            <div class="col-xs-12">
                <a href="<?php echo base_url(); ?>accounts/printincomestatement<?php echo isset($fromDate)?"/".date('Y-m-d', strtotime($fromDate)):"";?><?php echo isset($toDate)?"/".date('Y-m-d', strtotime($toDate)):"";?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
            </div>
          </div -->
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-xs-12" style="text-align: center;">
                    <h2 >
                        Balance Sheet
                    </h2>

                <div>For the period of  <?php echo date('d-m-Y',  strtotime($fromDate))?> To <?php echo date('d-m-Y',  strtotime($toDate))?></div>
                </div>
          </div><!-- /.row -->

          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped table-bordered balancesheet">
                  <thead class="text-center">
                    <tr>
                      <th class="" >Particulars</th>
                      <th class="" >Notes</th>
                      <th class="text-right" >Amount</th>
                    </tr>
                  </thead>
                <tbody>

                    <?php
                        $i=0;
        						$fixedAssetAmount=$currentAssetAmount=$netCapital=$netProfit=$totalLiabilities=0;

        						foreach ($fixedAsset as $transection){
                      $fixedAssetAmount += $transection['amount'];
                    }
                      ?>
                  <tr>
                      <td class="balance-sheet-head" >Property & Asset</td>
                      <td align=""></td>
                      <td align="right"></td>
                  </tr>
                  <tr>
                      <td class="balance-sheet-sub-head">Fiexed Asset</td>
                      <td align=""></td>
                      <td align="right" style="font-weight: 600;"><?php echo number_format($fixedAssetAmount,2);?></td>
                  </tr>
                    
                    <tr>
                        <td class="balance-sheet-sub-head" colspan="3">Current Asset:</td>
                        
                    </tr>
                    <tr>
                        <td>Inventories</td>
                        <td align=""></td>
                        <td align="right" style="border-top: 2px solid; border-left: 2px solid; border-right: 2px solid;"><?php echo number_format($inventory,2);?></td>
                    </tr>
                    <tr>
                        <td>Goods In Transit</td>
                        <td align=""></td>
                        <td align="right" style="border-left: 2px solid; border-right: 2px solid;"><?php echo number_format($goodsInTransit[0]['amount'],2);?></td>
                    </tr>
                    <tr>
                        <td>Advance, Deposit and Margin Account</td>
                        <td align="">5</td>
                        <td align="right" style="border-left: 2px solid; border-right: 2px solid;"><?php echo number_format($advance,2);?></td>
                    </tr>
                    <tr>
                        <td>Cash in Hand & Bank</td>
                        <td align="">6</td>
                        <td align="right" style="border-left: 2px solid; border-right: 2px solid;"><?php echo number_format($cashAndBank,2);?></td>
                    </tr>
                    <tr>
                        <td>Cheque In Hand</td>
                        <td align=""></td>
                        <td align="right" style="border-left: 2px solid; border-right: 2px solid;"><?php echo number_format($ChequeInHand[0]['amount'],2);?></td>
                    </tr>
                    <tr>
                        <td>Accounts Receivable</td>
                        <td align="">7</td>
                        <td align="right" style="border-left: 2px solid; border-right: 2px solid;"><?php echo number_format($receivable[0]['amount'],2);?></td>
                    </tr>
                    <tr>
                        <td>MD'S Current Account</td>
                        <td align=""></td>
                        <td align="right" style="border-bottom: 2px solid; border-left: 2px solid; border-right: 2px solid;"><?php echo number_format($mdAccount[0]['amount'],2);?></td>
                    </tr>
                    
                    <tr>
                        <td ></td>
                        <td align=""></td>
                        <td align="right" style="font-weight: 600;"><?php echo number_format(($inventory+$advance+$cashAndBank+$goodsInTransit[0]['amount']+$receivable[0]['amount']+$ChequeInHand[0]['amount']+$mdAccount[0]['amount']),2);?></td>
                    </tr>

                    <tr>
                        <td class="balance-sheet-head">Total</td>
                        <td align=""></td>
                        <td align="right" class="balance-sheet-head"><?php echo number_format(($fixedAssetAmount+$inventory+$advance+$cashAndBank+$goodsInTransit[0]['amount']+$receivable[0]['amount']+$ChequeInHand[0]['amount']+$mdAccount[0]['amount']),2);?></td>
                    </tr>
                    <tr>
                        <td class="balance-sheet-head">CAPITAL AND LIABILITIES:</td>
                        <td align=""></td>
                        <td align="right"></td>
                    </tr>
                    <?php
                    foreach ($capitalData as $transection){
                      $netCapital += $transection['amount'];
                    }
                    ?>
                    <tr>
                        <td class="balance-sheet-sub-head">Capital</td>
                        <td align=""></td>
                        <td align="right" style="font-weight: 600;"><?php echo number_format($netCapital,2);?></td>
                    </tr>
                    <?php
                    foreach ($profitandLossData as $transection){
                      $netProfit += $transection['amount'];
                    }
                    ?>
                    <tr>
                        <td class="balance-sheet-sub-head">Profit & Loss A/C</td>
                        <td align=""></td>
                        <td align="right"></td>
                    </tr>
                    <tr>
                        <td>Accumulated Profit upto previous year</td>
                        <td align=""></td>
                        <td align="right"><?php echo number_format($netProfit,2);?></td>
                    </tr>
                    <tr>
                        <td>Profit for this year as per I/S</td>
                        <td align=""></td>
                        <td align="right"><?php echo number_format($currentYearProfit,2);?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td align=""></td>
                        <td align="right" style="border-top: 2px solid;font-weight: 600;"><?php echo number_format($netProfit+$currentYearProfit,2);?></td>
                    </tr>
                    <tr>
                        <td class="balance-sheet-sub-head">Current Liabilities:</td>
                        <td align=""></td>
                        <td align="right" style="border-bottom: 2px solid;"></td>
                    </tr>
                    <?php
                    foreach ($liabilitiesData as $transection){
                      if($transection['accounts_head_id']==89)
                        continue;

                      $totalLiabilities += $transection['amount'];
                    ?>
                    <tr>
                          <td><?php echo $transection["head_name"];?></td>
                          <td align=""></td>
                          <td align="right" style="border-left: 2px solid;border-right: 2px solid;"><?php echo number_format($transection['amount'],2);?></td>
                      </tr>
                      
                    <?php
                    }
                    ?>
                     <tr>
                        <td></td>
                        <td align=""></td>
                        <td align="right" style="border-top: 2px solid;font-weight: 600;"><?php echo number_format($totalLiabilities,2);?></td>
                    </tr>
                    <tr>
                        <td class="balance-sheet-head">Total</td>
                        <td align=""></td>
                        <td align="right" class="balance-sheet-head"><?php echo number_format(($netCapital+$netProfit+$currentYearProfit+$totalLiabilities),2);?></td>
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
