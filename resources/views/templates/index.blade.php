@extends('layouts.default')

@section('title')
    Customers
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('templates-create') }}" class="btn btn-primary float-right">New Template</a>
        </div>
    </div>

    @if (count($templates))
        <hr class="mb-0"/>
        <div class="row">
        @foreach ($templates as $template)
            <div class="col-md-4 my-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-truncate"><strong>{{ $template->body }}</strong></h6>
                        <p class="card-text">{{ $template->subject }}</p>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    @else
        <hr/>
        There is no templates yet
    @endif
@endsection
