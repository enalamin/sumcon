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

           Current Stock Report

            

          </h1>

          <ol class="breadcrumb">

            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

            <li><a href="#">Inventory</a></li>

            <li class="active">Stock Report</li>

          </ol>

        </section>



 

        <!-- Main content -->

        

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

              <a href="<?php echo base_url(); ?>product/printstockreport/<?php echo $this->session->has_userdata('locationId');?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>

            </div>

          </div>

          <!-- info row -->

          <div class="row invoice-info">

            <div class="col-xs-12" style="text-align: center;">

                    <h2 >

                        stock report

                    </h2>

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
                        <th >Sample</th>
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

                        $grandReceive = $grandOut = $grandBalanceQty = $grandAmount = $grandBalanceWithLoan = $grandLoanQty = 0;

                            foreach ($stockData as $stock){

                               // $receiveTotal = $outTotal=$currentBalance=0;

                                $receiveTotal = $stock["conversion"]+$stock["transfer"]+$stock["purchase"]+$stock["salesreturn"]+$stock["loantaken"]+$stock["samplereturn"]+$stock["lc"];

                                $outTotal = $stock["conversionout"]+$stock["transferout"]+$stock["sales"]+$stock["loangiven"]+$stock["freesample"];

                                $currentBalance = $stock["openingbalance"]+$receiveTotal-$outTotal;

                                

                                $loanBalance= $stock["loanbalance"]+$stock["loangiven"]-$stock["loantaken"];

                                $currentBalanceWithLoan = $currentBalance + $loanBalance;

                                $currentBalanceAmount = $currentBalanceWithLoan*$stock["product_rate"];

                                if($stock["openingbalance"]==0 && $receiveTotal==0 && $outTotal==0 && $currentBalance==0 && $loanBalance==0){

                                    continue;

                                }

                                $grandReceive += $receiveTotal; 

                                $grandOut += $outTotal; 

                                $grandBalanceQty += $currentBalance; 

                                $grandLoanQty += $loanBalance;

                                $grandBalanceWithLoan += $currentBalanceWithLoan;

                                $grandAmount += $currentBalanceAmount; 

                    ?>

                       

                            <tr>

                                <td><?php echo ++$i;?></td>

                                <td ><?php echo $stock["product_description"];?></td>

                                <td align="right"><?php echo number_format($stock["openingbalance"],2);?></td>

                                <td align="right"><?php echo $stock["conversion"];?></td>

                                <td align="right"><?php echo $stock["transfer"];?></td>

                                <td align="right"><?php echo $stock["purchase"];?></td>

                                <td align="right"><?php echo $stock["salesreturn"];?></td>
                                <td align="right"><?php echo $stock["samplereturn"];?></td>
                                <td align="right"><?php echo $stock["lc"];?></td>

                                <td align="right"><?php echo $stock["loantaken"];?></td>

                                <td align="right"><?php echo $receiveTotal;?></td>

                                <td align="right"><?php echo $stock["conversionout"];?></td>

                                <td align="right"><?php echo $stock["transferout"];?></td>

                                <td align="right"><?php echo $stock["sales"];?></td>

                                <td align="right"><?php echo $stock["loangiven"];?></td>

                                <td align="right"><?php echo $stock["freesample"];?></td>

                                <td align="right"><?php echo $outTotal;?></td>

                                <td align="right"><?php echo number_format($currentBalance,2);?></td>

                                <td align="right"><?php echo number_format($loanBalance,2);?></td>

                                <td align="right"><?php echo number_format($currentBalanceWithLoan,2);?></td>

                                <td align="right"><?php echo number_format($stock["product_rate"],2);?></td>

                                <td align="right"><?php echo number_format($currentBalanceAmount,2);?></td>

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

                            <td align="right"><?php echo number_format($grandAmount,2);?></td>

                    </tr>

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

          

        </section><!-- /.content -->

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