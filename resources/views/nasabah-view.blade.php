@extends("layouts.app_user")

@section('content')
<div class="container mb-5">
    <h2>Detail Pendaftaran</h2>


    <div class="form-group">
        <label for="nama">Nama</label> :
        <span>{{ $data->nama }}</span>
    </div>

    <div class="form-group">
        <label for="tempat_lahir">Tempat Lahir</label> : 
        <span>{{ $data->tempat_lahir }}</span>
    </div>

    <div class="form-group">
        <label for="tanggal_lahir">Tanggal Lahir</label>:
        <span>{{ $data->tanggal_lahir }}</span>
    </div>

    <div class="form-group">
        <label for="jenis_kelamin">Jenis Kelamin</label>:
        <span>{{ $data->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
    </div>

    <div class="form-group">
        <label for="job">Pekerjaan</label> :
        <span>{{ $data->job->name ?? 'Tidak Diketahui' }}</span>
    </div>

    <div class="form-group">
        <label for="provinsi">Provinsi</label>:
        <span>{{ $data->provinsi->name ?? 'Tidak Diketahui' }}</span>
    </div>

    <div class="form-group">
        <label for="kabupaten">Kabupaten</label>:
        <span>{{ $data->provinsi->kabupaten->name ?? 'Tidak Diketahui' }}</span>
    </div>

    <div class="form-group">
        <label for="kecamatan">Kecamatan</label> :
        <span>{{ $data->provinsi->kabupaten->kecamatan->name ?? 'Tidak Diketahui' }}</span>
    </div>

    <div class="form-group">
        <label for="desa">Desa</label>:
        <span>{{ $data->provinsi->kabupaten->kecamatan->desa->name ?? 'Tidak Diketahui' }}</span>
    </div>

    <div class="form-group">
        <label for="alamat">Alamat</label>:
        <span>{{ $data->alamat }}</span>
    </div>

    <div class="form-group">
        <label for="nominal_setor">Nominal Setor</label>:
        <span>Rp. {{ number_format($data->nominal_setor, 0, ',', '.'); }}</span>
    </div>

    {{-- <a href="{{ url('/nasabah/edit') }}" class="btn btn-primary">Edit</a> --}}
    <a href="{{ url('/') }}" class="btn btn-secondary">Kembali</a>
</div>
  
@endsection



@section('script')
@endsection