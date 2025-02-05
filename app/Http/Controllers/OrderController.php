<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

use PaypalServerSdkLib\Authentication\ClientCredentialsAuthCredentialsBuilder;
use PaypalServerSdkLib\Environment;
use PaypalServerSdkLib\PaypalServerSdkClientBuilder;
use PaypalServerSdkLib\Models\Builders\MoneyBuilder;
use PaypalServerSdkLib\Models\Builders\OrderRequestBuilder;
use PaypalServerSdkLib\Models\Builders\PurchaseUnitRequestBuilder;
use PaypalServerSdkLib\Models\Builders\AmountWithBreakdownBuilder;
use PaypalServerSdkLib\Models\Builders\ShippingDetailsBuilder;
use PaypalServerSdkLib\Models\Builders\ShippingOptionBuilder;
use PaypalServerSdkLib\Models\ShippingType;

class OrderController extends Controller
{
    private function getPaypalClient() {
        $PAYPAL_CLIENT_ID = env('PAYPAL_CLIENT_ID');
        $PAYPAL_CLIENT_SECRET = env('PAYPAL_CLIENT_SECRET');
        return PaypalServerSdkClientBuilder::init()
            ->clientCredentialsAuthCredentials(
                ClientCredentialsAuthCredentialsBuilder::init(
                    $PAYPAL_CLIENT_ID,
                    $PAYPAL_CLIENT_SECRET
                )
            )
            ->environment(Environment::SANDBOX)
            ->build();
    }
    public function create(Request $request){
        $client = $this->getPaypalClient();
        $totalPrice = 0;
        foreach($request['cart'] as $item){
            $totalPrice += $item['price'] * $item['quantity'];
        }
        $orderBody = [
            "body" => OrderRequestBuilder::init("CAPTURE", [
                PurchaseUnitRequestBuilder::init(
                    AmountWithBreakdownBuilder::init(env('PAYPAL_CURRENCY'), $totalPrice)->build()
                )->build(),
            ])->build(),
        ];
        $apiResponse = $client->getOrdersController()->ordersCreate($orderBody);
        $response = [
            "jsonResponse" => json_decode($apiResponse->getBody(), true),
            "status" => $apiResponse->getStatusCode(),
        ];

        // $order = Order::create([
        //     'order_id' => $response["jsonResponse"]["id"],
        //     'status' => $response["status"],
        //     'payer_id' => $request['jsonResponse']['payer_id'],
        //     'cart' => $request['cart'],
        // ]);

        return response()->json($response["jsonResponse"]);
    }
    public function capture($orderId){
        $client = $this->getPaypalClient();
        $captureBody = [
            "id" => $orderId,
        ];


        $apiResponse = $client->getOrdersController()->ordersCapture($captureBody);


        // $order = Order::where('order_id', $orderId)->first();
        // $order->status = $apiResponse->getStatusCode();
        // $order->save();

        $response = [
            "jsonResponse" => json_decode($apiResponse->getBody(), true),
            "status" => $apiResponse->getStatusCode(),
        ];

        return response()->json($response["jsonResponse"]);
    }
}
