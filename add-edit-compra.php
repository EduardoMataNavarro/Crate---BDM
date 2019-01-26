<?php
	session_start();
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (isset($_POST['editScore'])) {
			$product_score = $_POST['calificacion'];
			$id_compra	   = $_POST['idCompra'];

			$db_connection   = new mysqli('localhost:3306', 'root', '', 'storedb');
			$mysql_statement = "CALL SP_ALTER_COMPRA_SCORE(".$id_compra.",".$product_score.")";
			$query_result    = mysqli_query($db_connection, $mysql_statement);
			if ($query_result) {
				echo json_encode(array('success' => true));
			}
			else 
				echo json_encode(array('success' => false));
			mysqli_close($db_connection);
		}
	}
?>