@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">ADD NEW CUSTOMER
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

                <form class="custom-validation" id="create-form" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="card-body">
                    <div class="card-shadow">
                        <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="cst_name" name="cst_name" placeholder="Name" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="cst_email" name="cst_email" placeholder="Email" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="name">Date of Birth</label>
                                        <input type="text" class="form-control" id="cst_dob" name="cst_dob" placeholder="YYYY-MM-DD" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email">Phone Number</label>
                                        <input type="number" class="form-control" id="cst_phoneNum" name="cst_phoneNum" placeholder="Phone Number" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="nationality_id">Nationality</label>
                                        <select name="nationality_id" required class="form-control">
                                            <option value="">Choose Nationality</option>
                                            @foreach ($nationalities as $nationality)
                                            <option value="{{ $nationality->nationality_id }}">
                                                {{$nationality->nationality_name}}
                                            </option>        
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row float-right" id="add-family">
                                    <a class="btn btn-success btn-sm">
                                        <i class="text-white">+ Add Family</i>
                                    </a>
                                </div>
                        </div>
                    </div>

                    <div class="card-shadow">
                        <div class="card-body family-list">
                        <u>Family List</u>
        
                        </div>
                        <div class="card-body mb-2">
                            <div class="row float-right">
                                <div class="col-md-2">
                                    <a class="btn btn-success text-white" onclick="saveData()">
                                        Save
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function(){

        //append row
        $("#add-family" ).on("click", function() {
            row = '<div class="row p-1">';
            row += '<div class="col-md-4">';
            row += '        <input type="text" class="form-control" name="fl_name[]" required placeholder="Family Name">';
            row += '</div>';
            row += '<div class="col-md-3">';
            row += '        <input type="text" class="form-control" name="fl_relation[]" required placeholder="Family Status">';
            row += '</div>';
            row += '<div class="col-md-3"> ';
            row += '        <input type="text" class="form-control" name="fl_dob[]" required placeholder="YYYY-MM-DD">';
            row += '</div>';
            row += '<div class="col-md-2 float-right">';
            row += '        <button type="button" class="btn btn-small btn-danger" onclick="removeRow(this)">Delete</button>';
            row += '</div>';
            row += '</div>';

            $(".family-list").append(row);
        });
    });

    //remove row
    function removeRow(e){
        $(e).closest(".row").remove();
    }

    //store form
    function saveData(){
        var formData = new FormData(document.getElementById('create-form'));
        console.log(formData);
        event.preventDefault();

        $.ajax({
            url: '{{ route("customer.store") }}',
            type:"POST",
            dataType: 'json',
            data: formData,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function() {
            },
            success:function(response){
                if(response.success == true){
                    alert("Data Saved Successfully!")
                    setTimeout(function(){
                            window.location.reload(true);
                    },500);
                }else{
                    console.log(response.message);
                    alert("Data Failed to Save! <br>" + response.message)
                }
            },
            error: function(xhr) {
                console.log(xhr.responseJSON.errors);
                alert("Please Fill All Data with Right Format")
                $('.invalid-feedback').remove();
                $.each(xhr.responseJSON.errors,function(field_name,error){
                    $(document).find('[name='+field_name+']').after('<label class="error invalid-feedback m-0 small d-block">' +error+ '</label>')
                })
            }
        });
    }
</script>
@endpush
