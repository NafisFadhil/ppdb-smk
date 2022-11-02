$(function () {
	"use strict";

	// Navbar Responsive
	$(function () {
		let toggler = $('#navbarToggler');
		let menu = $('#navbarResponsiveMenu');
		toggler.click((v) => {
			v.preventDefault();
			menu.toggle('hidden')
		});
	})

	// Formulir Card
	$('.card').map((i, elem) => {
		let children = elem.children;
		let header = $(children[0]);
		let body = $(children[1]);
		
		header.find('button').map((i, btn) => {
			let toggle = $(btn).data('toggle');
			
			if (toggle === 'min') {
				$(btn).click(v => {
					v.preventDefault();
					body.toggle('hidden');
				})
			}
			
		})
		
	})
	
})