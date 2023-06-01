@extends('layouts.app')

@section('title', 'Employee Leave Application')
@section('content')
<hr-leave_app></hr-leave_app>
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 mt-3">
            {{-- table --}}
            {{-- <div class="table-responsive" id="no-more-tables">
                <table class="table table-hover table-striped smnall table-sm text-center">
                    <thead>
                        <tr class="table-light">
                            <th class="numeric">From</th>
                            <th class="numeric">To</th>
                            <th class="numeric">Date Filed</th>
                            <th class="numeric">Type</th>
                            <th class="numeric">Status</th>
                            <th class="numeric"></th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @forelse ($all_leave as $item)
                            <tr>
                                <td data-title="From">{{ $item->date_from }}</td>
                                <td data-title="To">{{ $item->date_to }}</td>
                                <td data-title="Date Filed">{{ date('F d, Y', $item->create_at) }}</td>
                                <td data-title="Type">{{ $item->type }}</td>
                                <td data-title="Status">
                                    @if ($item->status == 1)
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif ($item->status == 2)
                                        <span class="badge bg-success">Accepted</span>
                                    @elseif ($item->status == 3)
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                </td>
                                <td>
                                    <a target="_blank" href="{{ route('users.myleave.show', $item->id) }}"
                                        class="btn btn-primary btn-sm" title="Print"><i class="fa-solid fa-print"></i></a>
                                    @if ($item->status == 1)
                                        <a href="{{ route('hr.leaveApplication.show', $item->id) }}" onclick="return confirm('Are you sure?')"
                                            class="btn btn-outline-success text-white btn-sm" title="Accept"><i
                                                class="fa-solid fa-check"></i></a>
                                        <a href="{{ route('hr.leaveApplication.edit', $item->id) }}" onclick="return confirm('Are you sure?')"
                                            class="btn btn-danger btn-sm text-white" title="Reject"><i
                                                class="fa-solid fa-x"></i></a>
                                    @endif
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
                    {{ $all_leave->links('pagination.custom') }}
                </div>
            </div> --}}
        </div>
    </div>


@endsection
