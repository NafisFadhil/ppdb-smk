$(function () {
	
	// Navbar Responsive
	var toggler = $('#navbarToggler');
	var menu = $('#navbarResponsiveMenu');
	toggler.click((v) => {
		v.preventDefault();
		menu.toggle('hidden')
	});

	// Formulir Card
	$('.card').map((i, elem) => {
		var children = elem.children;
		var header = $(children[0]);
		var body = $(children[1]);
		
		header.find('button').map((i, btn) => {
			var toggle = $(btn).data('toggle');
			
			if (toggle === 'min') {
				$(btn).click(v => {
					v.preventDefault();
					body.toggle('hidden');
				})
			}
			
		})
		
	})
	
})