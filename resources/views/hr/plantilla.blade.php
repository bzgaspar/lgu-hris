@extends('layouts.app')

@section('title', 'Plantilla Management')
@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-10">
            <h2>Department</h2>
            <div class="row justify-content-center">
                <div class="col-12 col-md-4">
                    @if ($edit_dep)
                        <form action="{{ route('hr.department.update', $edit_dep->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                        @else
                            <form action="{{ route('hr.department.store') }}" method="POST">
                                @csrf
                    @endif
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-1">
                                <input type="text"
                                    class="form-control text-uppercase @error('dep_id') is-invalid @enderror" name="dep_id"
                                    id="formId1" placeholder="Department ID"
                                    @if ($edit_dep) value="{{ old('dep_id', $edit_dep->dep_id) }}"
                                @else
                                value="{{ old('dep_id') }}" @endif>
                                <label for="formId1">Department ID</label>
                                @error('dep_id')
                                    <p class="text-danger small">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-1">
                                <input type="text"
                                    class="form-control text-uppercase @error('name') is-invalid @enderror" name="name"
                                    id="formId1" placeholder="Department Name"
                                    @if ($edit_dep) value="{{ old('name', $edit_dep->name) }}"
                                @else
                                value="{{ old('name') }}" @endif>
                                <label for="formId1">Department Name</label>
                                @error('name')
                                    <p class="text-danger small">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-outline-success w-100 mb-3" type="submit">
                        @if ($edit_dep)
                            <i class="fa fa-upload me-1" aria-hidden="true"></i> Save
                        @else
                            <i class="fa fa-plus me-1" aria-hidden="true"></i> Add
                        @endif
                    </button>
                    </form>
                </div>
                <div class="col-12 col-md">
                    <hr-department></hr-department>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row justify-content-center mt-5">
        <div class="col-12 col-md-10">
            <p class="float-start h3 m-0">Employee Plantilla
            </p>
            <p class="float-end m-0">
                <a target="_blank" href="{{ route('hr.plantilla.create') }}" class="btn btn-outline-success"><i
                        class="fa-solid fa-print me-1"></i>Print All Plantilla</a>
            </p>
            @if ($edit_plan)
                <form action="{{ route('hr.plantilla.update', $edit_plan->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                @else
                    <form action="{{ route('hr.plantilla.store') }}" method="POST">
                        @csrf
            @endif
            <div class="row mt-5">
                <div class="col-12 col-md-2">
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control @error('EPno') is-invalid @enderror" name="EPno"
                            id="formId1" placeholder="Plantilla No."
                            @if ($edit_plan) value="{{ old('EPno', $edit_plan->EPno) }}"
                        @else
                        value="{{ old('EPno') }}" @endif>
                        <label for="formId1">Plantilla No.</label>
                        @error('EPno')
                            <p class="text-danger small">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control text-uppercase @error('EPposition') is-invalid @enderror"
                            name="EPposition" id="formId1" placeholder="Position Title"
                            @if ($edit_plan) value="{{ old('EPposition', $edit_plan->EPposition) }}"
                        @else
                        value="{{ old('EPposition') }}" @endif>
                        <label for="formId1">Position title</label>
                        @error('EPposition')
                            <p class="text-danger small">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="form-floating">
                        <select class="form-select" id="floatingSelect"name="incumbent"
                            aria-label="Floating label select example">
                            <option value="" hidden>Select Incumbent</option>
                            @foreach ($all_user as $user)
                                @if ($edit_plan)
                                    <option @if ($edit_plan->user_id === $user->id) selected @endif value="{{ $user->id }}">
                                        {{ $user->first_name . ' ' . $user->last_name }}
                                    </option>
                                @else
                                    @if (!$user->empWithPlantilla($user->id))
                                        <option value="{{ $user->id }}">
                                            {{ $user->first_name . ' ' . $user->last_name }}
                                        </option>
                                    @endif
                                @endif
                            @endforeach
                        </select>
                        <label for="Incumbent" class="form-label">Incumbent</label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-md-4">
                    <div class="form-floating">
                        <select class="form-select @error('department') is-invalid @enderror"
                            id="floatingSelect"name="department" aria-label="Floating label select example">
                            <option value="" hidden>Select Department</option>
                            @foreach ($all_department as $dep)
                                <option
                                    @if ($edit_plan) @if ($edit_plan->dep_id === $dep->id) selected @endif
                                    @endif value="{{ $dep->id }}">
                                    {{ $dep->name }}
                                </option>
                            @endforeach
                        </select>
                        <label for="Incumbent" class="form-label">Department</label>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-floating">
                        <select class="form-select" id="floatingSelect"name="EPdesignation"
                            aria-label="Floating label select example">
                            <option hidden>Select Designation</option>
                            @foreach ($all_department as $dep)
                                <option
                                    @if ($edit_plan) @if ($edit_plan->EPdesignation === $dep->id)
                                selected @endif
                                    @endif
                                    value="{{ $dep->id }}">{{ $dep->name }}
                                </option>
                            @endforeach
                        </select>
                        <label for="Incumbent" class="form-label">Designation</label>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-floating">
                        <select class="form-select form-select-lg" name="status" id="status">
                            <option hidden>Employment Status</option>
                            <option @if ($edit_plan) @if ($edit_plan->status == 1) selected @endif
                                @endif value="1">Permananent</option>
                            <option @if ($edit_plan) @if ($edit_plan->status == 2) selected @endif
                                @endif value="2">Co-terminus</option>
                            <option @if ($edit_plan) @if ($edit_plan->status == 3) selected @endif
                                @endif value="3">Casual</option>
                            <option @if ($edit_plan) @if ($edit_plan->status == 4) selected @endif
                                @endif value="4">Appointed</option>
                            <option @if ($edit_plan) @if ($edit_plan->status == 5) selected @endif
                                @endif value="5">Elective</option>
                        </select>
                        <label for="status" class="form-label">Employment Status</label>
                    </div>
                </div>
            </div>
            <button class="btn btn-outline-success w-100" type="submit">
                @if ($edit_plan)
                    <i class="fa fa-upload me-1" aria-hidden="true"></i> Save
                @else
                    <i class="fa fa-plus me-1" aria-hidden="true"></i> Add
                @endif
            </button>
            <hr>
            </form>
        </div>
        <hr-plantilla></hr-plantilla>
        <div class="col-12 col-md-10 mt-3">

        </div>
    </div>

@endsection

@section('customJS')
    <script src="{{ asset('storage/js/selectSort.js') }}"></script>

@endsection
