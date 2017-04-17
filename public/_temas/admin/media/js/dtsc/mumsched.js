	// Tmp
	var tmpAction   = "";
	var tmpActionOK = "";

	// Initializing multiselects
	$('.multiple-selected').multiselect({
		numberDisplayed: 1,
        buttonWidth: '200px',
        nonSelectedText: 'None selected',
        allSelectedText: 'All selected',
        nSelectedText: 'selected'
    });		

	// Initializing multiselects
	$('.multiple-selected-big').multiselect({
		numberDisplayed: 1,
        buttonWidth: '300px',
        nonSelectedText: 'None selected',
        allSelectedText: 'All selected',
        nSelectedText: 'selected'
    });
    
    // Initializing datepickers
    $('input[name*="dt_"]').datepicker();
    
	// Delete items
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
	
	function scheduleConfiguration (action, actionOK) {
		
		// Setando TMPs
		tmpAction = action;
		tmpActionOK = actionOK;
		
		// Abrir Modal
		$('#modal-schedule-configuration').modal({
		    backdrop: 'static',
		});

	}
	
	// Generate Schedule Button Action
	function btnGenerateSchedule() {
		
		$("#btnGenerate").attr("disabled", "disabled");
		$("#btnGenerate").text("Running the process...");
		$("#modal-schedule-configuration").modal("hide");

		setTimeout(function(){ 
			beginGenerateSchedule (tmpAction, tmpActionOK); 
		}, 250);
				
		event.preventDefault();
	}
	
	// Generate Schedule Process
	function beginGenerateSchedule (action, actionOK) {
						
		// Open Modal
		$('#modal-generate-schedule').modal({
		    backdrop: 'static',
		    keyboard: false
		});
		
		// Progress bar control (simulating a busy server)
		stripesAnimate();
		setTimeout(function(){ setProgressBar (20); }, 1000);
		setTimeout(function(){ setProgressBar (50); }, 3000);
		setTimeout(function(){ setProgressBar (75); }, 5000);
		
		// Async Call
		setTimeout(function(){
			
			// Recuperar dados via ajax
			$.post ( action + "/" + $("#cbo-algorithm-type").val() + "/" + $("#cbo-order").val() )
				.done ( function (json) {

					if ( json['return'] > 0 ) {
						alert ( json['messages'][0] );
					}
					
					// Processo OK					
					setProgressBar (100);
					
					setTimeout(function(){ 
						window.location = actionOK;
					}, 3000);					
					
				})
				.fail ( function (error) {
					alert( "An error ocurred while trying to load data!");
				}
			);
			
		}, 7000);
	}