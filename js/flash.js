(function($){
	$(document).ready(function(){
		
		$.jGrowl.defaults.position = 'center';
		
		$.jGrowl.defaults.closer = false;

		$.jGrowl.defaults.animateOpen = {
			width: 'show'
		};
		$.jGrowl.defaults.animateClose = {
			width: 'hide'
		};

	});

})(jQuery);