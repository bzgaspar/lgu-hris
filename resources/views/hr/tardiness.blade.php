@extends('layouts.app')

@section('title', 'Tardiness')
@section('content')

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
