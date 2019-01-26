<?php
    session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Profile</title>
		<meta charset="utf-8">
		<link rel="icon" href="icon.ico">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="res/css/customStyle.css">
  		<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  		<script type="text/javascript" src="res/js/mainCode.js"></script>
	</head>
	<body>
		<div id="headWrapper">
			<div class="container-fluid" id="headContainer">
				<div class="container">
					<div class="row">
						<div class="col-2">
							<img class="img-fluid" src="crateLogo.png">
						</div>
						<div class="col-6" id="searchBarContainer">
							<input id="searchBar" type="text" name="searchBar" placeholder="Presiona enter para buscar...">
						</div>
						<div class="col-4"></div>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="row">
					<div class="col-10">
						<div class="row">
							<div class="col topContainer">
								<a href="#" class="topMenuButton">Categorias <span class="fa fa-sort-down"></span></a>
								<div class="container linksContainer">
									<ul>
                                        <?php 
											$db_connection = new mysqli('localhost:3306', 'root', '', 'storedb');
											$mysql_statement = "CALL SP_GET_CATEGORIAS";
											$query_result = mysqli_query($db_connection, $mysql_statement);
											if($query_result){
												while($row = mysqli_fetch_array($query_result, MYSQLI_ASSOC)){
													echo '<li><a href="">'.$row["nombre"].'</a></li>';
												}
											}
											mysqli_close($db_connection);
										?>
									</ul>
								</div>
							</div>
							<div class="col topContainer">
                                <?php
									if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1){
										echo '<a href="profile.php" class="topMenuButton">Ver perfil <span class="fas fa-user"></span></a>';
									}
									else {
										echo '<a href="#" class="topMenuButton">Cuenta <span class="fa fa-sort-down"></span></a>
										<div class="container linksContainer">
											<ul>
												<li><a href="#" onclick="showModal(1)">Ingresar</a></li>
												<li><a href="#" onclick="showModal(2)">Registrarse</a></li>
											</ul>
										</div>';
									}
								?>
							</div>
							<div class="col topContainer">
								<a href="cart.php" class="topMenuButton">Carrito</a>
							</div>
							<div class="col topContainer">
								<a href="searchResult.php?search_id=4" class="topMenuButton">Ofertas</a>
							</div>
							<div class="col topContainer">
								<a href="index.php" class="topMenuButton">Home</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container-fluid" id="bannerContainer">
		<?php
			if($_SESSION['bannerPhoto'])
				echo '<img class="img-fluid w-100" alt="No hay imagen de portada" src="data:'.$_SESSION['bannerPhotoFormat'].';base64,'.base64_encode($_SESSION['bannerPhoto']).'">';
			else 
				echo '<img class="img-fluid w-100" alt="No hay imagen de portada" src="img/profilePics/banner1.png">';					
		?>
		</div>
		<div class="container-fluid">
			<div class="row">
				<div class="col-2"></div>
				<div class="col-2">
					<div id="profileCard" class="card">
						<?php
							if ($_SESSION['userPhoto'] != Null) {
								echo '<img class="card-img-top" src="data:'.$_SESSION['avatarPhotoFormat'].';base64,'.base64_encode($_SESSION['userPhoto']).'" alt="Foto de avatar">';
							} 
							else {
								echo '<img class="card-img-top" src="img/default-user.png" alt="Foto de avatar">';
							}
						?>
						<div class="card-body">
                            <?php  echo' <h5 id="profileName">'.$_SESSION['username'].'</h5>'; ?>
							<ul class="list-group">
								<a href="#profileCard" id="misComprasBtn"><li id="misComprasLi" class="list-group-item">Mis Compras</li></a>
								<a href="#profileCard" id="misArticulosBtn"><li id="misArticulosLi" class="list-group-item">Mis articulos</li></a>
								<a href="cart.php"><li class="list-group-item">Mi carrito</li></a>
                                <a href="index.php"><li class="list-group-item">Pagina principal</li></a>
                                <a href=""><li class="list-group-item">Cerrar sesión</li></a>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-6 profileContent" id="misCompras">
					<h6>Mis productos comprados</h6>
					<hr>
					<?php
						$db_connection = new mysqli('localhost:3306', 'root', '', 'storedb');
						$mysql_statement = "CALL SP_GET_USER_COMPRAS(".$_SESSION['user_id'].");";
						$query_result = mysqli_query($db_connection, $mysql_statement);
						if ($query_result) {
							while ($rows = mysqli_fetch_array($query_result, MYSQLI_ASSOC)) {
								
								echo '<div class="row">';
								echo '<div class="col-2">
										<img class="img-fluid img-thumbnail" alt="imagen no disponible" src="data:'.$rows['imgFormato'].';base64,'.base64_encode($rows['imagen']).'"">
									  </div>';
								echo '<div class="col-8"> 
										  <h5 class="transactionName"><a href="product.php?id='.$rows["idProducto"].'">'.$rows["nombreProducto"].'</a></h5>
										  <span id="transactionDate">'.$rows["fechaCompra"].'</span>
										  <h6 id="transactionQuantity">Comprados: '.$rows["cantidad"].'</h6>';

									if ($rows['calificacion'] > 0) {
										for ($i=1; $i <= 5; $i++) { 
											if ($rows['calificacion'] >= $i) {
												echo '<span class="checked">★</span>';
											}
											else 
												echo '<span class="unchecked">★</span>';
										}
									}
									else 
									{
										echo '<div class="productUserRating">';
										for ($i=5; $i >= 1; $i--) { 
											echo '<input type="radio" class="radioStar" compra-id='.$rows['idCompra'].' id="radio'.$i.'-'.$rows['idCompra'].'" name="scoreRadio" value="'.$i.'">';
											echo '<label class="starLabel" for="radio'.$i.'-'.$rows['idCompra'].'">★</label>';  
										}
										echo '</div>';
									}
								echo '</div>';
								echo '<div class="col-2">
										  <h6>Total:</h6>
										  <h6>'.$rows['total'].'</h6>
										  <p>Descuento: '.$rows['oferta'].'</p>
								      </div> </div><hr>';
							}
						}
						mysqli_close($db_connection);
					?>
				</div>
				<div class="col-6 profileContent hiddenContent" id="misArticulos">
					<h6>Mis articulos en la tienda</h6>
					<button class="btn btn-outline-primary" onClick="showAddProduct()">
						<span class="fa fa-plus-square-o"></span>
						Agregar
					</button>
					<hr>
					<?php 
						$db_connection = new mysqli('localhost:3306', 'root', '', 'storedb');
						$mysql_statement = "CALL SP_GET_USER_PRODUCTS(".$_SESSION["user_id"].")";
						$query_result = mysqli_query($db_connection, $mysql_statement);
						if($query_result)
						{
							while($row = mysqli_fetch_array($query_result, MYSQLI_ASSOC))
							{			
								echo '<div class="row">';
								echo '<div class="col-2">
										<img class="img-fluid img-thumbnail" alt="imagen no disponible" src="data:'.$row['formatoImg'].';base64,'.base64_encode($row['imagen']).'"">
									  </div>';
								echo '<div class="col-8"> 
										  <h5 class="transactionName"><a href="product.php?id='.$row["idProducto"].'">'.$row["nombreProducto"].'</a></h5>
										  <span id="transactionDate">'.$row["fechaRegistro"].'</span>
										  <h6 id="transactionQuantity">Disponibles: '.$row["disponibles"].'</h6>
									   </div>';
								echo '<div class="col-2"> 
									  </div>';
								echo '</div> <hr>';
							}
						}
						mysqli_close($db_connection);
					?>
				</div>
			</div>
		</div>
		<footer>
			<br>
			<div class="container">
				<div class="row">
					<div class="col">
						<h3>Informacion</h3>
						<p>
							Proyecto final de programacion de aplicaciones web con el prof. Gerardo Alvarado
						</p>
					</div>
					<div class="col">
						<h3>Categorias</h3>
						<ul>
							<li><a href="">Electronica</a></li>
							<li><a href="">Accesorios</a></li>
							<li><a href="">Linea blanca</a></li>
							<li><a href="">Automoviles</a></li>
							<li><a href="">Ropa</a></li>
						</ul>
					</div>
					<div class="col">
						<h3>Links rapidos</h3>
						<ul>
							<li><a href="">Home</a></li>
							<li><a href="">Cuenta</a></li>
							<li><a href="">Carrito</a></li>
						</ul>
					</div>
				</div>
				<hr>
				<div id="footerFeet">
					<h5>Disclaimer:</h5>
					<p>
						Esta pagina fue hecha a mano con ayuda de boostrap y de su respectivo sitio
					</p>
					<p>
						-Eduardo Isai Mata Navarro
					</p>
				</div>
			</div>
		</footer>
		<div id="productAddModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<form method="POST" id="addProductForm" enctype="multipart/form-data" action="add-edit-product.php">
						<div class="modal-header">
							<h5 class="modal-title">Agregar articulo</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="container-fluid" id="productFilesSection">
								<div class="row">
									<div class="col-4">
										<img src="" alt="Elija una imagen para el producto" class="w-100 productImgContainer">
										<button type="button" class="btn btn-outline-primary submitFile">
											Agregar imagen
										</button>
										<input type="file" name="productImgs[]" class="productImage" accept="image/jpeg, image/jpg, image/png" required>
									</div>
									<div class="col-4">
										<img src="" alt="Elija una imagen para el producto" class="w-100 productImgContainer">
										<button type="button" class="btn btn-outline-primary submitFile">
											Agregar imagen
										</button>
										<input type="file" name="productImgs[]" class="productImage" accept="image/jpeg, image/jpg, image/png" required>
									</div>
									<div class="col-4">
										<img src="" alt="Elija una imagen para el producto" class="w-100 productImgContainer">
										<button type="button" class="btn btn-outline-primary submitFile">
											Agregar imagen
										</button>
										<input type="file" name="productImgs[]" class="productImage" accept="image/jpeg, image/jpg, image/png" required>
									</div>
								</div>
								<div class="row">
									<div class="col-4">
										<video autoplay="false" id="productVideo" title="Video demostrativo del producto">
										</video>
										<button type="button" class="btn btn-outline-primary submitFile">
											Agregar video...
										</button>
										<input type="file" name="productVideo" class="productVideo" accept="video/, video/mp4, video/webm, video/avi, video/mov" required>
									</div>
								</div>
							</div>
							<br>
							<hr>
							<h4>Informacion del producto:</h4>
							<label>Nombre:</label>
							<input class="form-control" type="text" name="productName">
							<label>Descripción:</label>
							<textarea class="form-control" placeholder="Agregue descripción al producto" name="productDescription" required></textarea>
							<label>Precio:</label>
							<input class="form-control" type="number" min="0.50" step="any" name="productPrice" required>
							<label>Cantidad:</label>
                            <input class="form-control" type="number" min="1" max="100000" name="productQuantity" required>
                            <label>% de descuento:</label>
                            <input class="form-control" type="number" min="0" max="100" name="productDiscount" required>
                            <label>Visibilidad del producto:</label>
                            <br>
                            <input type="checkbox" class="form-check-input" id="isProductPublic" name="isPublic"><label for="isProductPublic">Publico</label>
                            <div class="container-fluid">
                            	<div class="row">
                            		<div class="col-4">
                            			<?php
                            				$db_connection = new mysqli('localhost:3306', 'root', '', 'storedb');
                            				$mysql_statement = "CALL SP_GET_CATEGORIAS()";
                            				$query_result = mysqli_query($db_connection, $mysql_statement);
                            				$categories = array();
                            				$cats_count = 0;
                            				if ($query_result) {
                            					if(mysqli_num_rows($query_result)){
                            						while ($row = mysqli_fetch_array($query_result, MYSQLI_ASSOC)) {
                            							$categories[] = $row;
                            						}
                            					}
                            				}
                            				echo '<select name="cats1" class="form-control" form="addProductForm">';
                            				foreach ($categories as $category) {
                            					echo '<option value="'.$category['idCategoria'].'">'.$category['nombre'].'</option>';
                            				}
                            				echo '</select>';
                            			?>
                            		</div>
                            		<div class="col-4">
                            			<?php
                            				echo '<select name="cats2" class="form-control" form="addProductForm">';
                            				foreach ($categories as $category) {
                            					echo '<option value="'.$category['idCategoria'].'">'.$category['nombre'].'</option>';
                            				}
                            				echo '</select>';
                            			?>
                            		</div>
                            		<div class="col-4">
                            			<?php
                            				echo '<select name="cats3" class="form-control" form="addProductForm">';
                            				foreach ($categories as $category) {
                            					echo '<option value="'.$category['idCategoria'].'">'.$category['nombre'].'</option>';
                            				}
                            				echo '</select>';
                            			?>
                            		</div>
                            	</div>
                            </div>
						</div>
						<div class="modal-footer">
							<input class="btn btn-outline-primary" type="submit" name="productSubmit" value="Guardar">
							<input class="btn btn-outline-secondary" type="reset" name="productClear" value="Cancelar">
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
	<script type="text/javascript" src="ajaxCalls.js"></script>
</html>