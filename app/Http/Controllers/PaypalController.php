<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use DB;

class PayPalController extends Controller
{
    /**
     * create transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function createTransaction()
    {
        return view('transaction');
    }

    /**
     * process transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function processTransaction(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('successTransaction'),
                "cancel_url" => route('cancelTransaction'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "MXN",
                        "value" => $request->total
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {

            // redirect to approve href
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }

            return redirect()
                ->route('createTransaction')
                ->with('message', 'Algo salió mal.');

        } else {
            return redirect()
                ->route('createTransaction')
                ->with('message', $response['message'] ?? 'Algo salió mal.');
        }
       
    }

    /**
     * success transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function successTransaction(Request $request)
    {
    	$order='';
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {

            $user_id = auth()->user()->id;
            $order = DB::select('SELECT SUM(p.price*c.quantity) precio FROM product_items p INNER JOIN carts c ON p.id=c.product_item_id AND c.user_id='.$user_id.' AND c.active=1;');
            $product_items = DB::select('SELECT p.price,(p.quantity-c.quantity) cantidad,p.id FROM product_items p INNER JOIN carts c ON p.id=c.product_item_id AND c.user_id=1 AND c.active=1;');

        	DB::table('orders')->insert(
            array(
            'status'     =>   '1', 
            'order_type'   =>   '1',
            'order'   =>   $order[0]->precio,
            'shop_revenue'   =>   '8.5',
            'admin_revenue'   =>   '1.5',
            'tax'   =>   '10',
            'delivery_fee'   =>   '0',
            'total'   =>   $order[0]->precio,
            'otp'   =>   '587433',
            'user_id'   =>   $user_id,
            'shop_id'   =>   '1',
            'order_payment_id'   =>   '1'
     )
);
        	$lastId = DB::getPdo()->lastInsertId();

        	DB::update('UPDATE carts SET order_id='.$lastId.',active=0 WHERE user_id='.$user_id.' AND active=1;');
            foreach ($product_items as $P){
            DB::update('UPDATE product_items SET quantity='.$P->cantidad.' WHERE id='.$P->id);
           }
           return redirect()
                ->route('user.orders.index')
                ->with(['message'=> 'Transacción completada.']);
                
        } else {
            return redirect()
                ->route('user.orders.index')
                ->with('message', $response['message'] ?? 'Algo salió mal.');
        }

    }

    /**
     * cancel transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelTransaction(Request $request)
    {
        return redirect()
            ->route('user.orders.index')
            ->with('message', $response['message'] ?? 'Algo salió mal.');
    }
}