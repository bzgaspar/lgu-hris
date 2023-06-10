@extends('layouts.app')

@section('title', 'My Leave')
@section('content')



    <div class="row justify-content-center">
        <h3>My Leave</h3>
        <div class="col-12 col-md-10 mt-3">
            <form action="{{ route('users.myleave.store') }}" method="post">
                @csrf
                <div class="row justify-content-center mb-5">
                    <div class="col">
                        <div class="row">
                            <div class="col-12 col-md">
                                <div class="form-floating mb-1">
                                    <select type="text" class="form-select  @error('type') is-invalid @enderror"
                                        name="type" id="type">
                                        <option value="">Select Type</option>
                                        <option value="Vacation Leave">Vacation Leave</option>
                                        <option value="Mandatory Force Leave">Mandatory Force Leave</option>
                                        <option value="Sick Leave">Sick Leave</option>
                                        <option value="Maternity Leave">Maternity Leave</option>
                                        <option value="Paternity Leave">Paternity Leave</option>
                                        <option value="Special Privilege Leave">Special Privilege Leave</option>
                                        <option value="Solo Parent Leave">Solo Parent Leave</option>
                                        <option value="Study Leave">Study Leave</option>
                                        <option value="10-day VAWC leave">10-day VAWC leave</option>
                                        <option value="Rehabilitation Privilege">Rehabilitation Privilege</option>
                                        <option value="Special Leave Benifits for Women">Special Leave Benifits for Women
                                        </option>
                                        <option value="Special Emergency (Calamity) Leave">Special Emergency (Calamity)
                                            Leave</option>
                                        <option value="Adoption Leave">Adoption Leave</option>
                                        <option value="OTHERS">OTHERS</option>
                                    </select>
                                    <label for="type">Type of Leave</label>
                                </div>
                                @error('type')
                                    <p class="small text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-12 col-md">
                                <div class="form-floating mb-1">
                                    <select type="text" class="form-select @error('details_leave') is-invalid @enderror"
                                        name="details_leave" id="details_leave">
                                        <option value="">Select Details</option>
                                        <option value="Within Philippines">Within Philippines</option>
                                        <option value="Abroad">Abroad</option>
                                        <option value="In Hospital">In Hospital</option>
                                        <option value="Out Patient">Out Patient</option>
                                        <option value="Complication">Complication</option>
                                        <option value="BAR/Board Examination Review">BAR/Board Examination Review</option>
                                        <option value="Monetization of Leave Credits">Monetization of Leave Credits</option>
                                        <option value="Terminal Leave">Terminal Leave</option>
                                    </select>
                                    <label for="details_leave">Details of Leave</label>
                                </div>
                                @error('details_leave')
                                    <p class="small text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md">
                                <div class="form-floating mb-1">
                                    <input type="text" class="form-control" name="type_other" id="type_other"
                                        placeholder="Other / Specify Here">
                                    <label for="type_other">Other</label>
                                </div>
                            </div>
                            <div class="col-12 col-md">
                                <div class="form-floating mb-1">
                                    <input type="text" class="form-control" name="details_other" id="details_other"
                                        placeholder="Other / Specify Here">
                                    <label for="details_other">Other</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="form-floating mb-1">
                                    <input type="text" class="form-control @error('num_days') is-invalid @enderror"
                                        name="num_days" id="num_days" placeholder="Number of Working Days">
                                    <label for="num_days">Number of Working Days</label>
                                </div>
                                @error('num_days')
                                    <p class="small text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-12 col-md">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-floating mb-1">
                                            <input type="date"
                                                class="form-control @error('date_from') is-invalid @enderror"
                                                name="date_from" id="date_from" placeholder="">
                                            <label for="date_from">Date From</label>
                                        </div>
                                        @error('date_from')
                                            <p class="small text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <div class="form-floating mb-1">
                                            <input type="date"
                                                class="form-control @error('date_to') is-invalid @enderror" name="date_to"
                                                id="date_to" placeholder="">
                                            <label for="date_to">Date To</label>
                                        </div>
                                        @error('date_to')
                                            <p class="small text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-outline-success w-100" type="submit"><i class="fa-solid fa-plus me-2"></i>
                            File</button>
                    </div>
                </div>
            </form>
            <hr>
            {{-- table --}}
            <div class="table-responsive" id="no-more-tables">
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


                                    <form onsubmit="return confirm('Do you really want to delete your leave?');" action="{{ route('users.myleave.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <a target="_blank"
                                            href="{{ route('users.myleave.show', $item->id) }}"
                                            class="btn btn-primary btn-sm" title="Print"><i
                                                class="fa-solid fa-print"></i></a>
                                        @if ($item->status == 1)
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                title="Delete"><i class="fa-solid fa-trash"></i></button>
                                        @endif
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
                    {{ $all_leave->links('pagination.custom') }}
                </div>
            </div>
        </div>
    </div>


@endsection
