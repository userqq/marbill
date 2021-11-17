@extends('layouts.default')

@section('title')
    New customer
@endsection

@section('content')
    <form method="POST" action="{{ route('templates-store') }}">
        @csrf

        <div class="row">
            <div class="form-group col-md-12 position-relative">
                <label for="customer-input-email">Subject</label>
                <input type="text" name="subject" class="form-control" id="customer-input-email" value="{{ old('subject') }}">
                <small class="form-text text-muted">
                    Allowed placeholders: 
                    <b>{!! $placeholders->map(fn ($i) => sprintf('@{{%s}}', $i))->implode(', ') !!}</b>
                </small>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-12 position-relative">
                <label for="customer-input-email">Body</label>
                <textarea name="body" class="form-control" id="customer-input-email" value="{{ old('body') }}"></textarea>
                <small class="form-text text-muted">
                    Allowed placeholders: 
                    <b>{!! $placeholders->map(fn ($i) => sprintf('@{{%s}}', $i))->implode(', ') !!}</b>
                </small>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary float-right">Save</button>
            </div>
        </div>
    </form>
@endsection
