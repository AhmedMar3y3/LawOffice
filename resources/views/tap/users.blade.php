@extends('layout')

@section('main')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow rounded-4">
                    <div class="card-header bg-primary text-white rounded-top-4">
                        <h3 class="mb-0">📌 المستخدمين</h3>
                    </div>
                    <div class="card-body">
                        <p class="fs-4 text-center">
                            {{ $users }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
