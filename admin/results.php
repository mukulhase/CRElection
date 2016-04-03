<?php
	$auth_required = true;
	include('../config.php');
	$htmlOutput = '<script>var CandidateMap={};';

	$query = mysqli_prepare($DB, "SELECT id,name FROM `candidates`");
	mysqli_stmt_execute($query);
	mysqli_stmt_bind_result($query, $id, $name);
	mysqli_stmt_store_result($query);
	while(mysqli_stmt_fetch($query)){
		$htmlOutput .= 'CandidateMap['.$id.']="'.$name.'";';
	}
	$votecount=0;
	$htmlOutput.= '</script>';
	$query = mysqli_prepare($DB, "SELECT count(DISTINCT voteid) FROM `ranks`");
	mysqli_stmt_execute($query);
	mysqli_stmt_bind_result($query, $votecount);
	mysqli_stmt_store_result($query);
	mysqli_stmt_fetch($query);
	$htmlOutput.= '
<script>
var votes=new Array('.$votecount.');
';
	$query = mysqli_prepare($DB, "SELECT voteid,candidate,rank FROM `ranks`");
	mysqli_stmt_execute($query);
	mysqli_stmt_bind_result($query, $voteid, $candidate, $rank);
	mysqli_stmt_store_result($query);
	while(mysqli_stmt_fetch($query)){
		$htmlOutput .= 'if(!votes['.($voteid-1).'])votes['.($voteid-1).']=new Array('.$countCand.');';
		$htmlOutput .= 'votes['.($voteid-1).']['.($rank-1).']='.$candidate.';';
	}
	$htmlOutput .= '</script>';
	include("stv/result.js.php");
	$htmlOutput .= "
	<div id='cand_list'>
	</div>
<script src='stv/big.js'></script>
<script src='stv/frontend.js'></script>
<script src='stv/results.js'></script>
<button class='btn btn-green' href='".$base_url."admin/'>Go to Allow Voting</button>
<button id='res_btn' class='btn btn-green' onclick='showResult();''>Show Result</button>
";
$htmlOutput.="
";
	include("../template.php");
