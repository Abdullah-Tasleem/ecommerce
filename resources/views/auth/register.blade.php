{{-- <x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}

@extends('frontend.layout.main') {{-- Apne layout ka sahi path lagayein --}}

@section('section')
    <!-- register area start -->
    <section class="tp-login-area pb-140 p-relative z-index-1 fix">
        <div class="tp-login-shape">
            <img class="tp-login-shape-1" src="{{ asset('frontend/assets/img/login/login-shape-1.png') }}" alt="">
            <img class="tp-login-shape-2" src="{{ asset('frontend/assets/img/login/login-shape-2.png') }}" alt="">
            <img class="tp-login-shape-3" src="{{ asset('frontend/assets/img/login/login-shape-3.png') }}" alt="">
            <img class="tp-login-shape-4" src="{{ asset('frontend/assets/img/login/login-shape-4.png') }}" alt="">
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-8">
                    <div class="tp-login-wrapper">
                        <div class="tp-login-top text-center mb-30">
                            <h3 class="tp-login-title">Create a New Account</h3>
                            <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
                        </div>

                        <div class="tp-login-form">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="tp-login-input mb-20">
                                    <div class="tp-login-input-item">
                                        <span><i class="fa-light fa-user"></i></span>
                                        <input id="name" type="text" name="name" value="{{ old('name') }}"
                                            required autofocus placeholder="Enter Full Name">
                                    </div>
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="tp-login-input mb-20">
                                    <div class="tp-login-input-item">
                                        <span><i class="fa-light fa-envelope"></i></span>
                                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                                            required placeholder="Enter Email">
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

                                <div class="tp-login-input mb-20">
                                    <div class="tp-login-input-item">
                                        <span><i class="fa-light fa-lock-keyhole"></i></span>
                                        <input id="password_confirmation" type="password" name="password_confirmation"
                                            required placeholder="Confirm Password">
                                    </div>
                                    @error('password_confirmation')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="tp-login-bottom">
                                    <div class="mb-5">
                                        <span>Already have an account? <a href="{{ route('login') }}">Login</a></span>
                                    </div>
                                    <button type="submit" class="fill-btn w-100">
                                        <span class="fill-btn-inner">
                                            <span class="fill-btn-normal">Register</span>
                                            <span class="fill-btn-hover">Register</span>
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
    <!-- register area end -->
@endsection
