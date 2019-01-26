<?php
    session_start();
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        try
        {
            $db_connection = new mysqli('localhost:3306', 'root', '', 'storedb');
            if(isset($_POST["productSubmit"]))
            {
                $product_name     = mysqli_real_escape_string($db_connection, $_POST["productName"]);
                $product_desc     = mysqli_real_escape_string($db_connection, $_POST["productDescription"]);
                $product_quantity = mysqli_real_escape_string($db_connection, $_POST["productQuantity"]);
                $product_price    = mysqli_real_escape_string($db_connection, $_POST["productPrice"]);
                $product_disc     = $_POST["productDiscount"];
                $isProductPublic  = isset($_POST["isPublic"]);

                $product_img1     = addslashes(file_get_contents($_FILES['productImgs']['tmp_name'][0]));
                $product_img2     = addslashes(file_get_contents($_FILES['productImgs']['tmp_name'][1]));
                $product_img3     = addslashes(file_get_contents($_FILES['productImgs']['tmp_name'][2]));

                $product_img1Type = $_FILES['productImgs']['type'][0];
                $product_img2Type = $_FILES['productImgs']['type'][1];
                $product_img3Type = $_FILES['productImgs']['type'][2];

                $video_type       = $_FILES['productVideo']['type'];
                $random_num       = date(DATE_RSS);
                $video_name       = $_FILES['productVideo']['name'];
                
                $video_tmp_path   = $_FILES['productVideo']['tmp_name'];

                $milisegundos = round(microtime(true) * 1000);
                $video_path   = "vid/".$milisegundos."".$video_name;
                
                if (move_uploaded_file($video_tmp_path, "$video_path")) {
                    echo "se movio el video de la ubicacion";
                }

                $mysql_query = "CALL SP_ALTER_PRODUCTO(1, 0,'".$product_name."','".$product_desc."',".$product_quantity.",".$product_price.",".$product_disc.",".$isProductPublic.", ".$_SESSION['user_id'].",'".$product_img1."', '".$product_img1Type."', '".$product_img2."', '".$product_img2Type."', '".$product_img3."', '".$product_img3Type."', '".$video_path."', '".$video_type."')";
                $query_result = mysqli_query($db_connection, $mysql_query);
                if($query_result)
                {
                    $result = mysqli_fetch_array($query_result, MYSQLI_ASSOC);
                    if(isset($result["result"]))
                    {
                        $product_id = $result["result"];

                        mysqli_close($db_connection);
                            if (isset($_POST['cats1'])) {
                                $product_category1 = $_POST['cats1'];
                                $db_connection = new mysqli('localhost:3306', 'root', '', 'storedb');
                                $mysql_query = "CALL SP_ADD_PRODUCTO_CATEGORIA(".$product_id.",".$product_category1.")";
                                $query_result = mysqli_query($db_connection, $mysql_query);
                                if (!$query_result) {
                                     echo "pasó algo";
                                }
                                mysqli_close($db_connection);
                            }

                            if (isset($_POST['cats2'])) {
                                $product_category2 = $_POST['cats2'];
                                $db_connection = new mysqli('localhost:3306', 'root', '', 'storedb');
                                $mysql_query = "CALL SP_ADD_PRODUCTO_CATEGORIA(".$product_id.",".$product_category2.")";
                                $query_result = mysqli_query($db_connection, $mysql_query);
                                if (!$query_result) {
                                     echo "pasó algo";
                                }
                                mysqli_close($db_connection);
                            }

                            if (isset($_POST['cats3'])) {
                                $product_category3 = $_POST['cats3'];
                                $db_connection = new mysqli('localhost:3306', 'root', '', 'storedb');
                                $mysql_query = "CALL SP_ADD_PRODUCTO_CATEGORIA(".$product_id.",".$product_category3.")";
                                $query_result = mysqli_query($db_connection, $mysql_query);
                                if (!$query_result) {
                                     echo "pasó algo";
                                }
                                mysqli_close($db_connection);
                            }

                        echo '<script>prompt("Producto registrado")</script>';
                        header("location: profile.php");
                    }
                    else 
                    {
                        echo '<script>prompt("revise que la informacion del producto sea correcta")</script>';
                    }
                }
                else 
                {
                    echo 'Ocurrió un error';
                }
            }
            echo "Ocurrio un error";
        }
        catch(Exception $e)
        {

        }
    }
?>