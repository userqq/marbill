@extends('layouts.default')

@section('title')
    New customer
@endsection

@section('content')
    <form method="POST" action="{{ route('customers-store') }}">
        @csrf

        <div class="row">
            <div class="form-group col-md-6 position-relative">
                <label for="customer-input-email">Email address *</label>
                <input type="text" name="email" class="form-control" id="customer-input-email" value="{{ old('email') }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label for="customer-input-first_name">First name *</label>
                <input type="text" name="first_name" class="form-control" id="customer-input-first_name" value="{{ old('first_name') }}">
            </div>
            <div class="form-group col-md-6">
                <label for="customer-input-last_name">Last name *</label>
                <input type="text" name="last_name" class="form-control" id="customer-input-last_name" value="{{ old('last_name') }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label for="customer-input-birth_date">Birth date</label>
                <input type="date" name="birth_date" class="form-control" id="customer-input-birth_date" value="{{ old('birth_date') }}">
            </div>
            <div class="form-group col-md-6">
                <label>Sex</label>
                <div class="py-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="sex" id="customer-input-sex-unknown" value="" {{ (null === old('sex') || "" === old('sex')) ? ' checked' : '' }}>
                        <label class="form-check-label" for="customer-input-sex-unknown">Unknown</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="sex" id="customer-input-sex-female" value="0" {{ "0" === old('sex') ? ' checked' : '' }}>
                        <label class="form-check-label" for="customer-input-sex-female">Female</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="sex" id="customer-input-sex-male" value="1" {{ "1" === old('sex') ? ' checked' : '' }}>
                        <label class="form-check-label" for="customer-input-sex-male">Male</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary float-right">Add customer</button>
            </div>
        </div>
    </form>
@endsection
