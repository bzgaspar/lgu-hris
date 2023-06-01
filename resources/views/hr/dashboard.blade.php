@extends('layouts.app')

@section('customCSS')
    <link href="{{ asset('storage/css/circle-graph.css') }}" rel="stylesheet">
@endsection
@section('title', 'Employees')
@section('content')
    <dashboard-employee></dashboard-employee>
    {{-- <div class="row justify-content-center text-center">
        <div class="col table-responsive" id="no-more-tables">
            <table class="table table-hover table-striped small table-sm">
                <thead>
                    <tr class="table-light">
                        <th class="numeric">Name</th>
                        <th class="numeric" width="15%">Department</th>
                        <th class="numeric">Status</th>
                        <th class="numeric"></th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @forelse ($users as $user)
                        <tr>
                            <td data-title="Name">{{ $user->first_name . ' ' . $user->last_name }}</td>
                            <td data-title="Department">
                                @if ($user->empPlantilla)
                                    {{ $user->empPlantilla->designation->name }}
                                @else
                                    -
                                @endif
                            </td>
                            <td data-title="Status">
                                @if (Cache::has('user-is-online-' . $user->id))
                                    <span class="badge bg-success">
                                        Online
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        Offline
                                    </span>
                                @endif
                            </td>
                            <td data-title="Print">
                                <a target="_blank" href="{{ route('hr.dashboard.show',$user->id) }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-print me-1"></i> COE</a>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No users found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-center">
                {{ $users->links('pagination.custom') }}
            </div>
        </div>
    </div> --}}

@endsection
