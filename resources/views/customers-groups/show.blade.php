@extends('layouts.default')

@section('title')
    Customers Groups
@endsection

@section('content')
    <div class="d-flex">
        <form class="form-inline flex-grow-1" method="POST" action="{{ route('customers-groups-update', ['customerGroup' => $customerGroup->id]) }}">
            @csrf

            <h3>Customer group </strong></h3>
            <input type="text" name="name" class="form-control mx-2 flex-grow-1" value="{{ $customerGroup->name }}">
            <button type="submit" class="btn btn-success mx-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                </svg>
            </button>
        </form>

        <form class="form-inline" method="POST" action="{{ route('customers-groups-delete', ['customerGroup' => $customerGroup->id]) }}">
            @csrf

            <button type="submit" class="btn btn-danger ml-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                </svg>
            </a>
        </form>
    </div>

    <hr/>
    
    <div class="row">
        <div class="col-md-6">
            <h4>Customers in the group:</h4>

            @if (count($customerGroup->customers))
                @foreach ($customerGroup->customers as $customer)
                    <hr/>
                    <div class="row">
                        <div class="col-md-6 text-truncate">
                            {{ $customer->email }}
                        </div>
                        <div class="col-md-4 text-truncate">
                            {{ $customer->first_name }} {{ $customer->last_name }}
                        </div>
                        <div class="col-md-2">
                            <form method="POST" action="{{ route('customers-groups-remove-customer') }}">
                                @csrf
                                <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                                <input type="hidden" name="customer_group_id" value="{{ $customerGroup->id }}">
                                <button type="submit" class="btn btn-link py-0">
                                    <svg class="align-baseline" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                There is no customers in the group
            @endif
        </div>

        <div class="col-md-6">
            <h4>Add customer to the group:</h4>

            @if (count($customers))
                @foreach ($customers as $customer)
                    <hr/>
                    <div class="row">
                        <div class="col-md-6 text-truncate">
                            {{ $customer->email }}
                        </div>
                        <div class="col-md-4 text-truncate">
                            {{ $customer->first_name }} {{ $customer->last_name }}
                        </div>
                        <div class="col-md-2">
                            <form method="POST" action="{{ route('customers-groups-add-customer') }}">
                                @csrf
                                <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                                <input type="hidden" name="customer_group_id" value="{{ $customerGroup->id }}">
                                <button type="submit" class="btn btn-link py-0">
                                    <svg class="align-baseline" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                There is no customers available
            @endif
        </div>
    </div>
@endsection
