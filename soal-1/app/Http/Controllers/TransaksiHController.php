<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransaksiHRequest;
use App\Http\Requests\UpdateTransaksiHRequest;
use App\Models\Counter;
use App\Models\MsCustomer;
use App\Models\TransaksiD;
use App\Models\TransaksiH;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TransaksiHController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $transaksiHs = TransaksiH::query()
            ->when($request->from_date, function ($query, $from_date) {
                return $query->where('tanggal_transaksi', '>=', $from_date);
            })
            ->when($request->to_date, function ($query, $to_date) {
                return $query->where('tanggal_transaksi', '<=', $to_date);
            })
            ->orderBy('tanggal_transaksi', 'desc')
            ->paginate(10);

        return view('dashboard.transaksi-history.index', compact('transaksiHs') );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = MsCustomer::all();
        $nomorTransaksi = $this->generateNomorTransaksi();

        return view('dashboard.transaksi-history.create', compact('customers', 'nomorTransaksi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransaksiHRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $counterObj = new CounterController();
            $counterObj->store();

            $transaksiHData = [
                'nomor_transaksi' => $data['nomor_transaksi'],
                'tanggal_transaksi' => $data['tanggal_transaksi'],
                'customer_id' => $data['customer_id'],
                'total_transaksi' => $data['total'],
            ];
            $transaksiH = TransaksiH::make($transaksiHData);
            $transaksiH->saveOrFail();

            foreach ($data['kd_barang'] as $key => $value) {
                if ($data['qty'][$key] != null && $data['subtotal'][$key] != null) {   
                    $transaksiDData = [
                        'transaksi_h_id' => $transaksiH->id,
                        'kd_barang' => $data['kd_barang'][$key],
                        'qty' => $data['qty'][$key],
                        'subtotal' => $data['subtotal'][$key],
                        'nama_barang' => $data['nama_barang'][$key],
                    ];

                    $transaksiD = TransaksiD::make($transaksiDData);
                    $transaksiD->saveOrFail();
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('transaksi_h.index')->with(['error' => 'Transaksi History created failed']);
        }

        return redirect()->route('transaksi_h.index')->with(['success' => 'Transaksi History created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(TransaksiH $transaksiH)
    {
        return view('dashboard.transaksi-history.show', compact('transaksiH'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransaksiH $transaksiH)
    {
        $customers = MsCustomer::all();

        return view('dashboard.transaksi-history.edit', compact('transaksiH', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransaksiHRequest $request, TransaksiH $transaksiH)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();


            $transaksiH->fill([
                'nomor_transaksi' => $data['nomor_transaksi'],
                'tanggal_transaksi' => $data['tanggal_transaksi'],
                'customer_id' => $data['customer_id'],
                'total_transaksi' => $data['total'],
            ]);
            $transaksiH->saveOrFail();

            TransaksiD::where('transaksi_h_id', $transaksiH->id)->delete();

            foreach ($data['kd_barang'] as $key => $value) {
                if ($data['qty'][$key] != null && $data['subtotal'][$key] != null) {   
                    $transaksiDData = [
                        'transaksi_h_id' => $transaksiH->id,
                        'kd_barang' => $data['kd_barang'][$key],
                        'qty' => $data['qty'][$key],
                        'subtotal' => $data['subtotal'][$key],
                        'nama_barang' => $data['nama_barang'][$key],
                    ];

                    $transaksiD = TransaksiD::make($transaksiDData);
                    $transaksiD->saveOrFail();
                }
            }

            DB::commit();
            return redirect()->route('transaksi_h.index')->with(['success' => 'Transaksi History updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('transaksi_h.index')->with(['error' => 'Transaksi History update failed']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransaksiH $transaksiH)
    {
        DB::beginTransaction();

        try {
            $transaksiH->transaksi_ds()->delete();

            $transaksiH->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('transaksi_h.index')->with(['error' => 'Transaksi History deleted failed' . $e->getMessage()]);
        }

        return redirect()->route('transaksi_h.index')->with(['success' => 'Transaksi History deleted successfully']);
    }

    /**
     * Generate nomor transaksi
     */
    public function generateNomorTransaksi(Counter $counter = null)
    {   
        // format : SO/{tahun dari tanggal transaksi | YYYY}-{bulan dari tanggal transaksi | MM}/{counter | 0001}
        if ($counter == null) {
            $nomorTransaksi = 'SO/' . Carbon::now()->format('Y') . '-' . Carbon::now()->format('m') . '/' . str_pad(1, 4, '0', STR_PAD_LEFT);
        } else {   
            $nomorTransaksi = 'SO/' . Carbon::create($counter->tahun, $counter->bulan, 1)->format('Y') . '-' . Carbon::create($counter->tahun, $counter->bulan, 1)->format('m') . '/' . str_pad($counter->count(), 4, '0', STR_PAD_LEFT);
        }

        return $nomorTransaksi;
    }
}
