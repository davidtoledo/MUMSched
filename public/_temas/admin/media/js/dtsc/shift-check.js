// Controle de Seleção de checkboxes via SHIFT
var lastChecked = null;

$(document).ready(function() {
	
    var $chkboxes = $('.chkSelecionado');
    $chkboxes.click(function(e) {
    	
        if(!lastChecked) {
            lastChecked = this;
            return;
        }

        if(e.shiftKey) {
            var start = $chkboxes.index(this);
            var end = $chkboxes.index(lastChecked);
            $chkboxes.slice(Math.min(start,end), Math.max(start,end)+ 1).prop('checked', lastChecked.checked);
        }

        lastChecked = this;
    });
});		
