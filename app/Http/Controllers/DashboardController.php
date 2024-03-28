<?php

namespace App\Http\Controllers;

use App\Models\ProdiModel;
use Illuminate\Http\Request;
use App\Models\MahasiswaModel;
use App\Models\PembimbingModel;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $data_mahasiswa = MahasiswaModel::select('mahasiswa.*', 'prodi.prodi_id', 'prodi.prodi_nama', 'pembimbing.pembimbing_nama')
            ->join('prodi', 'mahasiswa.mhs_prodi_id', '=', 'prodi.prodi_id')
            ->join('pembimbing', 'mahasiswa.mhs_pembimbing_id', '=', 'pembimbing.pembimbing_id')
            ->whereNull('mahasiswa.deleted_at') // Menambahkan kondisi untuk memastikan deleted_at adalah NULL
            ->whereNull('prodi.deleted_at') // Menambahkan kondisi untuk memastikan deleted_at adalah NULL
            ->orderBy('mahasiswa.mhs_prodi_id', 'asc')
            ->get();

        $data_mahasiswa_group_prodi = DB::table('prodi')
            ->select('prodi.prodi_id', 'prodi.prodi_nama',
                DB::raw('SUM(CASE WHEN mahasiswa.mhs_jenis_kelamin = "P" THEN 1 ELSE 0 END) AS mhs_count_kelamin_wanita'),
                DB::raw('SUM(CASE WHEN mahasiswa.mhs_jenis_kelamin = "L" THEN 1 ELSE 0 END) AS mhs_count_kelamin_pria'))
            ->leftJoin('mahasiswa', 'prodi.prodi_id', '=', 'mahasiswa.mhs_prodi_id')
            ->whereNull('mahasiswa.deleted_at')
            ->whereNull('prodi.deleted_at') // Menambahkan kondisi untuk memastikan deleted_at adalah NULL
            ->groupBy('prodi.prodi_id', 'prodi.prodi_nama')
            ->orderBy('prodi.prodi_id')
            ->get();


        $data_pembimbing = PembimbingModel::all();
        $data_prodi = ProdiModel::orderBy('prodi_id')->get();

        return view('pages.dashboard.main_dashboard', compact('data_mahasiswa', 'data_pembimbing', 'data_prodi', 'data_mahasiswa_group_prodi'));
    }
}
