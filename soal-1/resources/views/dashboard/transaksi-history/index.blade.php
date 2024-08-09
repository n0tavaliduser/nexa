@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-3">Transaksi Penjualan</h1>
            </div>
        </div>

        <h6 class="fw-bold">Filter Tanggal Transaksi</h6>
        <form method="GET" action="{{ route('transaksi_h.index') }}">
            <div class="row">
                <div class="col-md-9">
                    <div class="row">
                        <div class="form-group col-md-4 mb-3">
                            <input type="date" id="from_date" name="from_date" value="{{ request('from_date') }}" class="form-control" placeholder="From Date">
                        </div>
                        <div class="form-group col-md-4 mb-3">
                            <input type="date" id="to_date" name="to_date" value="{{ request('to_date') }}" class="form-control" placeholder="To Date">
                        </div>
                        <div class="col-md-4 mb-3">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3 text-md-end">
                    <a href="{{ route('transaksi_h.create') }}" class="btn btn-primary w-100">Tambah Transaksi</a>
                </div>
            </div>
        </form>

        <div class="row mt-4">
            <div class="col-12">
                @include('components.alert')
            </div>
            <div class="col-12">
                <table class="table table-hover" id="transaksiHTable">
                    <thead>
                        <tr>
                            <th>Nomor Transaksi</th>
                            <th>Nama Customer</th>
                            <th>Tanggal Transaksi</th>
                            <th>Total Transaksi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksiHs as $transaksiH)
                            <tr>
                                <td><a href="{{ route('transaksi_h.edit', $transaksiH->id) }}">{{ $transaksiH->nomor_transaksi }}</a></td>
                                <td>{{ $transaksiH->ms_customer?->nama }}</td>
                                <td>{{ $transaksiH->tanggal_transaksi->format('F, d Y') }}</td>
                                <td>{{ number_format($transaksiH->total_transaksi, 2, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('transaksi_h.edit', $transaksiH->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $transaksiH->id }}">Hapus</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @foreach ($transaksiHs as $transaksiH)
                <div class="modal fade" id="deleteModal{{ $transaksiH->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $transaksiH->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $transaksiH->id }}">Konfirmasi Hapus</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Apakah Anda yakin ingin menghapus transaksi ini?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <form action="{{ route('transaksi_h.destroy', $transaksiH->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            {{ $transaksiHs->withQueryString()->links() }}
        </div>
    </div>
@endsection

