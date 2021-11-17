@extends('layouts.default')

@section('title')
    Customers
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('customers-create') }}" class="btn btn-primary float-right">New Customer</a>
        </div>
    </div>

    @if (count($customers))
        <table class="table mt-3">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Email</th>
                    <th scope="col">First name</th>
                    <th scope="col">Last name</th>
                    <th scope="col">Sex</th>
                    <th scope="col">Birth date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                    <tr>
                        <th scope="row">{{ $customer->id }}</th>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->first_name }}</td>
                        <td>{{ $customer->last_name }}</td>
                        <td>                                
                            @if (0 === $customer->sex)
                                Female
                            @elseif (1 === $customer->sex)
                                Male
                            @else
                                Unknown
                            @endif
                        </td>
                        <td>{{ $customer->birth_date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <hr/>
        There is no customers yet
    @endif
@endsection
