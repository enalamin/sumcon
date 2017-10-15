<!-- Main content -->
<div class="row col-xs-12">
    <!-- title row -->
	<div class="row ">
		<div class="col-xs-12 table-responsive text-center">
			<h3 style="text-decoration: underline;">Proforma Invoice Details</h3>
		</div><!-- /.col -->
	</div><!-- /.row -->
	<div class="row ">
		<div class="col-xs-6 table-responsive">
			<b>Proforma Invoice Number:</b> <?php echo $lcDetails[0]['pi_no'];?><br>
		</div><!-- /.col -->
		<div class="col-xs-6 table-responsive">
			<b>Proforma Invoice Date:</b> <?php echo $lcDetails[0]['pi_date']?><br>
		</div><!-- /.col -->
	</div><!-- /.row -->
	<div class="row">
		<div class="col-xs-6 table-responsive">
			<b>Supplier Name:</b> <?php echo $lcDetails[0]['client_name'];?><br>
		</div><!-- /.col -->
		<div class="col-xs-6 table-responsive">
			<b>Bank Info:</b> <?php echo $lcDetails[0]['bank_info'];?><br>
		</div>
        <div class="col-xs-6 table-responsive">
			<b>Invoice Amount : $</b> <?php echo number_format($lcDetails[0]['invoice_amount'],2);?><br>
		</div>
	</div><!-- /.row -->
	<div class="row">
		<div class="col-xs-6 form-group">
			<b>LC Number:</b> <?php echo $lcDetails[0]['lc_no'];?><br>
		</div>
        <div class="col-xs-6 form-group">
			<b>LC Current Status:</b> <?php echo $lcDetails[0]['status'];?> &nbsp;&nbsp;&nbsp;
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-3">
            <label>Product</label><br/>
            <select class="form-control select2" name="productDescription" id="productDescription" style="width: 100%">
                <option value="">Select Product</option>
            <?php
                if(is_array($productList)){
                    foreach ($productList as $product){
            ?>
                    <option value="<?php echo $product["product_id"];?>"><?php echo $product["product_description"];?></option>
            <?php
                    }
                }
            ?>
            </select>
        </div>
        <div class="col-md-2">
            <label>Quantity </label>
            <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Enter ..." style="text-align: right;">
        </div>
        <div class="col-md-1">
            <label> unit </label>
            <select class="form-control select2" id="unit" name="unit" style="width: 100%">
                <option>KG</option>
                <option>Pice</option>
                <option>CM</option>
                <option>MM</option>
            </select>
        </div>
        <div class="col-md-1">
            <label>Rate($)</label>
            <input type="text" class="form-control" id="unitprice" name="unitprice" placeholder="Enter ...">
        </div>
        <div class="col-md-2">
            <label>Amount ($)</label>
            <input type="text" class="form-control" id="amount" name="amount" placeholder="Enter ...">
        </div>
        <div class="col-md-2">
            <label>Package Info</label>
            <input type="text" class="form-control" id="package" name="package" placeholder="Enter ...">
        </div>
         <div class="col-md-1">
            <label>&nbsp; </label>
            <input id="btn_add" name="btn_add" type="button" class="btn btn-primary btn-block" value="Add" />
        </div>
    </div>

    <div class="row form-group">
        <div class="col-xs-12">
            <br>
        </div>
    </div>
    <?php
        if($lcProductDetails && count($lcProductDetails)>0){
    ?>
    <div class="row">
        <div class="col-xs-12">
            <h3>Product Details</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 table-responsive">

            <table class="table table-striped" id="griddetails">
                <thead>
                    <tr>
                        <td>Serial #</td>
                        <td>Product</td>
                        <td align="right">Invoice Qty </td>
                        <td align="right">Rate $</td>
                        <td align="right">Amount $</td>
                        <td>Package Info </td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $i=0;
                    $grandTotal=0;
                    foreach ($lcProductDetails as $receive){
                        $itemTotal = $receive["lc_quantity"]*$receive["unit_dollar_price"];
                ?>
                    <tr>
                        <td><?php echo ++$i;?></td>
                        <td><?php echo $receive["product_description"];?><input type='hidden' name='productid[]' value='<?php echo $receive["product_id"];?>'></td>
                        <td ><input type="text" name="product_qty[]" value="<?php echo $receive["lc_quantity"];?>" style="width: 80%;text-align: right;">Kg</td>
                        <td >$<input type="text" name="product_rate[]" value="<?php echo $receive["unit_dollar_price"];?>" style="width: 80%;text-align: right;"></td>
                        <td class='itemTotal'>$ <input type="text" name="product_total[]" value="<?php echo number_format($itemTotal,2,'.','');?>" style="width: 80%;text-align: right;"></td>
                        <td><input type="text" name="product_package[]" value="<?php echo $receive["package"];?>"></td>
                        <td><button type='button' class='removebutton' title='Remove this row'>X</button></td>
                    </tr>
                <?php
                    $grandTotal += $itemTotal;
                    }
                ?>
                    
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">Total</td>
                        <td align="right">$<input type="text" name="grandTotal" id="grandTotal" value="<?php echo  number_format($grandTotal,2,'.','');?>" readonly style="width: 80%;text-align: right;"><input type="hidden" name="totalItemRow" id="totalItemRow" value="<?php echo $i;?>" readonly > </td>
                        <td></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div><!-- /.col -->
    </div><!-- /.row -->
    <?php } ?>
</div><!-- /.content -->
<script type="text/javascript">
    var i=<?php echo $i; ?>;
    var invoiceTotal=<?php echo $grandTotal;?>;
    $(function () {
        
        $(".select2").select2();
        $("#quantity").change(function(){
            calculate();
        });
        $("#unitprice").change(function(){
            calculate();
        });
        $("#btn_add").click(function(){
            var product=$("#productDescription").val();
            var productDescription=$("#productDescription option:selected").text();
            var productQuantity=$("#quantity").val();
            var productUnit=$("#unit option:selected").text();
            var productPrice=$("#unitprice").val();
            var productAmount=$("#amount").val();
            var productPackage=$("#package").val();
            var currentContent = $("#griddetails").html();
            if(product!='' && productAmount!='' && productAmount>0){
                invoiceTotal += parseFloat(productAmount);
                $("#griddetails").append("<tr><td>"+(++i)+"</td><td>"+productDescription+"<input type='hidden' name='productid[]' value='"+product+"'></td><td><input type='text' name='product_qty[]' value='"+productQuantity+"' style='width: 80%;text-align: right;'>Kg</td><td>$<input type='text' name='product_rate[]' value='"+productPrice+"' style='width: 80%;text-align: right;'></td><td class='itemTotal'>$<input type='text' name='product_total[]' value='"+productAmount+"' style='width: 80%;text-align: right;'></td><td><input type='text' name='product_package[]' value='"+productPackage+"'></td>"
                +"<td><button type='button' class='removebutton' title='Remove this row'>X</button></td></tr>");
                restproductrow();
                
                $("#totalItemRow").val(i);
            }
            else{
                alert("check your entry");
            }
            if(i>0){
                
                $("#grandTotal").val(invoiceTotal.toFixed(2));
            }
        });         
    });
    $(document).on('click', 'button.removebutton', function () {
        if(confirm("Do you want to remove this?")){
            var currentRowTotal = $(this).closest('tr').find('.itemTotal input').val();
            $(this).closest('tr').remove();
            invoiceTotal -= parseFloat(currentRowTotal);
            i--;
            if(i>0){
                
                $("#grandTotal").val(invoiceTotal.toFixed(2));
            }
        }
        return false;
    });
    function calculate()
    {
        var productQuantity=$("#quantity").val();
        var productPrice=$("#unitprice").val();
        var amount = parseInt(productQuantity)*parseFloat(productPrice);
        if(!isNaN(amount)){
            amount = parseFloat(amount).toFixed(2);
        $("#amount").val(amount);
        }
    }
    function restproductrow()
    {
        $("#productDescription").val("");
        $("#quantity").val("");
        $("#unit").val("");
        $("#unitprice").val("");
        $("#amount").val("");
        $("#package").val("");
    }
    
</script>