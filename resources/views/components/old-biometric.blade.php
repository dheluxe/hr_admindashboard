@foreach ($biometrics as $biometric )
<a class="btn wave-effect biometric-data " type="submit"  >
    <i class="icofont-finger-print text-success "></i> <br>
    <i class="icofont-trash text-danger delete-biometric" data-id="{{$biometric->id}}"></i>
    <p class="mb-0 text-muted"  >Fingerprint {{$loop->iteration}}</p>

</a>
@endforeach
