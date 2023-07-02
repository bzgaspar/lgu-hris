@extends('layouts.app')

@section('title', 'Service Record')
@section('content')
    <div class="row justify-content-center">
        <h3>Service Record of <strong>{{ $user->first_name . ' ' . $user->last_name }}</strong></h3>

        <div class="row">
            <div class="col text-start">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('hr.service.index') }}"
                                class="text-decoration-none text-success">Service Record</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <strong>{{ $user->first_name . ' ' . $user->last_name }}</strong>
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col text-end">
                <a target="_blank" href="{{ route('hr.service.edit', $user->id) }}" class="btn btn-outline-success ">Print
                    Service Record</a>
            </div>
        </div>
        <hr>
        <div class="col-12 col-md-10 mt-3">
            <h1 class="h3">Add Service Record</h1>
            <div class="row">
                @if ($edit_service)
                    <form action="{{ route('hr.service.update', $edit_service->id) }}" method="POST">
                        @method('PATCH')
                    @else
                        <form action="{{ route('hr.service.store') }}" method="POST">
                @endif
                @csrf
                <input type="text" value="{{ $user->id }}" name="user_id" hidden>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-1">
                            <input type="date" class="form-control text-uppercase" name="from" id="from"
                                @if ($edit_service) value="{{ old('from', $edit_service->from) }}"
                                @else
                                value="{{ old('from') }}" @endif>
                            <label for="from" class="form-label small">From</label>
                            @error('from')
                                <p class="text-danger small">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-1">
                                    <input type="date" class="form-control text-uppercase" name="to" id="to"
                                        @if ($edit_service) value="{{ old('to', $edit_service->to) }}"
                            @else
                            value="{{ old('to') }}" @endif>
                                    <label for="to" class="form-label small">To</label>
                                    @error('to')
                                        <p class="text-danger small">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col">
                                    <input type="checkbox" value="PRESENT" class="form-check-input" name="to"
                                        id="WEidtoCheck">
                                    <label for="WEidtoCheck">Present</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md mb-3">
                        <div class="form-floating">
                            <input class="form-control @error('designation') is-invalid @enderror" name="designation"
                                @if ($edit_service) value="{{ old('designation', $edit_service->designation) }}"
                            @else

                            @if ($user->empPlantilla) value="{{ old('designation', $user->empPlantilla->EPposition) }}"
                            @else
                            value="{{ old('designation', $user->empPlantilla) }}" @endif
                                @endif>
                            <label for="Incumbent" class="form-label">Designation</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md mb-3">
                        <div class="form-floating mb-1">
                            <input type="text" class="form-control text-uppercase" name="status" id="status"
                                placeholder="Status"
                                @if ($edit_service) value="{{ old('status', $edit_service->status) }}"
                            @else
                            value="{{ old('status') }}" @endif>
                            <label for="status" class="form-label small">Status</label>
                            @error('status')
                                <p class="text-danger small">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md mb-3">
                        <div class="form-floating mb-1">
                            <input type="number" class="form-control text-uppercase" name="salary" id="salary"
                                placeholder="Salary" step="any"
                                @if ($edit_service) value="{{ old('salary', $edit_service->salary) }}"
                                @else
                                value="{{ old('salary') }}" @endif>
                            <label for="salary" class="form-label small">Salary</label>
                            @error('salary')
                                <p class="text-danger small">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md mb-3">
                        <div class="form-floating mb-1">
                            <input type="text" class="form-control text-uppercase" name="station" id="station"
                                placeholder="Station/Place/Branch"
                                @if ($edit_service) value="{{ old('station', $edit_service->station) }}"
                                @else
                                value="{{ old('station') }}" @endif>
                            <label for="station" class="form-label small">Station/Place/Branch</label>
                            @error('station')
                                <p class="text-danger small">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md mb-3">
                        <div class="form-floating mb-1">
                            <input type="text" class="form-control text-uppercase" name="wo_pay" id="wo_pay"
                                placeholder="L/V ABS W/O PAy"
                                @if ($edit_service) value="{{ old('wo_pay', $edit_service->wo_pay) }}"
                                @else
                                value="{{ old('wo_pay') }}" @endif>
                            <label for="wo_pay" class="form-label small">L/V ABS W/O PAy</label>
                            @error('wo_pay')
                                <p class="text-danger small">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md mb-3">
                        <div class="form-floating mb-1">
                            <input type="date" class="form-control text-uppercase" name="date" id="date"
                                placeholder="Date"
                                @if ($edit_service) value="{{ old('date', $edit_service->date) }}"
                                @else
                                value="{{ old('date') }}" @endif>
                            <label for="date" class="form-label small">Date</label>
                            @error('date')
                                <p class="text-danger small">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md mb-3">
                        <div class="form-floating mb-1">
                            <input type="text" class="form-control text-uppercase" name="cause" id="cause"
                                placeholder="Cause"
                                @if ($edit_service) value="{{ old('cause', $edit_service->cause) }}"
                                @else
                                value="{{ old('cause') }}" @endif>
                            <label for="cause" class="form-label small">Cause</label>
                            @error('cause')
                                <p class="text-danger small">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <button class="btn btn-outline-success w-100" type="submit">
                    @if ($edit_service)
                        <i class="fa fa-upload me-1" aria-hidden="true"></i> Save
                    @else
                        <i class="fa fa-plus me-1" aria-hidden="true"></i> Add
                    @endif
                </button>
                </form>
            </div>
            <hr>
            <div class="row">
                <h1 class="h3">Service Record History</h1>
                <div class="col">
                    {{-- table --}}
                    <div class="table-responsive" id="no-more-tables">
                        <table class="table table-hover table-striped smnall table-sm text-center">
                            <thead>
                                <tr class="table-light">
                                    <th class="numeric" width="10%">From</th>
                                    <th class="numeric" width="10%">To</th>
                                    <th class="numeric">Designation</th>
                                    <th class="numeric">Status</th>
                                    <th class="numeric">Salary</th>
                                    <th class="numeric">Station</th>
                                    <th class="numeric">Date</th>
                                    <th class="numeric">Cause</th>
                                    <th class="numeric" width="10%"></th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                @forelse ($service as $item)
                                    <tr>
                                        <td>{{ $item->from }}</td>
                                        <td>{{ $item->to }}</td>
                                        <td>
                                            @if ($item->empPlantilla)
                                                {{ $item->empPlantilla->EPposition }}
                                            @else
                                                {{ $item->designation }}
                                            @endif

                                        </td>
                                        <td>{{ $item->status }}</td>
                                        <td>{{ number_format($item->salary, 2, '.', ',') }}</td>
                                        <td>{{ $item->station }}</td>
                                        <td>{{ $item->date }}</td>
                                        <td>{{ $item->cause }}</td>

                                        <td>

                                            <form action="{{ route('hr.service.destroy', $item->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('hr.service.edit_record', $item->id) }}"
                                                    class="btn btn-warning btn-sm"><i class="fa-solid fa-pen"></i></a>
                                                <button type="submit" class="btn btn-danger btn-sm text-white"
                                                    onclick="return confirm('Are you sure?')"><i
                                                        class="fa-solid fa-trash-can"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No Records</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {{ $service->links('pagination.custom') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
