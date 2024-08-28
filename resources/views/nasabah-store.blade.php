@extends("layouts.app_user")

@section('content')
<div class="container mb-5">
    <h2>Formulir Pendaftaran</h2>
    <form action="{{ url('/nasabah') }}" method="POST">
        @csrf

        <!-- Display general error messages -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" required>
            @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="tempat_lahir">Tempat Lahir</label>
            <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required>
            @error('tempat_lahir')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="tanggal_lahir">Tanggal Lahir</label>
            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
            @error('tanggal_lahir')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="jenis_kelamin">Jenis Kelamin</label>
            <select class="form-control @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" required>
                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
            @error('jenis_kelamin')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="job">Pekerjaan</label>
            <select class="form-control @error('job') is-invalid @enderror" id="job" name="job" required>
                <!-- Options will be populated from the controller -->
                @foreach($jobs as $job)
                    <option value="{{ $job->id }}" {{ old('job') == $job->id ? 'selected' : '' }}>{{ $job->name }}</option>
                @endforeach
            </select>
            @error('job')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="provinsi">Provinsi</label>
            <select class="form-control @error('provinsi') is-invalid @enderror" id="provinsi" name="provinsi" required>
                <!-- Options will be populated from the controller -->
                @foreach($provinsiList as $provinsi)
                    <option value="{{ $provinsi->id }}" {{ old('provinsi') == $provinsi->id ? 'selected' : '' }}>{{ $provinsi->name }}</option>
                @endforeach
            </select>
            @error('provinsi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="kabupaten">Kabupaten</label>
            <select class="form-control @error('kabupaten') is-invalid @enderror" id="kabupaten" name="kabupaten" required>
                <!-- Options will be populated via AJAX based on selected provinsi -->
            </select>
            @error('kabupaten')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="kecamatan">Kecamatan</label>
            <select class="form-control @error('kecamatan') is-invalid @enderror" id="kecamatan" name="kecamatan" required>
              
                <!-- Options will be populated via AJAX based on selected kabupaten -->
            </select>
            @error('kecamatan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="desa">Desa</label>
            <select class="form-control @error('desa') is-invalid @enderror" id="desa" name="desa" required>
                <!-- Options will be populated via AJAX based on selected kecamatan -->
            </select>
            @error('desa')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
            @error('alamat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="nominal_setor">Nominal Setor</label>
            <input type="text"  id="nominal_setor" class="form-control @error('nominal_setor') is-invalid @enderror" id="nominal_setor" name="nominal_setor" value="{{ old('nominal_setor') }}" required>
            @error('nominal_setor')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Kirim</button>
    </form>
</div>  
@endsection



@section('script')
<script>

var rupiah = document.getElementById('nominal_setor');
		rupiah.addEventListener('keyup', function(e){
			// tambahkan 'Rp.' pada saat form di ketik
			// gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
			rupiah.value = formatRupiah(this.value, 'Rp. ');
		});
 
		/* Fungsi formatRupiah */
		function formatRupiah(angka, prefix){
			var number_string = angka.replace(/[^,\d]/g, '').toString(),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			rupiah     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if(ribuan){
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}
 
			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
		}


    $(document).ready(function() {


        // Initial load for kabupaten, kecamatan, and desa
   
        $('#provinsi').change(function() {
            const provinsiId = $(this).val();
            if (provinsiId) {
                $.ajax({
                    url: `/api/kabupaten/${provinsiId}`,
                    type: 'GET',
                    success: function(data) {
                        $('#kabupaten').empty().append('<option value="">Pilih Kabupaten</option>');
                        $('#kecamatan').empty().append('<option value="">Pilih Kecamatan</option>');
                       $('#desa').empty().append('<option value="">Pilih Desa</option>');
         
                        $.each(data, function(key, value) {
                            $('#kabupaten').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });
                    }
                });
            } else {
                // $('#kabupaten').empty().append('<option value="">Pilih Kabupaten</option>');
                // $('#kecamatan').empty().append('<option value="">Pilih Kecamatan</option>');
                // $('#desa').empty().append('<option value="">Pilih Desa</option>');
            }
        });
    
        $('#kabupaten').change(function() {
            const kabupatenId = $(this).val();
            if (kabupatenId) {
                $.ajax({
                    url: `/api/kecamatan/${kabupatenId}`,
                    type: 'GET',
                    success: function(data) {
                        $('#kecamatan').empty().append('<option value="">Pilih Kecamatan</option>');
                        $('#desa').empty().append('<option value="">Pilih Desa</option>');
      
                        $.each(data, function(key, value) {
                            $('#kecamatan').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });
                    }
                });
            } else {
                // $('#kecamatan').empty().append('<option value="">Pilih Kecamatan</option>');
                // $('#desa').empty().append('<option value="">Pilih Desa</option>');
            }
        });
    
        $('#kecamatan').change(function() {
            const kecamatanId = $(this).val();
            if (kecamatanId) {
                $.ajax({
                    url: `/api/desa/${kecamatanId}`,
                    type: 'GET',
                    success: function(data) {
                        $('#desa').empty().append('<option value="">Pilih Desa</option>');
                        $.each(data, function(key, value) {
                            $('#desa').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });
                    }
                });
            } else {
                // $('#desa').empty().append('<option value="">Pilih Desa</option>');
            }
        });
    });
    </script>   

@endsection