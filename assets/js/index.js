$(document).ready(function(){


	$(".toggle").on('click', function(){
		$(this).parents('form').next('form.modifier').toggle();
	});
	
});



