@extends('layouts.app')

@section('title', 'Training Needs Analysis')
@section('content')
    <div class="row justify-content-center">
        <h3>Training Needs Analysis</h3>
        <div class="col-12 col-md-10 mt-3">

            <div class="table-responsive" id="no-more-tables">
                <table class="table table-hover table-striped smnall table-sm text-center">
                    <thead>
                        <tr class="table-light">
                            <th class="numeric">Plantilla No</th>
                            <th class="numeric">Plantilla Position</th>
                            <th class="numeric">Employee Name</th>
                            <th class="numeric">Year</th>
                            <th class="numeric"></th>

                        </tr>
                    </thead>
                    <tbody class="table-group-divider">

                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{-- {{ $all_surveyForm->links('pagination.custom') }} --}}
                </div>
            </div>
        </div>
    </div>


@endsection
