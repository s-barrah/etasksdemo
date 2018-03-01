<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
     <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title><?php echo $pageTitle; ?></title>
	
	<!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	
	<!-- bootstrap datepicker -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datepicker3.css">
	
	<!-- Bootstrap DateTimePicker CSS -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-datetimepicker.min.css" />
	
	<!-- JQuery UI CSS -->
	<link href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />
	
	<!-- Font Awesome -->
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	
	<!-- Custom Theme Style -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/app.css?<?php echo time();?>" media="all"/>
	
	<script type="text/javascript">var baseurl = "<?php echo base_url(); ?>";</script>
</head>
<body id="<?php echo $pageID; ?>">

	<div id="load"></div>

	<!-- -->
	<div class="">
		<!-- Static navbar -->
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>'"><img alt="Brand" class="logo" src="<?php echo base_url('assets/images/logo/logo.png');?>" ></a>
				</div>
				<div id="navbar" class="navbar-collapse collapse">
				
					<ul class="nav navbar-nav">
						<li><a href="<?php echo base_url();?>">HOME <span class="sr-only">(current)</span></a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="<?php echo base_url('tasks');?>">TASKS</a></li>
						
					</ul>
				</div><!--/.nav-collapse -->
			</div><!--/.container-fluid -->	
		</nav>
	</div><!-- /.container-->
		
	