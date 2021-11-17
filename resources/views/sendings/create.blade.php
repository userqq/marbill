@extends('layouts.default')

@section('title')
    New customer
@endsection

@section('content')
    <form method="POST" action="{{ route('sendings-store') }}">
        @csrf

        <div class="form-group">
            <label for="sendings-template">Template *</label>
            @if (count($templates))
                <select class="form-control" id="sendings-template" name="email_template_id">
                    <option value="" selected>Select template --</option>
                    @foreach ($templates as $template)
                        <option value="{{ $template->id }}">{{ $template->subject }}</option>
                    @endforeach
                </select>
            @endif
        </div>

        <div class="form-group">
            <label for="sendings-template">Customers Group *</label>
            @if (count($customersGroups))
                <select class="form-control" id="sendings-template" name="customer_group_id">
                    <option value="" selected>Select customers group --</option>
                    @foreach ($customersGroups as $customersGroup)
                        <option value="{{ $customersGroup->id }}">{{ $customersGroup->name }}</option>
                    @endforeach
                </select>
            @endif
        </div>

        <div class="form-group">
            <label for="sendings-time">Send at</label>
            <input class="form-control" type="datetime-local" id="meeting-time"
                   name="time"
                   min="{{ $currentTime }}">
            <small class="form-text text-muted">Leave empty to run sending immediately</small>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary float-right">Create sending</button>
        </div>
    </form>
@endsection

