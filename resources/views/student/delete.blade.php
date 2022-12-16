@extends('layouts.app')
@section('content')
    <div class="container">

        <main>
            <div class="container mt-5">
                <h2 style="margin-bottom: 30px; text-align: center;">学生一覧削除</h2>
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
                <table id="stuTable" class="table table-bordered table-striped dt-responsive " style="width:100%">
                    <thead style="background-color: #575013; color: white;">
                        <tr>
                            <th>番号</th>
                            <th>ロール番号</th>
                            <th>氏名</th>
                            <th>年齢</th>
                            <th>登録日</th>
                            <th>削除</th>
                            {{-- @if (Request::is('students/delete')) --}}
                            {{-- @endif --}}

                        </tr>
                    </thead>
                    {{-- <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td>

                                </td>
                                <td>
                                    {{ $student->roll_no }}
                                </td>
                                <td>
                                    {{ $student->student_name }}
                                </td>
                                <td>
                                    {{ $student->age }}
                                </td>
                                <td>
                                    {{ $student->reg_date }}
                                </td>
                            </td>
                            <td>
                            </tr>
                        @endforeach
                    </tbody> --}}

                </table>
            </div>
        </main>
    </div>
    <!--delete student confirmation-->
    <div class="modal fade" id="deletemodal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">学生を削除する</h5>
                </div>
                <form action="{{ route('deleteById') }}" method="post">
                    @csrf
                    @method('delete')

                    <div class="modal-body">
                        <input type="text" name="stu_id" id="stu_id" value="" hidden>
                        <h4>削除してもよろしいですか?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                        <button type="submit" id="deletebtn" name="delete_student" class="btn btn-danger">削除</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            let $modal = $('#deletemodal');
            $('#stuTable').on('click', '.del_', function(e) {
                e.preventDefault();
                let stu_id = $(this).attr('data-id');
                $modal.modal('show');
                $("#stu_id").val(stu_id);
            });
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
                searching: false,
                language: {
                    "zeroRecords": "検索データがありません。",
                    "infoEmpty": "0 エントリ中 0 から 0 を表示",
                    "infoFiltered":   "(合計 _MAX_ 件のエントリからフィルタリング)",
                    "info": "表示中のページ _PAGE_ の _PAGES_",
                    "lengthMenu": "表示 _MENU_ エントリ",
                    paginate: {
                        previous: '前へ',
                        next: '次へ'
                    },
                },
                ajax: {
                    url: "{{ route('fetchStudentListDelete') }}",
                    data: function(data) {
                        data.search = $('#searchInput').val();
                    }
                },
                columns: [{
                        data: 'SrNo',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        searchable: false,
                        sortable: false,
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
                    {
                        data: 'action',
                        searchable: false,
                        sortable: false
                    },

                ]
            });
        });
    </script>
@endsection
