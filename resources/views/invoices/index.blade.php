@foreach ($invoices as $invoice)
    <div>{{ $invoice->invoice_number }}</div>
@endforeach