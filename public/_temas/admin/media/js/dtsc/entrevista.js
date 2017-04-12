    $('[data-rel=popover]').popover({html:true});
	
	function salvar(pronto_match) {
		
		$("#pronto_match").val(pronto_match);
		
		var erro = false;
		
		// Validando campos texto obrigatorios
		$(".is_obrigatorio").each(function(i) {
			if ( $(this).val() == "" || $(this).val() == null ) {
				erro = true;
				alert ("Favor preencher todos os campos obrigatórios!");
				$(this).focus();
				return false;
			}				
		});
		
		if (erro) {
			return false;
		}
		
		// Validando campos check obrigatorios
		var check_ok = true;
		var chk_name = "";
		$(".is_check_obrigatorio").each(function(i) {
			
			chk_name = $(this).attr('name');
			
			if ( !$("input[name='" + chk_name + "']:checked").val() ) {
				check_ok = false;
				$(this).focus();
				return false;
			}
			
		});
		
		if (!check_ok) {
			alert ("Favor marcar todos as avaliacoes obrigatórias!");
			return false;
		}
		
		// Submetendo
		$("#btnSalvar").text("Salvando...");
		$("#btnSalvarProntoParaMatch").text("Salvando...");
		
		$("#btnSalvar").attr("disabled", "disabled");
		$("#btnSalvarProntoParaMatch").attr("disabled", "disabled");
		$("#frm").submit();
	}