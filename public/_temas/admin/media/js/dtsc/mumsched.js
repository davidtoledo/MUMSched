	// Inicializando multiselects
	$('.multiple-selected').multiselect({
		numberDisplayed: 1,
        buttonWidth: '200px',
        nonSelectedText: 'Nenhum selecionado',
        allSelectedText: 'Todos selecionados',
        nSelectedText: 'selecionados'
    });		

	// Inicizlizando multiselects
	$('.multiple-selected-big').multiselect({
		numberDisplayed: 1,
        buttonWidth: '300px',
        nonSelectedText: 'Nenhum selecionado',
        allSelectedText: 'Todos selecionados',
        nSelectedText: 'selecionados'
    });
    
    // Inicializando datepickers
    $('input[name*="dt_"]').datepicker();
    
	// Deleta itens
	function deletar (action) {
		
		if ( confirm ("Are you sure you want do delete this record?") ) {
			// Submetendo
			$("#frm").attr("action", action);
			$("#frm").submit();			
		}
	}
	
	function orderBy(ordem) {
		$("#ordem").val (ordem);
		$("#frm").submit();
	}

	function checkAll (obj) {

		if (obj.checked) {
			$(".chkSelecionado").prop("checked", true);
		} else {
			$(".chkSelecionado").prop("checked", false);
		}
	}
		
	function orderBy(ordem) {
		$("#ordem").val (ordem);
		$("#frm").submit();
	}
	
	function validaEmail (email) {
		var expr = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;	
		if(email.search(expr) == -1) {
			return false;
		}
		return true;
	}
	

var admin = {

	/**
	 * aparece alert para confirmar exclusão
	 */
	confirmarExclusao: function() {
		$('a.delete_confirmation').click(function() {
			return confirm('ATENÇÃO: Todos os registros associados a este item poderão ser excluídos definitivamente do sistema. Você deseja realmente excluir este registro?') ? true : false;
		});
	}
};