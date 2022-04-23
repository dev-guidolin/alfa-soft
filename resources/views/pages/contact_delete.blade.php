@extends('template.app')
@section('title')
Agenda Alf Soft
@endSection()
@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-10 mx-auto">
            @if($success)
                <div class="alert alert-success text-center" role="alert">
                    {{ $message }}
                </div>
            @else
                <div class="alert alert-danger text-center" role="alert">
                    {{ $message }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
@section('exstra-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" ></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endSection()
@section('scripts')
<script>
    $(function (){
        setTimeout(function(){
            window.location.href = "{{ url('/')  }}"
        },2000)
    })
</script>
@endSection()
