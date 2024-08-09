@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-3">Tambah Customer</h1>
            </div>
        </div>

        @include('components.alert')

        <form method="POST" action="{{ route('ms_customer.store') }}">
            @csrf
            <div class="row">
                <div class="col-12 mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" required>
                    @error('nama')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-12 mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" name="alamat" class="form-control" required>
                    @error('alamat')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-12 mb-3">
                    <label for="phone" class="form-label">No. HP</label>
                    <input type="text" name="phone" class="form-control" required>
                    @error('phone')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3 text-md-start">
                    <button type="submit" class="btn btn-primary">Tambah Customer</button>
                </div>
            </div>
        </form>
    </div>
@endsection
