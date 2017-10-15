<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sumcon Biotechnology  | Delivery</title>
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

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
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
              <h2 >Chart of Accounts</h2>
						</div>

				</div>

        <!-- Table row -->
        <div class="row"  style="font-size: 7pt;">
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped table-bordered" align="center" style="width: 96%;">
                  <thead class="text-center">
                    <tr>
                          <th class="text-center">Sl #</th>
                          <th class="text-center">Accounts Name</th>
                          <th class="text-center">Financial Statement</th>
                          <th class="text-center">Group</th>
                          <th class="text-center">Sub-Group</th>
                          <th class="text-center">Accounts Type</th>

                    </tr>

                </thead>
                <tbody>
                  <?php
                        $i=0;
                        foreach ($chartOfAccountsList as $accountsHead){
                    ?>

                            <tr>
                                <td><?php echo ++$i;?></td>
                                <td><?php echo $accountsHead["head_name"];?></td>
                                <td><?php echo $accountsHead["financial_statement"];?></td>
                                <td><?php echo $accountsHead["group_name"];?></td>
                                <td><?php echo $accountsHead["sub_group_name"];?></td>
                                <td><?php echo $accountsHead["transection_type"];?></td>
                            </tr>
                                <?php
                           // $grandTotal += $invoice["itemtotal"];
                            }

                    ?>

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
      </section><!-- /.content -->
    </div><!-- ./wrapper -->

    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>dist/js/app.min.js"></script>
  </body>
</html>
