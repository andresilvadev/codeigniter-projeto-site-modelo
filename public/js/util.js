const BASE_URL = "http://localhost:8000/";

function clearErrors() {
	$(".has-error").removeClass("has-error");
	$(".help-block").html("");
}

function showErrors(error_list) {
	clearErrors();

	$.each(error_list, function(id, message) {
		//Id sobe dois niveis
		$(id).parent().parent().addClass("has-error");
		$(id).parent().siblings(".help-block").html(message); // Pega o irmão que tenha .help-block e passa a mensagem de erro
	});
}

function loadingImg(message="") {
	return "<i class='fa fa-circle-o-notch fa-spin'></i> &nbsp;" + message
}


function uploadImg(input_file, img, input_path) {

	src_before = img.attr("src");  // pega o src do atributo image
	img_file = input_file[0].files[0];  // pega o objeto arquivo que vem do input_file na posição zero
	form_data = new FormData();  // Istancia um novo formulario do java script

	form_data.append("image_file", img_file);  // image_file do controller restrict ajax upload

	$.ajax({
		url: BASE_URL + "restrict/ajax_import_image",
		dataType: "json",
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,
		type: "POST",

		beforeSend: function() {
			clearErrors();
			input_path.siblings(".help-block").html(loadingImg("Carregando imagem..."));
		},

		success: function(response) {
			clearErrors();
			if(response["status"]) {
				img.attr("src", response["img_path"]);
				input_path.val(response["img_path"]);
			} else {
				img.attr("src", src_before);  // Em caso de erro da um rollback do src da image
				input_path.siblings(".help-block").html(response["error"]);
			}
		},

		error: function() {
			img.attr("src", src_before); // Em caso de erro limpa a imagem para imagem anterior
		}
	})
}
