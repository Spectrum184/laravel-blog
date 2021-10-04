@extends('layouts.backend.app')
@push('header')
<link rel="stylesheet" href="{{asset('backend/vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" />
<link rel="stylesheet" href="{{asset('backend/vendors/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" />
<link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
@endpush
@section('content')

<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Dashboard</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li>Dashboard</li>
                    <li class="active">Profile</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content mt-3">
    <div class="row">
        <div class="col-md-12">
            @if ($errors->any())
            @foreach ($errors->all() as $error)
            <div class="alert  alert-danger alert-dismissible fade show" role="alert">
                <span class="badge badge-pill badge-danger">Error</span> {{$error}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            @endforeach
            @endif

        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title mb-3">Profile Card</strong>
                </div>
                <div class="card-body">
                    <div class="mx-auto d-block">
                        <img class="rounded-circle mx-auto d-block" src="{{asset('storage/user/' . $user->image)}}"
                            alt="Card image cap" style="width: 240px; height:240px;">
                        <h5 class="text-sm-center mt-2 mb-1">{{$user->name}}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Default Tab</h4>
                </div>
                <div class="card-body">
                    <div class="default-tab">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active show" id="nav-home-tab" data-toggle="tab"
                                    href="#nav-home" role="tab" aria-controls="nav-home"
                                    aria-selected="true">Profile</a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                                    role="tab" aria-controls="nav-profile" aria-selected="false">Credential</a>
                            </div>
                        </nav>
                        <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                aria-labelledby="nav-home-tab">
                                <form action="{{route('admin.profile.update')}}" method="POST"
                                    enctype="multipart/form-data" class="form-horizontal">
                                    @csrf
                                    @method('PUT')
                                    <div class="row form-group">
                                        <div class="col col-md-3"><label class=" form-control-label">Email</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <p class="form-control-static">{{$user->email}}</p>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-3"><label for="username"
                                                class=" form-control-label">Username</label></div>
                                        <div class="col-12 col-md-9"><input type="text" id="username" name="username"
                                                placeholder="username" class="form-control" value="{{$user->username}}">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-3"><label for="name"
                                                class=" form-control-label">Name</label></div>
                                        <div class="col-12 col-md-9"><input type="text" id="name" name="name"
                                                placeholder="name" class="form-control" value="{{$user->name}}"></div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-3"><label for="image"
                                                class=" form-control-label">Avatar</label></div>
                                        <div class="col-12 col-md-9"><input type="file" id="image" name="image"
                                                class="form-control-file"></div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-3"><label for="about"
                                                class=" form-control-label">About</label></div>
                                        <div class="col-12 col-md-9"><textarea name="about" id="about" rows="9"
                                                placeholder="About..." class="form-control">{{$user->about}}</textarea>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fa fa-dot-circle-o"></i> Submit
                                    </button>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                aria-labelledby="nav-profile-tab">
                                <form action="{{route('admin.profile.password')}}" method="POST"
                                    enctype="multipart/form-data" class="form-horizontal">
                                    @csrf
                                    @method('PUT')
                                    <div class="row form-group">
                                        <div class="col col-md-3"><label for="old_password"
                                                class=" form-control-label">Old Password</label></div>
                                        <div class="col-12 col-md-9"><input type="password" id="old_password"
                                                name="old_password" placeholder="Old Password" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-3"><label for="password" class=" form-control-label">New
                                                Password</label></div>
                                        <div class="col-12 col-md-9"><input type="password" id="password"
                                                name="password" placeholder="New Password" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-3"><label for="password_confirmation"
                                                class=" form-control-label">Confirm Password</label></div>
                                        <div class="col-12 col-md-9"><input type="password" id="password_confirmation"
                                                name="password_confirmation" placeholder="Confirm Password"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fa fa-dot-circle-o"></i> Submit
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('footer')
<script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
{!! Toastr::message() !!}
@endpush
