{{-- <x-mail::message>
# Introduction

The body of your message.

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message> --}}

@component('mail::message')
# Welcome, {{ $name }} 🎉

Thank you for registering on our eCommerce store.
We’re excited to have you onboard!

@component('mail::button', ['url' => url('/')])
Visit Store
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
