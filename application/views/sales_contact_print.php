<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sumcon Biotechnology  | Sales Contact </title>
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
<style type="text/css">
  @page {
   size: landscape;
   margin: 2%
}
.producttable>tbody>tr>th, .producttable>tfoot>tr>th, .producttable>thead>tr>td, .producttable>tbody>tr>td, .producttable>tfoot>tr>td {
    line-height: 1;
    border: 1px solid #6b6565;

}
</style>

  </head>
  <body onload="window.print();">
    <div class="wrapper">
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
        <div class="invoice-info" style="margin-top:-20px;">
                <div class="row">
                    <div class="col-xs-12" style="text-align: center;">
                        <table align="center">
                            <tr>
                                <td><h2 class="printheadertitle">Sales Contact</h2></td>
                            </tr>
                        </table>
                    </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table">
                        <tr>
                            <td style="border: 1px solid;width:50%;">
                                  <strong>Buyer:</strong><br>
                                    <strong><?php echo $employeeCommissions[0]['client_name']?></strong><br>
                                    <?php echo $employeeCommissions[0]['client_office_address']?><br/>
                  <b><?php echo $employeeCommissions[0]['commission_type'];?> #:</b> <?php echo $employeeCommissions[0]['refrenceNo']?><br/>
                  <b><?php echo $employeeCommissions[0]['commission_type'];?> Date:</b> <?php echo $employeeCommissions[0]['transection_date']?>
                            </td>
                            <td style="border: 1px solid;width:50%;">
                                <b>Date:</b> <?php  echo date('d-m-Y'); ?><br>
                                <b>Account Name:</b> <?php echo $employeeCommissions[0]['employee_name']?><br><br>
                                <b>address:</b> <?php echo $employeeCommissions[0]['address']?><br>
                                <b>Contact No:</b> <?php echo $employeeCommissions[0]['contact_no']?>
                            </td>
                        </tr>
                    </table>
                </div><!-- /.col -->
            </div>

          </div><!-- /.row -->
          
          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th style="border:1px solid;text-align:center;">SL No.</th>
                    <th style="border:1px solid;text-align:center;" width="15%">Product Description</th>
                    <th style="border:1px solid;text-align:center;">Quantity</th>
                    <th style="border:1px solid;text-align:center;">Sale Value in Kg</th>
                    <th style="border:1px solid;text-align:center;">Total Sale Value</th>
                    <?php 
                      if($employeeCommissions[0]['commission_type']=='PI'){
                    ?>
                    <th style="border:1px solid;text-align:center;">Actual Value in Kg</th>
                    
                    <th style="border:1px solid;text-align:center;">Total Actual Value</th>
                    <?php
                      }
                    ?>
                    <th style="border:1px solid;text-align:center;" width="15%">Name Of Person</th>
                    <th style="border:1px solid;text-align:center;">Commission in Kg</th>
                    <th style="border:1px solid;text-align:center;">Commission %</th>
                    <?php 
                      if($employeeCommissions[0]['commission_type']!='Invoice'){
                    ?>
                    <th style="border:1px solid;text-align:center;">Commission Amount $</th>
                    <th style="border:1px solid;text-align:center;">Dollar Rate</th>
                    <?php
                      }
                    ?>
                    <th style="border:1px solid;text-align:center;">Commission Amount (BDT)</th>
                  </tr>
                </thead>
                <tbody>
                     <?php
                        $i=0;
                        $grandTotal= $totalQty = $totalSaleValue = $totalActualValue =  $totalDollarAmount = 0;
                            foreach ($employeeCommissions as $commission){
                              $totalQty += $commission["product_qty"];
                              $totalSaleValue += $commission["product_qty"]*$commission["sale_value_in_kg"];
                              $totalActualValue += $commission["product_qty"]*$commission["actual_value_in_kg"];
                              $totalDollarAmount += $commission["commission_dollar_amount"];
                              $grandTotal += $commission["commission_amount"];
                    ?>

                            <tr>
                                <td style="border:1px solid;"><?php echo ++$i;?></td>
                                <td style="border:1px solid;"><?php echo $commission["product_description"];?></td>
                                        <td style="border:1px solid;text-align:right;"><?php echo $commission["product_qty"];?></td>
                                <td style="border:1px solid;text-align:right;"><?php echo number_format($commission["sale_value_in_kg"],2);?></td>
                                <td style="border:1px solid;text-align:right;"><?php echo number_format(($commission["sale_value_in_kg"]*$commission["product_qty"]),2);?></td>
                                <?php 
                                  if($employeeCommissions[0]['commission_type']=='PI'){
                                ?>          
                                <td style="border:1px solid;text-align:right;"><?php echo number_format($commission["actual_value_in_kg"],2);?></td>
                                <td style="border:1px solid;text-align:right;"><?php echo number_format(($commission["actual_value_in_kg"]*$commission["product_qty"]),2);?></td>
                                <?php
                                  }
                                ?>
                                <td style="border:1px solid;"><?php echo $commission["employee_name"];?></td>
                                <td style="border:1px solid;text-align:right;"><?php echo number_format($commission["commission_in_kg"],2);?></td>
                                <td style="border:1px solid;text-align:right;"><?php echo number_format($commission["commission_percent"],2);?></td>
                                <?php 
                                  if($employeeCommissions[0]['commission_type']!='Invoice'){
                                ?>                                
                                <td style="border:1px solid;text-align:right;"><?php echo number_format($commission["commission_dollar_amount"],2);?></td>
                                <td style="border:1px solid;text-align:right;"><?php echo number_format($commission["dollar_conversion_rate"],2);?></td>
                                <?php
                                  }
                                ?>
                                <td style="border:1px solid;text-align:right;"><?php echo number_format($commission["commission_amount"],2);?></td>

                            </tr>
                    <?php
                            //$grandTotal += $delivery["qty"];
                            }

                    ?>
                                       <tr>
                                <td style="border:1px solid;">&nbsp;</td>
                                <td style="border:1px solid;">Total</td>
                                <td style="border:1px solid;text-align: right;"><?php echo number_format($totalQty,2); ?></td>
                                <td style="border:1px solid;">&nbsp;</td>
                                <td style="border:1px solid;text-align: right;"><?php echo number_format($totalSaleValue,2); ?></td>
                                <?php 
                                  if($employeeCommissions[0]['commission_type']=='PI'){
                                ?>
                                <td style="border:1px solid;">&nbsp;</td>
                                <td style="border:1px solid;text-align: right;"><?php echo number_format($totalActualValue,2); ?></td>
                                <?php
                                  }
                                ?>
                                <td style="border:1px solid;">&nbsp;</td>
                                <td style="border:1px solid;">&nbsp;</td>
                                <td style="border:1px solid;">&nbsp;</td>
                                 <?php 
                                  if($employeeCommissions[0]['commission_type']!='Invoice'){
                                ?> 
                                <td style="border:1px solid;text-align: right;"><?php echo number_format($totalDollarAmount,2); ?></td>
                                <td style="border:1px solid;text-align: right;">&nbsp;</td>
                                <?php
                                  }
                                ?>
                                <td style="border:1px solid; text-align: right;"><?php echo number_format($grandTotal,2); ?></td>
                            </tr>
                            <tr>
                              <td style="border:1px solid;" colspan="<?php echo $employeeCommissions[0]['commission_type']=='Invoice'?'9':($employeeCommissions[0]['commission_type']=='LC'?'11':'13') ?>">
                                <?php 
                                    if($totalDollarAmount!=0){
                                ?>
                                    In Words:- <?php echo InWords($totalDollarAmount,'dollar only')?><br />
                                <?php
                                    }
                                ?>
                                    In Words:- <?php echo InWords($grandTotal,'Taka only')?>
                              </td>
                            </tr>
                            <tr>
                              <td style="border:1px solid;height: 100px;" colspan="<?php echo $employeeCommissions[0]['commission_type']=='Invoice'?'9':($employeeCommissions[0]['commission_type']=='LC'?'11':'13') ?>">
                              <b>Condition:</b>
                              </td>
                            </tr>
                    </tbody>
                </table>
            </div><!-- /.col -->
          </div><!-- /.row -->

        <br />
        <div class="row">
      <div class="col-xs-4  text-left signatory" style="padding-left: 30px;" >
        Account Holder Signature
      </div><!-- /.col -->
          <div class="col-xs-4  text-center signatory">
        
      </div><!-- /.col -->
          <div class="col-xs-4 text-right signatory" style="padding-right: 30px;">
        Authorized Signature
      </div><!-- /.col -->
    </div>
    <br />
    <div class="row">
      <div class="col-xs-12  text-left " style="padding-left: 30px;">
        <b>Entry By:</b> <?php echo $employeeCommissions[0]['entry_by']; ?> &nbsp;&nbsp;&nbsp;
      </div><!-- /.col -->
    </div>

      </section><!-- /.content -->
    </div><!-- ./wrapper -->

    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>dist/js/app.min.js"></script>
  </body>
</html>
