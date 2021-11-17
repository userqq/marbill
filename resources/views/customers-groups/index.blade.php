@extends('layouts.default')

@section('title')
    Customers Groups
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form class="form-inline justify-content-between" method="POST" action="{{ route('customers-groups-store') }}">
                @csrf

                <div class="d-flex flex-grow-1">
                    <input type="text" name="name" class="form-control mr-sm-2 flex-grow-1" id="customer-group-name" placeholder="Customer Group Name">
                </div>
                <button type="submit" class="btn btn-primary">Add Group</button>
            </form>
        </div>
    </div>

    @if (count($groups))
        <hr class="mb-0"/>
        <div class="row">
        @foreach ($groups as $group)
            <div class="col-md-4 my-3">
                <a href="{{ route('customers-groups-show', ['customerGroup' => $group->id]) }}" class="card">
                    <div class="card-body">
                        {{ $group->name }}
                    </div>
                </a>
            </div>
        @endforeach
        </div>
    @else
        <hr/>
        There is no customers groups yet
    @endif
@endsection
