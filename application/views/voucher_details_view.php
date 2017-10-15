<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sumcon Biotechnology | Invoice</title>
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
    <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/sumcon.css" media="all">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/skins/_all-skins.min.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

	<?php include_once "header.php"; ?>
	<!-- Left side column. contains the logo and sidebar -->
	<?php include_once "sidebar.php"; ?>

	<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
        <?php
            if(is_array($voucherDetails) && !empty($voucherDetails))
            {
        ?>

    <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
    				Accounts
            <small>Voucher Details</small>
    			</h1>
    			<ol class="breadcrumb">
    				<li><a href="<?php echo base_url()?>"><i class="fa fa-dashboard"></i> Home</a></li>
    				<li class="active"><a href="<?php echo base_url()?>accounts">Accounts</a></li>
            <li class="active">Voucher Details</li>
    			</ol>
        </section>

        <!-- Main content -->
        <section class="invoice">
          <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
               <?php include_once 'selfletterheadview.php';?>
              </h2>
            </div><!-- /.col -->
          </div>
          <!-- info row -->
          <div class="invoice-info" style="margin-top:-20px;">
			<div class="row">
        <div class="col-xs-12" style="text-align: center;">
					<table align="center">
						<tr>
							<td><h2 class="printheadertitle"><?php echo $voucherDetails[0]['voucher_type'];?> voucher</h2></td>
						</tr>
					</table>
        </div>
				</div>

			<div class="row">
				<div class="col-xs-12 table-responsive">
					<table class="table">
          <?php
            if($voucherDetails[0]['voucher_type']!='transfer'){
          ?>
						<tr>
							<td style="border: 1px solid;width:34%;">
                 <strong><?php echo $voucherDetails[0]['voucher_type']=='receipt'?"Received from":($voucherDetails[0]['voucher_type']=='payment'?"Paid to":"Party Name");?> :   </strong>
                <strong><?php echo $voucherDetails[0]['client_name']?></strong>
              
            </td>
            <td style="border: 1px solid;width:33%;">
              <b>Voucher Date:</b> <?php echo date('d-m-Y',  strtotime($voucherDetails[0]['voucher_date']));?>
            </td>
            <td style="border: 1px solid;width:33%;">
              <b>Voucher Number:</b> <?php echo $voucherDetails[0]['voucher_number'].'('.date('Ym',  strtotime($voucherDetails[0]['voucher_date'])).')';?><br>
            </td>
          </tr>
          <?php
            } else{
          ?>
            <tr>
             
            <td style="border: 1px solid;width:50%;">
              <b>Voucher Date:</b> <?php echo date('d-m-Y',  strtotime($voucherDetails[0]['voucher_date']));?>
            </td>
            <td style="border: 1px solid;width:50%;">
              <b>Voucher Number:</b> <?php echo $voucherDetails[0]['voucher_number'].'('.date('Ym',  strtotime($voucherDetails[0]['voucher_date'])).')';?><br>
            </td>
          </tr>
          <?php
            }
          ?>
          <tr>
            <td colspan="3" style="border: 1px solid;">
              <b>Voucher Description:</b><?php echo $voucherDetails[0]['description'];?>
            </td>
          </tr>
          <?php
            if($voucherDetails[0]['voucherTransectionType']=='Cheque'){
          ?>
          <tr>
            <td style="border: 1px solid;" colspan="3">
              <b>Bank Name:</b><?php echo $voucherDetails[0]['bank_name'];?> &nbsp;&nbsp;&nbsp;&nbsp;
              <b>Accout No:</b><?php echo $voucherDetails[0]['account_no'];?>&nbsp;&nbsp;&nbsp;&nbsp;
            
              <b>Cheque Number:</b><?php echo $voucherDetails[0]['cheque_number'];?>&nbsp;&nbsp;&nbsp;&nbsp;
              <b>Cheque Date:</b><?php echo $voucherDetails[0]['cheque_date']? date('d-m-Y', strtotime($voucherDetails[0]['cheque_date'])):'';?>
            </td>
            </tr>
            <?php
              }
            ?>
					</table>
				</div><!-- /.col -->
    </div><!-- /.row -->
			

          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped">
              <?php
                if($voucherDetails[0]['voucher_type']!='transfer'){
              ?>
                <thead>
                  <tr>
                    <th style="border:1px solid;text-align:center;">SL. No</th>
                    <th style="border:1px solid;text-align:center;">Accounts Head</th>
                    <?php
                      if(in_array($voucherDetails[0]['voucher_type'],array("payment","journal"))){
                    ?>
                        <th style="border:1px solid;text-align:center;">Car</th>
                        <th style="border:1px solid;text-align:center;">Employee</th>
                    <?php
                      }
                    ?>
                    <th style="border:1px solid;text-align:center;">Description</th>
                    <?php
                      if(in_array($voucherDetails[0]['voucher_type'],array("payment","receipt"))){
                    ?>
                      <th style="border:1px solid;text-align:right;">Amount</th>
                    <?php
                      } else {
                    ?>
                    <th style="border:1px solid;text-align:right;">Dr. Amount</th>
                    <th style="border:1px solid;text-align:right;">Cr. Amount</th>
                    <?php
                    }
                    ?>
                  </tr>
                </thead>
                <tbody>
                     <?php
                        $i=0;
                        $grandTotal=0;
                            foreach ($voucherDetails as $voucher){
                              if(in_array($voucherDetails[0]['voucher_type'],array("payment","receipt"))){
                                if($voucher["transection_type"]=='Cr' && $voucherDetails[0]['voucher_type']=='payment'){
                                  $grandTotal = $voucher["amount"];
                                  continue;
                                }
                                if($voucher["transection_type"]=='Dr' && $voucherDetails[0]['voucher_type']=='receipt'){
                                  $grandTotal = $voucher["amount"];
                                  continue;
                                }
                              }

                    ?>

                            <tr>
                                <td style="border:1px solid; padding: 0px;text-align: center;"><?php echo ++$i;?></td>
                                <td style="border:1px solid;padding: 0px;"><?php echo $voucher["head_name"];?></td>
                                <?php
                                  if(in_array($voucherDetails[0]['voucher_type'],array("payment","journal"))){
                                    ?>
                                    <td style="border:1px solid;padding: 0px;"><?php echo $voucher["car_number"];?></td>
                                    <td style="border:1px solid;padding: 0px;"><?php echo $voucher["employee_name"];?></td>
                                    <?php
                                  }
                                ?>
                                <td style="border:1px solid;padding: 0px;"><?php echo $voucher["particulers"];?></td>
                                <?php
                                  if(in_array($voucherDetails[0]['voucher_type'],array("payment","receipt"))){
                                    if($voucher["transection_type"]=='Cr' && $voucherDetails[0]['voucher_type']=='payment'){
                                      $grandTotal = $voucher["amount"];
                                      continue;
                                    }
                                    if($voucher["transection_type"]=='Dr' && $voucherDetails[0]['voucher_type']=='receipt'){
                                      $grandTotal = $voucher["amount"];
                                      continue;
                                    }


                                ?>
                                <td style="border:1px solid;text-align:right; padding: 0px;">
                                  <?php echo $voucher["transection_type"]=='Dr' && $voucherDetails[0]['voucher_type']=='payment'?number_format($voucher["amount"],2):'';?>
                                  <?php echo $voucher["transection_type"]=='Cr' && $voucherDetails[0]['voucher_type']=='receipt'?number_format($voucher["amount"],2):'';?>
                                    
                                </td>
                                <?php
                                  } else {
                                ?>
                                <td style="border:1px solid;text-align:right;padding: 0px;"><?php echo $voucher["transection_type"]=='Dr'?number_format($voucher["amount"],2):'';?></td>
                                <td style="border:1px solid;text-align:right;padding:0px;"><?php echo $voucher["transection_type"]=='Cr'?number_format($voucher["amount"],2):'';?></td>
                                <?php
                                }
                                ?>

                            </tr>
                    <?php
                            //$grandTotal += $voucher["transection_type"]=='Dr'?$voucher["amount"]:0;
                            }

                            if(in_array($voucherDetails[0]['voucher_type'],array("payment","receipt"))){
                    ?>
                            <tr>
                              <td colspan="<?php echo $voucherDetails[0]['voucher_type']=='payment'?'4':'2'; ?>" style="border:1px solid;font-weight: 600;padding:0px;">In words:- <?php echo InWords($grandTotal, "Taka"); ?> &nbsp;only</td>
                              <td style="border:1px solid;font-weight: 600; text-align: right;padding:0px;" >Total</td>
                              <td style="border:1px solid;text-align:right;font-weight: 600;padding:0px;"><?php echo number_format($grandTotal,2);?></td>

                            </tr>
                    <?php
                            }
                    ?>

                    </tbody>
                    <?php
                      } else{
                    ?>
                      <thead>
                        <tr>
                          <th style="border:1px solid;text-align:center;">Transfer From</th>
                          <th style="border:1px solid;text-align:center;">Transfer To</th>
                          <th style="border:1px solid;text-align:right;">Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td style="border:1px solid;padding:0px;">
                            <?php 
                                if($voucherDetails[0]['transection_type']=='Cr'){
                                  if($voucherDetails[0]['accounts_head_id']==1){
                                    echo "Account # ".$voucherDetails[1]['account_no'].", ".$voucherDetails[1]['bank_name'];
                                  } else{
                                    echo $voucherDetails[0]['head_name'];
                                  }
                                } else{
                                  if($voucherDetails[1]['accounts_head_id']==1){
                                    echo "Account # ".$voucherDetails[1]['account_no'].", ".$voucherDetails[1]['bank_name'];
                                  } else{
                                    echo $voucherDetails[1]['head_name'].' '.($voucherDetails[1]['accounts_head_id']==91? 'on account # '.$voucherDetails[1]['to_account_no']:'');
                                  }
                                }
                            ?>
                              
                          </td>
                          <td style="border:1px solid;padding:0px;">
                            <?php 
                                if($voucherDetails[0]['transection_type']=='Dr'){
                                  if($voucherDetails[0]['accounts_head_id']==1){
                                    echo "Account # ".$voucherDetails[1]['to_account_no'].", ".$voucherDetails[1]['to_bank_name'];
                                  } else{
                                    echo $voucherDetails[0]['head_name'].' '.($voucherDetails[0]['accounts_head_id']==91? 'on account # '.$voucherDetails[0]['to_account_no']:'');
                                  }
                                } else{
                                  if($voucherDetails[1]['accounts_head_id']==1){
                                    echo "Account # ".$voucherDetails[1]['to_account_no'].", ".$voucherDetails[1]['to_bank_name'];
                                  } else{
                                    echo $voucherDetails[1]['head_name'].' '.($voucherDetails[1]['accounts_head_id']==91? 'on account # '.$voucherDetails[1]['to_account_no']:'');;
                                  }
                                }
                            ?>
                          </td>
                          <td style="border:1px solid;text-align:right;padding:0px;"><?php echo number_format($voucherDetails[0]['amount'],2); ?></td>
                        </tr>
                        <tr>
                          <td colspan="3" style="border:1px solid;font-weight: 600;padding:0px;">In words:- <?php echo InWords($voucherDetails[0]['amount'], "Taka only"); ?></td>
                        </tr>
                      </tbody>
                    <?php
                      }
                    ?>
                </table>
            </div><!-- /.col -->
          </div><!-- /.row -->


		<br />
		<br />
		
		<div class="row">
      <?php
        if($voucherDetails[0]['voucher_type']=='journal'){
      ?>
      <div class="col-xs-4 text-left signatory" style="padding-left: 40px;">Prepared By</div>
      <div class="col-xs-4 text-center signatory">Checked By</div>
      <div class="col-xs-4 text-right signatory" style="padding-right: 40px;">Authorized Signature</div>
        <?php
      } else{
        ?>
        <div class="col-xs-3 text-left signatory" style="padding-left: 40px;">M.D/ Director (F&A)</div>
		    <div class="col-xs-3 text-center signatory">Manager (F&A)</div>
	      <div class="col-xs-2 text-center signatory" >Accountant</div>
        <div class="col-xs-2 text-center signatory" >Cashier</div>
        <div class="col-xs-2 text-right signatory" style="padding-right: 30px;">Receiver</div>
        <?php
      }
        ?>
    </div>
    <br />
    <div class="row">
      <div class="col-xs-12  text-left " style="padding-left: 40px;">
        <b>Entry By:</b> <?php echo $voucherDetails[0]['entry_by']; ?>&nbsp;&nbsp;&nbsp;&nbsp;
        <b>Approved By:</b> <?php echo $voucherDetails[0]['approve_by']; ?>
      </div><!-- /.col -->
      
    </div>


          <!-- this row will not appear when printing -->
          <div class="row no-print">
            <div class="col-xs-12">
              <a href="<?php echo base_url(); ?>/accounts/voucherdetailsprint/<?php echo $voucherDetails[0]['voucher_id']?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
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
