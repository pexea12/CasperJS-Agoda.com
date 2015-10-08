<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class HotelController extends Controller
{
    protected $currencyList = [
            'AED' => "Arab Emirates Dirham (AED)",
            'ARS' => "Argentine Peso (ARS)",
            'AUD' => "Australian Dollar (AUD)",
            'BHD' => "Bahrain Dinar (BHD)",
            'GBP' => "British Pound (GBP)",
            'BGN' => "Bulgarian Lev (BGN)",
            'CAD' => "Canadian Dollar (CAD)",
            'XPF' => "CFP Franc (XPF)",
            'CNY' => "Chinese Yuan (CNY)",
            'CZK' => "Czech Koruna (CZK)",
            'DKK' => "Danish Krone (DKK)",
            'EUR' => "Euro (EUR)",
            'FJD' => "Fiji Dollar (FJD)",
            'HKD' => "Hong Kong Dollar (HKD)",
            'HUF' => "Hungarian Forint (HUF)",
            'INR' => "Indian Rupee (INR)",
            'IDR' => "Indonesian Rupiah (IDR)",
            'JPY' => "Japanese Yen (JPY)",
            'JOD' => "Jordanian Dinar (JOD)",
            'KZT' => "Kazakh Tenge (KZT)",
            'KRW' => "Korean Won (KRW)",
            'KWD' => "Kuwaiti Dinar (KWD)",
            'MYR' => "Malaysian Ringgit (MYR)",
            'MXN' => "Mexican Peso (MXN)",
            'ILS' => "New Israeli Sheqel (ILS)",
            'NZD' => "New Zealand Dollar (NZD)",
            'NGN' => "Nigerian Naira (NGN)",
            'NOK' => "Norwegian Krone (NOK)",
            'OMR' => "Omani Rial (OMR)",
            'PKR' => "Pakistan Rupee (PKR)",
            'PHP' => "Philippine Peso (PHP)",
            'PLN' => "Polish Zloty (PLN)",
            'QAR' => "Qatari Rial (QAR)",
            'RON' => "Romanian Leu (RON)",
            'RUB' => "Russian Ruble (RUB)",
            'SAR' => "Saudi Riyal (SAR)",
            'SGD' => "Singapore Dollar (SGD)",
            'ZAR' => "South African Rand (ZAR)",
            'SEK' => "Swedish Krona (SEK)",
            'CHF' => "Swiss Franc (CHF)",
            'TWD' => "Taiwan Dollar (TWD)",
            'THB' => "Thai Baht (THB)",
            'TRY' => "Turkish Lira (TRY)",
            'UAH' => "Ukrainian Grivna (UAH)",
            'USD' => "US Dollar (USD)",
            'VND' => "Vietnamese Dong (VND)"
        ];

    public function index() { 
        $currencyList = $this->currencyList;
        return view('index', compact('currencyList'));
    }

    public function find() {

        $date = Request::get('date');
        $currency = Request::get('currency');

        ini_set('max_execution_time', 300);
        $result = shell_exec('..\node_modules\casperjs\bin\casperjs currency.js ' . $date . ' ' . $currency);
    
        $data = explode("\n", $result);
        $data = array_splice($data, 2, count($data) - 4);

        $pos = (count($data) - 2) / 2;
        $rooms = array_splice($data, 0, $pos);
        $rooms[count($rooms) - 1] .= ',';
        $rooms = array_map(function($v) {
            return substr($v, 5, strlen($v) - 8);
        }, $rooms);

        $prices = array_splice($data, 2, $pos);
        $prices[count($prices) - 1] .= ',';
        $prices = array_map(function($v) {
            return substr($v, 5, strlen($v) - 8);
        }, $prices);

        $rooms = array_combine($rooms, $prices);

        $currencyList = $this->currencyList;


        return view('list', compact('currencyList', 'currency', 'rooms'));
    }
} 
