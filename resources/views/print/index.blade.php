@extends('layouts.app')

@section('title', 'Document Printing')
@section('content')
    <div class="row justify-content-center">
        <h3>Printing</h3>
        <hr-print-index></hr-print-index>
        {{-- <div class="row mt-4 gx-4">
            <div class="col">
                <div class="card">
                    <div class="card-header">Service Record</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <div class="form-floating mb-1">
                                    <select type="text" class="form-select" name="formId1" id="serviceRecordSelect">
                                        <option hidden>Select Employee</option>
                                        @forelse ($all_user as $item)
                                            <option value="{{ $item->id }}">{{ $item->first_name }}
                                                {{ $item->last_name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    <label for="formId1">Select Employee</label>
                                </div>
                            </div>
                            <div class="col">
                                <button type="button" id="serviceRecord" class="btn btn-outline-success w-100">Print</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">Certificate of Employment</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <div class="form-floating mb-1">
                                    <select type="text" class="form-select" name="formId1" id="coeSelect">
                                        <option hidden>Select Employee</option>
                                        @forelse ($all_user as $item)
                                            <option value="{{ $item->id }}">{{ $item->first_name }}
                                                {{ $item->last_name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    <label for="formId1">Select Employee</label>
                                </div>
                            </div>
                            <div class="col">
                                <button type="button" id="coe" class="btn btn-outline-success w-100">Print</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2 gx-4">
            <div class="col">
                <div class="card">
                    <div class="card-header">Personal Data Sheet</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <div class="form-floating mb-1">
                                    <select type="text" class="form-select" name="formId1" id="pdsSelect">
                                        <option hidden>Select Employee</option>
                                        @forelse ($all_user as $item)
                                            <option value="{{ $item->id }}">{{ $item->first_name }}
                                                {{ $item->last_name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    <label for="formId1">Select Employee</label>
                                </div>
                            </div>
                            <div class="col">
                                <button type="button" id="pds" class="btn btn-outline-success w-100">Print</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">Leave Card</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <div class="form-floating mb-1">
                                    <select type="text" class="form-select" name="formId1" id="leavecardselect">
                                        <option hidden>Select Employee</option>
                                        @forelse ($all_user as $item)
                                            <option value="{{ $item->id }}">{{ $item->first_name }}
                                                {{ $item->last_name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    <label for="formId1">Select Employee</label>
                                </div>
                            </div>
                            <div class="col">
                                <button type="button" id="leavecard" class="btn btn-outline-success w-100">Print</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

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

@section('customJS')
{{-- <script src="{{ asset('storage/js/selectSort.js') }}"></script> --}}
    {{-- <script>
        $(document).ready(function() {
            // click
            $("#serviceRecord").click(function() {
                printServiceRecord();
            });

            $("#coe").click(function() {
                printCoe();
            });
            $("#pds").click(function() {
                printPds();
            });
            $("#leavecard").click(function() {
                printLeavecard();
            });

            // function
            function printServiceRecord() {
                // getting selected
                let id = $('#serviceRecordSelect').find(":selected").val();
                window.open('/hr/service/'+id+'/edit', '_blank');
            }
            function printCoe() {
                // getting selected
                let id = $('#coeSelect').find(":selected").val();
                window.open('/hr/dashboard/'+id, '_blank');
            }
            function printPds() {
                // getting selected
                let id = $('#pdsSelect').find(":selected").val();
                window.open('/users/pds/'+id+'/print', '_blank');
            }
            function printLeavecard() {
                // getting selected
                let id = $('#leavecardselect').find(":selected").val();
                window.open('/hr/leavecard/'+id, '_blank');
            }
        });
    </script> --}}
@endsection
