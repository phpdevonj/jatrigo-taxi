<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * SSL Wireless SMS gateway client (iSMS / SMS Plus, API v3).
 *
 * Ported from the vendor sample (isms_api_sample_code). Only the single-SMS
 * endpoint is needed for OTP delivery, but bulk/dynamic can be added the same way.
 */
class SslWirelessSmsService
{
    protected string $apiToken;
    protected string $sid;
    protected string $domain;
    protected bool $verifySsl;

    public function __construct()
    {
        $this->apiToken = (string) config('sslsms.api_token');
        $this->sid = (string) config('sslsms.sid');
        $this->domain = rtrim((string) config('sslsms.domain', 'https://smsplus.sslwireless.com'), '/');
        $this->verifySsl = (bool) config('sslsms.verify_ssl', false);
    }

    /**
     * Send a single SMS (mirrors singleSms() in the vendor sample).
     *
     * @param  string      $msisdn      Recipient number (any format; normalised to digits).
     * @param  string      $messageBody Message text.
     * @param  string|null $csmsId      Client-side message id (must be unique within a day).
     * @return array{success: bool, response: mixed}
     *
     * @throws \RuntimeException When the gateway is not configured.
     */
    public function sendSingleSms(string $msisdn, string $messageBody, ?string $csmsId = null): array
    {
        if ($this->apiToken === '' || $this->sid === '') {
            throw new \RuntimeException('SSL Wireless SMS gateway is not configured (SSLSMS_API_TOKEN / SSLSMS_SID).');
        }

        $params = [
            'api_token' => $this->apiToken,
            'sid' => $this->sid,
            'msisdn' => $this->normalizeMsisdn($msisdn),
            'sms' => $messageBody,
            'csms_id' => $csmsId ?: $this->generateCsmsId(),
        ];

        try {
            $response = Http::withOptions(['verify' => $this->verifySsl])
                ->acceptJson()
                ->asJson()
                ->timeout(30)
                ->post($this->domain . '/api/v3/send-sms', $params);
        } catch (\Throwable $e) {
            Log::error('SSL Wireless SMS request failed', ['msisdn' => $params['msisdn'], 'error' => $e->getMessage()]);
            return ['success' => false, 'response' => $e->getMessage()];
        }

        $body = $response->json() ?? $response->body();

        // The gateway returns status "SUCCESS" when the request is accepted.
        $status = is_array($body) ? ($body['status'] ?? null) : null;
        $success = $response->successful() && strtoupper((string) $status) === 'SUCCESS';

        if (! $success) {
            Log::warning('SSL Wireless SMS send unsuccessful', ['msisdn' => $params['msisdn'], 'response' => $body]);
        }

        return ['success' => $success, 'response' => $body];
    }

    /**
     * SSL Wireless expects the MSISDN as digits including the country code and
     * without a leading "+", e.g. "8801700000000".
     */
    protected function normalizeMsisdn(string $msisdn): string
    {
        return preg_replace('/\D+/', '', $msisdn);
    }

    /**
     * Generate a csms_id that is unique within the same day (gateway requirement).
     */
    protected function generateCsmsId(): string
    {
        return 'OTP' . now()->format('YmdHis') . mt_rand(1000, 9999);
    }
}
