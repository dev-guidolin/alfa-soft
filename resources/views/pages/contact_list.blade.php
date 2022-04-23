@extends('template.app')
@section('title')
    Agenda Alf Soft
@endSection()
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-12 mx-auto">
                <table class="table table-striped">
                    <thead>
                    <tr class="text-center">
                        <th>Nome</th>
                        <th>Contato</th>
                        <th>Email</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->contact }}</td>
                            <td>{{ $user->email  }}</td>
                            <td class="text-center">
                                <a href="{{ url('/user/detail',$user->id)  }}">
                                    <button type="button" class="btn btn-primary" title="Ver detalhes"><i class="bi bi-eye"></i> Detalhe</button>
                                </a>
                            </td>
                        </tr>
                    @endForeach
                    </tbody>
                </table>
            </div>
            <div class="col-sm-10">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endSection()
