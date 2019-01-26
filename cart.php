<?php
    session_start();
	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Carrito</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="icon" href="icon.ico">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="res/css/customStyle.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
		<div class="container">
			<div class="container-fluid" id="cartContainer">
				<div class="container">
					<h3>Articulos</h3>
					<hr>
					<div id="articlesContainer">
							<?php
								if(isset($_SESSION['user_id']))
								{
									$db_connection = new mysqli('localhost:3306', 'root', '', 'storedb');
									$mysql_statement = 'CALL SP_GET_USER_CART('.$_SESSION['user_id'].')';
									$query_result = mysqli_query($db_connection, $mysql_statement);
									if($query_result)
									{
										$num_rows = mysqli_num_rows($query_result);
										if (!$num_rows) {
											echo '<div class="col-12" style="height: 350px">
													<h1>NO TIENE ARICULOS EN SU CARRITO</h1>
												  </div>';
										}
										else 
											while($row = mysqli_fetch_array($query_result, MYSQLI_ASSOC)){
												echo '<div class="row"><div class="col-2">
													<img class="img-responsive img-thumbnail" src="data:'.$row['formatoImg'].';base64,'.base64_encode($row['imagen']).'">
													</div>
													<div class="col-7">
														<div class="row">
															<div class="col-6">
																<h5>'.$row['nombreProducto'].'</h5>
																<span>Precio original: $'.$row['precio'].'</span>
																<br>
																<span>Precio con descuento: $'.$row['precioOferta'].'</span>
															</div>
															<div class="col6">
																<label>Cantidad:</label>
																<input type="number" product-id="'.$row['idProducto'].'" class="input-group-text cartQuantity" min="1" max="'.$row['disponibles'].'"> 
															</div>
														</div>
													</div>
													<div class="col-3">
													</div>
													</div><hr>';
											}
									}
								}
								else 
								{
									echo '<div class="col-12" style="height: 350px">
											<h3>NECESITA ESTAR REGISTRADO PARA AGREGAR PRODUCTOS AL CARRITO</h3>
										  </div>';
								}
							?>
					</div>
					<div class="row">
						<div class="col-10"></div>
						<div class="col-2">
						<?php
							if (isset($_SESSION['user_id'])) {
								echo '<button type="button" class="btn btn-outline-success" id="btnComprarTodo">
									Comprar todo
								</button>';
							}
						?>
						</div>
					</div>
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
		<div class="modal fade" id="signInModal" tabindex="-1" role="dialog" aria-hidden="true">
			<form method="POST" action="login-register.php">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Sign up</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="container">
								<div class="row">
									<div class="col-6">
									<h5>Foto de avatar:</h5>
									<img id="avatarImg" class="img-responsive img-thumbnail" src="..." accept="image/jpeg, image/png" alt="Elija una foto de perfil...">
										<br>
										<br>
    									<input type="file" name="userphoto" class="form-control-file" onchange="setPhoto(this, 1)">
										<br>
										<h5>Foto de portada:</h5>
									<img id="bannerImg" class="img-fluid img-thumbnail" src="..." accept="image/jpeg, image/png" alt="Elija una foto de portada...">
										<br>
										<input type="file" name="bannerPhoto" class="form-control-file" onchange="setPhoto(this, 2)">
									</div>
								</div>
								<br>
								<label>Nombre de usuario:</label>
								<input id="newUserName" class="form-control" type="text" name="userName" required>
								<label>Correo:</label>
								<input id="newUserMail" class="form-control" type="email" name="mail" required>
								<label>Contraseña:</label>
								<input id="newUserPass" class="form-control" type="password" name="passwrd" onblur="checkPwrdMatch()" required>
								<label>Confirmar contraseña:</label>
								<input id="newUserPassConfirm" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" class="form-control" type="password" name="passwrdConfirm" onblur="checkPwrdMatch()" required>
								<span id="passAlertSpan">Las contraseñas no coinciden</span>
								<label>Telefono (opcional):</label>
								<input class="form-control" type="tel" name="phone" placeholder="123-123-1234">
								<label>Dirección (opcional):</label>
								<input class="form-control" type="text" name="address">
							</div>
						</div>
						<div class="modal-footer">
							<input class="btn btn-primary" type="submit" name="register" value="Registrar" onclick="validateSignIn()">
							<input class="btn btn-danger" type="reset" name="reset" value="Limpiar">
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="modal fade" id="logInModal" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">LogIn</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="container">
							<label>Usuario:</label>
							<input class="form-control" id="usermailInput" type="email" name="user" placeholder="tuCorreo@example.com" required>
							<label>Contraseña:</label>
							<input class="form-control" id="passwordInput" type="password" name="passwrd" placeholder="********" required>
							<label id="sessionMessage">No se ha podido iniciar la sessión</label>
						</div>
					</div>
					<div class="modal-footer">
						<input class="btn btn-primary" id="logBtn" type="button" name="logIn" value="log in">
						<input class="btn btn-danger" type="button" name="reset" value="Limpiar">
					</div>
				</div>
			</div>
		</div>
	</body>
	<script type="text/javascript" src="ajaxCalls.js"></script>
</html>