@extends('layout')

@section('main')
<div class="container">
    <h1>تفاصيل المكتب</h1>
    <div class="mb-3">
        <h4>الاسم:</h4> <span>{{ $user->name }}</span>
    </div>
    <div class="mb-3">
        <h4>رقم الكارنيه :</h4> <span>{{ $user->card_number }}</span>
    </div>
    <div class="mb-3">
        <h4>الهاتف:</h4> <span>{{ $user->phone }}</span>
    </div>
    <div class="mb-3">
        <h4>الايميل:</h4> <span>{{ $user->email }}</span>
    </div>
    <div class="mb-3">
        @if($user->image)
            <p><strong>الصورة:</strong></p>
            <img src="{{ asset('/public/users/' . basename($user->image)) }}" alt="Image" style="width: 100px;">
        @endif
    </div>
</div>
  
<a href="{{ route('offices.index') }}" class="btn btn-secondary">العودة إلى القائمة</a>
@endsection
