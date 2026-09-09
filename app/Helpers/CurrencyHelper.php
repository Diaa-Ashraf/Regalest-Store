<?php

if (!function_exists('get_active_currency')) {
    /**
     * Get the active currency code (Always USD)
     */
    function get_active_currency(): string
    {
        return 'USD';
    }
}

if (!function_exists('get_exchange_rate')) {
    /**
     * Get exchange rate (Fixed to 1.0 for USD)
     */
    function get_exchange_rate(): float
    {
        return 1.0;
    }
}

if (!function_exists('convert_price')) {
    /**
     * Convert USD price to current target currency
     */
    function convert_price(float $amountInUsd, ?string $currency = null): float
    {
        return $amountInUsd;
    }
}

if (!function_exists('format_currency')) {
    /**
     * Format a price in USD ($XX.XX)
     */
    function format_currency(?float $amountInUsd, ?string $currency = null): string
    {
        $amountInUsd = (float) ($amountInUsd ?? 0.0);
        return '$' . number_format($amountInUsd, 2);
    }
}
