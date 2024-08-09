<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMsCustomerRequest;
use App\Http\Requests\UpdateMsCustomerRequest;
use App\Models\MsCustomer;
use App\Models\TransaksiH;
use Illuminate\Http\Request;

class MsCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $msCustomers = MsCustomer::query()
            ->when($request->search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('dashboard.customer.index', compact('msCustomers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMsCustomerRequest $request)
    {
        $data = $request->validated();

        $msCustomer = MsCustomer::make($data);
        $msCustomer->saveOrFail();

        return redirect()->back()->with(['success' => 'Data Customer berhasil ditambahkan']);
    }

    /**
     * Display the specified resource.
     */
    public function show(MsCustomer $msCustomer)
    {
        return view('dashboard.customer.show', compact('msCustomer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MsCustomer $msCustomer)
    {
        return view('dashboard.customer.edit', compact('msCustomer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMsCustomerRequest $request, MsCustomer $msCustomer)
    {
        $data = $request->validated();

        $msCustomer->fill($data);
        $msCustomer->saveOrFail();

        return redirect()->back()->with(['success' => 'Data Customer berhasil diubah']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MsCustomer $msCustomer)
    {
        $transactionHistory = TransaksiH::where('customer_id', $msCustomer->id)->first();

        if ($transactionHistory) {
            return redirect()->back()->with(['error' => 'Data Customer tidak dapat dihapus karena masih memiliki transaksi']);
        }

        $msCustomer->delete();

        return redirect()->back()->with(['success' => 'Data Customer berhasil dihapus']);
    }

    public function getCustomerInfo(MsCustomer $msCustomer)
    {
        return response()->json($msCustomer);
    }
}
