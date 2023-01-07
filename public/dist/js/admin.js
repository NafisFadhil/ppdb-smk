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
		elem.submit(v => {
			let tagihanInput = 0+elem.find('input[name=tagihan_'+type+']').val()
				.replace('Rp','').replace(',','').replace('.','');
			let bayarInput = elem.find('input[name=bayar]').val();
			if (parseInt(bayarInput) > (parseInt(tagihanInput) / 100)) {
				return confirm('Nominal bayar melebihi tagihan, lanjut??');
			}
		})
	});

	// $("input").on("change load", function() {
	// 	this.setAttribute(
	// 		"data-date",
	// 		moment(this.value, "YYYY-MM-DD")
	// 		.format( this.getAttribute("data-date-format") )
	// 	)
	// }).trigger("change")

	$('input[type=singledate]').each(function (i,elem) {
		elem = $(elem);
		let value = elem.val(), opt = [];
		// Don't know but bellow linked to elem.val() -_-
		value = value.split('/').reverse().join('-');

		if (value) {
			opt = {
				startDate: value,
				endDate: value,
			}
		}

		elem.daterangepicker({
			...opt,
			autoUpdateInput: true,
			singleDatePicker: true,
			autoApply: true,
			locale: {
				format: 'YYYY-MM-DD',
			}
		});
	});


	$('input[daterangepicker]').each(function (i, elem) {
		elem = $(elem);
		let value = elem.val(), opt = [];
		let parsedValue = value.split(' - ') || [];
		console.log(value);
		console.log(parsedValue);

		if (parsedValue.length > 1) {
			opt = {
				startDate: parsedValue[0] || '',
				endDate: parsedValue[1] || '',
			}
		}

		$(elem).daterangepicker({
			...opt,
			locale: {
				format: 'YYYY-MM-DD',
				separator: ' - '
			}
		});
	})
})