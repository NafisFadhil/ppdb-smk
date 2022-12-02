$(function () {
	
	// Navbar Responsive
	var toggler = $('#navbarToggler');
	var menu = $('#navbarMenu');
	toggler.click((v) => {
		v.preventDefault();
		menu.toggle('hidden');
	});

	// Navbar Dropdown
	var toggler = $('.navbar-dropdown-toggler');
	toggler.click(v => {
		v.preventDefault();
		var menu = toggler.parent().children()[1];
		$(menu).toggle('hidden');
	})
	
})