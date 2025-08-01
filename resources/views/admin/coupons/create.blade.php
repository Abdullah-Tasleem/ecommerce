@extends('dashboard.layout.main')
@section('title', 'Create Coupon')
@section('dashboard')
    <div class="container mt-3">
        <h2>Create New Coupon</h2>
        <form action="{{ route('coupons.store') }}" method="POST">
            @csrf

            {{-- Basic details --}}
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" for="code">Coupon Code <span class="text-danger">*</span></label>
                    <input type="text" name="code" id="code" value="{{ old('code') }}"
                        class="form-control @error('code') is-invalid @enderror" required>
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-8">
                    <label class="form-label" for="name">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="form-control @error('name') is-invalid @enderror" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label" for="description">Description</label>
                    <textarea name="description" id="description" rows="3"
                        class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <hr class="my-4">

            {{-- Discount details --}}
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" for="discount_type">Discount Type <span class="text-danger">*</span></label>
                    <select name="discount_type" id="discount_type"
                        class="form-select @error('discount_type') is-invalid @enderror" required>
                        <option value="percent" {{ old('discount_type') === 'percent' ? 'selected' : '' }}>Percentage
                            (%)</option>
                        <option value="fixed" {{ old('discount_type') === 'fixed' ? 'selected' : '' }}>Fixed Amount
                        </option>
                    </select>
                    @error('discount_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="discount_value">Discount Value <span class="text-danger">*</span></label>
                    <input type="number" name="discount_value" id="discount_value" step="0.01"
                        value="{{ old('discount_value') }}"
                        class="form-control @error('discount_value') is-invalid @enderror" required>
                    @error('discount_value')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="max_discount_amount">Max Discount Amount</label>
                    <input type="number" name="max_discount_amount" id="max_discount_amount" step="0.01"
                        value="{{ old('max_discount_amount') }}"
                        class="form-control @error('max_discount_amount') is-invalid @enderror">
                    @error('max_discount_amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="min_cart_value">Min Cart Value</label>
                    <input type="number" name="min_cart_value" id="min_cart_value" step="0.01"
                        value="{{ old('min_cart_value') }}"
                        class="form-control @error('min_cart_value') is-invalid @enderror">
                    @error('min_cart_value')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <hr class="my-4">

            {{-- Validity --}}
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" for="start_date">Start Date <span class="text-danger">*</span></label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                        class="form-control @error('start_date') is-invalid @enderror" required>
                    @error('start_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="end_date">End Date <span class="text-danger">*</span></label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                        class="form-control @error('end_date') is-invalid @enderror" required>
                    @error('end_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>

                    </select>
                </div>
            </div>
    </div>

    <hr class="my-4">

    {{-- Usage limits --}}
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label" for="usage_limit">Usage Limit (total)</label>
            <input type="number" name="usage_limit" id="usage_limit" value="{{ old('usage_limit') }}"
                class="form-control @error('usage_limit') is-invalid @enderror">
            @error('usage_limit')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label" for="limit_per_user">Limit per User</label>
            <input type="number" name="limit_per_user" id="limit_per_user" value="{{ old('limit_per_user') }}"
                class="form-control @error('limit_per_user') is-invalid @enderror">
            @error('limit_per_user')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <hr class="my-4">

    {{-- Flags --}}
    <div class="row g-3">
        <div class="col-md-3 form-check ps-5">
            <input class="form-check-input" type="checkbox" name="first_time_users_only" id="first_time_users_only"
                {{ old('first_time_users_only') ? 'checked' : '' }}>
            <label class="form-check-label" for="first_time_users_only">First-time users only</label>
        </div>

        <div class="col-md-3 form-check">
            <input class="form-check-input" type="checkbox" name="registered_users_only" id="registered_users_only"
                {{ old('registered_users_only', true) ? 'checked' : '' }}>
            <label class="form-check-label" for="registered_users_only">Registered users only</label>
        </div>

        <div class="col-md-3 form-check">
            <input class="form-check-input" type="checkbox" name="exclude_sale_items" id="exclude_sale_items"
                {{ old('exclude_sale_items') ? 'checked' : '' }}>
            <label class="form-check-label" for="exclude_sale_items">Exclude sale items</label>
        </div>

        <div class="col-md-3 form-check">
            <input class="form-check-input" type="checkbox" name="auto_apply" id="auto_apply"
                {{ old('auto_apply') ? 'checked' : '' }}>
            <label class="form-check-label" for="auto_apply">Auto apply</label>
        </div>
    </div>

    <hr class="my-4">

    {{-- Category & product restrictions --}}
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label" for="eligible_categories">Eligible Categories</label>
            @php
                $oldCategories = old('eligible_categories');
                $selectedCategories = is_array($oldCategories)
                    ? collect($oldCategories)
                    : collect(json_decode($oldCategories, true));
            @endphp

            <select name="eligible_categories[]" id="eligible_categories"
                class="form-select @error('eligible_categories') is-invalid @enderror" multiple>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ $selectedCategories->contains($category->id) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <small class="text-muted">Hold Ctrl / Cmd to select multiple</small>
            @error('eligible_categories')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <hr class="my-4">
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-save"></i> Create Coupon
    </button>
    <a href="{{ route('coupons.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
    </div>
@endsection
