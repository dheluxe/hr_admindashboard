@extends('layouts.app')
@section('title','Company Setting')

@section('content')

        <div class="card ">
            <div class="card-body p-5">
                <div class="row">
                <div class="col-md-6 mb-2">
                    <p class="mb-0 font-weight-bold">Company Name</p>
                    <span>{{$settings->company_name}}</span>
                </div>
                <div class="col-md-6 mb-2">
                    <p class="mb-0 font-weight-bold">Company Email</p>
                    <span>{{$settings->company_email}}</span>
                </div>
                <div class="col-md-6 mb-2">
                    <p class="mb-0 font-weight-bold">Company Phone</p>
                    <span>{{$settings->company_phone}}</span>
                </div>
                <div class="col-md-6 mb-2 ">
                    <p class="mb-0 font-weight-bold">Company Addres</p>
                    <span>{{$settings->company_address}}</span>
                </div>
                <div class="col-md-6 mb-2">
                    <p class="mb-0 font-weight-bold">Office Start Time</p>
                    <span>{{$settings->office_start_time}}</span>
                </div>
                <div class="col-md-6 mb-2">
                    <p class="mb-0 font-weight-bold">Office End Time</p>
                    <span class="text-muted">{{$settings->office_end_time}}</span>
                </div>
                <div class="col-md-6 mb-2" >
                    <p class="mb-0 font-weight-bold">Bread Start Time</p>
                    <span>{{$settings->bread_start_time}}</span>
                </div>
                <div class="col-md-6 mb-2">
                    <p class="mb-0 font-weight-bold">Bread End Time</p>
                    <span>{{$settings->bread_end_time}}</span>
                </div>
                @can('edit_company_setting')
                    <div class="col-12 text-center mt-3">
                    <a href="{{route('companysetting.edit',$settings->id)}}" class="btn  btn-warning"><i class="fas fa-edit mr-2"></i>Edit Company Setting </a>
                    </div>
                    @endcan
            </div>
        </div>
        </div>
@endsection
@section('script')
<script>
    @if(session('success'))
                        Swal.fire({
                        title:"SuccessFully Created",
                        text:'{{session('success')}}',
                        icon:'success',
                            })
            @endif
</script>
@endsection
