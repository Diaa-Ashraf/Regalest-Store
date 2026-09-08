<?php

if (!function_exists('get_active_currency')) {
    /**
     * Get the active currency code from session or default settings
     */
    function get_active_currency(): string
    {
        return session('currency', settings('default_currency', 'USD'));
    }
}

if (!function_exists('get_exchange_rate')) {
    /**
     * Get USD to SYP exchange rate from settings
     */
    function get_exchange_rate(): float
    {
        return (float) settings('exchange_rate', 15000.00);
    }
}

if (!function_exists('convert_price')) {
    /**
     * Convert USD price to current target currency
     */
    function convert_price(float $amountInUsd, ?string $currency = null): float
    {
        $target = $currency ?? get_active_currency();

        if ($target === 'SYP') {
            return $amountInUsd * get_exchange_rate();
        }

        return $amountInUsd;
    }
}

if (!function_exists('format_currency')) {
    /**
     * Format a price according to currency
     */
    function format_currency(float $amountInUsd, ?string $currency = null): string
    {
        $target = $currency ?? get_active_currency();
        $converted = convert_price($amountInUsd, $target);

        if ($target === 'SYP') {
            return number_format($converted, 0) . ' ' . __('ل.س');
        }

        return '$' . number_format($converted, 2);
    }
}
