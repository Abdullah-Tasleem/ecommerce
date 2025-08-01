@php use Illuminate\Support\Str; @endphp

<x-mail::message>
# Thanks for your order!

Here are your ordered items:

@foreach ($order->orderItems ?? [] as $item)
- **{{ $item->product->name }}** × {{ $item->quantity }} — ${{ number_format($item->price, 2) }}

<x-mail::button :url="route('details', [$item->product->id, $item->product->slug])">
View Product
</x-mail::button>
@endforeach

**Total: ${{ number_format($order->total ?? 0, 2) }}**

We'll contact you when your order is on the way.

Thanks,
{{ config('app.name') }}
</x-mail::message>
