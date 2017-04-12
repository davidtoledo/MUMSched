[
	'{{repeat(45, 77)}}',
	{
		nome: '{{firstName}}',
		local: '{{city}}, {{state}}',
		descricao: '{{lorem(1,paragraphs)}}',
		imagem_thumb: function(idx) {
			var choices2 = ['http://placehold.it/224x224', 'http://placehold.it/452x452', 'http://placehold.it/224x452', 'http://placehold.it/452x224'];
			return choices2[this.numeric(0, choices2.length - 1)];
		},
		imagem: 'http://placehold.it/767x382',
		categorias: [ 'acessivel', 'aventura', 'cultura', 'ecoturismo', 'estudos', 'idosos' ],
		social: {
			usuario_nome: '{{firstName}}',
			usuario_url: "http://instagram.com/mateus_moura",
			social_nome: "Instagram",
			social_url: "http://instagram.com/p/bcXSwDudF7/"
		}
	}
]