
var admin = {

	/**
	 * conteúdo
	 * 
	 * @author Marco Malaquias
	 */
	conteudo: {

		/**
		 * formulário para edição de conteúdo
		 */
		editarFormulario: function() {
			$('select[name=tipo]').change(function(campo){
				if ( this.value == 1 ) { // video
					$('.box-videos').show();
				} else {
					$('.box-videos').hide();
					$('.box-videos input').val('');
				}
			}).trigger('change');
		},

		/**
		 * anexa um conteudo
		 */
		anexarConteudo: function() {
			$('#box-anexos .box-anexo button').click(function(){
				var titulo = $('#anexo_titulo').val()
				var link = $('#anexo_link').val();
				var tipo = $('#anexo_tipo').val();

				if ( titulo == '' || link == '' || tipo == '' ) {
					alert('É necessário informar o título, tipo e o link');
					return;
				}
				var html = ' ' +
							'<tr>' +
								'<td>' +
									'<input type="hidden" value="' + titulo + '" name="anexos_titulo[]">' +
									'<input type="hidden" value="' + link + '" name="anexos_link[]">' +
									'<input type="hidden" value="' + tipo + '" name="anexos_tipo[]">' +
									'<a href="' + link + '" target="_blank">' + titulo + ' - ' +   $("#anexo_tipo option:selected").text() + '</a>' +
								'</td>' +
								'<td>' +
									'<a title="deletar" class="icon24 item-del">deletar</a>' +
								'</td>' +
							'</tr>';
				$('#box-anexos .anexos table tbody').append(html);
				$('#anexo_titulo').val('');
				$('#anexo_link').val('');
				admin.conteudo.removerAnexos();
			});

			admin.conteudo.removerAnexos();
		},

		/**
		 * remove anexos
		 */
		removerAnexos: function () {
			$('#box-anexos .anexos table tbody tr td a.item-del').click(function(){
				$(this).parent('td').parent('tr').remove();
			});
		}
	},

	/**
	 * Alert para confirmar reinício de curso
	 */
	confirmarReinicioDeCurso: function() {
		$('a.delete_confirmation').click(function() {
			return confirm('ATENÇÃO: Todos os registros associados a este item serão excluídos definitivamente do sistema. Você deseja realmente excluir este registro?') ? true : false;
		});
	},

	/**
	 * aparece alert para confirmar exclusão
	 */
	confirmarExclusao: function() {
		$('a.reinicio_curso_confirmation').click(function() {
			return confirm('ATENÇÃO: Esta opção irá reiniciar este curso. Será realizada uma cópia do curso atual e a criação de um novo curso com a mesma estrutura, porém sem os dados de entrega. Deseja realmente REINICIAR este curso?') ? true : false;
		});
	},
	exibirRespostas: function(){
		$('.exibir-resposta').on('click', function(){
			item = $(arguments[0].currentTarget)[0];
			$id = $(item).data('discussao');
			url = $(item).data('url');
			self = this;
			
			$.ajax({
				url: url,
				type: 'GET',
				success: function(resposta){
					console.log('teste');
					$resposta = $('#resposta-'+$id); 
					$('.respostas').hide(function(){
						$($resposta).show();
					});
					$($resposta).html(resposta);
				}
			});
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
			return admin.tags.split( term ).pop();
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
					response( $.ui.autocomplete.filter( availableTags, admin.tags.extractLast( request.term ) ) );
				},
				focus: function() {
					// prevent value inserted on focus
					return false;
				},
				select: function( event, ui ) {
					var terms = admin.tags.split( this.value );
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
					if ( term in admin.tags.cache ) {
						response( admin.tags.cache[ term ] );
						return;
					}
					$.getJSON( source, request, function( data, status, xhr ) {
						admin.tags.cache[ term ] = data;
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
						$('#conteudosAtividade .conteudos > table > tbody').append(html);
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

	/**
	 * Carrega código para as paginas de grupos de acesso
	 * 
	 * @author William Ochetski Hellas
	 */
	eventosGruposAcesso: function()
	{
		// select de filtro
		$('.select_filtro').on('change', function() {
			if (typeof window.filtros == 'object') {
				var selecionado = window.filtros[$(this).val()];
				$(this).parents('fieldset')
					.find('*[class*="filtro_"]')
					.hide();
				$(this).parents('fieldset')
					.find(selecionado)
					.show();
			}
		});
		// select estado
		$('.select_cidade_estado').on('change', function() {
			admin.buscaCidadesPorEstado(this);
		});
	},

	/**
	 * Mostra cidades pelo estado selecionado
	 * 
	 * @author William Ochetski Hellas
	 */
	buscaCidadesPorEstado: function(element)
	{
		window.$grupos_cidade = $(element).parents('fieldset').find('.select_cidade').first();
		var url = window.location.href,
			id_estado = $(element).val();
		$grupos_cidade.html('').show();
		if (id_estado > 0) {
			$.ajax({
				url: base_path+'/usuario/carregar-cidades',
				data: {
					'estado': id_estado
				},
				dataType: 'json',
				type: 'GET',
				success:function(json){
					if (typeof json.cidades != "undefined") {
						for (var x in json.cidades) {
							$grupos_cidade.append( $('<option>').val(x).text(json.cidades[x]) );
						}
					}
				}
			});
		}
	}

};