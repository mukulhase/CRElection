<!DOCTYPE html>
<html>
	<head>
		<title>Election Portal</title>
		<link href='<?php echo $base_url; ?>css/normalize.css' rel='stylesheet'>
		<link href='<?php echo $base_url; ?>css/main.css' rel='stylesheet'>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<link rel="stylesheet" href="/resources/demos/style.css">
	</head>
	<style>

		.sortabletable{
			width:100%;
		}
		.sortabletable td{
			margin: 20px;
		}
		#sortable1{
			list-style-type: none;
		}
		#sortable1, #sortable2 {
			border: 1px solid #000000;
			min-height: 20px;
			margin: 0;
			padding: 5px 0 0 0;
			width:100%;
		}
		#sortable1 li, #sortable2 li {
			margin: 0px 5px 5px 5px;
			padding: 5px;
			font-size: 1.2em;
		}
		#sortable2 li{
			margin: 0px 5px 5px 30px !important;

		}
	</style>
	<body>
		<div class='navbar'>
			<div class='nav left'><?php echo $electionName; ?></div>
			<div id="messages-container">
				<div class="message" id="message-example"></div>
			</div>
		</div>
		<div class='container'>
			<?php
				echo $htmlOutput;
			?>
		</div>
	</body>
</html>
