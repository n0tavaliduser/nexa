@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-3">Daftar Customer</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <a href="{{ route('ms_customer.create') }}" class="btn btn-primary">Tambah Customer</a>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                @include('components.alert')
            </div>
            <div class="col-12">
                <table class="table table-hover" id="customerTable">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>No. HP</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($msCustomers as $msCustomer)
                            <tr>
                                <td>{{ $msCustomer->nama }}</td>
                                <td>{{ $msCustomer->alamat }}</td>
                                <td>{{ $msCustomer->phone }}</td>
                                <td>
                                    <a href="{{ route('ms_customer.edit', $msCustomer->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $msCustomer->id }}">Hapus</button>

                                    <!-- Delete Confirmation Modal -->
                                    <div class="modal fade" id="deleteModal{{ $msCustomer->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $msCustomer->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $msCustomer->id }}">Konfirmasi Hapus</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah Anda yakin ingin menghapus customer ini?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <form action="{{ route('ms_customer.destroy', $msCustomer->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $msCustomers->withQueryString()->links() }}
        </div>
    </div>
@endsection
