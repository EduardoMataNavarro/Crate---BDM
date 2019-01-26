$('#logBtn').click(function(e){
    e.preventDefault();
    var _usermail = $('#usermailInput').val();
    var _userpass = $('#passwordInput').val();

    $.ajax({
    url: 'login-register.php',
    type: 'POST',
    dataType: 'json', 
    data: {
        'logIn': true,
        'user': _usermail,
        'passwrd': _userpass
    }
    }).done(function(response){
        if (response.loggedIn) {
            alert("Bienvenido usuario");
            location.reload();
        }
        else {
            $('#sessionMessage').css('display', 'block');
        }
    });
});

$('.radioStar').on('click', function(e){
    var _score = $(this).attr('value');
    var _compraId = $(this).attr('compra-id');
        $.ajax({
            url: 'add-edit-compra.php',
            type: 'POST',
            dataType: 'json',
            data: {
                'calificacion': _score,
                'idCompra': _compraId,
                'editScore': 1
            }
        }).done(function(response){
            if (response.success) {
                alert("Se ha registrado la calificacion");
                location.reload();   
            }
            else 
                alert("No se ha podido registrar la calificacion");
        });
});
$('.cartQuantity').on('change', function(){
    var _productId = $(this).attr('product-id');
    var _cantidad = $(this).val();
    $.ajax({
        url: 'add-edit-carrito.php',
        type: 'POST',
        dataType: 'json',
        data: {
            'product_id': _productId,
            'cantidad': _cantidad,
            'alterQuantity': 1
        }
    }).done(function(result){
        if (!result.success) {
            alert("No se ha podido modificar la cantidad en la base de datos");
        }
    });
});

$('#btnComprarTodo').click(function(){
    $.ajax({
        url: 'add-edit-carrito.php',
        type: 'POST',
        dataType: 'json',
        data: {
            'comprar': 1
        }
    }).done(function(result){
        if (result.success) {
            alert("Se ha registrado la compra");
            window.location.href = "profile.php";
        }
        else 
            alert("se ha producido un error");
    });
});
function addToCart(myBtn)
{
    var _idProducto = $(myBtn).attr('id-art');
    $.ajax({
        url: 'add-edit-carrito.php',
        type: 'POST',
        dataType: 'json',
        data: {
            'idProducto' : _idProducto,
            'addProduct' : 1
        } 
    }).done(function(response) {
        if (response.result) {
            alert('Se ha registrado el producto en su carrito, puede consultarlo cuando lo desee ' + _idProducto);
        }
        else 
            alert('No se ha podido registrar el articulo' + _idProducto);
    });
}

function addCommentary(currentURL){
    var _idProducto = currentURL.charAt(currentURL.length - 1);
    var _commentary = $('#commentArea').val();
    if(_commentary != ""){
        $.ajax({
            url: 'post-edit-comments.php',
            type: 'POST',
            dataType: 'json',
            data: {
                'productId' : _idProducto,
                'commentText': _commentary,
                'submitComment': 1
            }
        }).done(function(response){
            if (response.success == 1) {
                console.log(response);
                alert('se ha registrado el comentario');
                $('#comments').append(response.commentBody);
            }
            else 
                alert('No se ha podido publicar el comentario');
        });
    }
    else{
        alert('Ingrese un comentario, por favor');
    }
}
