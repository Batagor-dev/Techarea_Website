<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Client;
use App\Models\InvoiceItem;
use App\Models\PaymentMethod;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\DataTables\InvoiceDataTable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(InvoiceDataTable $dataTable)
    {
        return $dataTable->render('invoice.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->data['payment_methods'] = PaymentMethod::all();
        $this->data['clients'] = Client::all();
        $this->data['action'] = "/invoice";
        $this->data['invoice_number'] = $this->generateInvoiceNumber();

        return view('invoice.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
        DB::transaction(function () use ($request) {

            $client = Client::create([
                'company_client' => $request->company_client,
                'name_client'    => $request->name_client,
                'email'          => $request->email,
                'phone_number'   => $request->phone_number,
                'address'        => $request->address,
            ]);

            $invoice = Invoice::create([
                'client_id'         => $client->id,
                'payment_method_id' => $request->payment_method_id,
                'invoice_number' => $this->generateInvoiceNumber(),
                'invoice_date'      => $request->invoice_date,
                'due_date'          => $request->due_date,
                'project_amount'    => $request->project_amount,
                'status'            => $request->status,
                'notes'             => $request->notes,
                'payment_status'    => $request->payment_status,
                'payment_date'      => $request->payment_date,
                'payment_amount'    => $request->payment_amount,
            ]);

            foreach ($request->item_name as $i => $item) {

                InvoiceItem::create([
                    'invoice_id'       => $invoice->id,
                    'item_name'        => $request->item_name[$i],
                    'item_description' => $request->item_description[$i],
                    'item_price'       => $request->item_price[$i],
                ]);

            }
        });

        Cache::forget('all-data');

        return redirect('/invoice')
            ->with('success', 'Invoice berhasil dibuat!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        $this->data['invoices'] = Invoice::all();
        $this->data['invoice_data'] = $invoice;
        // dd($this->data['invoice_data']);
        $this->data['action'] = "/invoice/" . $invoice->uuid;

        return view('invoice.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        $data = $request->validated();

        $invoice->update($data);

        Cache::forget('all-data');

        return redirect('/invoice')
            ->with('success', 'Invoice berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        Cache::forget('all-data');

        return redirect('/invoice')
            ->with('success', 'Invoice berhasil dihapus!');
    }

    // function auto generate invoice number
    private function generateInvoiceNumber(): string
    {
        $prefix = 'INV-' . now()->format('Ym') . '-';

        $lastInvoice = Invoice::where('invoice_number', 'like', $prefix.'%')
            ->latest('id')
            ->first();

        $number = 1;

        if ($lastInvoice) {
            $number = ((int) substr($lastInvoice->invoice_number, -4)) + 1;
        }

        return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}