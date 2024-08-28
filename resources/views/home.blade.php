@extends('layouts.app_user')

@section('content')
<div class="container">

    <div class="row my-2 ">
        <div class="col-10">
        <a class="btn btn-primary" href="{{ url("/nasabah")}}">
            Tambah Nasabah
        </a>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        
        <div class="col ml-5 pl-5">

            <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-danger">
                Logout
            </button>
        </div>
        
    </div>

    <table id="nasabahTable" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Jenis Kelamin</th>
                <th>Pekerjaan</th>
                <th>Desa</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div> 
@endsection


@section('script')

<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.2.2/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.2/js/buttons.html5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#nasabahTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/data-nasabah",
                type: 'GET'
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'nama', name: 'nama' },
                { data: 'tempat_lahir', name: 'alamat' ,searchable: false},
                { data: 'tanggal_lahir', name: 'tanggal_lahir' , searchable: false},
                { data: 'jenis_kelamin', name: 'jenis_kelamin' , searchable: false},
                { data: 'pekerjaan', name: 'pekerjaan' , searchable: false},
                { data: 'desa_name', name: 'desa_name' , searchable: false},
                { data: 'nominal_setor', name: 'nominal_setor', searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [[0, 'asc']] // Default sort column and order
        });

        $(document).on('click', '.approve-button', function() {
    var id = $(this).data('id');

        $.ajax({
            url:  'nasabah/approve/' + id,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}', // Include CSRF token for security
                // Add other data if needed
            },
            success: function(response) {
                // Handle the response from the server
                alert('Success: ' + response.message);
                $('#nasabahTable').DataTable().ajax.reload(null, false);

            },
            error: function(xhr) {
                // Handle errors
                alert('Error: ' + xhr.responseText);
            }
        });
    });

    });
</script>
@endsection
