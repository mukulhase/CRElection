<?php
	//CR Election portal
	require_once("config.php");
	global $delegationSize;
	session_start();
	function get_candidates() {
		global $DB;
		$query = mysqli_prepare($DB, "SELECT id, name FROM `candidates` ORDER BY name");
		mysqli_stmt_execute($query);
		mysqli_stmt_bind_result($query, $id, $name);
		mysqli_stmt_store_result($query);
		$results = array();
		while(mysqli_stmt_fetch($query)){
			$results[$id] = $name;
		}
		return $results;
	}

	$htmlOutput = '';

	if ( allowed() ) {
		$htmlOutput .= "
			<script>
				function checkVotes(form) {
					var inputs = form.getElementsByTagName('input');
					var rankings =  $('#sortable2').sortable( \"toArray\" );
					if(rankings.length!=$delegationSize){
						dialogSpawn(\"You have to rank $delegationSize candidates!\");
						return false;
					}
					for ( i=0; i<$delegationSize; i++ ) {
						inputs[i].value=rankings[i];
					}
					return true;
				}
			</script>
			";
		$htmlOutput .= "<form action='vote.php' method='post' class='vote' onsubmit='return checkVotes(this)'>";
		$candidates = get_candidates();
		if ( count($candidates) ) {
			$htmlOutput .= '
<table class="sortabletable" cellspacing="1">
<tr>
<th>Candidates</th><th>Your Ranking</th>
</tr>
<tr>
<td valign="top">
<ul id="sortable1" class="connectedSortable">';
			foreach ( $candidates as $id => $name ){
				$htmlOutput .= "<li class=\"ui-state-default\" id='$id'>$name</li>";
			}
			$htmlOutput.= '
</ul>
</td>
 <td valign="top">
<ol id="sortable2" class="connectedSortable">
</ol>
</td>
</tr>
</table>
<script>
  $(function() {
    $( "#sortable1, #sortable2" ).sortable({
      connectWith: ".connectedSortable",
      placeholder: "ui-state-highlight",
      receive: function(event, ui) {
            if (($(this).children().length > ' . $delegationSize .' )&&(this.id=="sortable2")) {
                $(ui.sender).sortable(\'cancel\');
                dialogSpawn("Cannot add more candidates");
            }
        }
    }).disableSelection();
  });
</script>
';
			foreach ( range(1,$delegationSize) as $rank ){
				$htmlOutput .= "<input type='text' name='$rank' hidden>";
			}
			$htmlOutput .= "<input class='btn' type='submit' value='Vote'></form>";
		}
		else {
			$htmlOutput .= "No Candidates in the list.";
		}
	}
	else {
		if ( isset( $_SESSION["done_voting"] ) && $_SESSION["done_voting"] ) {
			$htmlOutput .= "Your response has been recorded.<br><a class='btn' href=''>Refresh</a>";
			$htmlOutput .= "<script>document.body.onload=function(){setTimeout(function(){window.location=''}, 3000)}</script>";
			unset($_SESSION["done_voting"]);
		}
		else {
			$htmlOutput .= "<strong>Access denied.</strong> Please ask the administrator to allow you to vote. <br><a class='btn' href=''>Reload</a>";
			$htmlOutput .= "<script>document.body.onload=function(){setTimeout(function(){window.location=''}, 1000)}</script>";
		}
	}

	include('template.php');
