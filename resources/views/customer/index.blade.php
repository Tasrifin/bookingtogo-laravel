@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">CUSTOMERS
                <a class="badge badge-primary float-right" href="{{route('customer.create')}}">Add New Customer</a>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>*</th>
                                <th>Name</th>
                                <th>DOB</th>
                                <th>Phone Number</th>
                                <th>Nationality</th>
                                <th>Email</th>
                                <th>Action</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $index => $dat)
                            <tr>
                                <td>{{ $data->firstItem() + $index }}</td>
                                <td>{{ $dat->cst_name }}</td>
                                <td>{{ $dat->cst_dob }}</td>
                                <td>{{ $dat->cst_phoneNum }}</td>
                                <td>{{ $dat->nationality->nationality_name ?? '' }} ({{ $dat->nationality->nationality_code ?? '' }})</td>
                                <td>{{ $dat->cst_email }}</td>
                                <td>
                                    <a href="{{route('customer.show', [$dat->cst_id])}}" class="badge badge-primary">
                                        Detail
                                    </a>
                                    <a href="{{route('customer.edit', [$dat->cst_id])}}" class="badge badge-success">
                                        Edit
                                    </a>
                                    <form onsubmit="return confirm('Delete this data permanently?')" class="d-inline"
                                        action="{{route('customer.destroy', [$dat->cst_id])}}"  method="POST" >
                                        @csrf
                                        @method('delete')
                                        <button class="badge badge-danger">
                                            <i class="fa fa-trash">Delete</i>
                                        </button>
                                    </form>
                                </td>
                                
                            </tr>
                            @empty
                             <tr>
                                 <td colspan="7" class="text-center">Data is Empty</td>
                             </tr>
                            @endforelse
                        </tbody>
                        
                    </table>
                    <!-- {{$data->links()}} -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
