$(function() {

	$("#btn_add_course").click(function(){
		clearErrors();		// Limpa os erros
		$("#form_course")[0].reset(); // Limpa os campos do formulário
		$("#course_img_path").attr("src", ""); // Limpa a url da imagem
		$("#modal_course").modal();
	});

	$("#btn_add_member").click(function(){
		clearErrors();
		$("#form_member")[0].reset(); // Limpa os campos do formulário
		$("#member_photo_path").attr("src", ""); // Limpa a url da imagem
		$("#modal_member").modal();
	});

	$("#btn_add_user").click(function(){
		clearErrors();
		$("#form_member")[0].reset(); // Limpa os campos do formulário
		$("#modal_user").modal();
	});

	$("#btn_upload_course_img").change(function(){
		uploadImg($(this), $("#course_img_path"), $("#course_img"));
	});

	$("#btn_upload_member_photo").change(function(){
		uploadImg($(this), $("#member_photo_path"), $("#member_photo"));
	});

	$("#form_course").submit(function () {

		$.ajax({
			type: "POST",
			url: BASE_URL + "restrict/ajax_save_course",
			dataType: "json",
			data: $(this).serialize(),
			beforeSend: function() {
				clearErrors();
				$("#btn_save_course").siblings(".help-block").html(loadingImg("Verificando..."));
			},
			success: function(response) {
				clearErrors();
				if(response["status"]) {
					$("#modal_course").modal("hide");
				} else {
					showErrorsModal(response["error_list"]);
				}
			}
		});

		return false; // Evita que o form seja submetido
	});

	$("#form_member").submit(function () {

		$.ajax({
			type: "POST",
			url: BASE_URL + "restrict/ajax_save_member",
			dataType: "json",
			data: $(this).serialize(),
			beforeSend: function() {
				clearErrors();
				$("#btn_save_member").siblings(".help-block").html(loadingImg("Verificando..."));
			},
			success: function(response) {
				clearErrors();
				if(response["status"]) {
					$("#modal_member").modal("hide");
				} else {
					showErrorsModal(response["error_list"]);
				}
			}
		});

		return false; // Evita que o form seja submetido
	});


	$("#form_user").submit(function () {

		$.ajax({
			type: "POST",
			url: BASE_URL + "restrict/ajax_save_user",
			dataType: "json",
			data: $(this).serialize(),
			beforeSend: function() {
				clearErrors();
				$("#btn_save_user").siblings(".help-block").html(loadingImg("Verificando..."));
			},
			success: function(response) {
				clearErrors();
				if(response["status"]) {
					$("#modal_user").modal("hide");
				} else {
					showErrorsModal(response["error_list"]);
				}
			}
		});

		return false; // Evita que o form seja submetido
	});

	$("#btn_your_user").click(function () {

		$.ajax({
			type: "POST",
			url: BASE_URL + "restrict/ajax_get_user_data",
			dataType: "json",
			data: {"user_id": $(this).attr("user_id")},
			success: function(response) {
				clearErrors();
				$("#form_member")[0].reset(); // Limpa os campos do formulário
				$.each(response["input"], function(id, value){
					$("#"+id).val(value);
				});
				$("#modal_user").modal();
			}
		});

		return false; // Evita que o form seja submetido
	});


});
