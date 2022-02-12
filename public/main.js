$(() => {
	setTimeout(() => {
		$('.alert').each(function(i) {
			$(this).fadeOut(150).remove();
		})
	}, 2500)
})

function handle_login(event) {
	let name = $('#name');
	let pass = $('#password');
	if(!name.val().trim() || !pass.val().trim()) {
		event.preventDefault();
		Swal.fire({
		 	icon: 'error',
		 	title: 'Error',
		 	text: 'Ingrese todos los datos',
		 	//showConfirmButton: false,
  			timer: 2000
		})
	} else {
		event.next();
	}
}

function handle_register(event) {
	let name = $('#name');
	let email = $('#email');
	let pass = $('#password');
	if(!name.val().trim() || !pass.val().trim() || !email.val().trim()) {
		event.preventDefault();
		Swal.fire({
		 	icon: 'error',
		 	title: 'Error',
		 	text: 'Ingrese todos los datos',
		 	//showConfirmButton: false,
  			timer: 2000
		})
	} else {
		event.next();
	}
}

function show_alert(type, title, message) {
	Swal.fire({
	 	icon: type,
	 	title: title,
	 	text: message,
		timer: 2000
	})
}

function new_product() {
	$('#product_modal').modal('show');
	$('#save_product_form')[0].reset();

}
function save_product() {
	let url = $('#id_product').val() ? '/products/'+$('#id_product').val() : '/products';
	let method = $('#id_product').val() ? 'PUT' : 'POST';
	$.ajax({
		url: url,
		type: method,
		data: $('#save_product_form').serialize(),
		success: (response) => {
			if(response.code != 200) {
				show_alert('error', 'Error', response.message);
			} else {
				let product = response.product;
				if($('#id_product').val()) {
					let procard = $('#prod_'+product.id);
					procard.children().children('h5').text(product.name);
					procard.children().children('p').text(`Precio: ${product.price} $`);
					procard.children().children('span').text(`IVA: ${product.iva} %`);
				} else {
					// Creacion
					let item = `<div class="col-md-2" id="prod_${product.id}">
	                    <div class="card text-center mb-2 p-3">
	                        <h5>${product.name}</h5>
	                        <p class="mb-0">Precio: ${product.price}$</p>
	                        <span class="mb-1" style="font-size: 11px;">IVA: ${product.iva} %</span>
	                        <!--button class="btn btn-info">Comprar</button-->
	                        <div class="row">
	                            <div class="col-6">
	                                <a href="javascript:delete_product(${product.id});"><i class="bi bi-trash" title="Borrar"></i></a>
	                            </div>
	                            <div class="col-6">
	                                <a href="javascript:edit_product(${product.id});"><i class="bi bi-pencil" title="Editar"></i></a>
	                            </div>
	                        </div>
	                    </div>
	                </div>`;
                	$('#non_product').remove();
                	$('#product_list').prepend(item);
				}
               	$('#save_product_form')[0].reset();
                $('#product_modal').modal('hide');
			}
		}
	})
}

function edit_product(id) {
	$.ajax({
		url: 'products/'+id,
		type: 'GET',
		success: (response) => {
			if(response.code != 200)
				show_alert('error', 'Error', response.message);
			else {
				let product = response.product;
				$('#save_product_form')[0].reset();
				$('#product_modal').modal('show');	
				$('#id_product').val(id);
				$('#product_name').val(product.name);
				$('#product_price').val(product.price);
				$('#iva').val(product.iva);
			}
		}
	})
}

function delete_product(id) {
	Swal.fire({
	  title: 'Desea borrar el producto?',
	  showDenyButton: true,
	  confirmButtonText: 'Si',
	  denyButtonText: `Cancelar`,
	  reverseButtons: true
	}).then((result) => {
	  /* Read more about isConfirmed, isDenied below */
	  if (result.isConfirmed) {
	  	$.ajax({
	  		url: '/products/'+id,
	  		type: 'DELETE',
	  		data: {'_token' : $('input[name=_token]').val()},
	  		success: (response) => {
	  			if(response.code != 200)
					show_alert('error', 'Error', response.message);
				else {
					$('#prod_'+id).remove();
					Swal.fire('Exito', 'Producto borrado', 'success');
				}
	  		}
	  	})
	  }
	})
}

function new_user() {
	$('#user_modal').modal('show');
}

function save_user() {
	if(!$('#user_name').val().trim() || !$('#email').val().trim() || !$('#password').val().trim() || $('#rol_id').val() == 0) {
		show_alert('error', 'Error', 'complete todos los datos');
	} else {
		$.ajax({
			url: 'user',
			type: 'POST',
			data: $('#save_user_form').serialize(),
			success: (response) => {
				if(response.code != 200) {
					show_alert('error', 'Error', response.message);
				} else {
					let user = response.user;
					$('#non_user').remove();
					$('#user_list').prepend(`<tr>
	                    <td>${user.name}</td>
	                    <td>${user.email}</td>
	                    <td>${user.rol == 1 ? 'Cliente' : 'Administrador'}</td>
	                    <td>Hoy</td>
	                </tr>`)
	                $('#save_user_form')[0].reset();
	                $('#user_modal').modal('hide');
				}
			}
		})
	}
}

function facturar() {
	Swal.fire({
	  title: '¿Confirma procesar facturas?',
	  showDenyButton: true,
	  confirmButtonText: 'Si',
	  denyButtonText: `Cancelar`,
	  reverseButtons: true
	}).then((result) => {
	  if (result.isConfirmed) {
	  	$.ajax({
	  		url: '/facturar',
	  		type: 'POST',
	  		data: {'_token' : $('input[name=_token]').val()},
	  		success: (response) => {
	  			if(response.code != 200)
					show_alert('warning', 'Error', response.message);
				else
	  				location.reload();
	  		},
	  		error: () => {
	  			Swal.fire('Exito', 'Ha ocurrido un error', 'error');
	  		}
	  	})
	  }
	})
}

function comprar(id) {
	Swal.fire({
	  title: '¿Confirma compra del producto?',
	  showDenyButton: true,
	  confirmButtonText: 'Si',
	  denyButtonText: `Cancelar`,
	  reverseButtons: true
	}).then((result) => {
	  if (result.isConfirmed) {
	  	$.ajax({
	  		url: '/comprar',
	  		type: 'POST',
	  		data: {'_token' : $('input[name=_token]').val(), id},
	  		success: (response) => {
	  			Swal.fire('Exito', response.message, 'success');
	  		},
	  		error: () => {
	  			Swal.fire('Exito', 'Ha ocurrido un error', 'error');
	  		}
	  	})
	  }
	})
}