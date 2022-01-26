@extends('layouts.app-plain')
@section('title','CheckIn-CheckOut')
@section('extra_css')
<style>

</style>

@endsection
@section('content')

        <div class="d-flex align-items-center justify-content-center " style="height: 100vh">
            <div class="col-md-6">
                <div class="card ">
                    <div class="card-body p-4">
                        <div class="text-center my-3">
                          <h3 class="mb-0">QR Code</h3>
                        <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate($hash_value)) !!} ">
                                <p class="text-muted">Please scan QR Code to Check In (or)Check Out</p>
                        </div>
                        <hr>
                       <div class="text-center mb-4 mt-3">
                           <h3 class="mb-3">Enter PinCode</h3>
                        <div class="mb-3">
                            <input type="text" name="mycode" id="pincode-input1" autofocus  >
                        </div>
                        <p class="text-muted mb-0">Please enter Pin Code to Check In (or)Check Out</p>

                       </div>

                    </div>
                </div>
            </div>
        </div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $('#pincode-input1').pincodeInput({inputs:4,complete:function(value, e, errorElement){
          console.log("code entered: " + value);
                $.ajax({
                    url:'/checkin-checkout/store',
                    type:'POST',
                    data:{"pin_code": value},
                    success:function (res){
                    if (res.status == 'success' ) {
                        Toast.fire({
                            icon: 'success',
                            title: res.message
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: res.message
                        });
                    }
                    $('.pincode-input-container .pincode-input-text ').val('');
                    $('.pincode-input-text').first().select().focus();
                    }
                });

          /*do some code checking here*/

        //   $(errorElement).html("I'm sorry, but the code not correct");
        }});
        $('.pincode-input-text').first().select().focus();
    })
</script>

@endsection
