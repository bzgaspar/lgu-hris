@extends('layouts.app')

@section('customCSS')
    <link href="{{ asset('storage/css/circle-graph.css') }}" rel="stylesheet">
@endsection
@section('title', 'Admin | User Management')
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg col-sm-12">
            <div class="single-chart mx-auto">
                <svg viewBox="0 0 36 36" class="circular-chart success">
                    <path class="circle-bg" d="M18 2.0845
                                  a 15.9155 15.9155 0 0 1 0 31.831
                                  a 15.9155 15.9155 0 0 1 0 -31.831" />
                    <path class="circle"
                        stroke-dasharray="
                    {{ ($user_count['total_ol_alluser'] / $user_count['total_alluser']) * 100 }}
                    , 100"
                        d="M18 2.0845
                                  a 15.9155 15.9155 0 0 1 0 31.831
                                  a 15.9155 15.9155 0 0 1 0 -31.831" />
                    <text x="18" y="20.35"
                        class="percentage">{{ $user_count['total_ol_alluser'] . '/' . $user_count['total_alluser'] }}</text>
                </svg>
            </div>
            <h3 class="text-center">Overall Users</h3>
        </div>
        <div class="col-lg col-sm-12">
            <div class="single-chart mx-auto">
                <svg viewBox="0 0 36 36" class="circular-chart warning">
                    <path class="circle-bg" d="M18 2.0845
                                  a 15.9155 15.9155 0 0 1 0 31.831
                                  a 15.9155 15.9155 0 0 1 0 -31.831" />
                    <path class="circle"
                        stroke-dasharray="

                    {{ ($user_count['ol_emp_count'] / $user_count['total_emp_count']) * 100 }}
                    , 100"
                        d="M18 2.0845
                                  a 15.9155 15.9155 0 0 1 0 31.831
                                  a 15.9155 15.9155 0 0 1 0 -31.831" />
                    <text x="18" y="20.35"
                        class="percentage">{{ $user_count['ol_emp_count'] . '/' . $user_count['total_emp_count'] }}</text>
                </svg>
            </div>
            <h3 class="text-center">Employee Count</h3>
        </div>
        <div class="col-lg col-sm-12">
            <div class="single-chart mx-auto">
                <svg viewBox="0 0 36 36" class="circular-chart primary">
                    <path class="circle-bg" d="M18 2.0845
                                  a 15.9155 15.9155 0 0 1 0 31.831
                                  a 15.9155 15.9155 0 0 1 0 -31.831" />
                    <path class="circle"
                        stroke-dasharray="
                    {{ ($user_count['ol_users_count'] / $user_count['total_users_count']) * 100 }}
                    , 100"
                        d="M18 2.0845
                                  a 15.9155 15.9155 0 0 1 0 31.831
                                  a 15.9155 15.9155 0 0 1 0 -31.831" />
                    <text x="18" y="20.35"
                        class="percentage">{{ $user_count['ol_users_count'] . '/' . $user_count['total_users_count'] }}</text>
                </svg>
            </div>
            <h3 class="text-center">User Count</h3>
        </div>
    </div>
    <hr>
    @can('isAdmin')
        <div class="my-3">
            <div class="row">
                <div class="col">
                    <a href="{{ route('admin.backUp') }}" class="btn btn-success">Backup</a>
                    <a href="{{ route('admin.backUp') }}" class="btn btn-success">Backup DB</a>
                    <a href="{{ route('admin.backUpClean') }}" class="btn btn-success">Clean Backup</a>
                </div>
            </div>
        </div>
    @endcan

    <form action="{{ route('admin.user.store') }}" method="POST">
        @csrf
        <div class="row mt-4 align-items-center">
            <h3>Add User</h3>
            <div class="col-12 col-md">
                <div class="input-group mb-3">
                    <input type="text" name="first_name" aria-label="First name"
                        class="form-control @error('first_name') is-invalid @enderror"
                        placeholder="First Name @error('first_name') | {{ $message }} @enderror">
                    <input type="text" name="last_name" aria-label="Last name"
                        class="form-control @error('last_name') is-invalid @enderror"
                        placeholder="Last Name @error('last_name') | {{ $message }} @enderror">
                    <input type="text" name="email" aria-label="Last name"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="Email @error('email') | {{ $message }} @enderror">
                    <button class="btn btn-outline-success" id="button-addon2"><i class="fa-solid fa-circle-plus"></i>
                        Add</button>
                </div>
            </div>
        </div>
    </form>
    <hr>
    <div class="row justify-content-end">
        <div class="col-12 col-md-4 text-end">
            <form action="{{ route('admin.user.index') }}" method="get">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="search" placeholder="Search"
                        aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ old('search') }}">
                    <button class="btn btn-outline-warning fw-bold"><i
                            class="fa-solid fa-magnifying-glass me-1"></i>Search</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col table-responsive" id="no-more-tables">
            <table class="table table-hover table-striped small table-sm">
                <thead>
                    <tr class="table-light">
                        <th class="numeric">Name</th>
                        <th class="numeric">Email</th>
                        <th class="numeric" width="15%">Role</th>
                        <th class="numeric">Status</th>
                        <th class="numeric" width="15%"></th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @forelse ($all_users as $user)
                        <tr>
                            <td data-title="Name">{{ $user->first_name . ' ' . $user->last_name }}</td>
                            <td data-title="Email">{{ $user->email }}</td>
                            <td data-title="Role">
                                <form action="{{ route('admin.user.update', $user->id) }}" method="POST" id="role_id">
                                    @csrf
                                    @method('PATCH')
                                    <select @if ($user->id === '1') disabled @endif
                                        class="form-select form-select-sm" name="user_role" id="user_role"
                                        onchange="submit()">
                                        <option @if ($user->role === '0') selected @endif value="0">Admin
                                        </option>
                                        <option @if ($user->role === '1') selected @endif value="1">User
                                        </option>
                                        <option @if ($user->role === '2') selected @endif value="2">
                                            Employee</option>
                                        <option @if ($user->role === '3') selected @endif value="3">Head
                                        </option>
                                        <option @if ($user->role === '4') selected hidden @endif value="4">
                                            HR
                                        </option>
                                        <option @if ($user->role === '7') selected hidden @endif value="7">
                                            HR Head
                                        </option>
                                        <option @if ($user->role === '5') selected hidden @endif value="5">
                                            Mayor
                                        </option>
                                        <option @if ($user->role === '6') selected hidden @endif value="6">
                                            Retired
                                        </option>
                                        <option @if ($user->role === '8') selected hidden @endif value="8">
                                            Resigned
                                        </option>
                                        <option @if ($user->role === '8') selected hidden @endif value="8">
                                            Transferred
                                        </option>
                                    </select>
                                </form>
                            </td>
                            <td data-title="Status">
                                @if ($user->trashed())
                                    <span class="badge bg-danger">
                                        Block
                                    </span>
                                @elseif (Cache::has('user-is-online-' . $user->id))
                                    <span class="badge bg-success">
                                        Online
                                    </span>
                                @elseif ($user->status == 0)
                                    <span class="badge bg-warning">
                                        Banned
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        Offline
                                    </span>
                                @endif
                            </td>
                            <td data-title="">
                                <div class="btn-group btn-group-sm align-items-center" role="group"
                                    aria-label="Small button group">
                                    <form action="{{ route('admin.user.delete', $user->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button data-bs-toggle="modal" data-bs-target="#delete-notif-modal"
                                            data-confirm="Are you sure to Delete this User??"
                                            data-target="{{ route('admin.user.delete', $user->id) }}"
                                            class="btn btn-dark btn-sm text-white delete"
                                            value="{{ $user->id }}">Delete</button>

                                    </form>
                                    <a href="{{ route('admin.user.reset', $user->id) }}"
                                        class="btn btn-outline-primary text-small fw-bold">
                                        Reset
                                    </a>
                                    @if ($user->trashed())
                                        <button data-bs-toggle="modal" data-bs-target="#patch-notif-modal"
                                            data-confirm="Are you sure to Unblock this User?"
                                            data-target="{{ route('admin.user.activate', $user->id) }}"
                                            class="btn btn-outline-success btn-sm patch"
                                            value="{{ $user->id }}">Activate</button>
                                    @else
                                        <button data-bs-toggle="modal" data-bs-target="#delete-notif-modal"
                                            data-confirm="Are you sure to Block this User??"
                                            data-target="{{ route('admin.user.destroy', $user->id) }}"
                                            class="btn btn-danger btn-sm text-white delete"
                                            value="{{ $user->id }}">Block</button>

                                        {{-- <button class="btn btn-outline-danger text-small fw-bold" onclick="block_user.submit()">
                                            Block
                                        </button> --}}
                                    @endif
                                    @if ($user->status == 0)
                                        <button data-bs-toggle="modal" data-bs-target="#patch-notif-modal"
                                            data-confirm="Are you sure to Unbanned this User??"
                                            data-target="{{ route('admin.user.unbanned', $user->id) }}"
                                            class="btn btn-warning btn-sm  text-white patch"
                                            value="{{ $user->id }}">Unbanned</button>
                                    @endif
                                </div>
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
                {{ $all_users->links('pagination.custom') }}
            </div>
        </div>
    </div>

@endsection
