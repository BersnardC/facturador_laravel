@extends('layouts.index')
@section('content')
<div class="container px-4 py-5" id="featured-3">
    <h2 class="pb-2 border-bottom">Data Generada</h2>
    <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
      <div class="feature col">
        <h2><i class="bi bi-people-fill"></i> Usuario</h2>
        <p>Id <b>1</b></p>
        <p>Nombre <b>root</b></p>
        <p>Email <b>root@gmail.com</b></p>
        <p>Clave <b>root</b></p>
        <p>Rol <b>2 (Administrador)</b></p>
      </div>
      <div class="feature col">
        <h2><i class="bi bi-people-fill"></i> Usuario</h2>
        <p>Id <b>2</b></p>
        <p>Nombre <b>bmx</b></p>
        <p>Email <b>bmx@gmail.com</b></p>
        <p>Clave <b>123456</b></p>
        <p>Rol <b>1 (Cliente)</b></p>
      </div>
      <div class="feature col">
        <h2><i class="bi bi-people-fill"></i> Usuario</h2>
        <p>Id <b>3</b></p>
        <p>Nombre <b>alex</b></p>
        <p>Email <b>alex@gmail.com</b></p>
        <p>Clave <b>123456</b></p>
        <p>Rol <b>1 (Cliente)</b></p>
      </div>
      <div class="feature col">
        <h2><i class="bi bi-cart3"></i> Productos (5)</h2>
        <p>Nombre: Producto 1 - Precio: 123.45 -  Iva: 5</p>
        <p>Nombre: Producto 2 -  Precio: 45.65 -  Iva: 15</p>
        <p>Nombre: Producto 3 -  Precio: 39.73 -  Iva: 12</p>
        <p>Nombre: Producto 4 -  Precio: 250 -  Iva: 8</p>
        <p>Nombre: Producto 5 -  Precio: 59.35 -  Iva: 10</p>
      </div>
      <div class="feature col">
        <h2><i class="bi bi-cart3"></i> Compras (5)</h2>
        <p>Facturadas: 2 - Cliente: 2 (BMX)</p>
        <p>Sin facturar: 3</p>
      </div>
      <div class="feature col">
        <h2><i class="bi bi-file-earmark-spreadsheet"></i>Facturas (1)</h2>
        <p>Procesadas: 1 - Cliente: 2 (BMX)</p>
      </div>
    </div>
  </div>
@endsection()