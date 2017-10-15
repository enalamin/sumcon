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
            <h2 >
                Cash Book
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
        <?php
          $currentBalance = $openingBalance + $accountHeadDetails[0]["entry_balance"];
         ?>
        <tbody>
            <tr>
                <td colspan="3" align="center"><b>Opening Balance</b></td>

                <td colspan="3" align="right"></td>
                <td align="right"></td>
                <td align="right"><?php echo number_format($currentBalance,2);?></td>
            </tr>
            <?php
                $i=0;
            $totalDrAmount = $totalCrAmount = 0;
            $currentBalance = $openingBalance;
            foreach ($transectionData as $transection){
              $totalDrAmount += $transection['drAmount'];
              $totalCrAmount += $transection['crAmount'];


                $currentBalance += $transection['drAmount']-$transection['crAmount'];

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
