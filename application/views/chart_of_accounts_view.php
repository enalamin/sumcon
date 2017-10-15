<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>>Sumcon Biotechnology | Chart of Accounts</title>
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
	<!-- iCheck -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/iCheck/flat/blue.css">
	<!-- Morris chart -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/morris/morris.css">
	<!-- jvectormap -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/jvectormap/jquery-jvectormap-1.2.2.css">
	<!-- Date Picker -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/datepicker/datepicker3.css">
	<!-- Daterange picker -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/daterangepicker/daterangepicker-bs3.css">
	<!-- bootstrap wysihtml5 - text editor -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

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
				Accounts<small>Chart of Accounts entry</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?php echo base_url()?>"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Accounts</li>
				<li class="active">Chart of Accounts</li>
			</ol>
		</section>
		<section class="content">
			<div class="row">
			<!-- left column -->
				<div class="col-md-4">
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">New Chart of Accounts Entry</h3>
						</div><!-- /.box-header -->
						<div class="box-body">
							<?php $action = ($chartOfAccountsDetails && $chartOfAccountsDetails[0]['accounts_head_id']>0? "/".$chartOfAccountsDetails[0]['accounts_head_id']:"");?>
							<form role="form" action="<?php echo base_url()?>chartofaccounts/create_chartofaccounts<?php echo $action;?>" method="post">
							<div class="form-group">
								<label>Name fo Account Head</label>
								<input type="text" class="form-control" placeholder="Enter ..." name="accountsHeadName" value="<?php echo $chartOfAccountsDetails && $chartOfAccountsDetails[0]['accounts_head_id']>0? $chartOfAccountsDetails[0]['head_name']:""?>" required>
							</div>
							<div class="form-group">
								<label>Financila Statement</label>
								<select class="form-control select2" name="financialStatement" id="financialStatement" required>
									<option value="">Select Financila Statement</option>
									<option value="Balance Sheet" <?php echo $chartOfAccountsDetails && $chartOfAccountsDetails[0]['accounts_head_id']>0 && $chartOfAccountsDetails[0]['financial_statement']=='Balance Sheet'? "selected":""?> >Balance Sheet</option>
									<option value="Income Statement" <?php echo $chartOfAccountsDetails && $chartOfAccountsDetails[0]['accounts_head_id']>0 && $chartOfAccountsDetails[0]['financial_statement']=='Income Statement'? "selected":""?> >Income Statement</option>
								</select>
							</div>
							<div class="form-group">
								<label>Group</label>
								<select class="form-control select2" name="accountsGroup" id="accountsGroup" required>
									<option value="">Select Group</option>
									<?php
										if(is_array($groupList)){
											foreach ($groupList as $group){

									?>
											<option value="<?php echo $group["group_id"];?>" <?php echo $chartOfAccountsDetails && $chartOfAccountsDetails[0]['accounts_head_id']>0 && $group["group_id"]==$chartOfAccountsDetails[0]['group_id']? "selected":""?> ><?php echo $group["group_name"];?></option>
									<?php
											}
										}
									?>
								</select>
							</div>
							<div class="form-group">
								<label>Sub Group </label>
								<select class="form-control select2" name="accountsSubGroup" id="accountsSubGroup" required>
									<option value="">Select Sub Group</option>
								</select>
							</div>
							<div class="form-group">
							<label>Accounts Type</label>
								<select class="form-control select2" name="accountsType" id="accountsType" required>
									<option value="">Accounts Type</option>
									<option value="Debit" <?php echo $chartOfAccountsDetails && $chartOfAccountsDetails[0]['accounts_head_id']>0 && $chartOfAccountsDetails[0]['transection_type']=='Debit'? "selected":""?> >Debit</option>
									<option value="Credit" <?php echo $chartOfAccountsDetails && $chartOfAccountsDetails[0]['accounts_head_id']>0 && $chartOfAccountsDetails[0]['transection_type']=='Credit'? "selected":""?> >Credit</option>
								</select>
							</div>
							<div class="form-group">
								<div class="col-xs-6">
									<input id="btn_save" name="btn_save" type="submit" class="btn btn-primary btn-block" value="Save" />
								</div>
								<div class="col-xs-6">
									<input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-block btn-danger" value="Cancel" />
								</div>
							</div>
							</form>
						</div><!-- /.box-body -->
					</div>
				</div>
				<div class="col-md-8">
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">Chart of Accounts List</h3>
						</div><!-- /.box-header -->
						<div class="box-body">
							<table id="example1" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Head ID</th>
										<th>Accounts Head Name</th>
										<th>Financial Statement</th>
										<th>Group</th>
										<th>Sub Group</th>
										<th>Accounts Type</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
								<?php
									if(is_array($chartOfAccountsList) && !empty($chartOfAccountsList)){
										foreach ($chartOfAccountsList as $accountsHead){

								?>
									<tr>
										<td><?php echo $accountsHead["accounts_head_id"];?></td>
										<td><?php echo $accountsHead["head_name"];?></td>
										<td><?php echo $accountsHead["financial_statement"];?></td>
										<td><?php echo $accountsHead["group_name"];?></td>
										<td><?php echo $accountsHead["sub_group_name"];?></td>
										<td><?php echo $accountsHead["transection_type"];?></td>
										<td>
											<?php
												if($this->session->userdata('userType')=="admin"){
											?>
												<a href="<?php echo base_url(); ?>Chartofaccounts/edit_chartofaccounts/<?php echo $accountsHead["accounts_head_id"];?>" class="btn btn-block btn-primary">Edit</a>
											<?php
												}
											?>
										</td>
									</tr>
								<?php
										}
									}
								?>
								</tbody>
							</table>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
				</div>
			</div>
		</section>
	</div><!-- /.content-wrapper -->
	<?php include_once 'footer.php';?>
</div><!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="<?php echo base_url(); ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
	$.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.5 -->
<script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.min.js"></script>

<!-- Sparkline -->
<script src="<?php echo base_url(); ?>plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo base_url(); ?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url(); ?>plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url(); ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo base_url(); ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url(); ?>plugins/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->

<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>dist/js/demo.js"></script>
<!-- page script -->
    <script>
      $(function () {
        $("#example1").DataTable();
				$("#accountsGroup").change(function(){
					var options="<option value=''>Select Sub Group</option>";
					$.ajax({
							url: '<?php echo base_url()?>chartofaccounts/getsubgroups/'+$(this).val(),
							dataType: 'json',
							complete: function(data){
									var responses = JSON.parse(data.responseText);
									//if(responses.length>0)

										for(var subgroup in responses){

											options += "<option value='"+responses[subgroup].sub_group_id+"'>"+responses[subgroup].sub_group_name+"</option>";
										}
										$("#accountsSubGroup").html(options);
									//window.location = '<?php echo base_url()?>user';
							}
					});
				});

      });
      function removeUser(userId)
      {
          if(confirm("Do you want to Delete this user?")){
              if(userId>0){
                  $.ajax({
                      type: "POST",
                      url: '<?php echo base_url()?>user/removeuser/'+userId,
                      dataType: 'json',
                      complete: function(data){
                          var responses = data.responseText;
                          if(responses.length>0)
                            alert(responses)
                          window.location = '<?php echo base_url()?>user';
                      }
                  });
              }
              else
                  alert("select User");

          }
      }
    </script>
</body>
</html>
