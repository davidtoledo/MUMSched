
var admin = {

	/**
	 * conteúdo
	 * @author Marco Malaquias
	 */
	conteudo: {

		/**
		 * formulário para edição de conteúdo
		 */
		editarFormulario: function() {
			$('select[name=tipo]').change(function(campo){
				if ( this.value == 1 ) { //video
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
	 * aparece alert para confirmar exclusão
	 */
	confirmarExclusao: function() {
		$('a.delete_confirmation').click(function() {
			return confirm('Você deseja realmente excluir esse registro') ? true : false;
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
	simularSanfona: function() {
		$("form")
		.find("dd")
		.end()
		.find("dt").each(function() {
			$(this).css("cursor","pointer").on("click",function() {
				$(this).next("dd").slideToggle();
			});
		});
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
	}
};
