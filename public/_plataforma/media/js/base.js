$(window).load(function() {
	js.init();
});

var js = {
	init: function() {
		js.exibirPesquisa();
		js.exibirMenu();
		js.simularCheckRadio();
		js.abrirModal();
		//js.abrirBox();
	},

	/**
	 * favorito
	 */
	favorito: {
		/**
		 * favoritar
		 */
		favoritar: function(target, functionCall) {
			$(target).click(function(){
				var $this = $(this);
				var data = {
					'id': $this.data('id'),
					'tipo': $this.data('favorito-tipo')
				};
				$.post(base_path + '/favorito/favoritar', data, function(json){
					functionCall.call(this, $this);
				});
			});
		}
	},

	formularios: {

		formatacao: {

			/**
			  * Formata para tipo telefone
			  * @dependency módulo de máscara
			  */
			formatarTelefone: function(selectElement) {
				$(selectElement).focusout(function(){
					var phone, element;
					element = $(this);
					element.unmask();
					phone = element.val().replace(/\D/g, '');
					if(phone.length > 10) {
						element.mask("(99) 99999-999?9",{placeholder:" "});
					} else {
						element.mask("(99) 9999-9999?9",{placeholder:" "});
					}
				}).trigger('focusout');				
			}
		},

		iniciarFormularioEscolhaProjetoDashboad: function() {
			$('#formulario-projeto select').change(function(){
				var $this = $(this);
				if ( $this.val() != '' ) {
					location.href = $this.val();
				}
			});
		}
	},

	alternarListas: function() {
		var $abas = $("#abas");

		$abas.find("a").on("click",function() {
			var $this = $(this),
				alvo = $this.attr("href");

			$abas.find("li").removeClass("ativo");
			$this.parent("li").addClass("ativo");

			$(".listas").find("div").removeClass("ativo");
			$(alvo).addClass("ativo");

			return false;
		});
	},

	exibirPesquisa: function() {
		var $form = $("#formulario-pesquisa");

		$(".barra-topo").find(".pesquisa").on("click",function(e) {
			e.stopPropagation();
			$form.addClass("ativo");
		});

		$form.on("click",function(e) {
			e.stopPropagation();
		});

		// Fecha o form de pesquisa ao clicar em qualquer lugar da página
		$("body").on("click",function() {
			$form.removeClass("ativo");
		});
	},

	exibirMenu: function() {
		var $menu = $("nav");

		$(".barra-topo").find(".menu").on("click",function(e) {
			e.stopPropagation();
			$menu.addClass("ativo");
		});

		$menu.on("click",function(e) {
			e.stopPropagation();
		});

		// Fecha o menu ao clicar em qualquer lugar da página
		$("body,.fechar-menu").on("click",function() {
			$menu.removeClass("ativo");
		});
	},

	fecharAviso: function() {
		$(".fechar-box-aviso").on("click",function() {
			$(this).parents(".aviso").fadeOut(400, function() {
				$(this).remove();
			});
		});
	},

	selecionarLista: function() {
		$("body").on("change","#arena-lista",function() {
			var lista = $(this).val();
			$("#opcao-1").find(".lista").removeClass("ativo");
			$("#arena-" + lista).addClass("ativo");
		});
		$("body").on("change","#discussao-lista",function() {
			var lista = $(this).val();
			$("#opcao-2").find(".lista").removeClass("ativo");
			$("#discussao-" + lista).addClass("ativo");
		});
		$("body").on("change","#favorito-lista",function() {
			var lista = $(this).val();
			$("#opcao-3").find(".lista").removeClass("ativo");
			$("#favorito-" + lista).addClass("ativo");
		});
	},

	simularCheckRadio: function() {
		var $checkbox = $('input[type="checkbox"],input[type="radio"]');

		$checkbox.on("click",function() {
			var $this = $(this);

			if ($this.is(":checked") || ($this.attr("checked") == 'checked' && $this.attr("type") == "radio") ) {
				if ($this.attr("type") == "radio") {
					var nome = $this.attr("name");
					$("input[name=" + nome + "]")
						.not($this)
						.removeAttr("checked")
						.siblings("label")
						.removeClass("ativo");
				}
				$this.siblings("label").addClass("ativo");
			} else {
				$this.siblings("label").removeClass("ativo");
				//$this.removeAttr("checked");
			}
		});
		$("document").ready(function() {
			js.marcarCheckRadio();
		});
	},

	marcarCheckRadio: function() {
		var $checkbox = $('input[type="checkbox"],input[type="radio"]');
		$checkbox.each(function() {
			var $this = $(this);

			if ( $this.attr("checked") ) {
				$this.siblings("label").addClass("ativo");
				$this.attr("checked", 'checked');
				this.checked = true;
			} else {
				$this.siblings("label").removeClass("ativo");
				//$this.removeAttr("checked");
			}
		});
	},

	selecionarFormulario: function() {
		$("#fase-pre,#fase-operacional").on("click",function() {
			$("#formulario-fase")
				.find(".erro")
				.removeClass("erro")
				.end()
				.find(".mensagem-erro")
				.remove();

			var $socio = $("#fase-socio"),
				$this = $(this);

			if ($socio.is(":checked")) {

				$(".opcional").removeClass("ativo");

				if ( ($this.is(":checked")) && ($this.attr("id") == "fase-pre") ) {
					$("#formulario-pre").addClass("ativo");

				} else if ( ($this.is(":checked")) && ($this.attr("id") == "fase-operacional") ) {
					$("#formulario-operacional").addClass("ativo");
				}

				$("#formulario-pre-operacional")
					.find(".erro")
					.removeClass("erro")
					.end()
					.find(".mensagem-erro")
					.remove();

			} else {

				$socio
					.siblings("label")
					.addClass("erro")
					.after('<span class="mensagem-erro">É necessário confirmar antes de continuar</span>');
			}
		});

		$("#fase-socio").on("click",function() {
			$("#formulario-fase")
				.find(".erro")
				.removeClass("erro")
				.end()
				.find(".mensagem-erro")
				.remove();

				if ($(this).is(":checked")) {
					if ($("#fase-pre").is(":checked")) {
						$("#formulario-pre").addClass("ativo");
					} else if ($("#fase-operacional").is(":checked")) {
						$("#formulario-operacional").addClass("ativo");
					}
				} else {
					$(".opcional").removeClass("ativo");
					$("#fase-pre,#fase-operacional").attr("checked",false).siblings("label").removeClass("ativo");
				}
		});
	},

	validarFormulario: function(formulario) {
		$("#" + formulario).on("submit",function() {
			var erro = false;

			// Se o formulário for o do passo 2, a validação fica dividida entre duas opções
			if (formulario == "formulario-pre-operacional") {

				if ( ($("#fase-pre").is(":checked")) && ($("#fase-socio").is(":checked")) ) {
					var $form = $("#formulario-pre,#formulario-projeto");
				} else if ( ($("#fase-operacional").is(":checked")) && ($("#fase-socio").is(":checked")) ) {
					var $form = $("#formulario-operacional,#formulario-projeto");
				} else {
					var $form = $("#formulario-fase");
				}

			} else {

				var $form = $(this);

			}

			$form
				.find(".erro")
				.removeClass("erro")
				.end()
				.find(".mensagem-erro")
				.remove();

			$form
				.find(".obrigatorio")
				.each(function() {
					var $this = $(this),
						mensagem = $this.data("mensagem");

					if ($this.val() == "") {
						$this
							.addClass("erro")
							.after('<span class="mensagem-erro">' + mensagem + '</span>');

						erro = true;
				}
			});

			var $cnpj = $form.find(".validacao-cnpj");
			if ($cnpj.length > 0) {
				$cnpj
					.each(function() {
						var $this = $(this);

						if( !js.validarCNPJ($this.val()) ) {
							$this
								.addClass("erro")
								.after('<span class="mensagem-erro">CNPJ inválido</span>');

							erro = true;
					}
				});
			}

			var $cpf = $form.find(".validacao-cpf");
			if ($cpf.length > 0) {
				$cpf
					.each(function() {
						var $this = $(this);

						if( ($this.val() == '' && $this.hasClass('obrigatorio')) || ( !js.validarCPF($this.val()) && $this.val() != '') ) {
							$this
								.addClass("erro")
								.after('<span class="mensagem-erro">CPF inválido</span>');

							erro = true;
					}
				});
			}

			var $data = $form.find(".validacao-data");
			if ($data.length > 0) {
				$data
					.each(function() {
						var $this = $(this);

						if(  $this.val() != '' && !js.validarData($this.val()) ) {
							$this
								.addClass("erro")
								.after('<span class="mensagem-erro">Data inválida</span>');

							erro = true;
					}
				});
			}

			var $invisivel = $form.find(".validacao-invisivel:visible");
			if ($invisivel.length > 0) {
				$invisivel
					.each(function() {
						var $this = $(this),
							mensagem = $this.data("mensagem");

						if ($this.val() == "") {
							$this
								.addClass("erro")
								.after('<span class="mensagem-erro">' + mensagem + '</span>');

							erro = true;
					}
				});
			}

			var distancia = $form.offset();
			$('html, body').animate({scrollTop:distancia.top}, 'slow');

			return !erro;
		});
	},

	validarFormularioDenuncia: function() {
		$("#formulario-denuncia").on("submit",function() {
			var erro = false;
			$(this)
				.find(".erro")
				.removeClass("erro")
				.end()
				.find(".mensagem-erro")
				.remove();

			var $denuncia = $("input[name='denuncia-opcao']"),
				$outro = $("#denuncia-outro"),
				$texto = $("#denuncia-texto");

			if (!$denuncia.is(":checked")) {
				$denuncia
					.parents(".radio-group")
					.addClass("erro")
					.before('<span class="mensagem-erro">É necessário escolher uma das opções</span>');

				erro = true;
			}

			if (($outro.is(":checked")) && ($texto.val() == "")) {
				$texto
					.addClass("erro")
					.after('<span class="mensagem-erro">Digite o motivo</span>');

				erro = true;
			}

			if (erro == false) {
				window.sujeito = this;
				if ($("input[name='denuncia-opcao']:checked").size() > 0) {
					var valor = $("input[name='denuncia-opcao']:checked").val();
				} else {
					var valor = 'O';
				}
				console.log(valor);
				$.ajax({
					url: $(this).find('#url_denunciado').val(),
					data: {
						'codigo': $(this).find('#id_denunciado').val(),
						'opcao':  valor,
						'descricao': $texto.val(),
					},
					dataType: 'json',
					type: 'POST',
					success: function(json){
						var el = $('a.modal-denuncia[data-id="'+$(window.sujeito).find('#id_denunciado').val()+'"]');
						if (json.denunciado == true) {
							el.html('[remover denúncia]');
							$("#passo-1").removeClass("ativo");
							$("#passo-2").addClass("ativo");
						} else {
							el.html('[denunciar]');
						}
					}
				});
			}

			return false;
			// return !erro;
		});
	},

	comportamentosFormulario1: function() {
		// Máscaras de entrada
		$("#cadastro-cpf").mask("999.999.999-99",{placeholder:" "});
		$("#cadastro-nascimento").mask("99/99/9999",{placeholder:" "});
		$("#cadastro-cep").mask("99999-999",{placeholder:" "});
		//$("#cadastro-telefone-fixo,#cadastro-telefone-celular").mask("(99) 9999-9999?9",{placeholder:" "});

		$("#cadastro-telefone-fixo,#cadastro-telefone-celular").focusout(function(){
			var phone, element;
			element = $(this);
			element.unmask();
			phone = element.val().replace(/\D/g, '');
			if(phone.length > 10) {
				element.mask("(99) 99999-999?9",{placeholder:" "});
			} else {
				element.mask("(99) 9999-9999?9",{placeholder:" "});
			}
		}).trigger('focusout');

		js.validarFormulario("formulario-cadastro");

		$("#cadastro-telefone-fixo,#cadastro-telefone-celular").on("change",function() {
			if ($("#cadastro-telefone-fixo").val() != "") {
				$("#cadastro-telefone-celular").removeClass("obrigatorio");
			} else {
				$("#cadastro-telefone-celular").addClass("obrigatorio");
			}
			if ($("#cadastro-telefone-celular").val() != "") {
				$("#cadastro-telefone-fixo").removeClass("obrigatorio");
			} else {
				$("#cadastro-telefone-fixo").addClass("obrigatorio");
			}
		});
		$("document").ready(function() {
			if ($("#cadastro-telefone-fixo").val() != "") {
				$("#cadastro-telefone-celular").removeClass("obrigatorio");
			} else {
				$("#cadastro-telefone-celular").addClass("obrigatorio");
			}
			if ($("#cadastro-telefone-celular").val() != "") {
				$("#cadastro-telefone-fixo").removeClass("obrigatorio");
			} else {
				$("#cadastro-telefone-fixo").addClass("obrigatorio");
			}
		});
	},

	comportamentosFormulario2: function() {
		// Máscaras de entrada
		$("#operacional-cnpj").mask("99.999.999/9999-99",{placeholder:" "});
		$("#operacional-fundacao").mask("99/99/9999",{placeholder:" "});
		$("#investimento-valor-anjo,#investimento-valor-vc,#soma-investimento,#investimento-valor-outro").maskMoney({symbol:"R$ ", thousands:".", decimal:",", affixesStay: true});
		
		$("#pre-faturamento,#operacional-faturamento,#operacional-previsto ").maskMoney({symbol:"R$ ", thousands:".", decimal:",", affixesStay: true, allowZero: true});

		// Campos escondidos
		$("#operacional-setor").on("change",function() {
			if ( $(this).find('option:selected').text() == "Outros") {
				$("#operacional-setor-outros").removeClass("invisivel").parent().removeClass('hidden');
			} else {
				$("#operacional-setor-outros").addClass("invisivel").parent().addClass('hidden');
			}
		});
		// Campos escondidos
		$("#operacional-setor-pre").on("change",function() {
			if ( $(this).find('option:selected').text() == "Outros") {
				$("#operacional-setor-outros-pre").removeClass("invisivel").parent().removeClass('hidden');
			} else {
				$("#operacional-setor-outros-pre").addClass("invisivel").parent().addClass('hidden');
			}
		});
		$("#operacional-investimento").on("click",function() {
			if ($(this).is(":checked")) {
				$(".investimento-externo").removeClass("invisivel");

			} else {
				$(".investimento-externo").addClass("invisivel");
			}
		});
		$("document").ready(function() {
			js.simularCheckRadio();
			if ( ($("#fase-pre").is(":checked")) && ($("#fase-socio").is(":checked")) ) {
				$("#formulario-pre").addClass("ativo");
			} else if ( ($("#fase-operacional").is(":checked")) && ($("#fase-socio").is(":checked")) ) {
				$("#formulario-operacional").addClass("ativo");
			}
		});

		js.validarFormulario("formulario-pre-operacional");

		$("#formulario-pre-operacional").on("submit",function() {
			var erro = false;
			$("#formulario-fase")
				.find(".erro")
				.removeClass("erro")
				.end()
				.find(".mensagem-erro")
				.remove();

			var $socio = $("#fase-socio"),
				$fase = $("input[name=pre_operacional]");

			if (!$socio.is(":checked")) {
				$socio
					.siblings("label")
					.addClass("erro")
					.after('<span class="mensagem-erro">É necessário confirmar antes de continuar</span>');

				erro = true;
			}
			if (!$fase.is(":checked")) {
				$fase
					.parents(".radio-group")
					.addClass("erro")
					.after('<span class="mensagem-erro">É necessário escolher uma das opções</span>');

				erro = true;
			}

			return !erro;
		});
	},

	comportamentosFormulario3: function() {
		js.validarFormulario("formulario-descricao");
	},

	comportamentosFormularioVitrine: function() {
		// Máscaras de entrada
		$("#informacoes-faturamento").maskMoney({symbol:"R$ ", thousands:".", decimal:",", affixesStay: true});

		js.validarFormulario("formulario-informacoes-negocio");

		var $estagio = $("#informacoes-estagio"),
			$escondido = $("#informacoes-radio-fase");
		$("#informacoes-pre").on("change",function() {
			if ( $(this).is(":checked") ) {
				$estagio.removeClass("invisivel");
				$escondido.val("1");
			}
		});
		$("#informacoes-operacional").on("change",function() {
			if ( $(this).is(":checked") ) {
				$estagio.addClass("invisivel");
				$escondido.val("2");
			}
		});
		$("document").ready(function() {
			if ( $("#informacoes-pre").is(":checked") ) {
				$estagio.removeClass("invisivel");
				$escondido.val("1");
			}
		});

		$("#formulario-informacoes-negocio").on("submit",function() {
			var erro = false,
				$formulario = $("#formulario-informacoes-negocio"),
				$fase = $("input[name=informacoes-fase]");

			$formulario
				.find(".radio-group.erro")
				.removeClass("erro")
				.end()
				.find(".mensagem-erro.fase")
				.remove();

			if (!$fase.is(":checked")) {
				$fase
					.parents(".radio-group")
					.addClass("erro")
					.after('<span class="mensagem-erro fase">É necessário escolher uma das opções</span>');

				erro = true;
			}

			return !erro;
		});
	},

	validarCPF: function(cpf) {
		cpf = jQuery.trim(cpf);

		cpf = cpf.replace('.','');
		cpf = cpf.replace('.','');
		cpf = cpf.replace('-','');
		while(cpf.length < 11) cpf = "0"+ cpf;
		var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/, // === /^(\d)\1*$/ :D
			a = [],
			b = new Number,
			c = 11;

		for (i=0; i<11; i++){
			a[i] = cpf.charAt(i);
			if (i < 9) b += (a[i] * --c);
		}
		if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11-x }
		b = 0;
		c = 11;
		for (y=0; y<10; y++) b += (a[y] * c--);
		if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11-x; }

		var retorno = true;
		if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) retorno = false;

		return retorno;
	},

	validarData: function(valor) {
		if(valor.length!=10)
			return false;

		var data 	= valor,
			dia 	= data.substr(0,2),
			barra1	= data.substr(2,1),
			mes 	= data.substr(3,2),
			barra2	= data.substr(5,1),
			ano 	= data.substr(6,4);

		if(data.length!=10||barra1!="/"||barra2!="/"||isNaN(dia)||isNaN(mes)||isNaN(ano)||dia>31||mes>12)return false;
		if((mes==4||mes==6||mes==9||mes==11) && dia==31)return false;
		if(mes==2	&&	(dia>29||(dia==29 && ano%4!=0)))return false;
		if(ano < 1900)return false;
		return true;
	},

	validarCNPJ: function(cnpj) {
		var i = 0;
		var l = 0;
		var strNum = "";
		var strMul = "6543298765432";
		var character = "";
		var iValido = 1;
		var iSoma = 0;
		var strNum_base = "";
		var iLenNum_base = 0;
		var iLenMul = 0;
		var iSoma = 0;
		var strNum_base = 0;
		var iLenNum_base = 0;

		if (cnpj == "")
			//return ("Preencha o campo CNPJ.");
			return false;

		l = cnpj.length;
		for (i = 0; i < l; i++) {
			caracter = cnpj.substring(i,i+1)
			if ((caracter >= '0') && (caracter <= '9'))
				strNum = strNum + caracter;
		};

		if(strNum.length != 14)
			//return ("CNPJ deve conter 14 caracteres.");
			return false;

		strNum_base = strNum.substring(0,12);
		iLenNum_base = strNum_base.length - 1;
		iLenMul = strMul.length - 1;

		for(i = 0;i < 12; i++)
			iSoma = iSoma +
			parseInt(strNum_base.substring((iLenNum_base-i),(iLenNum_base-i)+1),10) *
			parseInt(strMul.substring((iLenMul-i),(iLenMul-i)+1),10);

			iSoma = 11 - (iSoma - Math.floor(iSoma/11) * 11);
			if(iSoma == 11 || iSoma == 10)
				iSoma = 0;

			strNum_base = strNum_base + iSoma;
			iSoma = 0;
			iLenNum_base = strNum_base.length - 1

			for(i = 0; i < 13; i++)
				iSoma = iSoma +
				parseInt(strNum_base.substring((iLenNum_base-i),(iLenNum_base-i)+1),10) *
				parseInt(strMul.substring((iLenMul-i),(iLenMul-i)+1),10)

			iSoma = 11 - (iSoma - Math.floor(iSoma/11) * 11);
			if(iSoma == 11 || iSoma == 10)
				iSoma = 0;
				strNum_base = strNum_base + iSoma;

				if(strNum != strNum_base)
					//return ("CNPJ inválido.");
					return false;

		return (true);
	},

	contarCaracteres: function() {
		$(".limitado").on("keyup",function(){
			var limite = $(this).data("limite"),
				quantidade = $(this).val().length,
				restante = limite - quantidade,
				$this = $(this);

			if (quantidade > limite) {
				$this.addClass("erro");
				$this.siblings(".contador").text("Limite de caracteres atingido.");
			} else {
				$this.removeClass("erro");
				$this.siblings(".contador").text(restante + " caracteres restantes");
			}
		});

		$("document").ready(function() {
			$(".limitado").each(function() {
				var limite = $(this).data("limite"),
					quantidade = $(this).val().length,
					restante = limite - quantidade,
					$this = $(this);

				if (quantidade > limite) {
					$this.addClass("erro");
					$this.siblings(".contador").text("Limite de caracteres atingido.");
				} else {
					$this.removeClass("erro");
					$this.siblings(".contador").text(restante + " caracteres restantes");
				}
			});
		});
	},

	controlarPerguntas: function() {
		// var pergntaAtiva = 1,
		// 	_barra = $('div.barra'),
		// 	subbarra = function( index ){
		// 		var l = index.replace(/^[^-]+\-\d+/g,''),
		// 			n = index.replace(/^[^-]+\-(\d+).*$/g,'$1'),
		// 			_li = $("#botao-" + n, _barra).parent();

		// 		$('div.sub-barra', _barra).add($('.sub-barra a', _barra)).removeClass('ativo');
		// 		$('div.sub-barra', _li).addClass('ativo');

		// 		$('a[rel=' + l + ']', _li).length
		// 			? $('a[rel=' + l + ']').addClass('ativo')
		// 			: $('.sub-barra a:first', _li).addClass('ativo');
		// 	};

		/*
		$("#projeto-salvar").on("click",function() {
			$("#formulario-descricao").find(".mensagem-erro").remove();
			$.post(base_url + '/projeto/adicionar_editar',
				$(this).closest('form').serialize(),
				function(json){
					if (typeof json.error != 'undefined') {
						$form = $('#formulario-descricao');
						if (json.error === false) {
							// adiciona id em URLs que ja existem
							$('.projeto-passos a').each(function(){
								var url = $(this).attr('href').replace(/\?.*$/g,'');
								$(this).attr('href', url+'?projeto_id='+json.data.projeto_id+'&empresa_id='+json.data.empresa_id);
							});
							var url = $('#estrategia-enviar').attr('href').replace(/\?.*$/g,'');
							$('#estrategia-enviar').attr('href', url+'?projeto_id='+json.data.projeto_id+'&empresa_id='+json.data.empresa_id);
							// esconde bloqueio perguntas
							$('.perguntas div.bloqueio').addClass("oculto");
						} else {
							$("#estrategia-descricao").after('<span class="mensagem-erro">' + json.messages + '</span>');
						}
					}
				}
			);
		});
		*/

		// Comportamento do botÃ£o AvanÃ§ar
		//$(".estrategia-avancar").on("click",function() {
			//var $botao = $(this);
			//$botao.parents("form").on("submit",function() {
			$("ul.pergunta > li > form").on("submit",function() {
				var erro = false;
				var $this = $(this);
				var $form = $this;
				$this.find(".erro").removeClass("erro");

				$this.find("textarea").each(function() {
					var $this = $(this);
					if ($this.val() == "") {
						$this.addClass("erro");
						erro = true;
					}
				});

				if (erro == false) {
					$(".bloqueio").addClass("carregando");
					$.post(base_url+'/projeto/canvas/responder',
						$form.serialize(),
						function(json){
							if (typeof json.error != 'undefined') {
								if (json.error === false) {
									// sucesso, retorna dados da categoria, pergunta e resposta para preencher os inputs

									// Escreve as perguntas e as respostas no canvas
									// var $perguntaAtiva = $(".pergunta").find("li.ativo"),
									// 	identificacao = $perguntaAtiva.attr("id"),
									// 	filtro = identificacao.split("pergunta-"),
									// 	quantidadePerguntas = $perguntaAtiva.find("textarea").length,
									// 	textoPergunta = "",
									// 	textoResposta = "";

									// for (i=1;i<=quantidadePerguntas;i++) {
									// 	textoPergunta = $("#pergunta-" + filtro[1]).find("#estrategia-pergunta-" + i).siblings("p").text();
									// 	textoResposta = $("#pergunta-" + filtro[1]).find("#estrategia-pergunta-" + i).val();

									// 	if (i == 1) {
									// 		$("#canvas-" + filtro[1]).html('<p class="pergunta-' + i + '"><strong>' + textoPergunta + '</strong>' + textoResposta + '</p>');
									// 	} else {
									// 		$("#canvas-" + filtro[1]).append('<p class="pergunta-' + i + '"><strong>' + textoPergunta + '</strong>' + textoResposta + '</p>');
									// 	}
									// }

									// muda para proxima pergunta
									var $lista = $this.parents(".pergunta"),
									$ativo = $lista.find(".ativo");
									if ($ativo.next("li").length) {
										$lista.find("li").removeClass("ativo");
										$ativo.next("li").addClass("ativo");

										var $sub = $(".perguntas").find(".barra"),
											$proximo = $sub.find(".ativo").next("li");
										if ($proximo.length) {
											$proximo.find("button").click();
										}
									}

									location.href = "#perguntasCanvas";
								} else {
									$('#formulario-estrategia .pergunta li.ativo').find("form").append('<span class="mensagem-erro">' + json.messages + '</span>');
								}
								$(".bloqueio").removeClass("carregando");
							}
						}
					);
				}

				js.verificarPerguntas();

				return false;
			});

		//});

		// Comportamento do botÃ£o Retornar
		$(".estrategia-voltar").on("click",function() {
			var $lista = $(".pergunta"),
				$ativo = $lista.find(".ativo");

			if ($ativo.prev("li").length) {
				$lista.find("li").removeClass("ativo");
				$ativo.prev("li").addClass("ativo");

				var $sub = $(".perguntas").find(".barra"),
					$anterior = $sub.find(".ativo").prev("li");
				if ($anterior.length) {
					$anterior.find("button").click();
				}
			}
			js.verificarPerguntas();
		});

		// Comportamento dos botÃµes de paginaÃ§Ã£o
		$(".perguntas").find(".barra").find("button").on("click",function() {
			var numero = $(this).parent("li").attr("id"),
				valor = numero.split("botao-");

			$(".pergunta").find("li").removeClass("ativo");
			$("#pergunta-" + valor[1]).addClass("ativo");

			$(".perguntas").find(".barra").find("li,button").removeClass("ativo");
			$(this).parent("li").addClass("ativo");
		});

		$(".perguntas").find(".barra").find("li > button").on("click",function() {
			$(this).siblings(".sub").find("button:first").click();
		});

		// $('div.sub-barra a').on('click', function(){
		// 	var _index = $('button.ativo', _barra).text(),
		// 		_this = $(this),
		// 		_rel = _this.attr('rel'),
		// 		_lista = $(".pergunta");

		// 	$('a.ativo', _this.parents('.sub-barra')).removeClass('ativo');

		// 	_this.addClass('ativo');

		// 	$('li.ativo', _lista).removeClass('ativo');
		// 	$('#pergunta-'+ _index + _rel).addClass('ativo');
		// });

		//Centralizar sub-barras

		// $('li:not(".ultimo"):not(".primeiro") .sub-barra', _barra).each(function(){
		// 	var _this = $(this);

		// 	_this.css(
		// 	{
		// 		left: -( ( _this.width() / 2 ) - 10 )
		// 	})
		// })

		// Comportamento do canvas
		// $("#canvas").find("a").on("click",function() {
		// 	var numero = $(this).attr("id"),
		// 		valor = numero.split("canvas-");

		// 	// $(".pergunta").find("li").removeClass("ativo");
		// 	// $("#pergunta-" + valor[1]).addClass("ativo");

		// 	// $(".perguntas").find(".barra").find("button").removeClass("ativo");
		// 	// $("#botao-" + valor[1]).addClass("ativo");

		// 	$("#botao-" + valor[1]).find("button").click();
		// 	var distancia = $("#formulario-estrategia").offset();
		// 	$('html, body').animate({scrollTop:distancia.top}, 'slow');

		// 	return false;
		// });

		$('#perguntasCanvas form textarea').blur(function(){
			var $this = $(this);
			var data = {
				'pergunta_id': $this.siblings('input[type="hidden"][name="pergunta_id[]"]').val(),
				'resposta_id': $this.siblings('input[type="hidden"][name="resposta_id[]"]').val(),
				'pergunta_resposta': $this.val(),
				'projeto_id': $this.parents('form').find('input[type="hidden"][name="projeto_id"]').val(),
			};
		
			$.post(base_path + '/projeto/canvas/responderAjax', data, function(json){
				if (json.error) alert (json.messages);

				var $form = $this.parents('form');
				var quantidadeTextArea = $form.find('textarea').size();
				var quantidade = 0;
				$form.find('textarea').each(function(){
					if (this.value.trim() != '') {
						quantidade++;
					}
				});

				if ( quantidade == quantidadeTextArea ) {
					$('#formulario-estrategia .perguntas ul.barra li.ativo').addClass('completo')
				} else {
					$('#formulario-estrategia .perguntas ul.barra li.ativo').removeClass('completo')
				}
			});
		});
	},

	verificarPerguntas: function() {
		var numeroPerguntas = $(".pergunta").find("textarea").length,
			numeroPerguntas1 = $("#pergunta-1").find("textarea").length,
			numeroPerguntas2 = $("#pergunta-2").find("textarea").length,
			numeroPerguntas3 = $("#pergunta-3").find("textarea").length,
			numeroPerguntas4 = $("#pergunta-4").find("textarea").length,
			numeroPerguntas5 = $("#pergunta-5").find("textarea").length,
			numeroPerguntas6 = $("#pergunta-6").find("textarea").length,
			numeroPerguntas7 = $("#pergunta-7").find("textarea").length,
			numeroPerguntas8 = $("#pergunta-8").find("textarea").length,
			numeroPerguntas9 = $("#pergunta-9").find("textarea").length,
			perguntasOK = 0,
			perguntasOK1 = 0,
			perguntasOK2 = 0,
			perguntasOK3 = 0,
			perguntasOK4 = 0,
			perguntasOK5 = 0,
			perguntasOK6 = 0,
			perguntasOK7 = 0,
			perguntasOK8 = 0,
			perguntasOK9 = 0;

		$("#pergunta-1").find("textarea").each(function() {
			if ( $(this).val() != "" ) {
				perguntasOK1 = perguntasOK1 + 1;
			}
		});
		$("#pergunta-2").find("textarea").each(function() {
			if ( $(this).val() != "" ) {
				perguntasOK2 = perguntasOK2 + 1;
			}
		});
		$("#pergunta-3").find("textarea").each(function() {
			if ( $(this).val() != "" ) {
				perguntasOK3 = perguntasOK3 + 1;
			}
		});
		$("#pergunta-4").find("textarea").each(function() {
			if ( $(this).val() != "" ) {
				perguntasOK4 = perguntasOK4 + 1;
			}
		});
		$("#pergunta-5").find("textarea").each(function() {
			if ( $(this).val() != "" ) {
				perguntasOK5 = perguntasOK5 + 1;
			}
		});
		$("#pergunta-6").find("textarea").each(function() {
			if ( $(this).val() != "" ) {
				perguntasOK6 = perguntasOK6 + 1;
			}
		});
		$("#pergunta-7").find("textarea").each(function() {
			if ( $(this).val() != "" ) {
				perguntasOK7 = perguntasOK7 + 1;
			}
		});
		$("#pergunta-8").find("textarea").each(function() {
			if ( $(this).val() != "" ) {
				perguntasOK8 = perguntasOK8 + 1;
			}
		});
		$("#pergunta-9").find("textarea").each(function() {
			if ( $(this).val() != "" ) {
				perguntasOK9 = perguntasOK9 + 1;
			}
		});

		if ( perguntasOK1 >= numeroPerguntas1 ) {
			$("#botao-1").addClass("completo");
		} else {
			$("#botao-1").removeClass("completo");
		}
		if ( perguntasOK2 >= numeroPerguntas2 ) {
			$("#botao-2").addClass("completo");
		} else {
			$("#botao-2").removeClass("completo");
		}
		if ( perguntasOK3 >= numeroPerguntas3 ) {
			$("#botao-3").addClass("completo");
		} else {
			$("#botao-3").removeClass("completo");
		}
		if ( perguntasOK4 >= numeroPerguntas4 ) {
			$("#botao-4").addClass("completo");
		} else {
			$("#botao-4").removeClass("completo");
		}
		if ( perguntasOK5 >= numeroPerguntas5 ) {
			$("#botao-5").addClass("completo");
		} else {
			$("#botao-5").removeClass("completo");
		}
		if ( perguntasOK6 >= numeroPerguntas6 ) {
			$("#botao-6").addClass("completo");
		} else {
			$("#botao-6").removeClass("completo");
		}
		if ( perguntasOK7 >= numeroPerguntas7 ) {
			$("#botao-7").addClass("completo");
		} else {
			$("#botao-7").removeClass("completo");
		}
		if ( perguntasOK8 >= numeroPerguntas8 ) {
			$("#botao-8").addClass("completo");
		} else {
			$("#botao-8").removeClass("completo");
		}
		if ( perguntasOK9 >= numeroPerguntas9 ) {
			$("#botao-9").addClass("completo");
		} else {
			$("#botao-9").removeClass("completo");
		}

		// Ativa o botão para ir para o passo 4
		$(".pergunta").find("textarea").each(function() {
			if ( $(this).val() != "" ) {
				perguntasOK = perguntasOK + 1;
			}
		});
		if ( perguntasOK >= numeroPerguntas ) {
			// $(".estrategia-avancar").addClass("oculto");
			$(".estrategia-enviar").addClass("ativo");
		} else {
			// $(".estrategia-avancar").removeClass("oculto");
			$(".estrategia-enviar").removeClass("ativo");
		}
	},

	trocarArea: function() {
		$(".area-expandir").on("click",function() {
			$("main").find(".passo").removeClass("ativo");
			if ($(this).parent(".passo").hasClass("lista-2")) {
				$(".lista-1").addClass("ativo");
			} else {
				$(".lista-2").addClass("ativo");
			}
		});
	},

	larguraPaginacao: function(){
		if( $('div.paginacao').length ){
			$('div.paginacao').each(function(){
				var _this = $(this),
					_w = ( $('li', _this).length * 50 ) + 194;
				_this.width(_w);
			})
		}
	},

	somarValores: function() {
		$("#investimento-valor-outro, #investimento-valor-anjo, #investimento-valor-vc").on("keyup",function() {
			var valor1 = $("#investimento-valor-anjo").val(),
				resultado1 = valor1.replace(/[^0-9,]+/g,''),
				final1 = resultado1.replace(",","."),
				numero1 = parseFloat(final1);
			numero1 = isNaN(numero1) ? 0 : numero1;

			var valor2 = $("#investimento-valor-vc").val(),
				resultado2 = valor2.replace(/[^0-9,]+/g,''),
				final2 = resultado2.replace(",","."),
				numero2 = parseFloat(final2);
			numero2 = isNaN(numero2) ? 0 : numero2;

			var valor3 = $("#investimento-valor-outro").val(),
			resultado3 = valor3.replace(/[^0-9,]+/g,''),
			final3 = resultado3.replace(",","."),
			numero3 = parseFloat(final3);
			numero3 = isNaN(numero3) ? 0 : numero3;

			var valor4 = numero1 + numero2 + numero3;
			var resultado4 = valor4.toFixed(2);
			var final4 = resultado4.toString();
			var number4 = new Number(final4).formatMoney(2, ',', '.');

			$("#investimento-soma").val(number4);
		});
	},

	exibirTooltip: function() {
		$(".privacidade").on("click",function(e) {
			e.stopPropagation();
			$(".tooltip").removeClass("ativo");
			$(this).siblings(".tooltip").addClass("ativo");
		});

		$("body").on("click",function() {
			$(".tooltip").removeClass("ativo");
		});

		$(".box-privacidade").find(".publica").on("click",function() {
			$(this)
				.parents(".box-privacidade")
				.removeClass("privada")
				.siblings('input[type="hidden"]')
				.val("1");
		});
		$(".box-privacidade").find(".privada").on("click",function() {
			$(this)
				.parents(".box-privacidade")
				.addClass("privada")
				.siblings('input[type="hidden"]')
				.val("0");
		});
	},

	lerURL: function(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$("#preview").attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	},
	
	trocarArea: function() {
		$(".area-expandir").on("click",function() {
			$("main").find(".passo").removeClass("ativo");
			if ($(this).parent(".passo").hasClass("lista-2")) {
				$(".lista-1").addClass("ativo");
			} else {
				$(".lista-2").addClass("ativo");
			}
		});
	},

	exibirComentarios: function() {
		$(".comentar").on("click",function(e) {
			e.stopPropagation();
			$(".display").removeClass("ativo");
			$(this)
				.find(".display")
				.addClass("ativo");

			$(".mensagens-recebidas").animate({ scrollTop: 60000 }, "fast");
		});

		$("body").on("click",function() {
			$(".display").removeClass("ativo");
		});
	},

	engatilharBotao: function() {
		$("#imagem-upload").change(function() {
			js.lerURL(this);
		});
	},

	exibirVideos: function() {
		var $lista = $(".lista-videos"),
			$botoes = $lista.find("button");

		$botoes
			.on("click",function() {
				$botoes.removeClass("ativo");
				$(this).addClass("ativo");

				var indice = $(this).data("indice");
				$lista
					.find(".container")
					.removeClass("ativo")
					.end()
					.find(".container[data-indice=" + indice + "]")
					.addClass("ativo");
		});
	},

	fecharModal: function() {
		$(".fechar-modal,#fundo").on("click",function() {
			$(".bloco-modal").remove();

			return false;
		});
	},

	abrirModal: function() {
		$(".modal-infografico").on("click",function() {
			var estrutura = '<div class="bloco-modal ativo" id="infografico-modal">\
								<div id="fundo"></div>\
								<div class="modal">\
									<div class="fechar">\
										<button class="fechar-modal" type="button">x</button>\
									</div>\
									<h2 class="titulo-3">O que você encontra no inovativa brasil</h2>\
									<div class="desktop">\
										<style>.embed-container { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%; } .embed-container iframe, .embed-container object, .embed-container embed { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }</style><div class="embed-container"><iframe src="http://www.youtube.com/embed/fnt17a3SouA" frameborder="0" allowfullscreen></iframe></div>\
									</div>\
									<div class="linha">\
										&nbsp;&nbsp;&nbsp;<a href="http://www.inovativabrasil.com.br/regulamento" target="_blank" class="botao-1">Regulamento</a>\
										<a href="#" class="botao-4 fechar-modal">Ok, entendi</a>\
									</div>\
								</div>\
							</div>';
			$("body").append(estrutura);
			$(".bloco-modal").addClass("ativo");
			js.fecharModal();
			$('html, body').animate({scrollTop:0}, 'slow');

			return false;
		});
	},

	abrirModalVideo: function() {
		$(".modal-video").on("click",function() {
			var endereco = $(this).attr("href"),
				estrutura = '<div class="bloco-modal" id="video-modal">\
								<div id="fundo"></div>\
								<div class="modal">\
									<div class="fechar">\
										<button class="fechar-modal" type="button">x</button>\
									</div>\
									<div class="container">\
										<div class="player">\
											<iframe \
												src="' + endereco +'" \
												frameborder="0" \
												webkitallowfullscreen mozallowfullscreen allowfullscreen>\
											</iframe>\
										</div>\
									</div>\
								</div>\
							</div>';
			$("body").append(estrutura);
			$(".bloco-modal").addClass("ativo");
			js.fecharModal();
			$('html, body').animate({scrollTop:0}, 'slow');

			return false;
		});
	},

	abrirModalDenuncia: function() {
		$(".modal-denuncia").on("click",function() {
			if ($(this).html() == '[remover denúncia]') {
				window.sujeito = this;
				$id = $(this).data('id');
				$.ajax({
					url: $(this).data('url'),
					data: {'codigo': $id},
					dataType: 'json',
					type: 'POST',
					success: function(json){
						console.log(json.sucesso);
						if (json.denunciado == true)
							$(window.sujeito).html('[remover denúncia]');
						else
							$(window.sujeito).html('[denunciar]');
					}
				});
			} else {
				var estrutura = '<div id="modal-denuncia" class="bloco-modal">\
								<div id="fundo"></div>\
								<div id="passo-1" class="modal ativo">\
									<h2 class="titulo-8">Denunciar conteúdo</h2>\
									<form id="formulario-denuncia" action="#" method="post">\
										<input type="hidden"id="id_denunciado" value="'+$(this).data('id')+'"/>\
										<input type="hidden"id="url_denunciado" value="'+$(this).data('url')+'"/>\
										<fieldset>\
											<legend>Formulário de denúncia</legend>\
											<span class="caption">Estou denunciando essa publicação porque:</span>\
											<div class="radio-group">\
												<div class="linha radio-button">\
													<input type="radio" id="denuncia-spam" class="denuncia-spam" name="denuncia-opcao" value="S" />\
													<label for="denuncia-spam"><span>É spam</span>A publicação é uma propaganda não solicitada. Não é útil nem relevante, somente promocional.</label>\
												</div>\
												<div class="linha radio-button">\
													<input type="radio" id="denuncia-ofensiva" class="denuncia-ofensiva" name="denuncia-opcao" value="F" />\
													<label for="denuncia-ofensiva"><span>É ofensiva, abusiva ou contém discurso de ódio</span>A publicação ofende diretamente um indivíduo ou grupo de indivíduos e não é relevante à discussão.</label>\
												</div>\
												<div class="linha radio-button">\
													<input type="radio" id="denuncia-duplicata" class="denuncia-duplicata" name="denuncia-opcao" value="D" />\
													<label for="denuncia-duplicata"><span>É uma duplicata</span>Já foi perguntada anteriormente.</label>\
												</div>\
												<div class="linha radio-button">\
													<input type="radio" id="denuncia-relevante" class="denuncia-relevante" name="denuncia-opcao" value="I" />\
													<label for="denuncia-relevante"><span>Não é relevante ao site</span>Não atende ou se adequa aos padrões do site.</label>\
												</div>\
												<div class="linha radio-button">\
													<input type="radio" id="denuncia-qualidade" class="denuncia-qualidade" name="denuncia-opcao" value="Q" />\
													<label for="denuncia-qualidade"><span>Não tem qualidade</span>Tem problemas graves de formatação ou compreensão.<br />Mesmo com edição não é possível melhorar o conteúdo da publicação.</label>\
												</div>\
												<div class="linha radio-button outro">\
													<input type="radio" id="denuncia-outro" class="denuncia-outro" name="denuncia-opcao" value="O" />\
													<label for="denuncia-outro"><span>Outro motivo</span>Explique ao moderador por que essa publicação deve ser removida:</label>\
													<input type="text" id="denuncia-texto" class="denuncia-texto" name="denuncia-texto" />\
												</div>\
												</div>\
											<div class="linha">\
												<input type="submit" id="denuncia-enviar" class="denuncia-enviar botao-2" name="denuncia-enviar" value="Denunciar" />\
											</div>\
										</fieldset>\
									</form>\
								</div>\
								<div id="passo-2" class="modal">\
									<h2 class="titulo-8">Denunciar conteúdo</h2>\
									<span class="caption">Sua denúncia à publicação foi enviada com sucesso!</span>\
									<button type="button" class="fechar-modal botao-2">Fechar</button>\
								</div>\
							</div>';
				$("body").append(estrutura);
				$(".bloco-modal").addClass("ativo");
				js.fecharModal();
				js.simularCheckRadio();
				js.alterarFoco();
				js.validarFormularioDenuncia();

				// Centralizar verticalmente o modal
				$.fn.center = function () {
					var scrollTop = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;
					this.css("position","absolute");
					this.css("top", scrollTop);
					this.css("width", $(window).width() );
					return this;
				}
				$('#modal-denuncia').center();

				// Antigo
				//$('html, body').animate({scrollTop:0}, 'slow');
			}
			return false;
		});
	},

	alterarFoco: function() {
		// Joga o foco no campo de texto ao clicar na opcao Outros
		$("#denuncia-outro").on("focus", function() {
			$("#denuncia-texto").focus();
		});
	},

	abrirBox: function() {
		var $sugestao = $("#lista-sugestao"),
			$duvida = $("#lista-duvida"),
			$contato = $(".box-contato");

		// Abre o box
		$("#link-box-contato").on("click",function(e) {
			e.stopPropagation();
			$(this).siblings('.box-contato').fadeToggle('fast');

			return false;
		});

		// Evita a propagação do evento para não fechar o box
		$contato.on("click",function(e) {
			e.stopPropagation();
		});

		// Fecha o box ao clique e corrige o posicionamento dos elementos
		$("body,.fechar-box").on("click",function() {
			$contato.fadeOut('fast',function() {
				$(".passo-2,.passo-3,.passo-extra").css("left",0).css("opacity",1);
				$(".passo-1").css("left","20px").css("opacity",1);
				$("#formulario-sugestao,#formulario-duvida")
					.find("#mensagem-erro")
					.remove()
					.end()
					.find(".erro")
					.removeClass("erro")
					.end()
					.find("input[type=text],textarea")
					.val("");
			});
		});

		// Muda para a segunda página
		$("#item-sugestao").on("click",function() {
			$(this).parent(".passo-1").animate({left: "-306px", opacity: 0}, 200, "swing");
			$sugestao.find(".passo-2").animate({left: "-286px", opacity: 1}, 350, "swing");
		});
		$("#item-duvida").on("click",function() {
			$(this).parent(".passo-1").animate({left: "-306px", opacity: 0}, 200, "swing");
			$duvida.find(".passo-2").animate({left: "-286px", opacity: 1}, 350, "swing");
		});

		// Muda para a terceira página
		$("#sugestao-enviar").on("click",function() {
			var erro = false,
				$formulario = $("#formulario-sugestao"),
				$assunto = $("#sugestao-assunto"),
				$texto = $("#sugestao-texto"),
				mensagem = '<span id="mensagem-erro">Preencha os campos em vermelho corretamente.</span>';

			$formulario.bind("submit", function() {
				erro = false;
				$formulario
					.find("#mensagem-erro")
					.remove()
					.end()
					.find(".erro")
					.removeClass("erro");

				if ($assunto.val() == "") {
					$assunto.addClass("erro");
					erro = true;
				}

				if ($texto.val() == "") {
					$texto.addClass("erro");
					erro = true;
				}

				var mensagemErro = $formulario.find("#mensagem-erro");
				if ((mensagemErro.length) <= 0 && (erro == true)) {
					$formulario.prepend(mensagem);
				} else {
					$sugestao.find(".passo-2").animate({left: "-566px", opacity: 0}, 200, "swing");
					$sugestao.find(".passo-3").animate({left: "-306px", opacity: 1}, 350, "swing");
				}

				return false;
				//return !erro;
			});
		});
		$("#duvida-enviar").on("click",function() {
			var erro = false,
				$formulario = $("#formulario-duvida"),
				$assunto = $("#duvida-assunto"),
				$texto = $("#duvida-texto"),
				mensagem = '<span id="mensagem-erro">Preencha os campos em vermelho corretamente.</span>';

			$formulario.bind("submit", function() {
				erro = false;
				$formulario
					.find("#mensagem-erro")
					.remove()
					.end()
					.find(".erro")
					.removeClass("erro");

				if ($assunto.val() == "") {
					$assunto.addClass("erro");
					erro = true;
				}

				if ($texto.val() == "") {
					$texto.addClass("erro");
					erro = true;
				}

				var mensagemErro = $formulario.find("#mensagem-erro");
				if ((mensagemErro.length) <= 0 && (erro == true)) {
					$formulario.prepend(mensagem);
				} else {
					$duvida.find(".passo-2").animate({left: "-566px", opacity: 0}, 200, "swing");
					$duvida.find(".passo-extra").animate({left: "-306px", opacity: 1}, 350, "swing");
				}

				return false;
				//return !erro;
			});
		});

		// Muda para a quarta página
		$("#publicar-pergunta").on("click",function() {
			$(this).parent(".passo-extra").animate({left: "-306px", opacity: 0}, 200, "swing");
			$duvida.find(".passo-3").animate({left: "-306px", opacity: 1}, 350, "swing");
		});
	},

	ativarCarrosselDiscussao: function() {
		$li = $(".carrossel-videos").find("li");
		$a = $li.find("a").length;
		if ( $a > 3) {
			distancia = 0;
			numero = 1;
			limite = $a -3;
			$(".carrossel-videos").find(".proximo").on("click",function() {
				if ( numero <= limite ) {
					distancia = distancia -129;
					$li.css("left", distancia + "px");

					numero = numero + 1;
				}

				return false;
			});

			$(".carrossel-videos").find(".anterior").on("click",function() {
				if ( numero > 1 ) {
					distancia = distancia +129;
					$li.css("left", distancia + "px");

					numero = numero - 1;
				}

				return false;
			});
		} else {
			$(".carrossel-videos").addClass("inativo");
		}
	},

	exibirCamposOcultos: function() {
		$("#busca-avancado").on("click",function() {
			$(this)
				.toggleClass("ativo")
				.parents("form")
				.find(".arcabouco")
				.slideToggle(500);

			if ( !$(this).hasClass("ativo") ) {
				$(this).text("Avançado");
			} else {
				$(this).text("Ocultar avançado");
			}
		});
	},

	executarAutoComplete: function() {
		$('.acao-deletar-membro').on('click', function(){
			$.get(
				base_path+'/negocio/ajax/membro' + ($(this).hasClass('deletar-membro-discussao') ? '_discussao' : '') + '/remover',
				{
					id_usuario: $(this).data('id'),
					id_negocio: $('#id_negocio').val(),
				},
				function(data) {
					if (! data.error) {
						$('#membro_negocio_'+ data.data.id+', #membro_discussao_'+ data.data.id)
							.remove();
					} else {
						alert(data.messages.join("\n"));
					}
				}
			);
		});
		$( ".auto-complete" ).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url: base_path+"/negocio/ajax/membros",
					dataType: "json",
					data: {
						id_negocio: $('#id_negocio').val(),
						busca: request.term
					},
					success: function( data ) {
						response( data );
					}
				});
			},
			minLength: 3,
			select: function( event, ui ) {
				if (ui.item)
					$.get(
						base_path+'/negocio/ajax/membro/adicionar',
						{
							id_usuario: ui.item.id,
							id_negocio: $('#id_negocio').val(),
						},
						function(data) {
							if (! data.error) {
								if (typeof data.data.nome != 'undefined') {
									$('#membro_negocio_'+ data.data.id+', #membro_discussao_'+ data.data.id)
										.remove();
									var estrutura = '<li class="tipo-pessoas" id="membro_negocio_'+ data.data.id +'">\
												<div class="dados">\
													<img src="' + data.data.imagem + '" alt="' + data.data.nome + '">\
													<p><a href="' + data.data.link + '">' + data.data.nome + '</a></p>\
													<button type="button" class="deletar-membro-negocio acao-deletar-membro" data-id="'+ data.data.id +'">x</button>\
												</div>\
											</li>';
									$('#lista-favoritos').append(estrutura);
									js.executarAutoComplete();
									$( ".auto-complete" ).val('');
								}
							} else {
								alert(data.messages.join("\n"));
							}
						}
					);
			},
			open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			},
			close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			}
		});
		$( ".auto-complete-discussao" ).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url: base_path+"/negocio/ajax/membros",
					dataType: "json",
					data: {
						id_negocio: $('#id_negocio').val(),
						busca: request.term
					},
					success: function( data ) {
						response( data );
					}
				});
			},
			minLength: 3,
			select: function( event, ui ) {
				if (ui.item)
					$.get(
						base_path+'/negocio/ajax/membro_discussao/adicionar',
						{
							id_usuario: ui.item.id,
							id_negocio: $('#id_negocio').val(),
						},
						function(data) {
							if (! data.error) {
								if (typeof data.data.nome != 'undefined') {
									$('#membro_negocio_'+ data.data.id+', #membro_discussao_'+ data.data.id)
										.remove();
									var estrutura = '<li class="tipo-pessoas" id="membro_discussao_'+ data.data.id +'">\
												<div class="dados">\
													<img src="' + data.data.imagem + '" alt="' + data.data.nome + '">\
													<p><a href="' + data.data.link + '">' + data.data.nome + '</a></p>\
													<button type="button" class="deletar-membro-discussao acao-deletar-membro" data-id="'+ data.data.id +'">x</button>\
												</div>\
											</li>';
									$('#lista-favoritos-discussao').append(estrutura);
									js.executarAutoComplete();
									$( ".auto-complete-discussao" ).val('');
								}
							} else {
								alert(data.messages.join("\n"));
							}
						}
					);
			},
			open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			},
			close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			}
		});
	},

	executarAutoCompleteBuscaDiscussoes: function() {
		$( ".auto-complete" ).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url: base_path+"/discussoes/busca/ajax/usuarios",
					dataType: "json",
					data: {
						busca: request.term
					},
					success: function( data ) {
						response( data );
					}
				});
			},
			minLength: 3,
			select: function( event, ui ) {
				if (ui.item) {

					//adiciona o autor para ser pesquisado depois
					var $autorBuscado = $('<input type="hidden" class="autocomplete-values"  name="autoresBuscados[]" />').val(ui.item.id);
					$(".auto-complete").after($autorBuscado);

					//adiciona o nome do autor na exibição para poder remover da pesquisa
					var $nomeBuscado = '<li>\
											<div class="dados">\
												<p class="remover-autor-id" data-id="' + ui.item.id + '">' + ui.item.label + '</p>\
											</div>\
										</li>';
					$('#itens-autocomplete').append($nomeBuscado);

					//remove o item da consulta quando clicado
					$(".remover-autor-id").on('click',function(){
						$(".autocomplete-values[value="+$(this).data('id')+"]").remove();
						$(this).parents("li").remove();
					});

				}
			},
			open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			},
			close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				$( "#buscaAutor").val('');
			}
		});
		$( ".auto-complete-discussao" ).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url: base_path+"/negocio/ajax/membros",
					dataType: "json",
					data: {
						id_negocio: $('#id_negocio').val(),
						busca: request.term
					},
					success: function( data ) {
						response( data );
					}
				});
			},
			minLength: 3,
			select: function( event, ui ) {
				if (ui.item)
					$.get(
						base_path+'/negocio/ajax/membro_discussao/adicionar',
						{
							id_usuario: ui.item.id,
							id_negocio: $('#id_negocio').val(),
						},
						function(data) {
							if (! data.error) {
								if (typeof data.data.nome != 'undefined') {
									$('#membro_negocio_'+ data.data.id+', #membro_discussao_'+ data.data.id)
										.remove();
									var estrutura = '<li class="tipo-pessoas" id="membro_discussao_'+ data.data.id +'">\
												<div class="dados">\
													<img src="' + data.data.imagem + '" alt="' + data.data.nome + '">\
													<p><a href="' + data.data.link + '">' + data.data.nome + '</a></p>\
													<button type="button" class="deletar-membro-discussao acao-deletar-membro" data-id="'+ data.data.id +'">x</button>\
												</div>\
											</li>';
									$('#lista-favoritos-discussao').append(estrutura);
									js.executarAutoComplete();
									$( ".auto-complete-discussao" ).val('');
								}
							} else {
								alert(data.messages.join("\n"));
							}
						}
					);
			},
			open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			},
			close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			}
		});
	},


	exibirOculto: function() {
		$(".exibirOculto").on('click',function() {
			$(this).siblings('.oculto').slideDown(400);
		});
	},

	exibirAbas: function() {
		$("#abas-areas")
			.find("button")
			.on("click", function() {
				var $this = $(this),
					$elemento = $this.parent("li"),
					alvo = $elemento.data("area"),
					nome = $elemento.data("slug");

				$(".area").removeClass("ativo");
				$("#" + alvo).addClass("ativo");

				$this
					.parent("li")
					.addClass("ativo")
					.siblings("li")
					.removeClass("ativo");

				window.history.pushState({ path: window.location.pathname }, '', 'area-conhecimento#' + nome);
		});
	},

	analisarAbas: function() {
		var endereco = window.location.hash;
		$(endereco).click();
	},

	escolherDestino: function() {
		$(".abas-cursos").find("select").on("change",function() {
			var destino = $(this).val();
			window.location.href = destino;
		});
		$(".escolher-time").find("select").on("change",function() {
			var destino = $(this).val();
			window.location.href = destino;
		});
	},

	manipularBoxDados: function() {
		$(".abrir-fechar-box-dados").on("click",function() {
			var el = $(this).parents(".icone").find(".box-dados");
			if (el.is(":visible")) {
				el.slideUp(200);
			} else {
				el.slideDown(200);
			}
			return false;
		});
		$(".abrir-box-dados").on("click",function() {
			$(this).parents(".icone").find(".box-dados").slideDown(200);
			return false;
		});
		$(".fechar-box-dados").on("click",function() {
			$(this).parents(".box-dados").slideUp(200);
			return false;
		});
	},

	alternarAbasChat: function() {
		$(".abas-chat")
			.find(".aba")
			.on("click",function() {
				var $this = $(this),
					alvo = $this.data("aba");

				$this
					.parents(".chat")
					.find(".lista-" + alvo)
					.addClass("ativo")
					.siblings(".lista")
					.removeClass("ativo");

				$this
					.parent("li")
					.addClass("ativo")
					.siblings("li")
					.removeClass("ativo");
		});
	},

	selecionarArea: function() {
		$(".menu-areas").find("select").on("change",function() {
			var alvo = $(this).val();

			$(".area").removeClass("ativo");
			$("#" + alvo).addClass("ativo");
		});
	},

	selecionarConteudo: function() {
		$(".abas-opcoes")
			.find("a")
			.on("click",function() {
				var $this = $(this),
					alvo = $this.attr("href");

			$(alvo)
				.addClass("ativo")
				.siblings(".conteudo-opcoes")
				.removeClass("ativo");

			$this
				.parent("li")
				.addClass("ativo")
				.siblings("li")
				.removeClass("ativo");
			return false;
		});
	},


	/** 
	  * bloco responsável pela área de inscrição à um desafio
	  * @author Marco Malaquias
	  */
	entregavel: {

		/** 
		  * salva o campo da inscrição via ajax
		  * @author Marco Malaquias
		  */
		salvarCampo: function() {
			$('#formulario-entregavel input, #formulario-entregavel select, #formulario-entregavel textarea').blur(function(){
				var valor = null;
				var $this = $(this);

				if ( $this.attr('id') == 'drpEntregas' || this.type == 'submit'  || this.type == 'file') {
					return;
				}

				if ( this.type == 'checkbox' ) {
					valor = this.checked ? '1' : '0';
				} else {
					valor = this.value;
				}

				var data = {
					'id': $this.data('campo'),
					'valor': valor,
					'negocio': $this.attr('id') == 'negocio' ? 'negocio' : '',
					'entrega': $('#id-entrega').val(),					
				};
				$this.removeClass('erro');
				$this.attr('title', '');

				if ( $this.tooltip( "instance" ) != undefined ) {
					$this.tooltip('destroy');
				}

				if ( valor != null ) {
					$.post(base_path + '/entregavel/salvar-campo', data, function(json){
						if ( ! json.sucesso ) {
							$this.addClass('erro');
							$this.attr('title', json.mensagem);
							$this.tooltip({
								'content': json.mensagem
							});
							$this.attr('title', '');
						}
					});
				}
			});

			$('input[type=file]').fileupload({
				url: base_path + '/cadastro/uploadArquivo',
				dataType: 'json',
				autoUpload: true,
				maxFileSize: 5000000,
				disableImageResize: /Android(?!.*Chrome)|Opera/.test(window.navigator.userAgent),
				previewCrop: false,
				add: function(e, data){

					var uploadErrors = [];
					var $this = $(this);
					
					if(data.originalFiles[0]['size'] > 100000000) {
						uploadErrors.push('Arquivo muito grande!');
					}

					$this.removeClass('erro');

					data.id = $this.data('campo');
					data.valor = '';
					data.negocio = '';	
					data.arquivo = '1';
					data.entrega = $('#id-entrega').val();
					$(this).siblings('.uploadprogresso').show();

					if(uploadErrors.length > 0) {
						alert(uploadErrors.join("\n"));
					} else {
						data.submit();
					}
				},
				done: function (e, data) {
					var $this = $(this);
					$(this).siblings('.arquivo-enviado').html( '' );

					if ( ! data.result.sucesso ) {
						$this.addClass('erro');
						$(this).siblings('.arquivo-enviado').text(data.result.mensagem).css('color', 'red');
					} else {
						$this.removeClass('erro');
						
						$(this).siblings('.arquivo-enviado').html('<a href="' + data.result.arquivo + '" target="_blank">' + data.result.mensagem + '</a>');
					}

					$.each(data.files, function (index, file) {
						var arquivo = '<a target="_blank" href="'+base_path+'/'+file.url+'">'+file.name+'</a> ',
							figura = '<img src="'+base_path+'/'+file.url+'" alt="'+file.name+'" width="250px" />';

						$(this).siblings('.arquivo-enviado').html( arquivo );
					});
				},
				progressall: function (e, data) {
					var progress = parseInt(data.loaded / data.total * 100, 10);
					$(this).siblings('.uploadprogresso').find('.barra').width(progress + "%").find('span').text(progress + "%");
				}
			});			
		},
	}


}

Number.prototype.formatMoney = function(c, d, t){
	var n = this,
		c = isNaN(c = Math.abs(c)) ? 2 : c,
		d = d == undefined ? "." : d,
		t = t == undefined ? "," : t,
		s = n < 0 ? "-" : "",
		i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
		j = (j = i.length) > 3 ? j % 3 : 0;
		return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};