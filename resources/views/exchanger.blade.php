@extends('layouts.app')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!DOCTYPE html>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    </head>
    <html lang="en">
    <body>

    <div class="row">
        <div class="col s12">
            <ul class="tabs">
                <li class="tab col s6"><a href="#test1">Currency Exchanger </a></li>
                <li class="tab col s6"><a href="#test2">Crypto Currency Exchanger </a></li>
            </ul>
        </div>
    </div>
    <div id="test1" class="col s6 m8 l12">
        <div class="card-horizontal">
            <div class="card-content">
                <div class="row">
                    <div class="col s12 m8">
                        <div id="card-stats" class="pt-0">
                            <div class="row">
                                @foreach($internalBalance as $key => $balance)
                                    <div class="col s12 m6 l6">
                                        <div class=" animate fadeLeft">
                                            @if($balance['currency'] === 'UAH')
                                                <div class="card-content green white-text">
                                                    <p class="card-stats-title"><i class="material-icons">account_balance_wallet</i>
                                                        Внутренний баланс</p>
                                                    <h4 class="card-stats-number white-text">
                                                        {{$balance['balance'] . ' ' . $balance['currency']}}</h4>
                                                    <div id="invoice-line"></div>
                                                    @elseif($balance['currency'] === 'USD')
                                                        <div class="card-content cyan white-text">
                                                            <p class="card-stats-title"><i
                                                                    class="material-icons">account_balance_wallet</i>
                                                                Внутренний баланс</p>
                                                            <h4 class="card-stats-number white-text">
                                                                {{$balance['balance'] . ' ' . $balance['currency']}}</h4>
                                                            <div id="invoice-line"></div>
                                                        </div>
                                                    @elseif($balance['currency'] === 'RUB')
                                                        <div class="card-content red white-text">
                                                            <p class="card-stats-title"><i
                                                                    class="material-icons">account_balance_wallet</i>
                                                                Внутренний баланс</p>
                                                            <h4 class="card-stats-number white-text">
                                                                {{$balance['balance'] . ' ' . $balance['currency']}}</h4>
                                                            <div id="invoice-line"></div>
                                                        </div>

                                                    @elseif($balance['currency'] === 'EUR')
                                                        <div class="card-content blue white-text">
                                                            <p class="card-stats-title"><i
                                                                    class="material-icons">account_balance_wallet</i>
                                                                Внутренний баланс</p>
                                                            <h4 class="card-stats-number white-text">
                                                                {{$balance['balance'] . ' ' . $balance['currency']}}</h4>
                                                            <div id="invoice-line"></div>
                                                        </div>
                                                    @endif
                                                </div>
                                        </div>
                                        @endforeach
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h2 class="header">Конвертор</h2>
                <div class="card horizontal">
                    <div class="card-stacked">
                        <div class="card-content">
                            <label for="in">Колиичество</label>
                            <input id="in">
                            <label class="mr-sm-2" for="picker-status">Валюта</label>
                            <select class="custom-select mr-sm-2" id="baseCurrency">
                                <option value="UAH">UAH</option>
                                <option value="RUB">RUB</option>
                                <option value="USD">USD</option>
                                <option value="EUR">EUR</option>
                            </select>
                            <hr>
                            <i class="material-icons">arrow_downward</i>
                            <hr>
                            <label class="mr-sm-2" for="picker-status">Валюта</label>
                            <select class="custom-select mr-sm-2" id="quoteCurrency">
                                <option value="UAH">UAH</option>
                                <option value="RUB">RUB</option>
                                <option value="USD">USD</option>
                                <option value="EUR">EUR</option>
                            </select>
                            <label class="mr-sm-2" for="result">Результат</label>
                            <input id="result">
                            <button class="btn waves-effect waves-light" type="button"
                                    name="action" id="save">Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="test2" class="col s6 m8 l12">
        <ul>
            @foreach($internalBalance as $key => $balance)
                @if($balance['currency'] !== 'USD' && $balance['currency'] !== 'UAH' && $balance['currency'] !== 'EUR')
            <li>
                {{$balance['balance'] . ' ' . $balance['currency']}}
            </li>
                @endif
            @endforeach
        </ul>
        <h2 class="header">Crypto Конвертор</h2>
        <div class="card horizontal">
            <div class="card-stacked">
                <div class="card-content">
                    <label for="baseCoin">Колиичество</label>
                    <input id="baseCoin">
                    <label class="mr-sm-2" for="picker-status">Монета</label>
                    <select class="custom-select mr-sm-2" id="baseCoinCurrency">
                        <option value="BTC">BTC</option>
                        <option value="USDT">USDT</option>
                        <option value="ETH">ETH</option>
                    </select>
                    <hr>
                    <i class="material-icons">arrow_downward</i>
                    <hr>
                    <label class="mr-sm-2" for="picker-status">Монета</label>
                    <select class="custom-select mr-sm-2" id="quoteCoinCurrency">
                        <option value="BTC">BTC</option>
                        <option value="USDT">USDT</option>
                        <option value="ETH">ETH</option>
                    </select>
                    <label class="mr-sm-2" for="result">Результат</label>
                    <input id="cryptoresult">
                    <button class="btn waves-effect waves-light" type="button"
                            name="action" id="cryptoSave">Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
    </body>
    </html>

    <script>
        $(document).ready(function () {
            $('.tabs').tabs();

            $('#save').on('click', function () {
                var data = {
                    in: $('#in').val(),
                    baseCurrency: $('#baseCurrency').val(),
                    quoteCurrency: $('#quoteCurrency').val(),
                }
                var ajax = $.ajax({
                    headers:
                        {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    type: "POST",
                    url: "{{route('exchanger')}}",
                    data: data,
                    success: function (success) {
                        $('#result').val(success)
                        setTimeout('', 6000);
                        window.location.reload();
                    }


                })
            });
            $('#cryptoSave').on('click', function () {
                var crtyptoData = {
                    baseCoin: $('#baseCoin').val(),
                    baseCoinCurrency: $('#baseCoinCurrency').val(),
                    quoteCoinCurrency: $('#quoteCoinCurrency').val(),
                }
                var cryptoAjax = $.ajax({
                    headers:
                        {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    type: "POST",
                    url: "{{route('crypto.exchanger')}}",
                    data: crtyptoData,
                    success: function (success) {
                        $('#cryptoresult').val(success)
                        setTimeout('', 6000);
                        window.location.reload();
                    }


                })
            });

        });
    </script>
@endsection

