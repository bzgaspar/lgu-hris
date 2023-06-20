@extends('layouts.app')

@section('title', 'Ranking')
@section('customCSS')
@endsection
@section('content')
    @canany(['isAdmin', 'isHR'])
        <div class="row">
            <div class="col-12 col-md-6 text-start">
                <form action="{{ route('hr.ranking.index') }}" method="get">
                    @csrf
                    <div class="input-group mb-3">
                        <select class="form-select" name="pub_id">
                            <option value="" hidden>Select Position to Print Ranking</option>
                            @forelse ($publication as $pub)
                                <option value="{{ $pub->id }}">{{ $pub->title }}</option>
                            @empty
                                <option hidden>No Publication Yet</option>
                            @endforelse
                        </select>
                        <button class="btn btn-outline-dark fw-bold">Get Ranking</button>
                    </div>
                </form>
            </div>
            <div class="col-12 col-md">

            </div>
            <div class="col-12 col-md-4 text-end">
                @if (!empty(request()->except('_token', '_method')))
                    <a target="_blank" href="{{ route('hr.ranking.edit', $_GET['pub_id']) }}"
                        class="btn btn-outline-success ">Print Top
                        10 Ranking</a>
                @endif
            </div>
        </div>
        <hr-ranking></hr-ranking>
    @else
        <hr-rating></hr-rating>
    @endcanany

@endsection
