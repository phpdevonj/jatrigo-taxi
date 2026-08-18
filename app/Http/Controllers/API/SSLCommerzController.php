<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Models\Wallet;
use App\Models\WalletHistory;
use App\Models\User;
use App\Notifications\CommonNotification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SSLCommerzController extends Controller
{
    protected $storeId;
    protected $storePassword;
    protected $isSandbox;
    protected $initUrl;
    protected $validUrl;

    public function __construct()
    {
        $gateway = PaymentGateway::where('type', 'sslcommerz')->where('status', 1)->first();
        if ($gateway) {
            $this->isSandbox = (bool) $gateway->is_test;
            if ($this->isSandbox) {
                $this->storeId = $gateway->test_value['store_id'] ?? null;
                $this->storePassword = $gateway->test_value['store_passwd'] ?? null;
            } else {
                $this->storeId = $gateway->live_value['store_id'] ?? null;
                $this->storePassword = $gateway->live_value['store_passwd'] ?? null;
            }
        } else {
            // Fallback to environment variables
            $this->isSandbox = (bool) env('SSLCOMMERZ_IS_SANDBOX', true);
            $this->storeId = env('SSLCOMMERZ_STORE_ID');
            $this->storePassword = env('SSLCOMMERZ_STORE_PASSWORD');
        }

        if ($this->isSandbox) {
            $this->initUrl = 'https://sandbox.sslcommerz.com/gwprocess/v4/api.php';
            $this->validUrl = 'https://sandbox.sslcommerz.com/validator/api/validationserverAPI.php';
        } else {
            $this->initUrl = 'https://securepay.sslcommerz.com/gwprocess/v4/api.php';
            $this->validUrl = 'https://securepay.sslcommerz.com/validator/api/validationserverAPI.php';
        }
    }

    /**
     * Initiate payment request to SSLCommerz.
     */
    public function initiate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1',
            'currency' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        if (empty($this->storeId) || empty($this->storePassword)) {
            return response()->json([
                'status' => false,
                'message' => 'SSLCommerz payment gateway is not configured or is inactive.',
            ], 400);
        }

        $tran_id = 'TXN_WAL_' . time() . '_' . rand(1000, 9999);
        $user = auth()->user();

        $post_data = [
            'store_id' => $this->storeId,
            'store_passwd' => $this->storePassword,
            'total_amount' => $request->amount,
            'currency' => $request->currency ?? 'BDT',
            'tran_id' => $tran_id,
            'success_url' => route('wallet.recharge.success'),
            'fail_url' => route('wallet.recharge.fail'),
            'cancel_url' => route('wallet.recharge.cancel'),
            'ipn_url' => route('wallet.recharge.ipn'),
            
            // Customer Info
            'cus_name' => $user->display_name ?? $user->first_name ?? 'Customer',
            'cus_email' => $user->email ?? 'customer@email.com',
            'cus_phone' => $user->contact_number ?? '01700000000',
            'cus_add1' => is_string($user->address) ? $user->address : ($user->address?->address ?? 'Dhaka'),
            'cus_city' => is_object($user->address) ? ($user->address?->city ?? 'Dhaka') : 'Dhaka',
            'cus_country' => is_object($user->address) ? ($user->address?->country ?? 'Bangladesh') : 'Bangladesh',
            
            // Shipment Info
            'shipping_method' => 'NO',
            
            // Product Info
            'product_name' => 'Wallet Recharge',
            'product_category' => 'Wallet',
            'product_profile' => 'general',
            
            // Custom Values
            'value_a' => $user->id,
            'value_b' => $request->amount,
            'value_c' => $request->currency ?? 'BDT',
            'value_d' => 'wallet_recharge',

            // Card Payment options
            'multi_card_name' => 'mastercard,visacard,amexcard'
        ];

        $wallet = Wallet::where('user_id', $user->id)->first();
        $balance = $wallet->total_amount ?? 0;

        // Set the status to pending inside the data column array
        $historyData = array_merge($post_data, ['status' => 'pending']);

        $walletHistory = WalletHistory::create([
            'user_id' => $user->id,
            'type' => 'credit', // Recharge is a credit to the wallet
            'transaction_type' => 'topup',
            'currency' => $request->currency ?? 'BDT',
            'amount' => $request->amount,
            'datetime' => now(),
            'balance' => $balance,
            'data' => $historyData,
            'description' => 'SSLCommerz payment initiation',
        ]);

        try {
            $response = Http::asForm()->post($this->initUrl, $post_data);

            Log::channel('sslcommerz')->info('SSLCommerz Initiated: ');

            if ($response->successful()) {
                $result = $response->json();
                if (isset($result['status']) && $result['status'] === 'SUCCESS') {
                    return response()->json([
                        'status' => true,
                        'payment_url' => $result['GatewayPageURL'],
                        'transaction_id' => $tran_id,
                    ]);
                }
                return response()->json([
                    'status' => false,
                    'message' => $result['failedreason'] ?? 'SSLCommerz payment initiation failed.',
                ], 400);
            }
        } catch (\Exception $e) {
            Log::channel('sslcommerz')->error('SSLCommerz initiation exception: ' . $e->getMessage());
        }

        return response()->json([
            'status' => false,
            'message' => 'Failed to connect to SSLCommerz API.',
        ], 500);
    }

    /**
     * Handle success redirect.
     */
    public function success(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $val_id = $request->input('val_id');
        $amount = $request->input('amount', $request->input('value_b', 0));
        $currency = $request->input('currency', $request->input('value_c', 'BDT'));

        $validated = false;
        $validationResult = [];

        if ($val_id && $tran_id) {
            // Verify with SSLCommerz validation API
            try {
                $response = Http::get($this->validUrl, [
                    'val_id' => $val_id,
                    'store_id' => $this->storeId,
                    'store_passwd' => $this->storePassword,
                    'format' => 'json',
                ]);

                if ($response->successful()) {
                    $validationResult = $response->json();
                    if (isset($validationResult['status']) && ($validationResult['status'] === 'VALID' || $validationResult['status'] === 'VALIDATED')) {
                        $validated = $this->updateTransactionStatus($tran_id, 'paid', $validationResult);
                    } else {
                        Log::channel('sslcommerz')->warning('SSLCommerz validation failed on success redirect: ' . json_encode($validationResult));
                    }
                } else {
                    Log::channel('sslcommerz')->error('SSLCommerz validation request failed on success redirect.');
                }
            } catch (\Exception $e) {
                Log::channel('sslcommerz')->error('SSLCommerz success validation exception: ' . $e->getMessage());
            }
        }

        if ($validated) {
            return $this->renderStatusView('Payment Successful!', 'Your wallet has been recharged successfully.', 'success', $tran_id, $amount, $currency);
        } else {
            return $this->renderStatusView('Validation Failed', 'We could not verify your payment transaction. Please contact support.', 'error', $tran_id, $amount, $currency);
        }
    }

    /**
     * Handle fail redirect.
     */
    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount', $request->input('value_b', 0));
        $currency = $request->input('currency', $request->input('value_c', 'BDT'));

        if ($tran_id) {
            $this->updateTransactionStatus($tran_id, 'failed', $request->all());
        }

        return $this->renderStatusView('Payment Failed', 'The payment transaction failed. Please try again.', 'error', $tran_id, $amount, $currency);
    }

    /**
     * Handle cancel redirect.
     */
    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount', $request->input('value_b', 0));
        $currency = $request->input('currency', $request->input('value_c', 'BDT'));

        if ($tran_id) {
            $this->updateTransactionStatus($tran_id, 'cancelled', $request->all());
        }

        return $this->renderStatusView('Payment Cancelled', 'The payment transaction was cancelled.', 'error', $tran_id, $amount, $currency);
    }

    /**
     * Handle Instant Payment Notification (IPN) webhook.
     */
    public function ipn(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $status = $request->input('status');
        $val_id = $request->input('val_id');

        Log::channel('sslcommerz')->info('SSLCommerz IPN webhook received: ' . json_encode($request->all()));

        if (!$tran_id) {
            return response()->json(['status' => 'failed', 'message' => 'Transaction ID missing'], 400);
        }

        if ($status === 'VALID' || $status === 'VALIDATED') {
            if ($val_id) {
                try {
                    $response = Http::get($this->validUrl, [
                        'val_id' => $val_id,
                        'store_id' => $this->storeId,
                        'store_passwd' => $this->storePassword,
                        'format' => 'json',
                    ]);

                    if ($response->successful()) {
                        $validationResult = $response->json();
                        if (isset($validationResult['status']) && ($validationResult['status'] === 'VALID' || $validationResult['status'] === 'VALIDATED')) {
                            $updated = $this->updateTransactionStatus($tran_id, 'paid', $validationResult);
                            if ($updated) {
                                return response()->json(['status' => 'success', 'message' => 'IPN success processed successfully']);
                            }
                        }
                    }
                } catch (\Exception $e) {
                    Log::channel('sslcommerz')->error('SSLCommerz IPN validation exception: ' . $e->getMessage());
                }
            }
        } elseif ($status === 'FAILED') {
            $updated = $this->updateTransactionStatus($tran_id, 'failed', $request->all());
            if ($updated) {
                return response()->json(['status' => 'success', 'message' => 'IPN failure processed successfully']);
            }
        } elseif ($status === 'CANCELLED') {
            $updated = $this->updateTransactionStatus($tran_id, 'cancelled', $request->all());
            if ($updated) {
                return response()->json(['status' => 'success', 'message' => 'IPN cancellation processed successfully']);
            }
        }

        return response()->json(['status' => 'failed', 'message' => 'IPN processing failed or transaction already processed'], 400);
    }

    /**
     * Update the status of the wallet history and wallet balance.
     */
    protected function updateTransactionStatus($tran_id, $status, $rawData = [])
    {
        // Find the wallet history record by transaction ID in JSON data
        $history = WalletHistory::where(function($query) use ($tran_id) {
            $query->where('data->tran_id', $tran_id)
                  ->orWhere('data', 'like', '%' . $tran_id . '%');
        })->first();

        if (!$history) {
            Log::channel('sslcommerz')->warning("SSLCommerz: Wallet history record not found for transaction: " . $tran_id);
            return false;
        }

        $userId = $history->user_id;
        $amount = $history->amount;
        $currency = $history->currency;

        if ($status === 'paid') {
            // ---------------------------------------------------------------
            // Security: never trust the gateway/callback blindly. Cross-check
            // the amount, currency and store_id returned by the Validation API
            // against the transaction we originally initiated. This blocks the
            // classic SSLCommerz tampering attack where a user pays a smaller
            // amount (or against another store) but VALIDs for that payment.
            // ---------------------------------------------------------------
            $validatedAmount   = isset($rawData['amount']) ? (float) $rawData['amount'] : null;
            $validatedCurrency = $rawData['currency'] ?? null;
            $validatedStoreId  = $rawData['store_id'] ?? null;

            if ($validatedAmount !== null && abs($validatedAmount - (float) $amount) > 0.99) {
                Log::channel('sslcommerz')->error("SSLCommerz: amount mismatch for {$tran_id}. Expected {$amount}, validation returned {$validatedAmount}. Aborting wallet credit.");
                return false;
            }

            if (!empty($validatedCurrency) && strtoupper(trim($validatedCurrency)) !== strtoupper(trim($currency))) {
                Log::channel('sslcommerz')->error("SSLCommerz: currency mismatch for {$tran_id}. Expected {$currency}, validation returned {$validatedCurrency}. Aborting wallet credit.");
                return false;
            }

            if (!empty($validatedStoreId) && !empty($this->storeId) && trim($validatedStoreId) !== trim($this->storeId)) {
                Log::channel('sslcommerz')->error("SSLCommerz: store_id mismatch for {$tran_id}. Expected {$this->storeId}, validation returned {$validatedStoreId}. Aborting wallet credit.");
                return false;
            }
        }

        // ---------------------------------------------------------------
        // Claim and mutate the record under a row-level lock. The success
        // redirect and the IPN webhook fire for the same transaction, so
        // without the lock both could pass the "already processed" check and
        // double-credit the wallet. Re-reading the status inside lockForUpdate
        // makes the state transition atomic. The closure returns:
        //   null                      -> already processed (idempotent no-op)
        //   'paid'/'failed'/'cancelled' -> freshly processed this call
        // ---------------------------------------------------------------
        try {
            $processed = DB::transaction(function () use ($history, $tran_id, $status, $rawData, $userId, $amount, $currency) {
                $walletHistory = WalletHistory::whereKey($history->id)->lockForUpdate()->first();

                $data = $walletHistory->data;
                if (!is_array($data)) {
                    $data = json_decode($walletHistory->data, true) ?? [];
                }

                $currentStatus = $data['status'] ?? 'pending';
                if (in_array($currentStatus, ['paid', 'failed', 'cancelled'])) {
                    Log::channel('sslcommerz')->info("SSLCommerz: Transaction {$tran_id} already processed with status: {$currentStatus}");
                    return null;
                }

                if ($status === 'paid') {
                    // Credit the wallet balance
                    $wallet = Wallet::firstOrCreate(['user_id' => $userId]);
                    $newBalance = ($wallet->total_amount ?? 0) + $amount;

                    $wallet->currency = strtolower($currency);
                    $wallet->total_amount = $newBalance;
                    $wallet->save();

                    $data['status'] = 'paid';
                    $data['raw_response'] = $rawData;
                    $walletHistory->type = 'credit';
                    $walletHistory->transaction_type = 'topup';
                    $walletHistory->balance = $newBalance;
                    $walletHistory->description = 'Wallet recharge via SSLCommerz successful';
                    $walletHistory->data = $data;
                    $walletHistory->save();

                    return 'paid';
                }

                // failed or cancelled: record the outcome, no balance change
                $data['status'] = $status;
                $data['raw_response'] = $rawData;
                $walletHistory->type = 'failed';
                $walletHistory->transaction_type = __('message.topup_failed');
                $walletHistory->description = 'Wallet recharge via SSLCommerz ' . $status;
                $walletHistory->data = $data;
                $walletHistory->save();

                return $status;
            });
        } catch (\Exception $e) {
            Log::channel('sslcommerz')->error("SSLCommerz: Wallet status update failed for {$tran_id} (status: {$status}): " . $e->getMessage());
            return false;
        }

        // Already processed by a concurrent/earlier callback: idempotent success.
        if ($processed === null) {
            return true;
        }

        // Notify only on a fresh transition, after the DB commit has succeeded.
        $user = User::find($userId);
        if ($user) {
            $currecyCode = currencyArray($currency);
            $currency = $currecyCode['symbol'] ?? '$';
            if ($processed === 'paid') {
                $notification_data = [
                    'id' => (string) $history->id,
                    'type' => 'wallet_recharge',
                    'subject' => __('message.wallet_recharged_success', [
                        'amount' => $amount,
                        'currency' => $currency
                    ]),
                    'message' => 'Your wallet has been successfully recharged with ' . $amount . ' ' . $currency . '.',
                ];
            } else {
                $notification_data = [
                    'id' => (string) $history->id,
                    'type' => 'wallet_recharge',    
                    'subject' => __('message.wallet_recharge', ['status' => $processed]),
                    'message' => 'Your wallet recharge of ' . $amount . ' ' . $currency . ' was ' . $processed . '.',
                ];
            }
            try {
                $user->notify(new CommonNotification($notification_data['type'], $notification_data));
            } catch (\Exception $e) {
                Log::channel('sslcommerz')->error("SSLCommerz notification dispatch error: " . $e->getMessage());
            }
        }

        return true;
    }

    /**
     * Render beautiful checkout status page.
     */
    protected function renderStatusView($title, $message, $type, $tran_id, $amount, $currency)
    {
        $isSuccess = ($type === 'success');
        $colorGradient = $isSuccess ? 'linear-gradient(135deg, #00f2fe, #4facfe)' : 'linear-gradient(135deg, #ff5e62, #ff9966)';
        $boxShadow = $isSuccess ? '0 8px 20px rgba(79, 172, 254, 0.4)' : '0 8px 20px rgba(255, 94, 98, 0.4)';
        $btnGradient = $isSuccess ? 'linear-gradient(135deg, #4facfe, #00f2fe)' : 'linear-gradient(135deg, #ff5e62, #ff9966)';
        $btnShadow = $isSuccess ? '0 4px 15px rgba(0, 242, 254, 0.2)' : '0 4px 15px rgba(255, 94, 98, 0.2)';

        $svgIcon = $isSuccess 
            ? '<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#0e1118" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>'
            : '<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#0e1118" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>';

        return response()->make(<<<HTML
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>{$title}</title>
                <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
                <style>
                    body {
                        font-family: 'Outfit', sans-serif;
                        background: radial-gradient(circle at top left, #1a1e36, #0e1118);
                        color: #ffffff;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                        margin: 0;
                        overflow: hidden;
                    }
                    .container {
                        background: rgba(255, 255, 255, 0.03);
                        backdrop-filter: blur(16px);
                        -webkit-backdrop-filter: blur(16px);
                        border: 1px solid rgba(255, 255, 255, 0.08);
                        border-radius: 24px;
                        padding: 40px;
                        width: 90%;
                        max-width: 420px;
                        text-align: center;
                        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
                        animation: fadeIn 0.8s ease-out;
                    }
                    @keyframes fadeIn {
                        from { opacity: 0; transform: translateY(20px); }
                        to { opacity: 1; transform: translateY(0); }
                    }
                    .icon-box {
                        width: 80px;
                        height: 80px;
                        background: {$colorGradient};
                        border-radius: 50%;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        margin: 0 auto 24px;
                        box-shadow: {$boxShadow};
                        animation: pulse 2s infinite;
                    }
                    @keyframes pulse {
                        0% { transform: scale(1); }
                        50% { transform: scale(1.05); }
                        100% { transform: scale(1); }
                    }
                    h1 {
                        font-size: 28px;
                        font-weight: 800;
                        margin: 0 0 12px;
                        background: linear-gradient(135deg, #ffffff, #a5b4fc);
                        -webkit-background-clip: text;
                        -webkit-text-fill-color: transparent;
                    }
                    p {
                        color: #94a3b8;
                        font-size: 16px;
                        line-height: 1.6;
                        margin: 0 0 32px;
                    }
                    .btn {
                        background: {$btnGradient};
                        color: #0e1118;
                        font-weight: 600;
                        border: none;
                        border-radius: 12px;
                        padding: 14px 28px;
                        font-size: 16px;
                        cursor: pointer;
                        transition: all 0.3s ease;
                        box-shadow: {$btnShadow};
                        text-decoration: none;
                        display: inline-block;
                        width: 100%;
                        box-sizing: border-box;
                    }
                    .btn:hover {
                        transform: translateY(-2px);
                        opacity: 0.95;
                    }
                    .details {
                        border-top: 1px solid rgba(255, 255, 255, 0.08);
                        margin-top: 24px;
                        padding-top: 24px;
                        text-align: left;
                    }
                    .detail-row {
                        display: flex;
                        justify-content: space-between;
                        margin-bottom: 10px;
                        font-size: 14px;
                    }
                    .detail-label {
                        color: #64748b;
                    }
                    .detail-value {
                        color: #cbd5e1;
                        font-weight: 600;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="icon-box">
                        {$svgIcon}
                    </div>
                    <h1>{$title}</h1>
                    <p>{$message}</p>
                    


                    <div class="details">
                        <div class="detail-row">
                            <span class="detail-label">Transaction ID</span>
                            <span class="detail-value">{$tran_id}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Amount</span>
                            <span class="detail-value">{$amount} {$currency}</span>
                        </div>
                    </div>
                </div>
            </body>
            </html>
            HTML
        );
    }
}
