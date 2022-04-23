@extends('template.app')
@section('title')
    Agenda Alf Soft
@endSection()
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-8 mx-auto">
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <img class="rounded-2 shadow img-responsive" src="{{ $image->picture->large }}" alt="Contato usuário">
                    </div>
                    <div class="flex-grow-1 ms-3">
                       <h5> {{ $user->name }}</h5>
                        <p>
                            <b>Contact : </b><span>{{ $user->contact }}</span>
                            <br>
                            <b>Email: </b><span>{{ $user->email }}</span>
                        </p>
                        @if(true)
                            <span> <a href="{{ url('/user/edit',$user->id) }}" class="text-decoration-none">Editar</a></span>
                            <span class="ml-5"><a class="text-decoration-none text-danger" href="{{ url('/user/delete',$user->id) }}">Apagar</a></span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endSection()
