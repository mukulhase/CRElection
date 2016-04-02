<?php
	$auth_required = true;
	include('../config.php');

	$total_votes = 0;
	$total_n_votes = 0;
	$htmlOutput = '<table class="result"><tr><th>Candidate ID</th><th>Candidate Name</th></tr>';

	$query = mysqli_prepare($DB, "SELECT id,name FROM `candidates`");
	mysqli_stmt_execute($query);
	mysqli_stmt_bind_result($query, $id, $name);
	mysqli_stmt_store_result($query);
	while(mysqli_stmt_fetch($query)){
		$htmlOutput .= '<tr><th>'.$id.'</th><td>'.$name.'</td></tr>';
	}
	$htmlOutput.= '</table><table><tr><th>Vote ID</th><th>Candidate ID</th><th>Rank</th></tr>';
	$query = mysqli_prepare($DB, "SELECT voteid,candidate,rank FROM `ranks`");
	mysqli_stmt_execute($query);
	mysqli_stmt_bind_result($query, $voteid, $candidate, $rank);
	mysqli_stmt_store_result($query);
	while(mysqli_stmt_fetch($query)){
		$htmlOutput .= '<tr><th>'.$voteid.'</th><td>'.$candidate.'</td><td>'.$rank.'</td></tr>';
	}
	$htmlOutput .= '</table>';
	$htmlOutput.= '<script> var votes=[];';
	$query = mysqli_prepare($DB, "SELECT voteid,candidate,rank FROM `ranks`");
	mysqli_stmt_execute($query);
	mysqli_stmt_bind_result($query, $voteid, $candidate, $rank);
	mysqli_stmt_store_result($query);
	while(mysqli_stmt_fetch($query)){
		$htmlOutput .= '
		if('.$voteid.' in votes){
			votes['.$voteid.']['.$rank']
		var vote={"voteid":'.$voteid.',"candidate":'.$candidate.',"rank":'.$rank.'};votes.push(vote);';
	}
	$htmlOutput .= 'console.log(votes);</script>';

	$htmlOutput .= "<br><br><br><br><a class='btn btn-green' href='".$base_url."admin/'>Go to Allow Voting</a>";

	include("../template.php");
