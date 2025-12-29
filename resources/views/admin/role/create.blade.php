@extends('layouts.lte.admin.main')
@section('title', 'Tambah Role')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6"><h3 class="mb-0">Tambah Role</h3></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('role.index') }}">Role</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header"><h3 class="card-title">Form Set Role User</h3></div>
                    <form action="{{ route('role.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show">
                                <h5><i class="bi bi-exclamation-triangle"></i> Error!</h5>
                                <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif
                            <div class="mb-3">
                                <label for="iduser" class="form-label">Pilih User <span class="text-danger">*</span></label>
                                <select class="form-select @error('iduser') is-invalid @enderror" 
                                        id="iduser" name="iduser" required autofocus>
                                    <option value="">-- Pilih User --</option>
                                    @foreach($users as $user)
                                     <option value="{{ $user->iduser }}" {{ old('iduser') == $user->iduser ? 'selected' : '' }}>
                                        {{ $user->nama }} ({{ $user->email }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('iduser')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <small class="form-text text-muted">Hanya user yang belum memiliki role</small>
                            </div>
                            <div class="mb-3">
                                <label for="idrole" class="form-label">Pilih Role <span class="text-danger">*</span></label>
                                <select class="form-select @error('idrole') is-invalid @enderror" 
                                        id="idrole" name="idrole" required>
                                    <option value="">-- Pilih Role --</option>
                                    @foreach(\DB::table('role')->get() as $role)
                                    <option value="{{ $role->idrole }}" {{ old('idrole') == $role->idrole ? 'selected' : '' }}>
                                        {{ $role->nama_role }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('idrole')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> Set Role</button>
                            <a href="{{ route('role.index') }}" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection