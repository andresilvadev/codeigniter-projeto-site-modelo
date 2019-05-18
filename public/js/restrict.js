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
					Swal.fire("Sucesso!", "Curso salvo com sucesso", "success");
					dt_course.ajax.reload();
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
					Swal.fire("Sucesso!", "Membro salvo com sucesso", "success");
					dt_member.ajax.reload();
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
					Swal.fire("Sucesso!", "Usuário salvo com sucesso", "success");
					dt_user.ajax.reload();
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

	function active_btn_course() {
		$(".btn-edit-course").click(function(){
			$.ajax({
				type: "POST",
				url: BASE_URL + "restrict/ajax_get_course_data",
				dataType: "json",
				data: {"course_id": $(this).attr("course_id")},
				success: function(response) {
					clearErrors();
					$("#form_course")[0].reset(); // Limpa os campos do formulário
					$.each(response["input"], function(id, value){
						$("#"+id).val(value);
					});
					$("#course_img_path").attr("src", response["img"]["course_img_path"]);
					$("#modal_course").modal();
				}
			});
		});

		$(".btn-del-course").click(function(){
			course_id = $(this);

			console.log(course_id.attr("course_id"));
			
			// Chama o sweet alert
			Swal.fire({
				title: "Atenção!",
				text: "Deseja deletar esse curso?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#d9534f",
				confirmButtonText: "Sim",
				cancelButtontext: "Não",
				closeOnConfirm: true,
				closeOnCancel: true,
			}).then((result) => {
				if(result.value) {
					$.ajax({
						type: "POST",
						url: BASE_URL + "restrict/ajax_delete_course_data",
						dataType: "json",
						data: {"course_id": course_id.attr("course_id")},
						success: function(response) {
							Swal.fire("Sucesso!", "Ação executada com sucesso", "success");
							dt_course.ajax.reload();							
						}
					})
				}
			});			
		});
	}
	
	var dt_course = $("#dt_courses").DataTable({
		"oLanguage" : DATATABLE_PTBR,
		"autoWidth": false,
		"processing": true,
		"serverSide" : true,
		"ajax" : {
			"url" : BASE_URL + "restrict/ajax_list_course",
			"type": "POST"
		},
		"columnDefs": [
			{ targets: "no-sort", orderable: false },
			{ targets: "dt-center", className: "dt-center"}
		],
		"drawCallback": function() { // Chama a função tanto na hora de criar quanto atualizar
			active_btn_course();
		}
	});

	function active_btn_member() {
		$(".btn-edit-member").click(function(){
			$.ajax({
				type: "POST",
				url: BASE_URL + "restrict/ajax_get_member_data",
				dataType: "json",
				data: {"member_id": $(this).attr("member_id")},
				success: function(response) {
					clearErrors();
					$("#form_member")[0].reset(); // Limpa os campos do formulário
					$.each(response["input"], function(id, value){
						$("#"+id).val(value);
					});
					$("#member_photo_path").attr("src", response["img"]["member_photo_path"]);
					$("#modal_member").modal();
				}
			});
		});

		$(".btn-del-member").click(function(){
			member_id = $(this);

			console.log(member_id.attr("member_id"));
			
			// Chama o sweet alert
			Swal.fire({
				title: "Atenção!",
				text: "Deseja deletar esse membro?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#d9534f",
				confirmButtonText: "Sim",
				cancelButtontext: "Não",
				closeOnConfirm: true,
				closeOnCancel: true,
			}).then((result) => {
				if(result.value) {
					$.ajax({
						type: "POST",
						url: BASE_URL + "restrict/ajax_delete_member_data",
						dataType: "json",
						data: {"member_id": member_id.attr("member_id")},
						success: function(response) {
							Swal.fire("Sucesso!", "Ação executada com sucesso", "success");
							dt_member.ajax.reload();
						}
					})
				}
			});			
		});
	}

	var dt_member = $("#dt_team").DataTable({
		"oLanguage" : DATATABLE_PTBR,
		"autoWidth": false,
		"processing": true,
		"serverSide" : true,
		"ajax" : {
			"url" : BASE_URL + "restrict/ajax_list_member",
			"type": "POST"
		},
		"columnDefs": [
			{ targets: "no-sort", orderable: false },
			{ targets: "dt-center", className: "dt-center"}
		],
		"drawCallback": function() { // Chama a função depois que o datatable for carregado
			active_btn_member();
		}
	});


	function active_btn_user() {
		$(".btn-edit-user").click(function(){
			$.ajax({
				type: "POST",
				url: BASE_URL + "restrict/ajax_get_user_data",
				dataType: "json",
				data: {"user_id": $(this).attr("user_id")},
				success: function(response) {
					clearErrors();
					$("#form_user")[0].reset(); // Limpa os campos do formulário
					$.each(response["input"], function(id, value){
						$("#"+id).val(value);
					});					
					$("#modal_user").modal();
				}
			});
		});

		$(".btn-del-user").click(function(){
			user_id = $(this);

			console.log(user_id.attr("user_id"));
			
			// Chama o sweet alert
			Swal.fire({
				title: "Atenção!",
				text: "Deseja deletar esse usuário?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#d9534f",
				confirmButtonText: "Sim",
				cancelButtontext: "Não",
				closeOnConfirm: true,
				closeOnCancel: true,
			}).then((result) => {
				if(result.value) {
					$.ajax({
						type: "POST",
						url: BASE_URL + "restrict/ajax_delete_user_data",
						dataType: "json",
						data: {"user_id": user_id.attr("user_id")},
						success: function(response) {
							Swal.fire("Sucesso!", "Ação executada com sucesso", "success");
							dt_users.ajax.reload();
						}
					})
				}
			});			
		});
	}

	var dt_users = $("#dt_users").DataTable({
		"oLanguage" : DATATABLE_PTBR,
		"autoWidth": false,
		"processing": true,
		"serverSide" : true,
		"ajax" : {
			"url" : BASE_URL + "restrict/ajax_list_user",
			"type": "POST"
		},
		"columnDefs": [
			{ targets: "no-sort", orderable: false },
			{ targets: "dt-center", className: "dt-center"}
		],
		"drawCallback": function() { // Chama a função depois que o datatable for carregado
			active_btn_user();
		}
	});

});
