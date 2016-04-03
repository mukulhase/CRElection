<?php
	//Submit Request
	require_once("config.php");
	session_start();

	function block_voting() {
		global $DB, $IP;
		$query = mysqli_prepare($DB, "UPDATE `clients` set allow_vote = 0 WHERE ip = ? ");
		mysqli_stmt_bind_param($query, 's', $IP);
		if ( !mysqli_stmt_execute($query) ) {
			die("Some Error Occured. Contact Administrator.");
		}
	}

	if ( !allowed() ) {
		header("Location: ".$base_url);
		die();
	}
	if ( true ) {
		$valid = true;
		foreach (range(1,$countCand) as $index){
			if(!isset( $_POST[$index] )){
				$valid = false;
				break;
			}
		}
		// Process votes
		if ( !$valid ) {
			block_voting();
			die("Something is wrong");
		}
		//insert into db, to be changed
		$query = mysqli_prepare($DB, "INSERT INTO `votes` VALUES()");
		if ( !mysqli_stmt_execute($query) ) {
			die("Some Error Occured. Response is not recorded. Contact Administrator.");
		}
		$voteid=mysqli_insert_id($DB);
		foreach ( range(1,$countCand) as $index ) {
			$query = mysqli_prepare($DB, "INSERT INTO `ranks` (voteid,candidate,rank) VALUES(?,?,?)");
			mysqli_stmt_bind_param($query, 'iii', $voteid,$_POST[$index],$index);
			if ( !mysqli_stmt_execute($query) ) {
				die("Some Error Occured. Response is not recorded. Contact Administrator.");
			}
		}
		block_voting();
	}
	else {
		block_voting();
		die("No Candidate Selected");
	}
	$_SESSION["done_voting"] = true;
	header("Location: ".$base_url);
