@extends('layouts.app')

@section('title', 'Employee 201 Files')
@section('content')
    <div class="row justify-content-center">
        {{-- test123 --}}
        <div class="col-12 col-md-10 mt-3">
            @if ($files_201_edit)
                <form action="{{ route('users.Files_201.update', $files_201_edit->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                @else
                    <form action="{{ route('users.Files_201.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
            @endif
            <div class="row justify-content-center">
                <div class="col-12 col-md-8">
                    @if ($files_201_edit)
                        <iframe src="{{ asset('/storage/files_201/' . $files_201_edit->document) }}" frameborder="0"
                            style="width: 100%;
                            min-height: 300px;
                            border: none;"></iframe>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-floating mb-3">
                        <p></p>
                        <input type="text" class="form-control" name="type" id="type" placeholder=""
                            @if (!$files_201_edit) value="{{ old('type') }}"
                        @else
                        value="{{ old('type', $files_201_edit->type) }}" @endif>
                        <label for="type">Type</label>
                        @error('type')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="mb-3">
                        <label for="formFile" class="form-label small m-0 p-0">Upload Document</label>
                        <input name="document" class="form-control" type="file" id="formFile"
                            aria-describedby="file-info" accept=".pdf,.jpg,.jpeg,.png,.gif">
                        <div class="small" id="file-info">The maximun file is 8mb (PDF only)</div>
                        @error('document')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col text-end">
                @if ($files_201_edit)
                    <a href="{{ route('users.Files_201.index') }}" class="btn btn-outline-success">
                        <i class="fa-solid fa-xmark me-1"></i>Cancel</a>
                @endif
                <button type="submit" class="btn w-25 btn-success ">
                    <i class="fa fa-check me-1" aria-hidden="true"></i> Save
                </button>
            </div>
            </form>
            <table class="table table-hover table-striped smnall table-sm">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>File Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @forelse ($files_201 as $item)
                        <tr>
                            <td>{{ $item->type }}</td>
                            <td>{{ $item->document }}</td>
                            <td>

                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a target="_blank" href="{{ asset('/storage/files_201/' . $item->document) }}"
                                        class="btn btn-dark btn-sm">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('users.Files_201.edit', $item->id) }}"
                                        class="btn btn-warning btn-sm  text-white"><i class="fa fa-pencil text-white"
                                            aria-hidden="true"></i></a>
                                    <form action="{{ route('users.Files_201.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-danger btn-sm text-white rounded-0 rounded-end"
                                            onclick="return confirm('Are you sure?')"><i
                                                class="fa-solid fa-trash-can me-1"></i> </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <td colspan="3">
                            <p class="text-center">No Files Yet.</p>
                        </td>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


@endsection
