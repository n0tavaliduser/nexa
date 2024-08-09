@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-3">Create Transaksi Penjualan</h1>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('transaksi_h.store') }}">
            @csrf
            <div class="row">
                <div class="col-12 mb-3">
                    <h4 class="fw-bold">Nomor Transaksi</h4>
                    <h6>{{ $nomorTransaksi }}</h6>
                    <input type="hidden" name="nomor_transaksi" value="{{ $nomorTransaksi }}">
                    @error('nomor_transaksi')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-12 mb-3">
                    <div class="row">
                        <div class="col-3">
                            <h4 class="fw-bold">Tanggal Transaksi</h4>
                            <input type="date" name="tanggal_transaksi" class="form-control mb-3">
                            @error('tanggal_transaksi')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr>

                <div class="col-12 mb-3">
                    <div class="row">
                        <div class="col-3">
                            <h4 class="fw-bold">Pilih Customer</h4>
                            <select name="customer_id" class="form-select mb-3" id="customerSelect">
                                <option value="">Pilih Customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->nama }}</option>
                                @endforeach
                                <option value="new">Customer Baru</option>
                            </select>
                            @error('customer_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="fw-bold">Data Customer</h4>
                        </div>
                        <div class="col-3">
                            <input type="text" name="nama_customer" class="form-control" placeholder="Nama Customer" readonly>
                            @error('nama_customer')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-3">
                            <input type="text" name="alamat" class="form-control" placeholder="Alamat" readonly>
                            @error('alamat')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-3">
                            <input type="text" name="phone" class="form-control" placeholder="No. HP" readonly>
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr>

                <div class="col-12 mb-3">
                    <h4 class="fw-bold">Pilih Barang</h4>
                    @php
                        try {
                            $client = new \GuzzleHttp\Client();
                            $loginResponse = $client->post('http://gmedia.bz/DemoCase/auth/login', [
                                'json' => [
                                    'username' => 'admindata',
                                    'password' => '12345',
                                ],
                                'headers' => [
                                    'Client-Service' => 'gmedia-recruitment',
                                    'Auth-Key' => 'demo-admin',
                                ],
                            ]);

                            $loginData = json_decode($loginResponse->getBody()->getContents(), true);

                            if (!isset($loginData['response']['token'])) {
                                throw new Exception('Token not found in login response');
                            }

                            $token = $loginData['response']['token'];

                            $barangResponse = $client->post('http://gmedia.bz/DemoCase/main/list_barang', [
                                'headers' => [
                                    'Authorization' => 'Bearer ' . $token,
                                    'Client-Service' => 'gmedia-recruitment',
                                    'Auth-Key' => 'demo-admin',
                                    'User-Id' => '1',
                                    'Token' => '8godoajVqNNOFz21npycK6iofUgFXl1kluEJt/WYFts9C8IZqUOf7rOXCe0m4f9B',
                                ],
                            ]);

                            $barangs = json_decode($barangResponse->getBody()->getContents(), true)['response'] ?? [];
                        } catch (Exception $e) {
                            $error = 'Error fetching barang list: ' . $e->getMessage();
                            $barangs = [];
                        }
                    @endphp

                    <div class="row">
                        <div class="form-group col-3">
                            <select name="barang_id" class="form-select mb-3">
                                @foreach ($barangs as $barang)
                                    <option value="{{ $barang['kd_barang'] }}">{{ $barang['nama_barang'] }}</option>
                                @endforeach
                            </select>
                            @error('barang_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            @if (isset($error))
                                <small class="text-danger">{{ $error }}</small>
                            @endif
                        </div>

                        <div class="col-3">
                            <input type="text" name="qty" class="form-control" placeholder="Qty" id="qty" oninput="calculateSubtotal()">
                            @error('qty')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-3">
                            <input type="text" name="subtotal" class="form-control" placeholder="Subtotal" id="subtotal">
                            @error('subtotal')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-3">
                            <button type="button" class="btn btn-primary" onclick="tambahBarang()">Tambah Barang</button>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="table">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <h4 class="fw-bold">Total</h4>
                    <h6 id="total"></h6>
                    <input type="hidden" name="total" class="form-control" id="totalInput">
                    @error('total')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3 text-md-start">
                    <button type="submit" class="btn btn-primary">Create Transaksi</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal for New Customer -->
    <div class="modal fade" id="newCustomerModal" tabindex="-1" aria-labelledby="newCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newCustomerModalLabel">Tambah Customer Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="newCustomerForm" method="POST" action="{{ route('ms_customer.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">No. HP</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelector('select[name="customer_id"]').addEventListener('change', function() {
            var selectedCustomer = this.options[this.selectedIndex];
            var customerData = @json($customers);

            if (selectedCustomer.value === 'new') {
                var newCustomerModal = new bootstrap.Modal(document.getElementById('newCustomerModal'));
                newCustomerModal.show();
            } else {
                var customer = customerData.find(c => c.id == selectedCustomer.value);

                if (customer) {
                    document.querySelector('input[name="nama_customer"]').value = customer.nama;
                    document.querySelector('input[name="alamat"]').value = customer.alamat;
                    document.querySelector('input[name="phone"]').value = customer.phone;
                }
            }
        });
    </script>

    <script>
        function calculateSubtotal() {
            var qty = document.getElementById('qty').value;
            var subtotal = qty * 1000;
            document.getElementById('subtotal').value = subtotal;
        }

        function tambahBarang() {
            var barangSelect = document.querySelector('select[name="barang_id"]');
            var barangText = barangSelect.options[barangSelect.selectedIndex].text;
            var barangValue = barangSelect.value;
            var qty = document.getElementById('qty').value;
            var subtotal = document.getElementById('subtotal').value;

            if (qty && subtotal) {
                var table = document.querySelector('.table tbody');
                var rowCount = table.rows.length;
                var row = table.insertRow(rowCount);

                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
                var cell5 = row.insertCell(4);

                cell1.innerHTML = rowCount + 1;
                cell2.innerHTML = barangText + '<input type="hidden" name="kd_barang[]" value="' + barangValue + '"><input type="hidden" name="nama_barang[]" value="' + barangText + '">';
                cell3.innerHTML = qty + '<input type="hidden" name="qty[]" value="' + qty + '">';
                cell4.innerHTML = subtotal + '<input type="hidden" name="subtotal[]" value="' + subtotal + '">';
                cell5.innerHTML = '<div class="d-flex gap-1"><button type="button" class="btn btn-sm btn-danger" onclick="hapusBarang(this)">Hapus</button><button type="button" class="btn btn-sm btn-warning" onclick="editBarang(this)">Edit</button></div>';

                // Reset form
                document.getElementById('qty').value = '';
                document.getElementById('subtotal').value = '';
                barangSelect.selectedIndex = 0;

                // Update total
                updateTotal();
            }
        }

        function hapusBarang(button) {
            var row = button.parentNode.parentNode.parentNode;
            row.parentNode.removeChild(row);

            // Update total
            updateTotal();
        }

        function editBarang(button) {
            var row = button.parentNode.parentNode.parentNode;
            var barangText = row.cells[1].innerText;
            var qty = row.cells[2].innerText;
            var subtotal = row.cells[3].innerText;

            var barangSelect = document.querySelector('select[name="barang_id"]');
            for (var i = 0; i < barangSelect.options.length; i++) {
                if (barangSelect.options[i].text === barangText) {
                    barangSelect.selectedIndex = i;
                    break;
                }
            }

            document.getElementById('qty').value = qty;
            document.getElementById('subtotal').value = subtotal;

            // Remove the row being edited
            row.parentNode.removeChild(row);

            // Update total
            updateTotal();
        }

        function updateTotal() {
            var table = document.querySelector('.table tbody');
            var rows = table.rows;
            var total = 0;

            for (var i = 0; i < rows.length; i++) {
                total += parseFloat(rows[i].cells[3].innerHTML);
            }

            document.getElementById('total').innerHTML = total;
            document.getElementById('totalInput').value = total;
        }
    </script>
@endsection
