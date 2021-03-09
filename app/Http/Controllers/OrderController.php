<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Customer;
use App\Models\Product;
use App\Mail\InvoiceMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::get(['id', 'customer_name']);

        return view('orders.index', compact('customers'));
    }

    public function getCustomer(Request $request)
    {
        $customer = Customer::select('address','city','email','hp')->findOrFail((int)$request->customer);
        
        return response()->json($customer);
    }

    public function getProduct(Request $request)
    {
        $product = Product::where('product_code', $request->product)->select('id','product_code', 'product_name', 'stock', 'price')->first();
        
        $orders = [];
        $outOfStock = false;
        if (!is_null($product)){
            if(!$request->session()->has('order')){
                session([
                    'order' => $orders,
                    'outOfStock' => $outOfStock
                ]);
            }

            $orders = (session('order'));
            //cek apakah kode produk sudah ada di session
            if (array_key_exists($request->product, $orders)){
                if ($product->stock >= ($request->qty + $orders[$request->product]['qty'])){
                    $orders[$request->product]['qty'] += $request->qty;
                    $orders[$request->product]['total'] = $orders[$request->product]['qty'] * $product->price;
                }else{
                    $outOfStock = true;
                }
            }else{
                if ($product->stock >= $request->qty){
                    $orders[$product->product_code] = [
                        'product_id' => $product->id,
                        'product_code' => $product->product_code,
                        'product_name' => $product->product_name,
                        'qty' => (int)$request->qty,
                        'total' => $product->price * $request->qty
                    ];
                }else{
                    $outOfStock = true;
                }
            }
            //simpan ke session
            session([
                'order' => $orders, 
                'outOfStock' => $outOfStock
            ]);
        }       
        
        return response()->json(['order' => $orders, 'outOfStock' => $outOfStock]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    private function generateInvoice()
    {
        $formatInvoice = 'INV-'.date('Y').'-';
        $order = Order::selectRaw('RIGHT(MAX(invoice_no),4) as latest_invoice')-> where('invoice_no', 'like', $formatInvoice.'%')->first();

        return $formatInvoice.str_pad((!is_null($order->latest_invoice) ? $order->latest_invoice+1 : '1'), 5, '0', STR_PAD_LEFT);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'customer' => 'required',
            'total' => 'numeric|min:1'
        ],[
            'customer.required' => 'Customer belum dipilih',
            'total.min' => 'Belum ada produk yang dipesan'
        ]);
        
        $orders = session('order');
        $orderDetails = [];
        foreach($orders as $order){
            $orderDetails[] = [
                'product_id' => $order['product_id'],
                'qty' => $order['qty'],
                'total' => $order['total']
            ];
        }
                
        DB::beginTransaction();
        try{
            $order = Order::create([
                'invoice_no' => $this->generateInvoice(),
                'customer_id' => $request->input('customer'),
                'order_date' => now(),
                'total_price' => $request->input('total'),
                'user_id' => Auth::user()->id
            ]); 
            
            //insert ke tabel order detail dengan eloquent relationship
            $order->orderDetails()->createMany($orderDetails);
            
            DB::commit();
            $status = [
                'status' => 'success',
                'message' => 'Proses order telah berhasil'
            ];

            //send email ke customer
            Mail::to($request->input('email'))->send(new InvoiceMail($order->load('orderDetails', 'customer')));
        }catch(Exception $e){
            DB::rollback();
            $status = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }

        return redirect('order')->with($status);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
