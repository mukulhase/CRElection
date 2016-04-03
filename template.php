<!DOCTYPE html>
<html>
	<head>
		<title>Election Portal</title>
		<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
		<meta content="utf-8" http-equiv="encoding">
		<link href='<?php echo $base_url; ?>css/normalize.css' rel='stylesheet'>
		<link href='<?php echo $base_url; ?>css/main.css' rel='stylesheet'>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href='<?php echo $base_url; ?>css/jquery-ui.min.css'>
		<link rel="stylesheet" href='<?php echo $base_url; ?>css/theme.css'>
		<link rel="stylesheet" href='<?php echo $base_url; ?>css/template.css'>

		<script src="<?php echo $base_url; ?>js/jquery.js"></script>
		<script src="<?php echo $base_url; ?>js/jquery-ui.js"></script>
	</head>
	<script>
		function dialogSpawn(text){
			var dynamicDialog = $('<div id="MyDialog">\
            <P>'+text+'</P>\
            </div>');
			dynamicDialog.dialog();
		}

	</script>
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
