<?php
    session_start();
    if(isset($_POST["submitComment"]))
    {
        $db_connection = new mysqli('localhost:3306', 'root', '', 'storedb');
        $user_id = $_SESSION["user_id"];
        $comment = mysqli_real_escape_string($db_connection, $_POST["commentText"]);
        $product_id = $_POST["productId"];
        $mysql_statement = "CALL SP_ALTER_COMENTARIO(1, 0,".$user_id.",".$product_id.",'".$comment."')";
        $query_result = mysqli_query($db_connection, $mysql_statement);
        if($query_result)
        {
            $row = mysqli_fetch_array($query_result, MYSQLI_ASSOC);
            if(isset($row['idComentario']))
            {
                header("location: product.php?id=".$product_id."");
            }
        }
    }
?>