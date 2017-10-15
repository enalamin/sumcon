<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sumcon Biotechnology  | Party Ledger</title>
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

  </head>
  <body onload="window.print();">
    <div class="wrapper">
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

                                    /*$dueAmount = $transection["opening_balance"]+$transection["invoicetotal"]+$transection['pay_amount']-($transection['purchase_amount']+$transection['under_invoice_amount']+$transection['collection']+$transection['return_amount']+$transection['sales_discount']+$transection['source_tax']);*/
                                    $dueAmount = $dueAmount+$transection['misc_transection']-($transection['collection']+$transection['return_amount']+$transection['sales_discount']+$transection['source_tax']);

                                   
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
                                    <td>Total</td>
                                    <td align=""></td>
                                    <td align="right"><?php echo number_format($totalDue,2);?></td>
                                </tr>
                            </tbody>
                        </table>
              </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
    </div><!-- ./wrapper -->

    <script src="<?php echo base_url(); ?>dist/js/app.min.js"></script>
  </body>
</html>
