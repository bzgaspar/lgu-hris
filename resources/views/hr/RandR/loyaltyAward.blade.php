@extends('layouts.app')

@section('title', 'Loyalty Award')
@section('content')
    <div class="row justify-content-center">
        <h3>Loyalty Award</h3>
        <div class="col-12 col-md-10 mt-3">

            <div class="row justify-content-end">
                <div class="col-12 col-md text-end">
                    <form action="{{ route('hr.loyalty.index') }}" method="get">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="search" placeholder="Search Employee"
                                aria-label="Recipient's username" aria-describedby="button-addon2"
                                value="{{ old('search') }}">
                            <button class="btn btn-outline-warning fw-bold"><i
                                    class="fa-solid fa-magnifying-glass me-1"></i>Search</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <h1 class="h3">Service Record History</h1>
                <div class="col">
                    {{-- table --}}
                    <div class="table-responsive" id="no-more-tables">
                        <table class="table table-hover table-striped smnall table-sm text-center">
                            <thead>
                                <tr class="table-light">
                                    <th class="numeric" width="20%">Employee</th>
                                    <th class="numeric">Department</th>
                                    <th class="numeric">Years in Service</th>
                                    <th class="numeric" colspan="2" width="20%">Next Loyalty Pay</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                {{-- {{ dd($all_users) }} --}}
                                @forelse ($all_users as $user)
                                    <tr>
                                        <td data-title="Employee">{{ $user->first_name }} {{ $user->last_name }}</td>
                                        <td data-title="Department">
                                            @if ($user->empPlantilla)
                                                {{ $user->empPlantilla->department->name }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td data-title="Years in Service">
                                            @if ($user->hasloyaltyRecord())
                                                {{ $user->loyaltyRecord->year_difference }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td data-title="Next Loyalty Pay">
                                            @if ($user->hasloyaltyRecord())
                                                {{ date('M, d Y', strtotime($user->loyaltyRecord->next_loyalty)) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td data-title="Next Loyalty Pay">
                                            @if ($user->hasloyaltyRecord())

                                                {{ \Carbon\Carbon::parse($user->loyaltyRecord->next_loyalty)->diffForHumans() }}
                                            @else
                                                -
                                            @endif
                                        </td>

                                        {{-- <td> ->diffForHumans()
                                            <a href="#" class="btn btn-outline-danger"><i
                                                    class="fa-solid fa-trash-can"></i></a>
                                        </td> --}}
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No Records</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {{ $all_users->links('pagination.custom') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
