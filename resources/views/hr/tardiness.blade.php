@extends('layouts.app')

@section('title', 'Tardiness')
@section('content')

    {{-- <p class="text-danger">make this vue js</p> --}}
    <h3>Tardiness for <span class="fw-bold"> {{ $user->first_name . ' ' . $user->last_name }}</span></h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('hr.leave.index') }}" class="text-decoration-none text-success">Leave
                    Credit</a></li>
            <li class="breadcrumb-item active" aria-current="page">Leave Card</li>
        </ol>
    </nav>
    <div class="row mx-5">
        <div class="col text-end">
            <a href="{{ route('hr.leavecard', $user->id) }}" class="btn btn-outline-success">
                <i class="fa-solid fa-print me-1"></i> Print leave Card</a>
        </div>
    </div>
    <div class="row justify-content-center">
        {{-- <div class="col-12 col-md-10 mt-3">
            <form action="{{ route('hr.leave.update', $user->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-12 col-md">
                        <div class="form-floating mb-1">
                            <input type="date" class="form-control" name="from" id="formId1">
                            <label for="formId1">From</label>
                        </div>
                        @error('from')
                            <p class="text-danger small">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-12 col-md">
                        <div class="form-floating mb-1">
                            <input type="date" class="form-control" name="to" id="formId1">
                            <label for="formId1">To</label>
                        </div>
                        @error('to')
                            <p class="text-danger small">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" checked type="radio" id="w_pay" name="with_pay_vl" value="0">
                    <label class="form-check-label" for="w_pay">
                        With Pay</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="wo_pay" name="with_pay_vl"value="1">
                    <label class="form-check-label" for="wo_pay">
                        Without Pay</label>
                </div>
                <div class="row">
                    <div class="col-12 col-md">
                        <div class="form-floating mb-1">
                            <select type="number" class="form-control" name="vl_m" id="formId1"
                                placeholder="Vacation Leave (Minutes)">
                                <option value="0">0</option>
                                @foreach ($minutes as $minute)
                                    <option value="{{ $minute->value }}">{{ $minute->id }}</option>
                                @endforeach
                            </select>
                            <label for="formId1">Vacation Leave (Minutes)</label>
                        </div>
                    </div>
                    <div class="col-12 col-md">
                        <div class="form-floating mb-1">
                            <select type="number" class="form-control" name="vl_h" id="formId1"
                                placeholder="Vacation Leave (Minutes)">
                                <option value="0">0</option>
                                @foreach ($hours as $hour)
                                    <option value="{{ $hour->value }}">{{ $hour->id }}</option>
                                @endforeach
                            </select>
                            <label for="formId1">Vacation Leave (Hours)</label>
                        </div>
                    </div>
                    <div class="col-12 col-md">
                        <div class="form-floating mb-1">
                            <input type="number" class="form-control" name="vl_d" id="formId1"
                                placeholder="Vacation Leave (Days)" value="0" max="30"
                                value="{{ old('particular') }}">
                            <label for="formId1">Vacation Leave (Days)</label>
                        </div>
                    </div>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" checked type="radio" id="w_pay_1" name="with_pay_sl" value="0">
                    <label class="form-check-label" for="w_pay_1">
                        With Pay</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="wo_pay_1" name="with_pay_sl" value="1">
                    <label class="form-check-label" for="wo_pay_1">
                        Without Pay</label>
                </div>
                <div class="row">
                    <div class="col-12 col-md">
                        <div class="form-floating mb-1">
                            <select type="number" class="form-control" name="sl_m" id="formId1"
                                placeholder="Vacation Leave (Minutes)">
                                <option value="0">0</option>
                                @foreach ($minutes as $minute)
                                    <option value="{{ $minute->value }}">{{ $minute->id }}</option>
                                @endforeach
                            </select>
                            <label for="formId1">Sick Leave (Minutes)</label>
                        </div>
                    </div>
                    <div class="col-12 col-md">
                        <div class="form-floating mb-1">
                            <select type="number" class="form-control" name="sl_h" id="formId1"
                                placeholder="Vacation Leave (Minutes)">
                                <option value="0">0</option>
                                @foreach ($hours as $hour)
                                    <option value="{{ $hour->value }}">{{ $hour->id }}</option>
                                @endforeach
                            </select>
                            <label for="formId1">Sick Leave (Hours)</label>
                        </div>
                    </div>
                    <div class="col-12 col-md">
                        <div class="form-floating mb-1">
                            <input type="number" class="form-control" name="sl_d" id="formId1"
                                placeholder="Sick Leave (Days)" value="0" max="30"
                                value="{{ old('particular') }}">
                            <label for="formId1">Sick Leave (Days)</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md">
                        <div class="form-floating mb-1">
                            <input type="text" class="form-control" name="particular" id="formId1"
                                value="{{ old('particular') }}" placeholder="Particulars">
                            <label for="formId1">Particulars</label>
                        </div>
                    </div>
                    <div class="col-12 col-md">
                        <div class="form-floating mb-1">
                            <input type="text" class="form-control" name="remarks" id="formId1"
                                placeholder="Remarks" value="{{ old('remarks') }}">
                            <label for="formId1">Remarks</label>
                        </div>
                    </div>
                </div>
                <div class="float-end">
                    <button class="btn btn-outline-success fw-bold"><i class="fa-solid fa-plus me-1"></i>Add</button>
                </div>
            </form>
        </div> --}}
        <div class="col-12 mt-3">
            <div class="table-responsive" id="no-more-tables">
                <table class="table table-hover table-striped smnall table-sm text-center table-bordered">
                    <thead>
                        <tr class="table-light text-center border-dark">
                            <th colspan="2">Date</th>
                            <th></th>
                            <th colspan="3">Vacation Leave</th>
                            <th colspan="3">Sick Leave</th>
                            <th colspan="3"></th>
                        </tr>
                        <tr class="table-light text-center border-dark">
                            <th class="numeric" width="8%">From</th>
                            <th class="numeric" width="8%">To</th>
                            <th class="numeric" width="10%">Particular</th>
                            <th class="numeric">W/ Pay</th>
                            <th class="numeric">Balance</th>
                            <th class="numeric">W/O Pay</th>
                            <th class="numeric">W/ Pay</th>
                            <th class="numeric">Balance</th>
                            <th class="numeric">W/O Pay</th>
                            <th class="numeric">Remarks</th>
                            <th class="numeric" width="10%"></th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider table-borderless">
                        @forelse ($leavecard as $leave)
                            <tr>
                                <td data-title="From">{{ $leave->elc_period_from }}</td>
                                <td data-title="To">{{ $leave->elc_period_to }}</td>
                                <td data-title="Particular">{{ $leave->elc_particular }}</td>
                                <td data-title="VL Balance">{{ $leave->elc_vl_auw_p }}</td>
                                <td data-title="VL Balance">{{ $leave->elc_vl_balance }}</td>
                                <td data-title="VL Balance">{{ $leave->elc_vl_auwo_p }}</td>
                                <td data-title="VL Balance">{{ $leave->elc_sl_auw_p }}</td>
                                <td data-title="VL Balance">{{ $leave->elc_sl_balance }}</td>
                                <td data-title="VL Balance">{{ $leave->elc_sl_auwo_p }}</td>
                                <td data-title="Remarks">{{ $leave->elc_remarks }}</td>
                                <td>
                                    <form action="{{ route('hr.leave.destroy', $leave->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm text-white"
                                            onclick="return confirm('Are you sure?')"><i
                                                class="fa-solid fa-trash-can me-1"></i> </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">No Records Found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $leavecard->links('pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
@endsection
