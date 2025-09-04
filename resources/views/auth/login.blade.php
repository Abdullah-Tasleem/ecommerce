{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
@extends('frontend.layout.main')

@section('section')
    <!-- login area start -->
    <section class="tp-login-area pb-140 p-relative z-index-1 fix">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-8">
                    <div class="tp-login-wrapper">
                        <div class="tp-login-top text-center mb-30">
                            <h3 class="tp-login-title">Login to Your Account</h3>
                            <p>Don't have an account? <a href="{{ route('register') }}">Create free account</a></p>
                        </div>
                        <div class="tp-login-option">
                            <div class="tp-login-social mb-10 d-flex flex-wrap align-items-center justify-content-center">
                                <a class="tp-login-fb" href="#"><i class="fab fa-facebook-f"></i> Facebook</a> &nbsp;&nbsp;
                                <a class="tp-login-google" href="#"><i class="fa-brands fa-google"></i> Google</a>
                            </div>
                            <div class="tp-login-mail text-center mb-40">
                                <p>or Sign in with <a href="#">Email</a></p>
                            </div>
                        </div>
                        <div class="tp-login-form">
                            @if (session('status'))
                                <div class="alert alert-success mb-3">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="tp-login-input mb-20">
                                    <div class="tp-login-input-item">
                                        <span><i class="fa-light fa-envelope"></i></span>
                                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                                            required autofocus placeholder="Enter Email">
                                    </div>
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="tp-login-input mb-20">
                                    <div class="tp-login-input-item">
                                        <span><i class="fa-light fa-lock"></i></span>
                                        <input id="password" type="password" name="password" required
                                            placeholder="Enter Password">
                                    </div>
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="tp-login-option mb-20 d-sm-flex justify-content-between">
                                    <div class="tp-login-remeber">
                                        <input id="remember" type="checkbox" name="remember">
                                        <label for="remember">Remember Me</label>
                                    </div>
                                    @if (Route::has('password.request'))
                                        <div class="tp-login-forgot">
                                            <a href="{{ route('password.request') }}">Forgot Password?</a>
                                        </div>
                                    @endif
                                </div>

                                <div class="tp-login-bottom">
                                    <div class="mb-5">
                                        <span>Sign Up ? <a href="{{ route('register') }}">Create free account</a></span>
                                    </div>
                                    <button type="submit" class="fill-btn w-100">
                                        <span class="fill-btn-inner">
                                            <span class="fill-btn-normal">Login</span>
                                            <span class="fill-btn-hover">Login</span>
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- login area end -->
@endsection
@push('scripts')

@if (session('error'))
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var notyf = new Notyf({
                duration: 4000,
                position: {
                    x: 'right',
                    y: 'top',
                }
            });

            notyf.error("{{ session('error') }}");
        });
    </script>
@endif
@endpush
