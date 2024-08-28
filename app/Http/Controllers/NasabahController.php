<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Nasabah;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class NasabahController extends Controller
{
    public function index()
    {

        return view("home");
    }

    public function getNasabahData()
    {
        $query = Nasabah::query();

        return DataTables::of($query)
        ->addColumn('action', function ($nasabah) {
            $url = url('/nasabah/' . $nasabah->id);

            if ($nasabah->approve == 1) {
                return '<button class="btn btn-secondary btn-sm" disabled>Already Approved</button>
                <a href="' . $url .'">Detail</a>';
            } else {
                if (auth()->user()->role == "admin"){
                    return '<button class="btn btn-primary btn-sm approve-button" data-id="' . $nasabah->id . '">Approve</button>
                    <a href="'. $url .'">Detail</a>';
                }else{
                    return '<a href="'.$url.'">Detail</a>';
                }
            }

        })
            ->addColumn('pekerjaan', function ($nasabah) {
                return $nasabah->job_id ? $nasabah->job->name : 'N/A'; // Assuming 'name' is a field in the 'desas' table
            })
            ->addColumn('nominal_setor', function ($nasabah) {
                $formattedAmount = number_format($nasabah->nominal_setor, 0, ',', '.');
                return "Rp. ". $formattedAmount ?? 'N/A'; // Assuming 'name' is a field in the 'desas' table
            })
            ->addColumn('desa_name', function ($nasabah) {
                return $nasabah->desa ? $nasabah->desa->name : 'N/A'; // Assuming 'name' is a field in the 'desas' table
            })
            ->addColumn('jenis_kelamin', function ($nasabah) {
                return $nasabah->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'; // Adjust the mapping as needed
            })
            ->addColumn('alamat_provinsi', function ($nasabah) {
                return $nasabah->desa->kecamatan->kabupaten->provinsi->name; // Adjust the mapping as needed
            })
            ->filterColumn('nama', function($query, $keyword) {
                $query->where('nama', 'like', "%{$keyword}%");
            })
            ->orderColumn('nama', 'nama $1')
            ->make(true);
    }
    
    public function add()
    {

        $provinsiList = Provinsi::all();
        $jobs = Job::all();

        return view("nasabah-store", compact("provinsiList", "jobs"));
    }

    public function store(Request $request)
    {

        $number = (int) str_replace(['Rp. ', '.'], '', $request->nominal_setor);
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama' => [
                'required',
                'regex:/^(?!.*\b(?:Haji|Profesor)\b)(?:[A-Za-z\s]+)$/i', // Hanya huruf dan spasi
            ],
            'tempat_lahir' => 'required|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'job' => 'required|exists:jobs,id',
            'desa' => 'required|exists:desas,id', // Pastikan id desa ada di tabel desas
            'alamat' => 'required|max:255',
            'nominal_setor' => 'required|',
        ], [
            'nama.required' => 'Nama tidak boleh kosong.',
            'nama.regex' => 'Nama tidak boleh diawali dengan "Haji" atau "Profesor", dan hanya boleh berisi huruf dan spasi.',
            'tempat_lahir.required' => 'Tempat lahir harus diisi.',
            'tempat_lahir.max' => 'Tempat lahir tidak boleh lebih dari 255 karakter.',
            'tanggal_lahir.required' => 'Tanggal lahir harus diisi.',
            'tanggal_lahir.date' => 'Tanggal lahir harus berupa tanggal yang valid.',
            'jenis_kelamin.required' => 'Jenis kelamin harus diisi.',
            'jenis_kelamin.in' => 'Jenis kelamin harus berupa "L" atau "P".',
            'job.required' => 'Pekerjaan harus diisi.',
            'job.exists' => 'Pekerjaan yang dipilih tidak valid.',
            'desa.required' => 'Desa harus diisi.',
            'desa.exists' => 'Desa yang dipilih tidak valid.',
            'alamat.required' => 'Alamat harus diisi.',
            'alamat.max' => 'Alamat tidak boleh lebih dari 255 karakter.',
            'nominal_setor.required' => 'Nominal setor harus diisi.',
            // 'nominal_setor.min' => 'Nominal setor harus lebih besar atau sama dengan 0.',
        ]);
        

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Simpan data ke database
        $nasabah = new Nasabah();
        $nasabah->nama = $request->input('nama');
        $nasabah->tempat_lahir = $request->input('tempat_lahir');
        $nasabah->tanggal_lahir = $request->input('tanggal_lahir');
        $nasabah->jenis_kelamin = $request->input('jenis_kelamin');
        $nasabah->job_id = $request->input('job');
        $nasabah->desa_id = $request->input('desa');
        $nasabah->alamat = $request->input('alamat');
        $nasabah->nominal_setor =         $number;
        ;
        $nasabah->save();

        return redirect('/')->with('success', 'Data berhasil disimpan.');
    
    }

    public function approve(Request $request, $id)
    {
    
        $nasabah = Nasabah::find($id);

        if ($nasabah) {
            $nasabah->approve = 1;
            $nasabah->save();

            return response()->json(['message' => 'Approved successfully.']);
        }

        return response()->json(['message' => 'Not found.'], 404);
    }

    public function detail($id) {

        $data = Nasabah::with(["desa", "desa.kecamatan", "desa.kecamatan.kabupaten", "desa.kecamatan.kabupaten.provinsi"])->find($id);


        return view("nasabah-view", compact("data"));
    }

}
