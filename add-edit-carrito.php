<?php
    session_start();
    if (isset($_POST['addProduct'])) {
        $product_id = $_POST['idProducto'];
        $user_id = $_SESSION['user_id'];
        $db_connection = new mysqli('localhost:3306', 'root', '', 'storedb');
        $mysql_statement = "CALL SP_ALTER_CARRITO(1, ".$user_id.", ".$product_id.")";
        $query_result = mysqli_query($db_connection, $mysql_statement);
        if($query_result)
            echo json_encode(array('result' => 1));
        else 
            echo json_encode(array('result' => 0));
        mysqli_close($db_connection);
    }
    if (isset($_POST['alterQuantity'])) {
        $product_id = $_POST['product_id'];
        $product_quantity = $_POST['cantidad'];
        $user_id = $_SESSION['user_id'];

        $db_connection   = new mysqli('localhost:3306', 'root', '', 'storedb');
        $mysql_statement = "CALL SP_ALTER_CART_QUANTITY($product_quantity, $product_id, $user_id)";
        $query_result = mysqli_query($db_connection, $mysql_statement);
        if ($query_result) {
            echo json_encode(array('success' => true));
        }
        else 
            echo json_encode(array('success' => false));
        mysqli_close($db_connection);
    }
    if (isset($_POST['comprar'])) {
        $user_id = $_SESSION['user_id'];

        $db_connection = new mysqli('localhost:3306', 'root', '', 'storedb');
        $mysql_statement = "CALL SP_COMPRAR_CARRITO(".$user_id.")";
        $query_result = mysqli_query($db_connection, $mysql_statement);
        if ($query_result) {
            echo json_encode(array('success' => true));
        }
        else 
            echo json_encode(array('success' => false));
    }
?>