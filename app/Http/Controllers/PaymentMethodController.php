<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use App\Http\Requests\StorePaymentMethodRequest;
use App\Http\Requests\UpdatePaymentMethodRequest;
use App\DataTables\PaymentMethodDataTable;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PaymentMethodDataTable $dataTable)
    {
        return $dataTable->render('payment.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['action'] = "/payment";
        return view('payment.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePaymentMethodRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaymentMethodRequest $request)
    {
        $data = $request->all();

        PaymentMethod::create($data);

        return redirect('/payment')->with('success', 'New payment method has been created!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentMethod  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentMethod $payment)
    {
        $this->data['paymentmethods'] = PaymentMethod::all();

        $this->data['payment_method_data'] = $payment;
        $this->data['action'] = "/payment/".$payment->uuid;
        return view('payment.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePaymentMethodRequest  $request
     * @param  \App\Models\PaymentMethod  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaymentMethodRequest $request, PaymentMethod $payment)
    {
        $data = $request->all();

        $payment->update($data);

        return redirect('/payment')->with('success', 'Payment Method has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentMethod  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentMethod $payment)
    {
        $payment->delete();
        return redirect('/payment')->with('success', 'Payment Method has been deleted!');
    }
}
