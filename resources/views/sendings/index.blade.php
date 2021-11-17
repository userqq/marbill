@extends('layouts.default')

@section('title')
    Customers
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            @if ($customersGroupsCount && $templatesCount)
                <a href="{{ route('sendings-create') }}" class="btn btn-primary float-right">New Sending</a>
            @else
                <p>To create email sending plase add at least on template and at least one group with customer</p>
            @endif
        </div>
    </div>

    @if ($sendings)
        <hr class="mb-0"/>

        <div class="row">
        @foreach ($sendings as $sending)
            <div class="col-md-4 my-3">
                <div class="card">
                    <div class="card-body">
                        <p @class([
                            'card-text',
                            'text-right',
                            'text-primary'   => $sending->status == \App\Models\SendingSchedule::STATUS_NOT_SENT,
                            'text-info'      => $sending->status == \App\Models\SendingSchedule::STATUS_ACQUIRED,
                            'text-info'      => $sending->status == \App\Models\SendingSchedule::STATUS_IN_PROGRESS,
                            'text-success'   => $sending->status == \App\Models\SendingSchedule::STATUS_SENT,
                            'text-danger'    => $sending->status == \App\Models\SendingSchedule::STATUS_ERROR,
                        ])>
                            {{ $sending->getTextStatus() }}
                        </p>
                        <h6 class="text-truncate"><strong>{{ $sending->customerGroup->name }}</strong></h6>
                        <p class="text-truncate">{{ $sending->emailTemplate->subject }}</p>
                        <p class="card-text text-right text-muted"><i>at {{ $sending->time }}</i></p>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    @else
        <hr/>
        There is no email sendings yet
    @endif
@endsection
