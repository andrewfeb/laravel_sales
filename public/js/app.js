function sweetAlert(status, message){
	Swal.fire({
		icon: status,
		title: 'Informasi',
		text: message,
		showConfirmButton: false,
		timer: 2000
	});
}

function confirmDelete() {
  	$('a[data-confirm]').on('click', function (e) {
		e.preventDefault();
        Swal.fire({
			title: 'Peringatan',
			text: $(this).data('confirm'),
			icon: 'warning',
			showLoaderOnConfirm: true,
			preConfirm: function () {
				return new Promise(function (resolve) {
					setTimeout(function () {
						resolve();
					}, 500)
				})
			},
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya',
			cancelButtonText: 'Tidak'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					type: 'DELETE',
					url: $(this).attr('href'),
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					dataType: 'JSON',
					success: function (data) {
						//show alert
						sweetAlert(data.status, data.message);
						//reload datatable
						table.ajax.reload();
					}
				});
			}    
		});
	});
}