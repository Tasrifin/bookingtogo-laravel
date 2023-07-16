@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">UPDATE CUSTOMER
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
                @method('PUT')
                <div class="card-body">
                    <input type="hidden" name="id" id="id" value="{{ $customer->cst_id }}">
                    <div class="card-shadow">
                        <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="cst_name" name="cst_name" placeholder="Name" value="{{$customer->cst_name}}" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="cst_email" name="cst_email" placeholder="Email" value="{{$customer->cst_email}}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="name">Date of Birth</label>
                                        <input type="text" class="form-control selector" id="cst_dob" autocomplete="off" name="cst_dob" placeholder="YYYY-MM-DD" value="{{$customer->cst_dob}}" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email">Phone Number</label>
                                        <input type="number" class="form-control" id="cst_phoneNum" name="cst_phoneNum" placeholder="Phone Number"  value="{{$customer->cst_phoneNum}}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="nationality_id">Nationality</label>
                                        <select name="nationality_id" required class="form-control">
                                            <option value="">Choose Nationality</option>
                                            @foreach ($nationalities as $nationality)
                                            <option value="{{ $nationality->nationality_id }}" {{$nationality->nationality_id == $customer->nationality_id  ? 'selected' : ''}}>
                                                {{$nationality->nationality_name}}
                                            </option>        
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row float-right" id="add-family">
                                    <a class="btn btn-success btn-sm" onclick="addFamily()">
                                        <i class="text-white">+ Add Family</i>
                                    </a>    
                                </div>
                        </div>
                    </div>

                    <div class="card-shadow">
                        <div class="card-body family-list">
                        <u>Family List</u>
                        @foreach ($familyLists as $family)
                            <div class="row p-1">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="fl_name[]" value="{{$family->fl_name}}" required placeholder="Family Name">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="fl_relation[]" value="{{$family->fl_relation}}" required placeholder="Family Status">
                                </div>
                                <div class="col-md-3"> 
                                    <input type="text" class="form-control selector" name="fl_dob[]" value="{{$family->fl_dob}}" autocomplete="off" required placeholder="YYYY-MM-DD">
                                </div>
                                <div class="col-md-2 float-right">
                                    <button type="button" class="btn btn-small btn-danger" onclick="removeRow(this)">Delete</button>
                                </div>
                            </div>
                        @endforeach
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
    //appendrow
    function addFamily(){
        row = '<div class="row p-1">';
        row += '<div class="col-md-4">';
        row += '        <input type="text" class="form-control" name="fl_name[]" required placeholder="Family Name">';
        row += '</div>';
        row += '<div class="col-md-3">';
        row += '        <input type="text" class="form-control" name="fl_relation[]" required placeholder="Family Status">';
        row += '</div>';
        row += '<div class="col-md-3"> ';
        row += '        <input type="text" class="form-control selector" name="fl_dob[]" autocomplete="off" required placeholder="YYYY-MM-DD">';
        row += '</div>';
        row += '<div class="col-md-2 float-right">';
        row += '        <button type="button" class="btn btn-small btn-danger" onclick="removeRow(this)">Delete</button>';
        row += '</div>';
        row += '</div>';

        $(".family-list").append(row);

        $(".selector" ).datepicker({
            dateFormat: "yy-mm-dd"
        });
    }

    function removeRow(e){
        $(e).closest(".row").remove();
    }

    //store form
    function saveData(){
        var formData = new FormData(document.getElementById('create-form'));
        var id  = $('#id').val();
        let url = '{{ route("customer.update", ":id") }}'
        url = url.replace(':id', id);
        console.log(formData);
        event.preventDefault();

        $.ajax({
            url: url,
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
                    alert("Data Update Successfully!")
                    setTimeout(function(){
                            window.location.reload(true);
                    },500);
                }else{
                    console.log(response.message);
                    alert("Data Failed to Update! <br>" + response.message)
                }
            },
            error: function(xhr) {
                var data = JSON.parse(xhr.responseText);
                console.log(data);
                alert(data.message)
                $('.invalid-feedback').remove();
                $.each(data.errors,function(field_name,error){
                    $(document).find('[name='+field_name+']').after('<label class="error invalid-feedback m-0 small d-block">' +error+ '</label>')
                })
            }
        });
    }

</script>
@endpush
