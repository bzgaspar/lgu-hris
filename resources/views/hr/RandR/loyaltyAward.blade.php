@extends('layouts.app')

@section('title', 'Loyalty Award')
@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 mt-3">
            <div class="row">
                <div class="col">
                    {{-- table --}}
                    <hr-loyalty_reward />
                    {{-- <div class="table-responsive" id="no-more-tables">
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
                    </div> --}}
                </div>
            </div>
        </div>
    </div>


@endsection
