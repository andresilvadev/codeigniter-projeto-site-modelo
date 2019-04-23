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
