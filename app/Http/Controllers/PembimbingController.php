<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use Illuminate\Http\Request;
use App\Models\PembimbingModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PembimbingController extends Controller
{
    public function formTambah()
    {
        return view('pages.pembimbing.form_isian_pembimbing');
    }

    public function formUbah($pembimbing_id)
    {
        // Mengambil data pembimbing
        $data_pembimbing = pembimbingModel::findOrFail($pembimbing_id);

        return view('pages.pembimbing.form_isian_pembimbing', compact('data_pembimbing', 'data_pembimbing'));
    }

    public function index()
    {
        $data_pembimbing = PembimbingModel::all();

        return view('pages.pembimbing.main_pembimbing', compact('data_pembimbing'));
    }

    public function tambahDataPembimbing(Request $request)
    {
        // Buat entri baru tanpa validasi
        $pembimbing = new PembimbingModel();
        // Set nilai-niali properti berdasarkan input form
        $pembimbing->pembimbing_npp = $request->pembimbing_npp;
        $pembimbing->pembimbing_nama = $request->pembimbing_nama;
        $pembimbing->pembimbing_jenis_kelamin = $request->pembimbing_jenis_kelamin;
        $pembimbing->pembimbing_no_hp = $request->pembimbing_no_hp;
        $pembimbing->pembimbing_alamat = $request->pembimbing_alamat;
        // Simpan data ke database
        $pembimbing->created_by = Auth::user()->name;
        $pembimbing->save();

        // Set variabel sesi untuk pesan berhasil
        Session::flash('success_insert_pembimbing', 'Data pembimbing Berhasil Disimpan');

        // Kembalikan ke halaman utama atau halaman yang Anda inginkan
        return redirect()->route('pembimbing');
    }

    public function ubahDataPembimbing(Request $request)
    {
        // Buat entri baru tanpa validasi
        $pembimbing_upd = pembimbingModel::findOrFail($request->pembimbing_id);
        // Set nilai-niali properti berdasarkan input form
        $pembimbing_upd->pembimbing_npp = $request->pembimbing_npp;
        $pembimbing_upd->pembimbing_nama = $request->pembimbing_nama;
        $pembimbing_upd->pembimbing_jenis_kelamin = $request->pembimbing_jenis_kelamin;
        $pembimbing_upd->pembimbing_no_hp = $request->pembimbing_no_hp;
        $pembimbing_upd->pembimbing_alamat = $request->pembimbing_alamat;
        // Simpan data ke database
        $pembimbing_upd->updated_by = Auth::user()->name;
        $pembimbing_upd->save();

        // Set variabel sesi untuk pesan berhasil
        Session::flash('success_update_pembimbing', 'Data pembimbing Berhasil Disimpan');

        // Kembalikan ke halaman utama atau halaman yang Anda inginkan
        return redirect()->route('pembimbing');
    }

    public function hapusDataPembimbing($pembimbing_id)
    {
        $pembimbing = PembimbingModel::findOrFail($pembimbing_id);

        // Simpan email pengguna yang login sebagai 'deleted_by'
        $pembimbing->deleted_by = Auth::user()->name;
        $pembimbing->delete();

        Session::flash('delete_pembimbing', 'Data Pembimbing Berhasil Dihapus');
        return redirect()->route('pembimbing');
    }

    public function cetakDataPembimbingPDF() {
        $data_pembimbing = PembimbingModel::all();
        $filename = 'data-pembimbing-'.date("Ymd-His").'.pdf';

        $pdf = new Dompdf();
        $pdf->loadHTML(view('pages.pembimbing.laporan.form_cetak_pdf_pembimbing', compact('data_pembimbing'))->render());
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();
        $pdf->stream($filename);
    }

    public function cetakDataPembimbingExcel()
    {
        // Query untuk mendapatkan data pembimbing
        $data_pembimbing = PembimbingModel::all();

        // Buat objek Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'NPP');
        $sheet->setCellValue('D1', 'Jenis Kelamin');
        $sheet->setCellValue('E1', 'No. HP');
        $sheet->setCellValue('F1', 'Alamat');

        // Data pembimbing
        $row = 2;
        $number = 1;
        foreach ($data_pembimbing as $pembimbing) {
            $sheet->setCellValue('A' . $row, $number);
            $sheet->setCellValue('B' . $row, $pembimbing->pembimbing_nama);
            $sheet->setCellValue('C' . $row, $pembimbing->pembimbing_npp);
            $sheet->setCellValue('D' . $row, $pembimbing->pembimbing_jenis_kelamin);
            $sheet->setCellValue('E' . $row, $pembimbing->pembimbing_no_hp);
            $sheet->setCellValue('F' . $row, $pembimbing->pembimbing_alamat);
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
        $filename = 'data-pembimbing-'.date("Ymd-His").'.xlsx';

        // Kembalikan respons untuk mendownload file Excel
        return Response::download($tempFilePath, $filename, $headers)->deleteFileAfterSend(true);
    }

}
