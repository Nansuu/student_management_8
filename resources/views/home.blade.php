@extends('layouts.app')
@php
$user = Auth::user();
$email=$user->email;
@endphp
@section('content')
<main>
    <h2 class="m-3" style="text-align: center;">ホーム</h2>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 col-md-7 col-sm-6 mx-auto">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    
                    @if (Cookie::has('email') ) 
                       <p style='text-align:center'>いらっしゃいませ {{ $user->name}}! 訪問ありがとうございます。</p>
                       @php
            Cookie::queue('email', $email, 300);
                    @endphp
                    @else 
                       <p style='text-align:center'>お帰りなさい {{ $user->name}} ! 再び訪問していただきありがとうございます。</p>
                    
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
