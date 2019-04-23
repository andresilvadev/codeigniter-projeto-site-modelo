// Executado assim que for chamado o arquivo login.js
$(function() {

	$("#login_form").submit(function() {

		$.ajax({
			type: "post",
			url: BASE_URL + "restrict/ajax_login",
			dataType: "json",
			data: $(this).serialize(), // Dados de entrada do formulario, pega os campos do form

			// Antes de enviar vamos limpar os erros
			beforeSend: function() {
				clearErrors();
				$("#btn_login").parent().siblings(".help-block").html(loadingImg("Verificando...")); //Pega o irmao da div form-group que é o span com a class help-block
			},

			// Em caso de sucesso
			success: function(json) {
				if(json["status"] == 1) {
					clearErrors();
					$("#btn_login").parent().siblings(".help-block").html(loadingImg("Logando no sistema...")); //Pega o irmao da div form-group que é o span com a class help-block
					// Refresh da págna passando a url que queremos
					window.location = BASE_URL + "restrict";
				} else {
					showErrors(json["error_list"]);
				}
			},
			// Em caso de erro na request apenas mostra no console
			error: function(response) {
				console.log(response);
			}
		});

		return false; // Evita de ser submetido a não pelo que for dentro do ajax
	});

});
