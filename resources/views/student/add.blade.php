@extends('layouts.app')
@section('content')
    <main>
        <div class="container-fluid">
            <div class="row ">
                <div class="col-md-6 mx-auto">
                    <div class="card m-5">
                        @if (isset($students))
                            <form class="studentForm" method="post" action="{{ route('update')}}">
                                @method('PUT')
                                @csrf
                                <div class="card-header text-light" style="background-color:#A39624;">
                                    <h4>学生を更新</h4>
                                </div>
                            @else
                                <form class="studentForm" method="post" action="{{ route('store') }}">
                                    @csrf
                                    <div class="card-header text-light" style="background-color:#A39624;">
                                        <h4>新しい学生を作成</h4>
                                    </div>
                        @endif

                        <div class="card-body bg-light">
                            <div id="message"></div>
                            <div class="form-group mt-3">
                                <label>ロール番号</label>
                                @if (isset($students))
                                <select class="form-select" name="roll_no" id="roll_no">
                                    <option value="" selected disabled>選択</option>
                                    @foreach($students as $student)
                                    <option value="{{ $student['id']}}"  {{ old('roll_no') == $student['id'] ? 'selected' : '' }}>
                                        {{ $student['roll_no'] }}
                                    </option>
                                    @endforeach
                                </select>
                                @else
                                <input type="text" name="roll_no" id="roll_no"
                                class="form-control  @error('roll_no') is-invalid @enderror"
                                value="{{ old('roll_no')}}">
                            @endif
                            @error('roll_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mt-3">
                                <label>氏名</label>
                                <input type="text" name="student_name" id="student_name"
                                    class="form-control  @error('student_name') is-invalid @enderror"
                                    value="{{ old('student_name')}}">
                                @error('student_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group my-3">
                                <label>年齢</label>
                                <input type="text" name="age"
                                    class="form-control  @error('age') is-invalid @enderror" id="age"
                                    value="{{ old('age')}}">
                                @error('age')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer bg-light d-flex justify-content-center">
                            @csrf
                            <input type="submit" class="btn text-light mx-1" id="submitbtn"
                                value=" @if (isset($student)) 更新@else 登録 @endif"
                                style="background-color:#A39624;">
                            <input type="submit" class="btn btn-secondary mx-1" id="clearbtn" value="キャンセル">
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        $(document).ready(function() {
            $("#roll_no").on("change", function() {
                var id = this.value;
                $.ajax({
                    url: "/students/fetch-student/" + id,
                    type: "GET",
                    dataType: 'json',
                    success: function(result) {
                        $.each(result, function(key, value) {
                            $("#student_name").val(value.student_name);
                            $("#age").val(value.age);
                        });
                    },
                });
            });
            $(document).on("click", "#clearbtn", function(e) {
                e.preventDefault();
                $(".studentForm")[0].reset();
                $("#message").html("");
                $("span").html("");
                $("#roll_no").val("");
                $("#student_name").val("");
                $("#age").val("");
                $(".invalid-feedback").hide();
                $(".form-group").find('.is-invalid').removeClass("is-invalid");
            });
            $('form input[type=text]').focus(function() {
                $(this).siblings(".invalid-feedback").hide();
                $(this).parent(".form-group").find('.is-invalid').removeClass("is-invalid");
            });
        });
    </script>
@endsection
