@extends('layouts.app')

@section('title', 'Document Printing')
@section('content')
    <div class="row justify-content-center">
        <h3>Printing</h3>
        <hr-print-index></hr-print-index>

        <div class="row mt-2 gx-4">
            <div class="col">
                <div class="card">
                    <div class="card-header">Publication</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <a href="{{ route('hr.publication.create') }}" target="_blank" class="btn btn-outline-success w-100">Print</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">Employee Plantilla</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <a href="{{ route('hr.plantilla.create') }}" target="_blank" class="btn btn-outline-success w-100">Print</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
