@extends('layouts.index')
@section('content')
<div class="col-lg-8 mx-auto p-3 py-md-5">
	<header class="d-flex align-items-center pb-3 mb-3 border-bottom">
	    <a href="javascript:;" class="col-6 d-flex align-items-center text-dark text-decoration-none">
	      <i class="bi bi-file-earmark-spreadsheet fs-3"></i>
	      <span class="fs-4">Factur nro: <b>{{$invoice->id}}</b></span>
	    </a>
    	<span class="fs-5 col-6 text-end">Fecha: <b>{{date('d-m-Y', strtotime($invoice->created_at))}}</b></span>
  	</header>
  	<div class="row g-5">
      <div class="col-md-6">
        <h5>Cliente</h5>
        <p class="mb-1">Nombre: <b>{{$invoice->client->name}}</b></p>
        <p>Email: <b>{{$invoice->client->email}}</b></p>
      </div>
      <div class="col-md-6 text-end">
        <h5>Realizada por</h5>
        <p class="mb-1">Nombre: <b>{{$invoice->user->name}}</b></p>
        <p>Email: <b>{{$invoice->user->email}}</b></p>
      </div>
    </div>
    <div class="row">
    	<h5>Compra(s)</h5>
    	<div>
    		<div class="card">
	    		<table class="table table-hover text-center">
		            <thead>
		                <tr>                            
		                    <th>Producto</th>
		                    <th>Precio $</th>
		                    <th>Iva %</th>
		                    <th>Importe Iva $</th>
		                    <th>Monto</th>
		                    <th>Fecha</th>
		                </tr>
		            </thead>
		            <tbody style="border-top: none;" id="user_list">
		               @foreach($products as $product)
		               	 <tr>
		               	 	<?php 
		                		$importe_iva = $product->price * $product->iva / 100;
		                	?>
		                	<td>{{$product->name}}</td>
		                	<td>{{$product->price}} $</td>
		                	<td>{{$product->iva}} %</td>
		                	<td>{{round($importe_iva, 2)}} $</td>
		                	<td>{{round($importe_iva + $product->price, 2)}} $</td>
		                	<td>{{date('d-m-Y', strtotime($product->created_at))}}</td>
		                </tr>
		               @endforeach()
		            </tbody>
		        </table>
	    	</div>
    	</div>
    </div>
    <div class="row">
    	<div class="offset-md-6 col-md-6 text-end">
	        <p>SubTotal: <b>{{$invoice->subtotal}} $</b></p>
	        <p>IVA: <b>{{$invoice->iva_amount}} $</b></p>
	        <h5>TOTAL: {{$invoice->subtotal + $invoice->iva_amount}} $</h5>
	    </div>
    </div>
    <footer class="pt-5 my-5 text-muted border-top">
    	Creado por <a href="https://github.com/BersnardC" target="_blank"><i class="bi bi-github"></i> Bersnard</a>
    	<button class="btn btn-info" style="float: right;" onclick="window.print()"><i class="bi bi-printer"></i> Imprimir</button>
  	</footer>
</div>
@endsection()