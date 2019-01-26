$(document).ready(function(){
	$('.topMenuButton').click(function(){
		$(this).next('.linksContainer').toggle();
	});

	$('#misComprasBtn').click(function(){
		$('#misArticulos').addClass("hiddenContent");
		$('#misCompras').removeClass("hiddenContent");
	});

	$('#misArticulosBtn').click(function(){
		$('#misCompras').addClass("hiddenContent");
		$('#misArticulos').removeClass("hiddenContent");
	});

	$('.submitFile').on('click', function(){
		var inputFile = $(this).next('input[type=file]');
		inputFile.click();
	});

	$('.productImage').on('change', function(){
		var imgUrl = $(this).val();
		var btn = $(this).prev('.submitFile');
		var picture = btn.prev();
		if (imgUrl) {
			var reader = new FileReader();
			reader.onload = function(e){
				picture.attr('src', e.target.result) ; 
			}
			reader.readAsDataURL(this.files[0]);
		}
	});

	$('.productVideo').on('change', function(){
		var srcPath = $(this).val();
		var videoSource = $('#productVideo');
		if (videoSrc) {
			videoSource.src = srcPath;
		}
	});

	$('#searchBar').keypress(function(e){
		if (e.which == 13) {
			var searchTerm = $(this).val();
			if (searchTerm == "") {
				alert("Introduzca un parametro de busqueda");
			}
			else {
				var searchURL = "searchResult.php?srch_term=" + searchTerm;
				window.location.href= searchURL;
			}
		}
	});
});

function showModal(modalSelected)
{
	if (modalSelected == 1) {
		$('#logInModal').modal('show');
	}
	else
	{
		if (modalSelected === 2) {
			$('#signInModal').modal('show');
		}
	}
}

function showAddProduct()
{
	$('#productAddModal').modal('show');
}

function checkPwrdMatch()
{
	if ($('#newUserPass').val() != $('#newUserPassConfirm').val()) {
		$('#passAlertSpan').css("display", "block");
	}
	else 
	{
		$('#passAlertSpan').css("display", "none");
	}
}

function setPhoto(input, imgIndex)
{
	if (input.files && input.files[0]) 
	{
        var reader = new FileReader();
        reader.onload = function (e) {
			if(imgIndex == 1){
				$('#avatarImg').attr('src', e.target.result);
			}
			else {
				$('#bannerImg').attr('src', e.target.result);
			}
        };
		reader.readAsDataURL(input.files[0]);
    }
}