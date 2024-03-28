<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use Illuminate\Http\Request;
use App\Models\ProdiModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ProdiController extends Controller
{
    public function formTambah()
    {
        return view('pages.prodi.form_isian_prodi');
    }

    public function formUbah($prodi_id)
    {
        // Mengambil data prodi
        $data_prodi = ProdiModel::findOrFail($prodi_id);

        return view('pages.prodi.form_isian_prodi', compact('data_prodi', 'data_prodi'));
    }

    public function index()
    {
        $data_prodi = ProdiModel::all();

        return view('pages.prodi.main_prodi', compact('data_prodi'));
    }

    public function tambahDataprodi(Request $request)
    {
        // Buat entri baru tanpa validasi
        $prodi = new ProdiModel();
        // Set nilai-niali properti berdasarkan input form
        $prodi->prodi_kode = $request->prodi_kode;
        $prodi->prodi_nama = $request->prodi_nama;
        $prodi->created_by = Auth::user()->name;
        // Simpan data ke database
        $prodi->save();

        // Set variabel sesi untuk pesan berhasil
        Session::flash('success_insert_prodi', 'Data prodi Berhasil Disimpan');

        // Kembalikan ke halaman utama atau halaman yang Anda inginkan
        return redirect()->route('prodi');
    }

    public function ubahDataprodi(Request $request)
    {
        // Buat entri baru tanpa validasi
        $prodi_upd = ProdiModel::findOrFail($request->prodi_id);
        // Set nilai-niali properti berdasarkan input form
        $prodi_upd->prodi_kode = $request->prodi_kode;
        $prodi_upd->prodi_nama = $request->prodi_nama;
        $prodi_upd->updated_by = Auth::user()->name;
        // Simpan data ke database
        $prodi_upd->save();

        // Set variabel sesi untuk pesan berhasil
        Session::flash('success_update_prodi', 'Data prodi Berhasil Disimpan');

        // Kembalikan ke halaman utama atau halaman yang Anda inginkan
        return redirect()->route('prodi');
    }

    public function hapusDataprodi($prodi_id)
    {
        $prodi = ProdiModel::findOrFail($prodi_id);

        // Simpan email pengguna yang login sebagai 'deleted_by'
        $prodi->deleted_by = Auth::user()->name;
        $prodi->delete();

        Session::flash('delete_prodi', 'Data prodi Berhasil Dihapus');
        return redirect()->route('prodi');
    }

    public function cetakDataprodiPDF() {
        $data_prodi = ProdiModel::all();
        $filename = 'data-prodi-'.date("Ymd-His").'.pdf';

        $pdf = new Dompdf();
        $pdf->loadHTML(view('pages.prodi.laporan.form_cetak_pdf_prodi', compact('data_prodi'))->render());
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();
        $pdf->stream($filename);
    }

    public function cetakDataprodiExcel()
    {
        // Query untuk mendapatkan data prodi
        $data_prodi = ProdiModel::all();

        // Buat objek Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Prodi');
        $sheet->setCellValue('C1', 'Nama Prodi');

        // Data prodi
        $row = 2;
        $number = 1;
        foreach ($data_prodi as $prodi) {
            $sheet->setCellValue('A' . $row, $number);
            $sheet->setCellValue('B' . $row, $prodi->prodi_kode);
            $sheet->setCellValue('C' . $row, $prodi->prodi_nama);
            $row++;
            $number++;
        }

        // Buat writer Xlsx
        $writer = new Xlsx($spreadsheet);

        // Simpan file sementara di penyimpanan sementara
        $tempFilePath = tempnam(sys_get_temp_dir(), 'excel');
        $writer->save($tempFilePath);

        // Atur header respons untuk file Excel
        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ];

        // Ambil tanggal saat ini untuk nama file
        $filename = 'data-prodi-'.date("Ymd-His").'.xlsx';

        // Kembalikan respons untuk mendownload file Excel
        return Response::download($tempFilePath, $filename, $headers)->deleteFileAfterSend(true);
    }
}
