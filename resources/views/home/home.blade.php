@extends('layouts.index')
@section('content')
<style>
	body {
  height: 100vh;
}

nav ul {
	flex: 1;
	text-align: right;
}
.hero {
	width: 100%;
	background: var(--primary-color);
	font-family: sans-serif;
	position: relative;
	transition: background 0.5s;
}
nav {
	width: 100%;
	margin: auto;
	padding: 20px 0;
	display: flex;
	align-items: center;
	justify-content: space-between;
}
.logo {
	width: 45px;
	cursor: pointer;
	border-radius: 50px;
}
nav ul li {
	list-style: none;
	display: inline-block;
	margin: 10px 20px;
}

nav ul li.active {
	color: #fff;
    background: #212529;
    padding: 0 5px;
    border-radius: 3.5px;
}

nav ul li a {
	text-decoration: none;
	color: var(--secondary-color);
}

nav ul li a:hover {
	color: #ff4321;
}

.tails-item-box {
	height: 200px;
	max-height: 200px;
    overflow: auto;
}

.header-info {
	float: right;
    font-size: 12.5px;
    margin-top: 3.5px;
}
a {
	color: #212529;
	text-decoration: none;
}

.tbtn {
	background: red;
    padding: 2.5px;
    border-radius: 50px;
    font-size: 10px;
    color: #fff;
}
</style>
<div class="container">
	<div class="hero">
		<nav>
	        <img src="https://media-exp1.licdn.com/dms/image/C4E03AQG6a0Pw6iyJnA/profile-displayphoto-shrink_200_200/0/1541457400725?e=1637798400&v=beta&t=LfsO6VmLjeFuv8fGf95cZGR62pvkPsiO_mWwv1938AM" alt="" class="logo" />
	        <ul>
	          	<li class="{{Route::CurrentRouteName() == 'home' ? 'active' : ''}}"><a href="#">Home</a></li>
	          	<li><a href="https://www.linkedin.com/in/bersnardcoello/" target="_blank">Sobre mi</a></li>
	          	<li><a href="https://github.com/BersnardC" target="_blank"><i class="bi bi-github"></i></a></li>
	        </ul>
	    </nav>
    </div>
    <div class="row">
        <div class="col-7">
            <p>Bienvenido: <b>{{Auth::user()->name}}</b></p>
        </div>
        <div class="col-5 text-end">
            <a href="{{url('logout')}}" class="btn btn-dark btn-sm"><i class="bi bi-box-arrow-left"></i> Cerrar sesión</a>
        </div>
    </div>
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            @if(Auth::user()->rol == 2)
                <button class="nav-link active" id="nav-facturas-tab" data-bs-toggle="tab" data-bs-target="#nav-facturas" type="button" role="tab" aria-controls="nav-facturas" aria-selected="true"><i class="bi bi-file-earmark-spreadsheet"></i> Facturas</button>
                <button class="nav-link" id="nav-inventario-tab" data-bs-toggle="tab" data-bs-target="#nav-inventario" type="button" role="tab" aria-controls="nav-inventario" aria-selected="false"><i class="bi bi-cart3"></i> Inventario</button>
                <button class="nav-link" id="nav-historial-tab" data-bs-toggle="tab" data-bs-target="#nav-historial" type="button" role="tab" aria-controls="nav-historial" aria-selected="false"><i class="bi bi-people-fill"></i> Usuarios</button>
            @else
                <button class="nav-link active" id="nav-inventario-tab" data-bs-toggle="tab" data-bs-target="#nav-inventario" type="button" role="tab" aria-controls="nav-inventario" aria-selected="false"><i class="bi bi-cart3"></i> Tienda</button>
                <button class="nav-link" id="nav-facturas-tab" data-bs-toggle="tab" data-bs-target="#nav-facturas" type="button" role="tab" aria-controls="nav-facturas" aria-selected="true"><i class="bi bi-file-earmark-spreadsheet"></i> Mis Compras</button>
            @endif()
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        @if(Auth::user()->rol == 2)
            <div class="tab-pane fade show active" id="nav-facturas" role="tabpanel" aria-labelledby="nav-facturas-tab">
                <div class="row">                	
                    <h4 class="text-center"><i class="bi bi-file-earmark-spreadsheet"></i> Facturas</h4>
                    <div class="mb-3">
                        <button class="btn btn-dark btn-sm" {{count($por_facturar) ? '' : 'disabled'}} onclick="facturar()"><i class="bi bi-file-earmark-plus"></i> Facturar</button> {{count($por_facturar) ? count($por_facturar).' Cliente(s) por facturar' : ''}}
                    </div>
                    <table class="table table-hover table-bordered text-center" style="margin: 0 12px;">
                        <thead>
                            <tr>                            
                                <th>Total</th>
                                <th>Subtotal</th>
                                <th>Monto Iva</th>
                                <th>Cliente</th>
                                <th>Cantidad Productos</th>
                                <th>Creada</th>
                                <th>...</th>
                            </tr>
                        </thead>
                        <tbody style="border-top: none;">
                            @if(!count($invoices))
                                <tr id="non_invoice"><td colspan="7"><h5 class="text-center text-danger">Listado vacío</h5></td></tr>
                            @else
                                @foreach($invoices as $invoice)
                                    <tr>
                                        <td>{{$invoice->iva_amount + $invoice->subtotal}} $</td>
                                        <td>{{$invoice->subtotal}} $</td>
                                        <td>{{$invoice->iva_amount}} $</td>
                                        <td>{{$invoice->client->name}}</td>
                                        <td>{{count($invoice->purchases)}}</td>
                                        <td>{{date('d-m-Y', strtotime($invoice->created_at))}}</td>
                                        <td><a href="{{url('factura/'.$invoice->id)}}" target="_blank" class="btn btn-sm btn-primary"><i class="bi bi-search"></i> Ver</a></td>
                                    </tr>
                                @endforeach()
                            @endif()
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-inventario" role="tabpanel" aria-labelledby="nav-inventario-tab">
                <div class="row">
                    <h4 class="text-center"><i class="bi bi-cart3"></i> Productos</h4>
                    <div class="mb-3">
                        <button class="btn btn-dark btn-sm" onclick="new_product()"><i class="bi bi-plus-circle"></i> Nuevo Producto</button>
                    </div>
                    <div class="row" id="product_list">
                        @if(!count($products))
                            <div id="non_product" class="col-md-12 text-center text-danger">
                                <h5>No hay productos en Stock</h5>
                            </div>
                        @else
                            @foreach($products as $prod)
                                <div class="col-md-2" id="prod_{{$prod->id}}">
                                    <div class="card text-center mb-2 p-3">
                                        <h5>{{$prod->name}}</h5>
                                        <p class="mb-0">Precio: {{$prod->price}}$</p>
                                        <span class="mb-1" style="font-size: 11px;">IVA: {{$prod->iva}} %</span>
                                        <!--button class="btn btn-info">Comprar</button-->
                                        <div class="row">
                                            <div class="col-6">
                                                <a href="javascript:delete_product({{$prod->id}});"><i class="bi bi-trash" title="Borrar"></i></a>
                                            </div>
                                            <div class="col-6">
                                                <a href="javascript:edit_product({{$prod->id}});"><i class="bi bi-pencil" title="Editar"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach()
                        @endif()
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-historial" role="tabpanel" aria-labelledby="nav-historial-tab">
                <div class="row">
                    <h4 class="text-center"><i class="bi bi-people-fill"></i> Usuarios</h4>
                    <div class="mb-3">
                        <button class="btn btn-dark btn-sm" onclick="new_user()"><i class="bi bi-plus-circle"></i> Nuevo Usuario</button>
                    </div>
                    <table class="table table-hover table-bordered text-center" style="margin: 0 12px;">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Rol</th>
                                <th>Creado</th>
                            </tr>
                        </thead>
                        <tbody style="border-top: none;" id="user_list">
                            @if(!count($users))
                                <tr id="non_user"><td colspan="4"><h5 class="text-center text-danger">Listado vacío</h5></td></tr>
                            @else
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->rol == 1 ? 'Cliente' : 'Administrador'}}</td>
                                        <td>{{date('d-m-Y', strtotime($user->created_at))}}</td>
                                    </tr>
                                @endforeach()
                            @endif()
                		</tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="tab-pane fade show active" id="nav-inventario" role="tabpanel" aria-labelledby="nav-inventario-tab">
                <div class="row">
                    <h4 class="text-center mb-4"><i class="bi bi-cart3"></i> Tienda</h4>
                    @csrf
                    <div class="row" id="product_list">
                        @if(!count($products))
                            <div id="non_product" class="col-md-12 text-center text-danger">
                                <h5>No hay productos en Stock</h5>
                            </div>
                        @else
                            @foreach($products as $prod)
                                <div class="col-md-2" id="prod_{{$prod->id}}">
                                    <div class="card text-center mb-2 p-3">
                                        <h5>{{$prod->name}}</h5>
                                        <p class="mb-0">Precio: {{$prod->price}}$</p>
                                        <span class="mb-1" style="font-size: 11px;">IVA: {{$prod->iva}} %</span>
                                        <button class="btn btn-info" onclick="comprar({{$prod->id}})">Comprar</button>
                                    </div>
                                </div>
                            @endforeach()
                        @endif()
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-facturas" role="tabpanel" aria-labelledby="nav-facturas-tab">
                <div class="row">                   
                    <h4 class="text-center mb-4"><i class="bi bi-file-earmark-spreadsheet"></i> Mis Compras</h4>
                    <table class="table table-hover table-bordered text-center" style="margin: 0 12px;">
                        <thead>
                            <tr>                            
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Fecha</th>
                                <th>Monto</th>
                            </tr>
                        </thead>
                        <tbody style="border-top: none;" id="user_list">
                            <tr id="non_invoice"><td colspan="5"><h5 class="text-center text-danger">Historial de compras no disponible.</h5></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endif()
    </div>
</div>
<div class="modal fade" id="product_modal" tabindex="-1" aria-labelledby="product_modal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <!--h5 class="modal-title" id="product_modal">Modal title</h5-->
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="save_product_form">
            @csrf
            <input type="hidden" name="id_product" id="id_product">
            <div class="mb-3">
                <input type="text" name="name" id="product_name" class="form-control" placeholder="Nombre">
            </div>
            <div class="mb-3">
                <input type="number" name="price" id="product_price" class="form-control" placeholder="Precio ($)">
            </div>
            <div class="mb-3">
                <input type="number" name="iva" id="iva" class="form-control" placeholder="IVA (%)">
            </div>
            <div class="text-end">
                <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-slash-square"></i> Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="save_product()"><i class="bi bi-save"></i> Guardar</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="user_modal" tabindex="-1" aria-labelledby="user_modal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <!--h5 class="modal-title" id="user_modal">Modal title</h5-->
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="save_user_form">
            @csrf
            <input type="hidden" name="id_product" id="id_product">
            <div class="mb-3">
                <input type="text" name="name" id="user_name" class="form-control" placeholder="Nombre de Usuario">
            </div>
            <div class="mb-3">
                <input type="email" name="email" id="email" class="form-control" placeholder="Correo">
            </div>
            <div class="mb-3">
                <input type="password" name="password" id="password" class="form-control" placeholder="Clave">
            </div>
            <div class="mb-3">
                <label for="rol_id">Rol de Usuario</label>
                <select name="rol" id="rol_id" class="form-control">
                    <option value="0">Seleccione</option>
                    <option value="1">Cliente</option>
                    <option value="2">Admin</option>
                </select>
            </div>
            <div class="text-end">
                <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-slash-square"></i> Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="save_user()"><i class="bi bi-save"></i> Guardar</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection()