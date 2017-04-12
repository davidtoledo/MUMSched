   // DTSC ENGENHARIA DE SISTEMAS PROGRESS BAR

	var demoColorArray = ['red','blue','green','yellow','purple','gray'];
	var newPerc = 0;
	setSkin ( demoColorArray[2] );
		
	// Stripes interval
	var stripesAnim;
	
	$progress = $('.progress-bar');
	$percent = $('.percentage');
	$stripes = $('.progress-stripes');
	$stripes.text('////////////////////////');
	
	/* CHANGE LOADER SKIN */
	$('.skin').click(function(){
		var whichColor = $(this).attr('id');
		setSkin(whichColor);
	});
	
	function setProgressBar(percentage) {
		
		if (percentage <= newPerc) {
			return false;
		}
		
		newPerc = percentage;
		
		$progress.animate({
			width: newPerc + "%"
		}, 0, function() {
			$percent.text( newPerc + '%');
			
			if (newPerc >= 100) {
				clearInterval(stripesAnim);
			}			
		});
	}
	
	/* STRIPES ANIMATION */
	function stripesAnimate() {
		animating();
		stripesAnim = setInterval(animating, 2500);
	}

	function animating() {
		$stripes.animate({
			marginLeft: "-=30px"
		}, 2500, "linear").append('/');
	} 
	
	function setSkin(skin){
		$('.loader').attr('class', 'loader '+skin);
	}