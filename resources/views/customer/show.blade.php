@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">DETAIL CUSTOMER
                <a class="badge badge-primary float-right" href="{{route('customer.index')}}">Back To List</a>
                </div>
                @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                @endif

                @if ($errors->any())
                    <div class="alert btn-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card-body">
                    <input type="hidden" name="id" id="id" value="{{ $customer->cst_id }}">
                    <div class="card-shadow">
                        <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="cst_name" name="cst_name" placeholder="Name" value="{{$customer->cst_name}}" disabled>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="cst_email" name="cst_email" placeholder="Email" value="{{$customer->cst_email}}" disabled>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="name">Date of Birth</label>
                                        <input type="text" class="form-control" id="cst_dob" name="cst_dob" placeholder="YYYY-MM-DD" value="{{$customer->cst_dob}}" disabled>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email">Phone Number</label>
                                        <input type="number" class="form-control" id="cst_phoneNum" name="cst_phoneNum" placeholder="Phone Number"  value="{{$customer->cst_phoneNum}}" disabled>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="nationality_id">Nationality</label>
                                        <select name="nationality_id" disabled class="form-control">
                                            <option value="">Choose Nationality</option>
                                            @foreach ($nationalities as $nationality)
                                            <option value="{{ $nationality->nationality_id }}" {{$nationality->nationality_id == $customer->nationality_id  ? 'selected' : ''}}>
                                                {{$nationality->nationality_name}}
                                            </option>        
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                        </div>
                    </div>

                    <div class="card-shadow">
                        <div class="card-body family-list">
                        <u>Family List</u>
                        @foreach ($familyLists as $family)
                            <div class="row p-1">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="fl_name[]" value="{{$family->fl_name}}" disabled placeholder="Family Name">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="fl_relation[]" value="{{$family->fl_relation}}" disabled placeholder="Family Status">
                                </div>
                                <div class="col-md-4"> 
                                    <input type="text" class="form-control" name="fl_dob[]" value="{{$family->fl_dob}}" disabled placeholder="YYYY-MM-DD">
                                </div>
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
