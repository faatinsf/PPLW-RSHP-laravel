@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <!-- ambil sessi yang sudah disimpan saat login -->
                <div class="card-header">{{ __('Dashboard') }} – {{ session('user_name') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in! ') }} {{ session('user_role_name') }}

                    <div class="mt-4">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <a href="{{ route('admin.jenis-hewan.index') }}" class="btn btn-primary btn-block">
                                    <i class="fas fa-paw"></i> Jenis Hewan
                                </a>
                            </div>
                            <div class="col-md-12 mb-2">
                                <a href="{{ route('admin.pemilik.index') }}" class="btn btn-success btn-block">
                                    <i class="fas fa-users"></i> Pemilik
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
