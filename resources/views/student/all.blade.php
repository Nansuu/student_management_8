@extends('layouts.app')
@section('content')
    <div class="container">

        <main>
            <div class="container mt-5">
                <h2 style="margin-bottom: 30px; text-align: center;">学生一覧</h2>
                @if (session('info'))
                    <div class="alert alert-info">
                        {{ session('info') }}
                    </div>
                @endif
                <div class="input-group mb-3 dflex justify-content-end">
                    <input type='text' id="searchInput" class='dateFilter' name='searchInput'>
                    <i class="icon fa fa-calendar input-group-text text-white" aria-hidden="true"
                        style="background-color:#575013"></i>
                </div>
                <table id="stuTable" class="table table-bordered table-striped dt-responsive " id="mytable"
                    style="width:100%">
                    <thead style="background-color: #575013; color: white;">

                        <tr>
                            <th>番号</th>
                            <th>ロール番号</th>
                            <th>氏名</th>
                            <th>年齢</th>
                            <th>登録日</th>

                        </tr>
                    </thead>
                </table>
            </div>
        </main>
    </div>
    <script>
        $(document).ready(function() {
            $(".dateFilter").datepicker({
                dateFormat: "yy-mm-dd",
                maxDate: new Date(),
            });
            $(".icon").on("click", function() {
                $(".dateFilter").focus();
            });
            $('#searchInput').change(function() {
                stuTable.draw();
            });
            var stuTable = $('#stuTable').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                render: function(data, type, row) {
                    return '<button class="btn btn-primary" data-toggle="modal" data-id="' + data.id +
                        '" data-title="' + data.id + '" data-target="#deletemodal">Details</button>';
                },
                language: {
                    "zeroRecords": "検索データがありません。",
                    "infoEmpty": "0 エントリ中 0 から 0 を表示",
                    "infoFiltered": "(合計 _MAX_ 件のエントリからフィルタリング)",
                    "info": "表示中のページ _PAGE_ の _PAGES_",
                    "lengthMenu": "表示 _MENU_ エントリ",
                    paginate: {
                        previous: '前へ',
                        next: '次へ'
                    },
                },
                ajax: {
                    url: "{{ route('fetchStudentList') }}",
                    data: function(data) {
                        data.search = $('#searchInput').val();
                    }
                },
                columns: [{
                        data: 'SrNo', //for number of rows
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'roll_no'
                    },
                    {
                        data: 'student_name'
                    },
                    {
                        data: 'age'
                    },
                    {
                        data: 'reg_date'
                    },

                ]
            });

        });
    </script>
@endsection
