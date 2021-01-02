<head>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://nightly.datatables.net/css/jquery.dataTables.css" rel="stylesheet" type="text/css"/>


</head>
<div class="main">
    <div class="col s12 m8 l12">
        <div class="users-list-filter">
            <div class="card-panel">
                <div class="row">
                    <div class="col s12 m6 l2">
                        <label class="mr-sm-2" for="picker-user-id">UserIDs</label>
                        <select class="custom-select mr-sm-2" id="picker-user-id">
                            @foreach($users as $key => $user)
                                <option value="{{$user['id']}}">{{$user['id'] . ' ' . $user['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l2">
                        <label class="mr-sm-2" for="picker-date-from">Date From</label>
                        <input type="text" id="picker-date-from" class="date-from">
                    </div>
                    <div class="col s12 m6 l2">
                        <label class="mr-sm-2" for="picker-date-to">Date To</label>
                        <input type="text" id="picker-date-to" class="date-to">
                    </div>

                    <div class="col s12 m6 l2 display-flex align-items-center show-btn">
                        <button id="today" type="submit"
                                class="btn btn-block indigo waves-effect waves-light date-button">
                            Сегодня

                        </button>
                    </div>
                    <div class="col s12 m6 l2 display-flex align-items-center show-btn">
                        <button id="yesterday" type="submit"
                                class="btn btn-block indigo waves-effect waves-light date-button">
                            Вчера
                        </button>
                    </div>
                    <div class="col s12 m6 l2 display-flex align-items-center show-btn">
                        <button id="week" type="submit"
                                class="btn btn-block indigo waves-effect waves-light date-button">
                            За
                            неделю
                        </button>
                    </div>
                    <div class="col s12 m6 l2 display-flex align-items-center show-btn">
                        <button id="month" type="submit"
                                class="btn btn-block indigo waves-effect waves-light date-button">
                            За
                            месяц
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="users-list-wrapper">
            <div class="card users-list-table">
                <div class="card-content dataTables_length">
                    <!-- datatable start -->
                    <div class="responsive-table">
                        <table id="user-list-datatable" class="display" style="width:100%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>currency</th>
                                <th>created_at</th>
                                <th>updated_at</th>
                                <th>user_id</th>
                                <th>amount</th>
                                <th>type</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"
        integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA=="
        crossorigin="anonymous"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
        integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
        crossorigin="anonymous"></script>
<script>

    $(document).ready(function () {
        $.noConflict();

        $('#picker-date-from').datepicker({
            autoClose: true,
            format: 'dd.mm.yyyy',
            container: 'body',
            onDraw: function onDraw() {
                $('.datepicker-container').find('.datepicker-select').addClass('browser-default');
                $(".datepicker-container .select-dropdown.dropdown-trigger").remove();
            }
        });

        $('#picker-date-to').datepicker({
            autoClose: true,
            format: "dd.mm.yyyy",
            container: 'body',
            onDraw: function onDraw() {
                $('.datepicker-container').find('.datepicker-select').addClass('browser-default');
                $(".datepicker-container .select-dropdown.dropdown-trigger").remove();
            }
        });

        $('.date-from').val(moment().subtract(1, 'day').format('DD.MM.YYYY'));

        var table = $('#user-list-datatable').DataTable({
            processing: true,
            serverSide: true,
            bPaginate: false,
            bLengthChange: false,
            bFilter: true,
            bInfo: false,
            bAutoWidth: false,
            searching: false,
            language: {
                processing: '<div class="progress">\n' +
                    '      <div class="indeterminate"></div>\n' +
                    '    </div>'
            },
            ajax: {
                url: "{{route('transactionsDatatables')}}",
                data: {
                    user_id: function () {
                        return $('#picker-user-id').val()
                    },
                    date_from: function () {
                        return $('.date-from').val()
                    },
                    date_to: function () {
                        return $('.date-to').val()
                    },
                },

            },
            columns: [
                {data: 'id'},
                {data: 'currency'},
                {data: 'created_at'},
                {data: 'updated_at'},
                {data: 'user_id'},
                {data: 'amount'},
                {data: 'type'},
            ],
            columnDefs: [
                {
                    targets: [2],
                    createdCell: function (td, cellData, rowData, row, col) {
                        if (rowData) {
                            $(td).addClass('green  lighten-5 green-text text-accent-4');
                        }
                    }
                }, {
                    targets: [3],
                    createdCell: function (td, cellData, rowData, row, col) {
                        if (rowData) {
                            $(td).addClass('orange lighten-5 orange-text text-accent-4');
                        }
                    }
                },
            ]
        });

        $('.date-button, #clear').on('click', function () {
            if ($(this).attr('id') === 'today') {
                $('.date-from').val(moment().format('DD.MM.YYYY'));
                $('.date-to').val(moment().format('DD.MM.YYYY'));
            } else if ($(this).attr('id') === 'yesterday') {
                $('.date-from').val(moment().subtract(1, 'day').format('DD.MM.YYYY'));
                $('.date-to').val(moment().subtract(1, 'day').format('DD.MM.YYYY'));
            } else if ($(this).attr('id') === 'week') {
                if (($('date-to') !== ' ')) {
                    $('.date-to').val('')
                    $('.date-from').val(moment().subtract(7, 'day').format('DD.MM.YYYY'));
                }
            } else if ($(this).attr('id') === 'month') {
                if (($('date-to') !== ' ')) {
                    $('.date-to').val('')
                    $('.date-from').val(moment().subtract(1, 'month').format('DD.MM.YYYY'));
                }
            }
            table.ajax.reload();

        });

        $('.date-button').on('change', '#picker-date-from, #picker-date-to', function (e) {
            table.ajax.reload();
        });

        table.ajax.reload();
    });
</script>
