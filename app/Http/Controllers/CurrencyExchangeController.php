<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use App\Models\Transactions;
use App\Models\User;
use App\Models\UserBalance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CurrencyExchangeController extends Controller
{
    public function view()
    {
        $user = User::where('id', auth()->user()->id)->with('balance')->get();
        foreach ($user as $k => $v) {
            if (!empty($v['balance'])) {
                $internalBalance = $v['balance'];
            } else {
                $internalBalance = 0;
            }
        }
        return view('exchanger', compact('internalBalance'));
    }

    public function exchanger(Request $request)
    {
        $in = $request->get('in');
        $baseCurrency = $request->get('baseCurrency');
        $quoteCurrency = $request->get('quoteCurrency');

        $file = Storage::disk()->get('courses.json');
        $decodeCourses = json_decode($file, true);
        $coursesArr = [];
        foreach ($decodeCourses as $key => $val) {
            $coursesArr[$val['ccy']] = $val;
        }


        $baseUserBalance = UserBalance::where('user_id', Auth()->user()->id)->where('currency', $baseCurrency)->first();
        $baseBalance = $baseUserBalance['balance'];
        $baseCurrency = $baseUserBalance['currency'];

        $quoteUserBalance = UserBalance::where('user_id', Auth()->user()->id)->where('currency', $quoteCurrency)->first();

        if ($baseBalance >= $in) {
            if ($baseCurrency !== $quoteCurrency) {
                $rate = 0;
                $quoteCurrencyAmount = 0;
                if ($baseCurrency === 'UAH' && $quoteCurrency === 'USD') {
                    $rate = $coursesArr['USD']['buy'];
                    $quoteCurrencyAmount = $in / $rate;
                }
                if ($baseCurrency === 'USD' && $quoteCurrency === 'UAH') {
                    $rate = $coursesArr['USD']['sale'];
                    $quoteCurrencyAmount = $in * $rate;
                }
                if ($baseCurrency === 'UAH' && $quoteCurrency === 'RUB') {
                    $rate = $coursesArr['RUR']['buy'];
                    $quoteCurrencyAmount = $in / $rate;
                }
                if ($baseCurrency === 'RUB' && $quoteCurrency === 'UAH') {
                    $rate = $coursesArr['RUR']['sale'];
                    $quoteCurrencyAmount = $in * $rate;
                }
                if ($baseCurrency === 'UAH' && $quoteCurrency === 'EUR') {
                    $rate = $coursesArr['EUR']['buy'];
                    $quoteCurrencyAmount = $in / $rate;
                }
                if ($baseCurrency === 'EUR' && $quoteCurrency === 'UAH') {
                    $rate = $coursesArr['EUR']['sale'];
                    $quoteCurrencyAmount = $in * $rate;
                }
                if ($baseCurrency === 'RUB' && $quoteCurrency === 'EUR') {
                    $rate = $coursesArr['EUR']['buy'];
                    $quoteCurrencyAmount = $in / $rate;
                }
                if ($baseCurrency === 'EUR' && $quoteCurrency === 'RUB') {
                    $rate = $coursesArr['EUR']['sale'];
                    $quoteCurrencyAmount = $in * $rate;
                }

                Exchange::create([
                    'baseCurrency' => $baseCurrency,
                    'quoteCurrency' => $quoteCurrency,
                    'user_id' => Auth()->user()->id,
                    'rate' => $rate,
                    'baseCurrencyAmount' => $in,
                    'quoteCurrencyAmount' => sprintf('%.2f', $quoteCurrencyAmount),

                ]);

                if ($quoteUserBalance === null) {
                    UserBalance::create([
                        'balance' => round($quoteCurrencyAmount, 2),
                        'currency' => $quoteCurrency,
                        'user_id' => Auth()->user()->id,
                    ]);
                } else {
                    $quoteUserBalance->balance += $quoteCurrencyAmount;
                    $quoteUserBalance->save();
                    Transactions::create([
                        'user_id' => Auth::user()->id,
                        'amount' => $quoteCurrencyAmount,
                        'type' => 'plus',
                        'currency' => $quoteCurrency
                    ]);
                }

                $baseUserBalance->balance -= $in;
                $baseUserBalance->save();

                Transactions::create([
                    'user_id' => Auth::user()->id,
                    'amount' => $in,
                    'type' => 'minus',
                    'currency' => $baseCurrency
                ]);

                return response()->json($quoteCurrencyAmount);
            }
        } else {
            return response()->json('Low balance' . ' '. $baseCurrency);
        }

    }

    public function cryptoExchanger(Request $request)
    {
        $baseCoin = $request->get('baseCoin');
        $baseCoinCurrency = $request->get('baseCoinCurrency');
        $quoteCoinCurrency = $request->get('quoteCoinCurrency');

        $file = Storage::disk()->get('CryptoCourses.json');
        $decodeCourses = json_decode($file, true);

        $baseUserBalance = UserBalance::where('user_id', Auth()->user()->id)->where('currency', $baseCoinCurrency)->first();
        $baseBalance = $baseUserBalance['balance'] ?? 0;
        $baseCurrency = $baseUserBalance['currency'] ?? 0;

        $quoteUserBalance = UserBalance::where('user_id', Auth()->user()->id)->where('currency', $quoteCoinCurrency)->first();

        if ($baseBalance >= $baseCoin) {
            if ($baseCoinCurrency !== $quoteCoinCurrency) {
                $rate = 0;
                $quoteCurrencyAmount = 0;
                if ($baseCoinCurrency === 'BTC' && $quoteCoinCurrency === 'USDT') {
                    $rate = $decodeCourses['BTCUSDT'];
                    $quoteCurrencyAmount = $baseCoin * $rate;
                }
                if($baseCoinCurrency === 'USDT' && $quoteCoinCurrency === 'BTC'){
                    $rate = $decodeCourses['BTCUSDT'];
                    $quoteCurrencyAmount = $baseCoin / $rate;
                }
                if ($baseCoinCurrency === 'BTC' && $quoteCoinCurrency === 'ETH') {
                    $rate = $decodeCourses['ETHBTC'];
                    $quoteCurrencyAmount = $baseCoin / $rate;
                }
                if($baseCoinCurrency === 'ETH' && $quoteCoinCurrency === 'BTC'){
                    $rate = $decodeCourses['ETHBTC'];
                    $quoteCurrencyAmount = $baseCoin * $rate;
                }
                if ($baseCoinCurrency === 'ETH' && $quoteCoinCurrency === 'USDT') {
                    $rate = $decodeCourses['ETHUSDT'];
                    $quoteCurrencyAmount = $baseCoin * $rate;
                }
                if($baseCoinCurrency === 'USDT' && $quoteCoinCurrency === 'ETH'){
                    $rate = $decodeCourses['ETHUSDT'];
                    $quoteCurrencyAmount = $baseCoin / $rate;
                }

                Exchange::create([
                    'baseCurrency' => $baseCurrency,
                    'quoteCurrency' => $quoteCoinCurrency,
                    'user_id' => Auth()->user()->id,
                    'rate' => $rate,
                    'baseCurrencyAmount' => $baseCoin,
                    'quoteCurrencyAmount' => sprintf('%.2f', $quoteCurrencyAmount),
                ]);

                if ($quoteUserBalance === null) {
                    UserBalance::create([
                        'balance' => round($quoteCurrencyAmount, 2),
                        'currency' => $quoteCoinCurrency,
                        'user_id' => Auth()->user()->id,
                    ]);
                } else {
                    $quoteUserBalance->balance += $quoteCurrencyAmount;
                    $quoteUserBalance->save();
                    Transactions::create([
                        'user_id' => Auth::user()->id,
                        'amount' => $quoteCurrencyAmount,
                        'type' => 'plus',
                        'currency' => $quoteCoinCurrency
                    ]);
                }

                $baseUserBalance->balance -= $baseCoin;
                $baseUserBalance->save();

                Transactions::create([
                    'user_id' => Auth::user()->id,
                    'amount' => $baseCoin,
                    'type' => 'minus',
                    'currency' => $baseCurrency
                ]);

                return response()->json($quoteCurrencyAmount);

            }
        }else{
            return response()->json('Low balance' .' '.$baseCoinCurrency );
        }
    }

}
