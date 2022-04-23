@extends('template.app')
@section('title')
    Agenda Alf Soft
@endSection()
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-8 mx-auto">
                <form id="formEdit" >
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required value="{{ $user->name }}">
                        <input type="hidden" class="form-control" id="id" name="id" required value="{{ $user->id }}">
                    </div>
                    <div class="mb-3">
                        <label for="contact" class="form-label">Contact</label>
                        <input type="text" class="form-control" id="contact" name="contact" required value="{{ $user->contact }}">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required value="{{ $user->email }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
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
        $("#contact").mask('(00) 0000-0000');

        $("#formEdit").on('submit',function (e){
            e.preventDefault();
            $.ajax({
                url: "{{ url('user/update') }}",
                method: "POST",
                data: $(this).serializeArray(),
                success: (response) =>{
                    if(response.success) {
                        Swal.fire({
                            title: 'Tudo certo!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'Fechar'
                        }).then(function (e){
                            window.location.href = "{{ url('/') }}";
                        })
                    }else{
                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'Fechar'
                        })
                    }
                },
                error: (err)=>{
                    Swal.fire({
                        title: 'Error!',
                        text: err.responseJSON.errors.id[0],
                        icon: 'error',
                        confirmButtonText: 'Fechar'
                    })
                    console.log()
                }
            })
        })
    </script>
@endSection()
