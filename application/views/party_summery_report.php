<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Sumcon Biotechnology | Party ledger</title>
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
                    <h1>Summery Party Ledger</h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Sales</a></li>
                        <li class="active">Summery Party Ledger</li>
                    </ol>
                </section>
                <!-- Main content -->
                <section >
                    <div class="box-body">
                        <form role="form" action="<?php echo base_url()?>sales/summerypartyledger" method="post">
                            <div class="col-md-8">
                                <label>Party Type</label>
                                <select class="form-control select2" name="balanceType" id="balanceType" >
                                    <option value="">Select Type</option>
                                    <option value="Debtor">Debtor</option>
                                    <option value="Creditor">Creditor</option>
                                </select>
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
                if(isset($transectionData)) {
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
                            <a href="<?php echo base_url(); ?>sales/printsummerypartyledger/<?php echo $balanceType; ?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
                        </div>
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-xs-12" style="text-align: center;">
                            <h2 >Party summery ledger</h2>
	                     </div>
                    </div><!-- /.row -->
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <th class="text-center">Sl #</th>
                                        <th class="text-center">Party Name</th>
                                        <th class="text-center">Due Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $i=0;
                                    $totalDue = 0 ;
                                    $dueAmount = 0;
                                    $tempSection ='';
                                    $typeTotal=0;
        							/*if($balanceType=="Dr")
        								$operator = ' > ';
        							else if($balanceType=='Cr')
        								$operator = ' < ';
        							else
        								$operator = ' != ';*/

                                    foreach ($transectionData as $transection){
                                        if($transection['client_type']=='Debtor'){
                                            $dueAmount=$transection["opening_balance"]+$transection["invoicetotal"]+$transection['pay_amount']- ($transection['purchase_amount']+$transection['under_invoice_amount']);
                                        } else{
                                            $dueAmount=$transection["opening_balance"]-($transection["invoicetotal"]+$transection['pay_amount'])+($transection['purchase_amount']+$transection['under_invoice_amount']); 
                                        }
                                        if($tempSection!=$transection['client_section']){
                                    
                                            if($tempSection!=''){
                                    ?>
                                            <tr>                                            
                                                <td colspan="2"><strong>Total</strong></td>
                                                <td align="right"><strong><?php echo number_format($typeTotal,2);?></strong></td>
                                            </tr>

                                    <?php
                                            $typeTotal=0;
                                            }
                                    ?>
                                        <tr>                                            
                                            <td colspan="3"><strong><?php echo $transection['client_section'];?></strong></td>
                                        </tr>
                                    <?php
                                            $tempSection=$transection['client_section'];
                                            $i=0;

                                        }
                                    /*$dueAmount = $transection["opening_balance"]+$transection["invoicetotal"]+$transection['pay_amount']-($transection['purchase_amount']+$transection['under_invoice_amount']+$transection['collection']+$transection['return_amount']+$transection['sales_discount']+$transection['source_tax']);*/
                                    $dueAmount = $dueAmount+$transection['misc_transection']-($transection['collection']+$transection['return_amount']+$transection['sales_discount']+$transection['source_tax']);

		                               
                                         $typeTotal += $dueAmount;
                                         $totalDue += $dueAmount;
                                         if($dueAmount!=0){
                                 ?>
                                        <tr>
                                            <td><?php echo ++$i;?></td>
                                            <td align=""><?php echo $transection['client_name'];?></td>
                                            <td align="right"><?php echo number_format($dueAmount,2);?></td>
                                        </tr>
                                <?php
                                        
                                    }
                                }
                                ?>
                                <tr>                                            
                                    <td colspan="2"><strong>Total</strong></td>
                                    <td align="right"><strong><?php echo number_format($typeTotal,2);?></strong></td>
                                </tr>
                                <tr>
                                    <td><strong>Grand Total</strong></td>
                                    <td align=""></td>
                                    <td align="right"><strong><?php echo number_format($totalDue,2);?></strong></td>
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
