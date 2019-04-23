<?php
include('db_connect.php');

$action = $_GET['action'];

if($action == 'insert'){
	$ic = $_POST['ic'];
	$adult = $_POST['adult'];
	$children = $_POST['children'];
	$infans = $_POST['infans'];

	$sql_check = "SELECT COUNT(ic) AS ttlBook
				  FROM booking
				  WHERE ic = '$ic'";
	$result_check = $conn->query($sql_check);
	$row_check = $result_check->fetch_array();
	$ttlBook = $row_check['ttlBook'];

	if($ttlBook > '2'){
		echo "Maximum number of room per booking is 3";
	}else{
		$sql_insert = "INSERT INTO booking
					   (ic, adult, children, infants, status)
					   VALUES
					   ('$ic', '$adult', '$children', '$infans', '')";
		$result_insert = $conn->query($sql_insert);
	}
}
if($action == 'update'){
	$icNo = $_POST['icNo'];

	$sql_update = "UPDATE booking
				   SET status = 'Confirm'
				   WHERE ic = '$icNo'";
	$result_update = $conn->query($sql_update);
}
if($action == 'del'){
	$idbook = $_POST['idbook'];

	$sql_del = "DELETE FROM booking
				   WHERE id_book = '$idbook'";
	$result_del = $conn->query($sql_del);
}
?>