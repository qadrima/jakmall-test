@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Prepaid Balance</div>

                <div class="card-body">
            
                    <form method="POST" action="{{ route('topup_balance_create') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="mobile_number" class="col-md-4 col-form-label text-md-right">Mobile Number</label>

                            <div class="col-md-6">

                                <input 
                                    id="mobile_number" 
                                    type="text" 
                                    class="form-control @error('mobile_number') is-invalid @enderror" 
                                    name="mobile_number" 
                                    value="{{ old('mobile_number') }}"
                                    required 
                                >

                                @error('mobile_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="value" class="col-md-4 col-form-label text-md-right">Value</label>

                            <div class="col-md-6">

                                <select id="value" class="form-control @error('value') is-invalid @enderror" name="value">
                                    <option value="" selected disabled hidden>Choose here</option>

                                    @foreach($values as $value)
                                        <option value="{{$value}}">{{ number_format($value, 0, '', '.') }}</option>
                                    @endforeach

                                </select>

                                @error('value')
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
