$(function () {
	let inputs = document.getElementsByClassName('input-uppercase');
	for (let input of inputs) {
		input.onkeyup = function () {
			input.value = input.value.toUpperCase();
		}
	}
	$('#xtable, table.datatable').DataTable({
		"paging": false,
		// "pageLength": 10,
		"lengthChange": false,
		"searching": false,
		"ordering": true,
		"info": false,
		"autoWidth": false,
		"responsive": false,
		"fixedHeader": false,
	});
	$('.select2').select2();

	// Alert When More Cash
	$('form[data-form-lebih]').map((i, elem) => {
		elem = $(elem);
		let type = elem.data('form-lebih');
		elem.submit((v) => {
			let tagihanInput = elem.find('input[name=tagihan_'+type+']').val().replace('Rp','').replace(',','');
			let bayarInput = elem.find('input[name=bayar]').val();
			if (parseInt(bayarInput) > (parseInt(tagihanInput) / 100)) {
				return confirm('Nominal bayar melebihi tagihan, lanjut??');
			}
		})
	});




	$('input[daterangepicker]').daterangepicker();
	// $('input[daterangepicker]').map((i,elem) => {
	// 	elem = $(elem);
	// 	if (!elem.val()) {
	// 		elem.attr('placeholder')
	// 	}
	// });
})