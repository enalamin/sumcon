<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Sumcon Biotechnology | Delivery Challan</title>
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
                    <h1>Date wise Stock Report</h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Inventory</a></li>
                        <li class="active">Stock Report</li>
                    </ol>
                </section>

 
        <!-- Main content -->
        <section >
            <div class="box-body">
                        <form role="form" action="<?php echo base_url()?>product/datestockreport" method="post">
                          <!-- select -->
                        
                        <!-- text input -->
                        <div class="col-md-4">
                            <label>Location</label>
                                <select class="form-control select2" name="stockLocation" id="stockLocation" >
                                    <option value="0">All</option>
                                    <?php
                                        if(is_array($locationList)){
                                            foreach ($locationList as $location){
                                                
                                    ?>
                                            <option value="<?php echo $location["location_id"];?>" <?php echo $locationId==$location["location_id"]?"selected":""; ?>><?php echo $location["location_name"];?></option>
                                    <?php
                                            
                                            }
                                        }
                                    ?>
                                </select>
                        </div>
                        <div class="col-md-2">
                            <label>Date From</label>
                            <input type="text" class="form-control" placeholder="Date From" name="fromDate" id="fromDate" >
                        </div>
                        <div class="col-md-2">
                            <label>Date To</label>
                            <input type="text" class="form-control" placeholder="Date To" name="toDate" id="toDate" >
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
            if(isset($stockData))
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
                <a href="<?php echo base_url(); ?>product/printstockreport/<?php echo $locationId;?><?php echo isset($fromDate)?"/".$fromDate:"";?><?php echo isset($toDate)?"/".$toDate:"";?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
            </div>
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-xs-12" style="text-align: center;">
				<h2 >
					Stock Report
				</h2>
				<?php
					if($locationName)
						echo "<div>Location:".$locationName."</div>";
				?>
				<div>
					
				</div>
                <div>
                    <?php
                        if(isset($fromDate)){
                            echo "For the period of  ".date('d-m-Y',  strtotime($fromDate))." To ".date('d-m-Y',  strtotime($toDate));
                        }
                        else{
                            echo "Upto ".date('d-m-Y');
                        }
                    ?>
                    
                </div> 
          </div><!-- /.row -->

          <!-- Table row -->
          <div class="row" style="font-size: 8pt;">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped table-bordered">
                  <thead class="text-center">
                  <tr>
                        <th rowspan="2" class="text-center">Sl #</th>
                        <th rowspan="2" class="text-center">Product</th>
                        <th rowspan="2" class="text-center">Opening</th>
                        <th colspan="8" class="text-center">Receive</th>
                        <th colspan="6" class="text-center">Out</th>
                        <th rowspan="2" class="text-center">Balance (Kg)</th>
                        <th rowspan="2" class="text-center">Loan (Kg)</th>
                        <th rowspan="2" class="text-center">With Loan Total</th>
                        <th rowspan="2" class="text-center">Rate</th>
                        <th rowspan="2" class="text-center">Amount</th>
                    
                  </tr>
                  <tr>
                        <th>Conve.</th>
                        <th >Trans.</th>
                        <th >Purchase</th>
                        <th >S.Return</th>
                        <th >Loan</th>
                        <th >Samle</th>
                        <th >LC</th>
                        <th >Total</th>
                        <th>Conve.</th>
                        <th >Trans.</th>
                        <th >Sales</th>
                        <th >Loan</th>
                        <th >Sample</th>
                        <th >Total</th>
                    
                  </tr>
                </thead>
                <tbody>
                      <?php
                        $i=0;
                        $grandReceive = $grandOut = $grandBalanceQty = $grandAmount = $grandBalanceWithLoan = $grandLoanQty =  $grandAmountC=0;
                            foreach ($stockData as $stock){
                               // $receiveTotal = $outTotal=$currentBalance=0;
                                $receiveTotal = $stock["conversion"]+$stock["transfer"]+$stock["purchase"]+$stock["salesreturn"]+$stock["loantaken"]+$stock["samplereturn"]+$stock["lc"];
                                $outTotal = $stock["conversionout"]+$stock["transferout"]+$stock["sales"]+$stock["loangiven"]+$stock["freesample"];

                                $receiveTotalAmount = $stock["conversionAmount"]+$stock["transferAmount"]+$stock["purchaseAmount"]+$stock["salesreturnAmount"]+$stock["loantakenAmount"]+$stock["samplereturnAmount"]+$stock["lcAmount"];
                                $outTotalAmount = $stock["conversionoutAmount"]+$stock["transferoutAmount"]+$stock["salesAmount"]+$stock["loangivenAmount"]+$stock["freesampleAmount"];
                                $currentBalance = $stock["openingbalance"]+$receiveTotal-$outTotal;
                                $currentBalanceAmount = $stock["openingbalanceAmount"]+$receiveTotalAmount-$outTotalAmount;
                                
                                $loanBalance= $stock["loanbalance"]+$stock["loangiven"]-$stock["loantaken"];
                                $loanBalanceAmount= $stock["loanbalanceAmount"]+$stock["loangivenAmount"]-$stock["loantakenAmount"];
                                $currentBalanceWithLoan = $currentBalance + $loanBalance;
                                $currentBalanceAmountC = $currentBalanceWithLoan*round($productRate[$stock["product_id"]],2);
                                $currentBalanceAmount= $currentBalanceWithLoan*round($stock["product_rate"],2);
                                //$currentBalanceAmount = $currentBalanceAmount+$loanBalanceAmount;
                                //$currentRate = $currentBalanceWithLoan>0?($currentBalanceAmount/$currentBalanceWithLoan):$stock["product_rate"];
                                if($stock["openingbalance"]==0 && $receiveTotal==0 && $outTotal==0 && $currentBalance==0 && $loanBalance==0){
                                    continue;
                                }
                                $grandReceive += $receiveTotal; 
                                $grandOut += $outTotal; 
                                $grandBalanceQty += $currentBalance; 
                                $grandLoanQty += $loanBalance;
                                $grandBalanceWithLoan += $currentBalanceWithLoan;
                                $grandAmount += $currentBalanceAmount; 
                                $grandAmountC += $currentBalanceAmountC; 
                    ?>
                       
                            <tr>
                                <td align="right"><?php echo ++$i;?></td>
                                 <td ><?php echo $stock["product_description"];?></td>
                                <td align="right"><?php echo number_format($stock["openingbalance"],2);?></td>
                                <td align="right"><?php echo $stock["conversion"]==0?'-':number_format($stock["conversion"],2);?></td>
                                <td align="right"><?php echo $stock["transfer"]==0?'-':number_format($stock["transfer"],2);?></td>
                                <td align="right"><?php echo $stock["purchase"]==0?'-':number_format($stock["purchase"],2);?></td>
                                <td align="right"><?php echo $stock["salesreturn"]==0?'-':number_format($stock["salesreturn"],2);?></td>
                                <td align="right"><?php echo $stock["loantaken"]==0?'-':number_format($stock["loantaken"],2);?></td>
                                <td align="right"><?php echo $stock["samplereturn"]==0?'-':number_format($stock["samplereturn"],2);?></td>
                                <td align="right"><?php echo $stock["lc"]==0?'-':number_format($stock["lc"],2);?></td>
                                <td align="right"><?php echo number_format($receiveTotal,2);?></td>
                                <td align="right"><?php echo $stock["conversionout"]==0?'-':number_format($stock["conversionout"],2);?></td>
                                <td align="right"><?php echo $stock["transferout"]==0?'-':number_format($stock["transferout"],2);?></td>
                                <td align="right"><?php echo $stock["sales"]==0?'-':number_format($stock["sales"],2);?></td>
                                <td align="right"><?php echo $stock["loangiven"]==0?'-':number_format($stock["loangiven"],2);?></td>
                                <td align="right"><?php echo $stock["freesample"]==0?'-':number_format($stock["freesample"],2);?></td>
                                <td align="right"><?php echo number_format($outTotal,2);?></td>
                                <td align="right"><?php echo number_format($currentBalance,2);?></td>
                                <td align="right"><?php echo number_format($loanBalance,2);?></td>
                                <td align="right"><?php echo number_format($currentBalanceWithLoan,2);?></td>
                                <td align="right"><?php echo number_format($productRate[$stock['product_id']],2);?></td>
                                <!-- <td align="right"><?php echo number_format($stock["product_rate"],2);?></td> -->
                                <td align="right"><?php echo number_format($currentBalanceAmountC,2);?></td>
                            </tr>
                       
                                <?php
                           // $grandTotal += $invoice["itemtotal"];
                            }

                    ?>
                    <tr>
                            <td colspan="2">Total</td>
                            <td align="right"></td>
                            <td align="right"></td>
                            <td align="right"></td>
                            <td align="right"></td>
                            <td align="right"></td>
                            <td align="right"></td>
                            <td align="right"></td>
                            <td align="right"></td>
                            <td align="right"><?php echo number_format($grandReceive,2);?></td>
                            <td align="right"></td>
                            <td align="right"></td>
                            <td align="right"></td>
                            <td align="right"></td>
                            <td align="right"></td>
                            <td align="right"><?php echo number_format($grandOut,2);?></td>
                            <td align="right"><?php echo number_format($grandBalanceQty,2);?></td>
                            <td align="right"><?php echo number_format($grandLoanQty,2);?></td>
                            <td align="right"><?php echo number_format($grandBalanceWithLoan,2);?></td>
                            <td align="right"></td>
                            <td align="right"><?php echo number_format($grandAmountC,2);?></td>
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
<script>
    $(function(){
        $("#fromDate").datepicker();
        $("#toDate").datepicker();
    });
</script>
</body>
</html>
