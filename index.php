<?php
require_once("config.php");
session_start();

$htmlOutput = '';
if (allowed()) {
    $htmlOutput .= "
			<script>
				function checkVotes(form) {
					var inputs = form.getElementsByTagName('input');
					var rankings =  $('#sortable2').sortable( \"toArray\" );
					if(rankings.length!=$countCand){
						dialogSpawn(\"You have to rank $countCand candidates!\");
						return false;
					}
					for ( i=0; i<$countCand; i++ ) {
						inputs[i].value=rankings[i];
					}
					return true;
				}
			</script>
			";
    $htmlOutput .= "<form action='vote.php' method='post' class='vote' onsubmit='return checkVotes(this)'>";
    if (count($candidates)) {
        $htmlOutput .= '
<table class="sortabletable" cellspacing="1">
<tr>
<th>Candidates</th><th>Your Ranking</th>
</tr>
<tr>
<td valign="top">
<ul id="sortable1" class="connectedSortable">';
        foreach ($candidates as $id => $name) {
            $htmlOutput .= "<li class=\"ui-state-default\" id='$id'>$name</li>";
        }
        $htmlOutput .= '
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
      placeholder: "ui-state-highlight"
    }).disableSelection();
  });
</script>
';
        foreach (range(1, count($candidates)) as $rank) {
            $htmlOutput .= "<input type='text' name='$rank' hidden>";
        }
        $htmlOutput .= "<input class='btn' type='submit' value='Vote'></form>";
    } else {
        $htmlOutput .= "No Candidates in the list.";
    }
} else {
    $htmlOutput .= "
<script>
document.body.onload=function(){
setInterval(function(){
$.get(\"check.php\", function(data, status){
        console.log(data);
        if(data==\"true\")window.location='';
    });
}, 1000);
}</script>";
    if (isset($_SESSION["done_voting"]) && $_SESSION["done_voting"]) {
        $htmlOutput .= "Your response has been recorded.<br><a class='btn' href=''>Refresh</a>";
        unset($_SESSION["done_voting"]);
    } else {
        $htmlOutput .= "<strong>Access denied.</strong> Please ask the administrator to allow you to vote. <br><a class='btn' href=''>Reload</a>";
    }
}
include('template.php');
