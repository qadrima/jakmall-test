@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    
                    <form method="POST" action="{{ route('product_create') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="product" class="col-md-4 col-form-label text-md-right">Product</label>

                            <div class="col-md-6">

                                <textarea
                                    id="product" 
                                    class="form-control @error('product') is-invalid @enderror" 
                                    name="product" 
                                    required
                                >{{ old('product') }}</textarea>

                                @error('product')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="shipping_address" class="col-md-4 col-form-label text-md-right">Shipping Address</label>

                            <div class="col-md-6">

                                <textarea
                                    id="shipping_address" 
                                    class="form-control @error('shipping_address') is-invalid @enderror" 
                                    name="shipping_address" 
                                    required
                                >{{ old('shipping_address') }}</textarea>

                                @error('shipping_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="price" class="col-md-4 col-form-label text-md-right">Price</label>

                            <div class="col-md-6">

                                <input 
                                    id="price" 
                                    type="text" 
                                    class="form-control @error('price') is-invalid @enderror" 
                                    name="price" 
                                    value="{{ old('price') }}"
                                    placeholder="10000" 
                                    required 
                                >

                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            
                            @if (session('error'))
                                <div class="col-md-8 offset-md-4">
                                    <p class="text-danger">{{ session('error') }}</p>
                                </div>
                            @endif

                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
