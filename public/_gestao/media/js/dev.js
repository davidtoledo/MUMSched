$(window).load(function() {
	
	dev.removeFavorito();
	dev.alteraFavorito();
	dev.carregarCidades();
	// dev.exibirFormacaoAcademica();
	dev.passo2();
});

var dev = {

	removeFavorito: function() 
	{
		$('.deletar-item').on('click',removeFavoritoCallback);
		
		function removeFavoritoCallback(e) {
			
			item = $(e.currentTarget)[0];
			$favoritoId = $(item).data('favorito-id');
			tipo =  $(item).data('favorito-tipo');
			redirect = $(item).data('redfav');
			
			if (typeof $favoritoId == "undefined"){
				$favoritoId = $(item).find('button').data('favorito-id');
				redirect = $(item).find('button').data('redfav');
				tipo =  $(item).find('button').data('favorito-tipo');
			}
			
			url = window.location.href;
			base_url = url.substr(0,url.indexOf('plataforma')) + 'plataforma/favorito/favoritar';
			
			$.ajax({
				url: base_url,
				data: {'id': $favoritoId, 'tipo': tipo},
				dataType: 'json',
				type: 'POST',
				success: function(response)
				{
					if (response.sucesso == true) {
						$(item).parents('li').remove();
						totalFavoritos = document.getElementById('totalFavoritos').innerHTML;
						totalFavoritos--;
						document.getElementById('totalFavoritos').innerHTML = totalFavoritos;
					}
				}
			});
			
		}
	},
	alteraFavorito: function() 
	{
		$('.alterar-favoritar').on('click',alteraFavoritoCallback);
		
		function alteraFavoritoCallback(e) {
			url = window.location.href;
			item = $(e.currentTarget)[0];
			$favoritoId = $(item).data('id');
			
			redirect = $(item).data('redfav');
			tipo =  $(item).data('favorito-tipo');

			$.ajax({
				url: base_path+'/favorito/favoritar',
				data: {'id': $favoritoId, 'tipo': tipo},
				dataType: 'json',
				type: 'POST',
				success: function(response)
				{
					if (response.sucesso == true) {
						if (response.favorito == true) {
							if ( $(item).find('.icon').hasClass("icon-favoritarx2-desabilitado") )
								$(item).find('.icon').addClass('icon-favoritarx2').removeClass('icon-favoritarx2-desabilitado');
							
							if ( $(item).find('.icon').hasClass("icon-favoritar-desabilitado") )
								$(item).find('.icon').addClass('icon-favoritar').removeClass('icon-favoritar-desabilitado');
						} else {
							if ( $(item).find('.icon').hasClass("icon-favoritarx2") )
								$(item).find('.icon').addClass('icon-favoritarx2-desabilitado').removeClass('icon-favoritarx2');
							
							if ( $(item).find('.icon').hasClass("icon-favoritar") )
								$(item).find('.icon').addClass('icon-favoritar-desabilitado').removeClass('icon-favoritar');
						}
						$(item).find('#fav-icon').hasClass('ativo') ? $(item).find('#fav-icon').removeClass('ativo') : $(item).find('#fav-icon').addClass('ativo');
						$(item).hasClass('ativo') ? $(item).removeClass('ativo') : $(item).addClass('ativo');
					}
				}
			});
			
		}	
		
	},
	denunciar: function()
	{
		$('.denunciar').on('click', function(){
			item = $(arguments[0].currentTarget)[0];
			$id = $(item).data('id');
			$.ajax({
				url: $(item).data('url'),
				data: {'codigo': $id},
				dataType: 'json',
				type: 'POST',
				success: function(json){
					console.log(json.sucesso);
					if (json.denunciado == true)
						$(item).html('[remover denúncia]');
					else
						$(item).html('[denunciar]');
				}
			});
			
			
		});
	},
	idDestinatario: function()
	{
		$('.mensagemDestinatario').on('click', function() {
			item = $(arguments[0].currentTarget)[0];
			$id = $(item).data('mensagem-id');
			
			$("form#enviarMensagem [name='destinatario']").remove();
			$("form#enviarMensagem").append( $('<input id="idDestino" name="destinatario" type="hidden" value="'+$id+'">') ) ;

			
			textoMensagem = '#mensagens-'+$id;
			$(textoMensagem).scrollTop($(textoMensagem)[0].scrollHeight);
			
			$.ajax({
				url: base_path+'/usuario/mensagem/ler',
				data: {'id': $id},
				dataType: 'json',
				type: 'POST',
				success: function(json)
				{
					if (json.sucesso == true){
						$(item).find(".contador").remove();
					}
				}
			});
		});
	},
	enviarMensagem: function() 
	{
		$('form#enviarMensagem').submit(function() {
			item = $(arguments[0].currentTarget)[0];
			mensagem = $(item).find("[name='mensagem']").val();
			destinatario = $(item).find("[name='destinatario']").val();
			
			textoMensagem = '#mensagens-'+destinatario;
			$(textoMensagem).scrollTop($(textoMensagem)[0].scrollHeight);
			
			$.ajax({
				url: base_path+'/usuario/mensagem/enviar',
				data: {'usuario': destinatario, 'mensagem': mensagem},
				dataType: 'json',
				type: 'POST',
				success: function(json)
				{
					if (json.sucesso == true){
						var $today = new Date();
						
						var $dia = $today.getDay();
						switch($dia){
							case 0: $dia = "Domingo";break;
							case 1: $dia = "Segunda-feira";break;
							case 2: $dia = "Terça-feira";break;
							case 3: $dia = "Quarta-feira";break;
							case 4: $dia = "Quinta-feira";break;
							case 5: $dia = "Sexta-feira";break;
							case 6: $dia = "Sábado";break;
						}
						var $mes = $today.getMonth();
						switch($mes){
							case 0: $mes = "Janeiro";break;
							case 1: $mes = "Fevereiro";break;
							case 2: $mes = "Março";break;
							case 3: $mes = "Abril";break;
							case 4: $mes = "Maio";break;
							case 5: $mes = "Junho";break;
							case 6: $mes = "Julho";break;
							case 7: $mes = "Agosto";break;
							case 8: $mes = "Setembro";break;
							case 9: $mes = "Outubro";break;
							case 10: $mes = "Novembro";break;
							case 11: $mes = "Dezembro";break;
						}
						
						var $data = $dia+", dia "+$today.getDate()+" de "+$mes+" de "+$today.getFullYear()+", "+$today.getHours()+":"+$today.getMinutes();
						$mensagem = $('#mensagens-'+destinatario);
						$('.comentario-texto').val("");
						$($mensagem).append( $('<span class="data">'+$data+'</span>') );
						$($mensagem).append( $('<span class="eu">'+mensagem+'<span class="perninha"></span></span>') );

						$(".mensagens-recebidas").animate({ scrollTop: 60000 }, "slow");

					}else
						alert(json.mensagem);
				}
			});
		});
	},
	votar: function()
	{
		$('.voto-indicacao').on('click', function(){
			item = $(arguments[0].currentTarget)[0];
			$id = $(item).data('indicacao');

			if ($(this).hasClass('voto-up'))
				$voto = 1;
			else $voto = -1;
			
			self = this;
			
			$.ajax({
				url: base_path+'/area-conhecimento/indicar-material/votar',
				data: {'tipo': 1, 'codigo':$id, 'voto':$voto},
				dataType: 'json',
				type: 'POST',
				success:function(json){
					$valor = parseInt($(self).parent().children('span').text());
					$valor = $valor + ($voto > 0 ? 1 : ($voto < 0 ? -1 : 0));
					$(self).parent().children('span').text($valor);
					if (json.up == true)
						$(self).parent().find('.voto-up').css('display', 'block');
					if (json.up == false)
						$(self).parent().find('.voto-up').css('display', 'none');
					if (json.down == true)
						$(self).parent().find('.voto-down').css('display', 'block');
					if (json.down == false)
						$(self).parent().find('.voto-down').css('display', 'none');
				}
			});
		});
		$('.voto-pergunta').on('click', function(){
			item = $(arguments[0].currentTarget)[0];
			$id = $(item).data('pergunta');

			if ($(this).hasClass('voto-up'))
				$voto = 1;
			else $voto = -1;
			
			self = this;
			
			$.ajax({
				url: base_path+'/discussoes/perguntas-respostas/votar',
				data: {'tipo': 1, 'codigo':$id, 'voto':$voto},
				dataType: 'json',
				type: 'POST',
				success:function(json){
					$valor = parseInt($("#voto-pergunta").text());
					$valor = $valor + ($voto);
					$("#voto-pergunta").text($valor);
					if (json.up == true)
						$(self).parent().find('.voto-up').css('display', 'block');
					if (json.up == false)
						$(self).parent().find('.voto-up').css('display', 'none');
					if (json.down == true)
						$(self).parent().find('.voto-down').css('display', 'block');
					if (json.down == false)
						$(self).parent().find('.voto-down').css('display', 'none');
				}
			});
		});
		$('.voto-resposta').on('click', function(){
			item = $(arguments[0].currentTarget)[0];
			$id = $(item).data('resposta');

			if ($(this).hasClass('voto-up'))
				$voto = 1;
			else $voto = -1;
			
			self = this;
			
			$.ajax({
				url: base_path+'/discussoes/perguntas-respostas/votar',
				data: {'tipo': 2, 'codigo':$id, 'voto':$voto},
				dataType: 'json',
				type: 'POST',
				success:function(json){
					$valor = parseInt( $(self).parent().children('span').text() );
					$valor = $valor + ($voto);
					$(self).parent().children('span').text($valor);
					if (json.up == true)
						$(self).parent().find('.voto-up').css('display', 'block');
					if (json.up == false)
						$(self).parent().find('.voto-up').css('display', 'none');
					if (json.down == true)
						$(self).parent().find('.voto-down').css('display', 'block');
					if (json.down == false)
						$(self).parent().find('.voto-down').css('display', 'none');
				}
			});
		});		
	},
	visualizarMarcador: function(){
		$('.visualizado').on('click', function(){
			item = $(arguments[0].currentTarget)[0];
			$id = $(item).data('indicacao');
			objeto = '#marca-'+$id;
			$(objeto).addClass('ativo');

			
			$.ajax({
				url: base_path+'/visualizar-indicacao',
				data: {'codigo': $id},
				dataType: 'json',
				type: 'POST',
			});
		});
	},
	carregarCidades: function()
	{
		$('#cadastro-estado, #buscaUf').on('change', function(){
			url = window.location.href;

			if ($("#cadastro-cidade").size() > 0){
				id_estado = $('#cadastro-estado').val();
				$("#cadastro-cidade").html("");
				$("#cadastro-cidade").append( $('<option>').val('').text('Cidades') );
			}else if ($("#buscaCidade").size() > 0){
				id_estado = $('#buscaUf').val();
				$("#buscaCidade").html("");
				$("#buscaCidade").append( $('<option>').val('').text('Cidades') );
			}
			
			if (id_estado > 0){
				$.ajax({
					url: base_path+'/usuario/carregar-cidades',
					data: {'estado': id_estado},
					dataType: 'json',
					type: 'GET',
					success:function(json){
						if (typeof json.cidades != "undefined"){
							for(x in json.cidades ){
								if ($("#cadastro-cidade").size() > 0){
									$("#cadastro-cidade").append( $('<option>').val(x).text(json.cidades[x]) );
								}else{
									$("#buscaCidade").append( $('<option>').val(x).text(json.cidades[x]) );
								}
							}
						} 
						
					}
				});
			}
						
		});		
	},
	exibirFormacaoAcademica: function()
	{
		
		// verifica se o campo existe.
		if ( $('#cadastro-escolaridade').length && $('#cadastro-formacao').length )
		{
			// faz no start
			exibeOcultaFormacao();
			
			// deixa o bind no select
			$('#cadastro-escolaridade').on('change',exibeOcultaFormacao);
		}
		
		/**
		 * exibe oculta valor de acordo com o text do option
		 */
		function exibeOcultaFormacao() {
			
			if ( $('#cadastro-escolaridade option:selected').text() != 'Grau de escolaridade' && $('#cadastro-escolaridade option:selected').text() != 'ensino fundamental' && $('#cadastro-escolaridade option:selected').text() != 'ensino médio'  ) 
			{
				$('#cadastro-formacao').parent(".linha").show();
			}
			else
			{
				$('#cadastro-formacao').val("").parent(".linha").hide();
			}
			
		}
		
	},
	passo2: function()
	{
		/**
		 * Campo, já recebeu investimento externo
		 */
		if ( $('#operacional-investimento').length )
		{
	
			if ( $('#operacional-investimento').is(':checked') )
			{
				if ( $('.investimento-externo').hasClass('invisivel') )
				{
					$('.investimento-externo').removeClass('invisivel');
				}
				
				if ( ! $('label[for=operacional-investimento]').hasClass('ativo') )
				{
					$('label[for=operacional-investimento]').addClass('ativo');
				}
			} else {
				if ( $('label[for=operacional-investimento]').hasClass('ativo') )
				{
					$('label[for=operacional-investimento]').removeClass('ativo');
				}
			}
			
			$('#operacional-investimento').on('change', function(){
				if ( $('#operacional-investimento:checked').val() != 1 ) {
					$('.investimento-externo').find('input').each(function(e){
						
						if ( $(this).attr('type') == 'text')
						{
							$(this).val('');
						}
						else if ( $(this).attr('type') == 'checkbox')
						{
							$(this).attr('checked', false);
							$('label[for='+$(this).attr('id')+']').removeClass('ativo');
						}
						
					})
				}
					
			});
			
		}
		// FIM CAMPO INVESTIMENTO EXTERNO
	
	},
	passo4: function(){
		var _input = $('#teste');
		var loading = $('#loading');

		$('#negocio-negocio, #negocio-adicional').blur(function(){
			var $mensagem = $('#formulario-negocio .mensagem-ajax');
			$mensagem.hide();
			var data = {
				'projeto_id': $('#projeto_id').val(),
				'pitch': $('#negocio-negocio').val(),
				'descricao': $('#negocio-adicional').val(),
			};
			$.post(base_path + '/projeto/passo/salvar-informacoes-passo4', data, function(json) {
				if ( json.error ) {
					$mensagem.show().html(json.messages).css('color', 'red');
				} else {
					$mensagem.show().html(json.messages).css('color', 'green');
				}
			});
		});

		_input.fileupload({
			url: base_path+'/projeto/arquivo-passo4',
			dataType: 'json',
			autoUpload: true,
			maxFileSize: 5000000,
			acceptFileTypes: /(\.|\/)(pdf|doc?x|ppt?x)$/i,
			disableImageResize: /Android(?!.*Chrome)|Opera/
				.test(window.navigator.userAgent),
			previewCrop: false,
			add: function(e, data){
				var uploadErrors = [],
					verificar = new RegExp(/(\.|\/)(pdf|doc?x|ppt?x)$/i);

				loading.fadeIn();
				data.projeto_id = $('#projeto_id');

				if(data.originalFiles[0]['size'] > 100000000) {
					uploadErrors.push('Arquivo muito grande!');
				} else if( !verificar.test(data.files[0].name) ){
					uploadErrors.push('O arquivo pode conter somente a extensões: PDF, DOC ou PPT');
				}


				if(uploadErrors.length > 0) {
					alert(uploadErrors.join("\n"));
					loading.fadeOut();
				} else {
					data.submit();
				}
			},
			done: function (e, data) {
				$.each(data.result.files, function (index, file) {
					var arquivo = '<a target="_blank" href="'+base_path+'/'+file.url+'">'+file.name+'</a> ',
						figura = '<img src="'+base_path+'/'+file.url+'" alt="'+file.name+'" width="250px" />';

					$('#arquivo_enviado').html( arquivo );

					$('#uploadprogresso p').text('Carregado com sucesso!');
					
					$('figcaption', $(e.target).parent()).hide();
				});
			},
			progressall: function (e, data) {
				var progress = parseInt(data.loaded / data.total * 100, 10);

				$('#uploadprogresso').width(progress + "%").find('p').text(progress + "%");

				progress < 100
					? loading.fadeIn()
					: loading.fadeOut();
			}
		});
	},

	/**
	 * tags
	 */
	tags: {

		/**
		 * split
		 */
		split: function ( val ) {
			return val.split( /,\s*/ );
		},

		/**
		 * extract
		 */
		extractLast: function ( term ) {
			return dev.tags.split( term ).pop();
		},

		/**
		 * trigger
		 */
		triggerTags: function(target, availableTags) {
			$( target ).bind( "keydown", function( event ) {
				if ( event.keyCode === $.ui.keyCode.TAB && $( this ).data( "ui-autocomplete" ).menu.active ) {
					event.preventDefault();
				}
			}).autocomplete({
				minLength: 0,
				source: function( request, response ) {
					// delegate back to autocomplete, but extract the last term
					response( $.ui.autocomplete.filter( availableTags, dev.tags.extractLast( request.term ) ) );
				},
				focus: function() {
					// prevent value inserted on focus
					return false;
				},
				select: function( event, ui ) {
					var terms = dev.tags.split( this.value );
					// remove the current input
					terms.pop();
					// add the selected item
					terms.push( ui.item.value );
					// add placeholder to get the comma-and-space at the end
					terms.push( "" );
					this.value = terms.join( ", " );
					return false;
				}
			});
		},

		/**
		 * trigger para um endereço
		 */
		cache: new Array(),
		triggerTagsSource: function(target, source, minLength, functionToCall) {
			$( target ).autocomplete({
				source: function(request, response) {
					var term = request.term;
					if ( term in dev.tags.cache ) {
						response( dev.tags.cache[ term ] );
						return;
					}
					$.getJSON( source, request, function( data, status, xhr ) {
						dev.tags.cache[ term ] = data;
						response( data );
					});
				},
				minLength: minLength,
				select: function( event, ui ) {
					if ( ui.item ) {
						var html = '<tr>' +
										'<td><a class="icon24 item-up-down" title="deletar"></a></td>' +
										'<td>' +
											'<input type="hidden" name="conteudoAtividade[]" value="' + ui.item.id + '" />' + ui.item.label +
										'</td>' +
										'<td>' +
											'<a class="icon24 item-del" title="deletar">deletar</a>' +
										'</td>' +
									'</tr>';
						$('#conteudosAtividade .conteudos > table > tbody').v(html);
						functionToCall.call();
					}
				}
			}).blur(function(){
				this.value = '';
			});
		},

		/**
		 * exclui tag
		 */
		excluirTag: function(target) {
			$(target).click(function(){
				$(this).parent('td').parent('tr').remove()
			});
		}
	},
	removerImagem: function(){
		$('#remover-imagem').on('click', function(){
			$.ajax({
				url: base_path+'/usuario/remove-foto',
				dataType: 'json',
				type: 'POST',
				success: function(json){
					if (json.sucesso === true)
						$("#preview").attr('src', base_path+'/_plataforma/media/img/fke/avatar.png');
						console.log(json.sucesso);
				}
			});
		});
	},
	
	limitarCaracteres: function(){
	    $(".maxlength").keyup(function(event){
 
	        // pega a span onde esta a quantidade máxima de caracteres.
	        var id = $(this).attr('id');
	        var target    = $("#content-countdown-"+id);
	 
	        // pego pelo atributo title a quantidade maxima permitida.
	        var max        = target.attr('title');
	 
	        // tamanho da string dentro da textarea.
	        var len     = $(this).val().length;
	 
	        // quantidade de caracteres restantes dentro da textarea.
	        var remain    = max - len;
	 
	        // caso a quantidade dentro da textarea seja maior que
	        // a quantidade maxima.
	        if(len > max)
	        {
	            // abaixo vamos pegar tudo que tiver na string e limitar
	            // a quantidade de caracteres para o máximo setado.
	            // isso significa que qualquer coisa que seja maior que
	            // o máximo será cortado.
	            var val = $(this).val();
	            $(this).val(val.substr(0, max));
	 
	            // setamos o restante para 0.
	            remain = 0;
	        }
	 
	        // atualizamos a quantidade de caracteres restantes.
	        target.html(remain);
	    });
	},
};