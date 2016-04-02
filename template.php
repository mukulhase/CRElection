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
	<script>
		function dialogSpawn(text){
			var dynamicDialog = $('<div id="MyDialog">\
            <P>'+text+'</P>\
            </div>');
			dynamicDialog.dialog();
		}

	</script>
	<style>
		.ui-state-highlight { height: 1.5em; line-height: 1.2em; }

		.sortabletable{
			width:100%;
			table-layout: fixed;
		}
		.sortabletable td{
			margin: 20px;
			padding: 10px;
		}
		#sortable1{
			list-style-type: none;
		}
		#sortable2{
			background-color: #ffffff;
			background-image: -webkit-repeating-radial-gradient(center center, rgba(0,0,0,.2), rgba(0,0,0,.2) 1px, transparent 1px, transparent 100%);
			background-image: -moz-repeating-radial-gradient(center center, rgba(0,0,0,.2), rgba(0,0,0,.2) 1px, transparent 1px, transparent 100%);
			background-image: -ms-repeating-radial-gradient(center center, rgba(0,0,0,.2), rgba(0,0,0,.2) 1px, transparent 1px, transparent 100%);
			background-image: repeating-radial-gradient(center center, rgba(0,0,0,.2), rgba(0,0,0,.2) 1px, transparent 1px, transparent 100%);
			-webkit-background-size: 3px 3px;
			-moz-background-size: 3px 3px;
			background-size: 3px 3px;
		}
		#sortable1, #sortable2 {
			min-height: 20px;
			padding: 5px 0 0 0;
			width:100%;
			border: 1px solid #000000;

		}
		#sortable1 li, #sortable2 li {

			text-align: center;
			margin: 0px 5px 5px 5px;
			padding: 5px;
			font-size: 1.2em;
		}
		#sortable2 li{
			margin: 0px 5px 5px 30px !important;

		}
		.dotted {
			padding: 2.25em 1.6875em;

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
