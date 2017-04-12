	// Tipos de campo dinâmico
	var CAMPO_TIPO_TEXTO = 'T';
	var CAMPO_TIPO_TEXTAREA = 'A';
	var CAMPO_TIPO_ARQUIVO = 'F';
	var CAMPO_TIPO_CHECKBOX = 'C';
	var CAMPO_TIPO_DROPDOWN = 'S';
	var CAMPO_TIPO_MONETARIO = 'M';
	var CAMPO_TIPO_DATA = 'D';
	var CAMPO_TIPO_RADIO = 'R';
	var CAMPO_TIPO_LINK = 'L';
	var CAMPO_TIPO_CNPJ = 'J';
	var CAMPO_TIPO_SEXO = 'SX';
	var CAMPO_TIPO_STATUS = 'ST';
	var CAMPO_TIPO_NUMERICO = 'N';
	
	var DADO_DINAMICO = 'D';
	var DADO_FIXO = 'F';
	
	// Status
	var STATUS_CONVIDADO = 1;
	var STATUS_PERFIL_INICIADO = 2;
	var STATUS_PERFIL_ENVIADO = 3;
	var STATUS_ENTREVISTA_AGENDADA = 4;
	var STATUS_ENTREVISTA_COMPLETA = 5;
	var STATUS_PRONTO_PARA_MATCH = 6;
	var STATUS_MATCH_PROPOSTO = 7;
	var STATUS_EM_PARCERIA = 8;
	var STATUS_EM_ESPERA = 9;
	var STATUS_DECLINADO = 10;
	
	// Inicializando datepickers
	$('input[name*="txtDadoData"]').datepicker();		
	
	// Inicizlizando multiselects
	$('.multiple-selected-big').multiselect({
		numberDisplayed: 1,
        buttonWidth: '300px',
        nonSelectedText: 'Nenhum selecionado',
        allSelectedText: 'Todos selecionados',
        nSelectedText: 'selecionados'
    });
    	
	function editarPerfil() {
		
		$(".edicao").toggle();
		
		if ( $("#btnEditar").html() == "Ativar Edição&nbsp;&nbsp;&nbsp;" ) {
			$("#btnEditar").html("Desativar Edição&nbsp;&nbsp;&nbsp;");
		} else {
			$("#btnEditar").html("Ativar Edição&nbsp;&nbsp;&nbsp;");
		}
	}
	
	function editar (campo, tp_campo, valor, maxlength, id_resposta) {
		
		if (id_resposta) {
			$("#id_resposta").val(id_resposta);
		} else {
			$("#id_resposta").val("");
		}
		
		// Ajustando campo
		$("#campo").val(campo);
		
		// Removendo criticas
		$("#tp_campo").val(tp_campo);
		
		// Reset nos botões
		$("#btnSalvarTexto").html("<i class=\"fa fa-check\"></i> Salvar");
		$("#btnSalvarTexto").attr("disabled", false);

		$("#txtDadoTextarea").html("<i class=\"fa fa-check\"></i> Salvar");
		$("#txtDadoTextarea").attr("disabled", false);

		$("#btnSalvarData").html("<i class=\"fa fa-check\"></i> Salvar");
		$("#btnSalvarData").attr("disabled", false);

		$("#btnSalvarStatus").html("<i class=\"fa fa-check\"></i> Salvar");
		$("#btnSalvarStatus").attr("disabled", false);
		
		// Abrir Modal de acordo com o tipo
		if (tp_campo == CAMPO_TIPO_TEXTO     || 
			tp_campo == CAMPO_TIPO_LINK      || 
			tp_campo == CAMPO_TIPO_NUMERICO  ||
			tp_campo == CAMPO_TIPO_MONETARIO
		) {
			$('#modal-edicao-texto').modal({ backdrop: 'static', });
			
			if (maxlength != null) {
				$("#txtDadoTexto").attr('maxlength', maxlength);
			}
						
			$('#txtDadoTexto').val(valor);
			setTimeout(function(){ $('#txtDadoTexto').focus(); }, 300);
			
		} else if (tp_campo == CAMPO_TIPO_TEXTAREA) {
			$('#modal-edicao-textarea').modal({ backdrop: 'static', });
			$('#txtDadoTextarea').val(valor);
			setTimeout(function(){ $('#txtDadoTextarea').focus(); }, 300);
			
		} else if (tp_campo == CAMPO_TIPO_DATA) {
			$('#modal-edicao-data').modal({ backdrop: 'static', });
			$('#txtDadoData').val(valor);
		
		} else if (tp_campo == CAMPO_TIPO_SEXO) {
			$('#modal-edicao-sexo').modal({ backdrop: 'static', });
			$('#cboDadoSexo').val(valor);
			$('#cboDadoSexo').multiselect("refresh");			

		} else if (tp_campo == CAMPO_TIPO_STATUS) {
			$('#modal-edicao-status').modal({ backdrop: 'static', });
			$('#cboDadoStatus').val(valor);
			$('#cboDadoStatus').multiselect("refresh");			
		}
	}
	
	function salvarCampo (valor) {
		
		var id_resposta = $("#id_resposta").val();

		if (id_resposta) {
			$("#campo").val (id_resposta);
		}
		
		var campo = $("#campo").val();
		var tp_campo = $("#tp_campo").val();
		var id_usuario = $("#id_usuario").val();
		
		if (campo == null || campo == "" || id_usuario == null) {
			alert ("Ocorreu um erro ao tentar identificar o campo: " + campo + ", (usuario " + id_usuario + ")");
			event.preventDefault();
			return false;
		}
		
		// Críticas
		if (valor == null || valor == "") {
			alert ("É necessário informar um valor!");
			event.preventDefault();
			return false;			
		}
		
		if ( tp_campo == CAMPO_TIPO_NUMERICO || tp_campo == CAMPO_TIPO_MONETARIO) {
			
			if ( !isNumber(valor) ) {
				alert ("Informe apenas números!");
				event.preventDefault();
				return false;
			}
		}

		// Tratando campos específicos
		if ( tp_campo == CAMPO_TIPO_DATA) {
			valor = date2db(valor);
		}
				
		$("#btnSalvarTexto").text("Salvando...");
		$("#btnSalvarTexto").attr("disabled", "disabled");

		$("#txtDadoTextarea").text("Salvando...");
		$("#txtDadoTextarea").attr("disabled", "disabled");
		
		$("#btnSalvarData").text("Salvando...");
		$("#btnSalvarData").attr("disabled", "disabled");

		$("#btnSalvarStatus").text("Salvando...");
		$("#btnSalvarStatus").attr("disabled", "disabled");
		
		// Ajax Form
 		var formData = {
            'id_usuario'        : $('input[name=id_usuario]').val(),
            'campo'             : $('input[name=campo]').val(),
            'valor'             : valor
        };
		
		// Salvar dados via AJAX
		$.ajax({
			        type        : 'POST',
			        url         : (id_resposta ? action_cd : action_cf),
			        data        : formData,	
			        	                        
		}).done ( function (json) {
	
				if ( json['retorno'] > 0 ) {
					alert ( json['messages'][0] );
				}
				
				// Processo OK
				if (campo == "anos_experiencia") {
					$("#txt_" + campo).text (valor);
					
				} else if (tp_campo == CAMPO_TIPO_DATA) {
					$("#txt_" + campo).text ( $("#txtDadoData").val() );
				
				} else if (tp_campo == CAMPO_TIPO_LINK) {
					
					if (id_resposta) {
						$("#link_" + id_resposta).text ("Acessar Link");
						$("#link_" + id_resposta).attr ("href", valor );
						$("#link_" + id_resposta).attr ("target", "_blank" );
					} else {
						$("#link_" + campo).text ("Acessar Link");
						$("#link_" + campo).attr ("href", valor );
						$("#link_" + campo).attr ("target", "_blank" );
					}					

				} else if (tp_campo == CAMPO_TIPO_STATUS) {
					$("#txt_" + campo).text ( getStatusByID (valor) );

				} else if (tp_campo == CAMPO_TIPO_MONETARIO) {
					$("#txt_" + campo).text ( "R$ " + number_format (valor, 2, ',', '.') );
				
				} else {
					$("#txt_" + campo).text (valor);
				}
				
				// Seta novo valor
				$("#" + campo).val (valor); // Fixos
				
				if (id_resposta) { // Dinamicos
					$("#campo-" + campo).val (valor);
				} 
				
				// Fecha todas as modals
				$('.modal').modal('hide');
				
			})
			.fail ( function (error) {
				alert( "Ocorreu um erro ao tentar carregar os dados!");
			}
		);
		
		// Evita Submissão
		event.preventDefault();
		return false;		
	}
	
	function isNumber(n) {
	  return !isNaN(parseFloat(n)) && isFinite(n);
	}
	
	function date2db(data) {
		return data.split("/").reverse().join("-");
	}
	
	function getStatusByID (id) {
		
		if (id == "" || id == null) {
			return "Nenhum";
		}
		
		id = parseInt(id);
		
		switch (id) {
			
			case STATUS_CONVIDADO           : return ("Convidado");
			case STATUS_PERFIL_INICIADO     : return ("Perfil Iniciado");
			case STATUS_PERFIL_ENVIADO      : return ("Perfil Enviado");
			case STATUS_ENTREVISTA_AGENDADA : return ("Entrevista Agendada");
			case STATUS_ENTREVISTA_COMPLETA : return ("Entrevista Completa");
			case STATUS_PRONTO_PARA_MATCH   : return ("Pronto para Match");
			case STATUS_MATCH_PROPOSTO      : return ("Match Proposto");
			case STATUS_EM_PARCERIA         : return ("Em Parceria");
			case STATUS_EM_ESPERA           : return ("Em Espera");
			case STATUS_DECLINADO           : return ("Declinado");
			default                         : return ("Nenhum");
		}
	}
	
	function alterarSenha() {
		$('#modal-edicao-senha').modal({ backdrop: 'static', });
		setTimeout(function(){ $('#txtSenha').focus(); }, 300);
	}
	
	function salvarSenha (senha, senha2) {
		
		// Críticas
		if (senha == null || senha == "" || senha.length < 5) {
			alert ("É necessário informar uma senha de no mínimo 5 dígitos!");
			event.preventDefault();
			return false;			
		}
		
		if (senha != senha2) {
			alert ("Senhas não conferem!");
			event.preventDefault();
			return false;						
		}
						
		$("#btnSalvarTextoSenha").text("Salvando...");
		$("#btnSalvarTextoSenha").attr("disabled", "disabled");

		// Ajax Form
 		var formData = {
            'id_usuario'        : $('input[name=id_usuario]').val(),
            'senha'             : senha
        };
		
		// Salvar dados via AJAX
		$.ajax({
			        type        : 'POST',
			        url         : action_senha,
			        data        : formData,	
			        	                        
		}).done ( function (json) {
	
			if ( json['retorno'] > 0 ) {
				alert ( json['messages'][0] );
			}
			
			if ( json['retorno'] == 0 ) {
				alert ("Senha alterada com sucesso!");
				$("#btnSalvarTextoSenha").text("Modificar Senha");
				$("#btnSalvarTextoSenha").removeAttr('disabled');				
				$("#txtSenha").val("");
				$("#txtRepetirSenha").val("");
			}
			
			// Fecha todas as modals
			$('.modal').modal('hide');
				
			})
			.fail ( function (error) {
				alert( "Ocorreu um erro ao tentar carregar os dados!");
			}
		);
		
		// Evita Submissão
		event.preventDefault();
		return false;		

	}
		
	function number_format(number, decimals, dec_point, thousands_sep) {
	
	  number = (number + '')
	    .replace(/[^0-9+\-Ee.]/g, '');
	  var n = !isFinite(+number) ? 0 : +number,
	    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
	    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
	    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
	    s = '',
	    toFixedFix = function(n, prec) {
	      var k = Math.pow(10, prec);
	      return '' + (Math.round(n * k) / k)
	        .toFixed(prec);
	    };
	  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
	  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
	    .split('.');
	  if (s[0].length > 3) {
	    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	  }
	  if ((s[1] || '')
	    .length < prec) {
	    s[1] = s[1] || '';
	    s[1] += new Array(prec - s[1].length + 1)
	      .join('0');
	  }
	  return s.join(dec);
	}
	
	function uploadPerfil (id_usuario) {
		$('#img-perfil').trigger('click');
	}
	
	$('#img-perfil').change(function() {

		var size = this.files[0].size;
		var file = $('#img-perfil').val();
		var exts = ['jpg','jpeg','png','gif'];
		
		if ( file ) {
			
			var get_ext = file.split('.');
			get_ext = get_ext.reverse();

			if (size > 5000000) {
				alert ("Arquivo grande demais!");
				return false;
			}
			
			// OK
			if ( $.inArray ( get_ext[0].toLowerCase(), exts ) > -1 ) {
				
				// Submete
				$("#frm").attr("action", action_img);
				$("#frm").submit();
				
			} else {
				alert("Tipo de arquivo inválido!");
				return false;
			}
		}

	});
	
	function modoEdicao() {
		
		if ( confirm ("Para modificar este campo, você será direcionado para a plataforma de edição. Deseja continuar?") ) {
			$("#frm").attr('action', action_edicao);
			$("#frm").submit();
		}
	}