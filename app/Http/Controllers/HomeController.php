<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Purchase;
use App\Models\Seed;
use Hash;
use DB;

class HomeController extends Controller
{
    public function __invoke(Request $request) {
        $products = Product::orderBy('id', 'DESC')->get();
        $invoices = Invoice::orderBy('id', 'DESC')->with('purchases')->with('client')->get();
        $users = User::where('id','!=',auth()->user()->id)->orderBy('id', 'DESC')->get();
        $not_facture = DB::table('purchases')
            ->select('client_id')
            ->whereNull('invoice_id')
            ->groupBy('client_id')
            ->get();
        return view('home.home', [
            'products' => $products,
            'invoices' => $invoices,
            'users' => $users,
            'por_facturar' => $not_facture
        ]);
    }
    public function new_user(Request $request) {
        $user = User::where('name', $request->name)
                ->orWhere('email', $request->email)
                ->first();
        if($user)
            return response()->json(['code' => 0, 'message' => 'Nombre / email de usuario no disponible']);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => $request->rol
        ]);
        return response()->json(['code' => 200, 'user' => $user]);
    }

    public function comprar(Request $request) {
        $compra = new Purchase();
        $compra->client_id = auth()->user()->id;
        $compra->product_id = $request->id;
        $compra->created_at = date('Y-m-d H:i:s');
        $compra->save();
        return response()->json(['code' => 200, 'message' => 'Compra realizada']);
    }

    public function facturar(Request $request) {
        $not_facture = DB::table('purchases')
            ->select('client_id')
            ->whereNull('invoice_id')
            ->groupBy('client_id')
            ->get();
        if(!count($not_facture))
            return response()->json(['code' => 100, 'message' => 'No hay facturas pendientes']);
        $data = [];
        foreach($not_facture as $nf) {
            $invoice = new Invoice();
            $invoice->client_id = $nf->client_id;
            $invoice->user_id = auth()->user()->id;
            $invoice->created_at = date('Y-m-d H:i:s');
            $invoice->save();
            $subtotal = 0;
            $iva_amount = 0;
            $purchases = Purchase::where('client_id', $nf->client_id)->whereNull('invoice_id')->with('client')->with('product')->get();
            foreach($purchases as $ps) {
                $subtotal += $ps->product->price;
                $iva_import = $ps->product->price * $ps->product->iva / 100;
                $iva_amount += $iva_import;
                $ps->invoice_id = $invoice->id;
                $ps->save();
            }
            $invoice->subtotal = round($subtotal, 2);
            $invoice->iva_amount = round($iva_amount, 2);
            $invoice->save();
        }
        return response()->json(['code' => 200]);
    }

    public function ver_factura($id) {
        $invoice = Invoice::with('client')->with('user')->find($id);
        if(!$invoice) {
            echo json_encode('Factura no encontrada'); die();
        }
        #echo json_encode($invoice); die();
        $products = Product::join('purchases', 'products.id', 'purchases.product_id')->orderBy('purchases.created_at', 'DESC')
            ->where('purchases.invoice_id', $invoice->id)
            ->get();
        #echo json_encode($products); die();
        return view('home.factura', ['invoice' => $invoice, 'products' => $products]);
    }

    public function seed(Request $request) {
        $seeds = Seed::get();
        if(count($seeds))
            return view('home.seed');
        else {
            # Usuarios
            $useradmin = $user = User::create([
                'name' => 'root',
                'email' => 'root@gmail.com',
                'password' => Hash::make('root'),
                'rol' => 2
            ]);
            $client1 = $user = User::create([
                'name' => 'bmx',
                'email' => 'bmx@gmail.com',
                'password' => Hash::make('123456'),
                'rol' => 1
            ]);
            $client2 = $user = User::create([
                'name' => 'alex',
                'email' => 'alex@gmail.com',
                'password' => Hash::make('123456'),
                'rol' => 1
            ]);
            # Productos
            $products = [
                ['Producto 1', 123.45, 5],
                ['Producto 2', 45.65, 15],
                ['Producto 3', 39.73, 12],
                ['Producto 4', 250, 8],
                ['Producto 5', 59.35, 10]
            ];
            foreach($products as $pr) {
                $prod = new Product();
                $prod->name = $pr[0];
                $prod->price = $pr[1];
                $prod->iva = $pr[2];
                $prod->user_id = 1;
                $prod->save();
            }
            # Compras
            $compras = [
                [2, 4, 1],
                [2, 5, 1],
                [3, 1, null],
                [2, 3, null],
                [2, 2, null]
            ];
            foreach($compras as $cp) {
                $compra = new Purchase();
                $compra->client_id = $cp[0];
                $compra->product_id = $cp[1];
                $compra->invoice_id = $cp[2];
                $compra->created_at = date('Y-m-d H:i:s');
                $compra->save();
            }
            # Facturas :  [309.35, 25.94, 2, 1];
            $invoice = new Invoice();
            $invoice->subtotal = 309.35;
            $invoice->iva_amount = 25.94;
            $invoice->client_id = 2;
            $invoice->user_id = 1;
            $invoice->created_at = date('Y-m-d H:i:s');
            $invoice->save();
            # Seed
            $seed = new Seed();
            $seed->created_at = date('Y-m-d H:i:s');
            $seed->save();
            return view('home.seed');
        }
    }
}
