@component('mail::message')
# 🚨 Low Stock Alert

The following products are low in stock (2 or less available):

@component('mail::table')
| Product Name | Stock |
|--------------|-------|
@foreach($products as $product)
| {{ $product->name }} | {{ $product->stock }} |
@endforeach
@endcomponent

Please restock these products soon.

Thanks,
{{ config('app.name') }}
@endcomponent
