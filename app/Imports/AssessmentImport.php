<?php
namespace App\Imports;

use App\Models\Assessment;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class AssessmentImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function headingRow(): int
    {
        // Misal header ada di baris ke-1 pada template
        // Kalau di file asli header ada di baris ke-4 atau ke-5, sesuaikan
        return 5;
    }
    public function model(array $row)
    {
        // Konversi tanggal
        $tgl_inspeksi = $this->excelDate($row['tgl_inspeksi']);

        // Tentukan kelas berdasarkan Status kulit
        $kelas_perawan = null;
        $kelas_pulihan = null;
        $kelas_nta     = null;

        if (! empty($row['status_kulit'])) {
            $status = strtolower(trim($row['status_kulit']));
            if ($status === 'perawan') {
                $kelas_perawan = $row['kelas'];
            } elseif ($status === 'pulihan') {
                $kelas_pulihan = $row['kelas'];
            } elseif ($status === 'nta') {
                $kelas_nta = $row['kelas'];
            }
        }

        return Assessment::firstOrCreate(
            [
                'tgl_inspeksi' => $tgl_inspeksi,
                'nik_penyadap' => $row['emp_code'],
                'blok'         => $row['block'],
            ],
            [
                'dept'              => $row['sub_division'],
                'nama_inspektur'    => $row['nama_inspektur'],
                'nama_penyadap'     => $row['nama_penyadap'],
                'status'            => $row['status_reg_fl'],
                'kemandoran'        => $row['kemandoran'],
                'task'              => $row['task'],
                'tahun_tanam'       => $row['yp'],
                'clone'             => $row['clone'],
                'panel_sadap'       => $row['panel_sadap'],
                'jenis_kulit_pohon' => $row['status_kulit'],

                // Item mapping (sesuaikan header di template Excel)
                'item1_1'           => $row['tidak_menggunakan_gagang_pisau_panjang'],
                'item1_2'           => $row['tidak_menggunakan_pisau_sodok_ho'],
                'item1_3'           => $row['sadapan_tidak_disodok_ditarik'],

                'item2_1'           => $row['kurang_dalam'],
                'item2_2'           => $row['normatif'],
                'item2_3'           => $row['terlalu_dalam'],

                'item3_1'           => $row['irisan_melampaui_batas_depan'],
                'item3_2'           => $row['irisan_melampaui_batas_belakang'],
                'item3_3'           => $row['tidak_ada_sodokan'],
                'item3_4'           => $row['tidak_ada_pethikan'],
                'item3_5'           => $row['tebal_tatal_lebih_3mm'],
                'item3_6'           => $row['bergelombang'],
                'item3_7'           => $row['tidak_ada_tanda_bulan'],

                'item4_1'           => $row['lebih_45_derajat'],
                'item4_2'           => $row['kurang_45_derajat'],

                'item5_1'           => $row['diambil'],
                'item5_2'           => $row['tidak_diambil'],

                'item6_1'           => $row['talang'],
                'item6_2'           => $row['mangkok'],
                'item6_3'           => $row['hanger'],

                'item7_1'           => $row['talang_kotor'],
                'item7_2'           => $row['mangkok_kotor'],
                'item7_3'           => $row['ember_kotor'],

                'item8'             => $row['pohon_sehat_tidak_disadap'],
                'item9'             => $row['hasil_tidak_dipungut'],
                'item10'            => $row['talang_sadap_mepet'],

                'nilai'             => $row['nilai'],
                'kelas_perawan'     => $kelas_perawan,
                'kelas_pulihan'     => $kelas_pulihan,
                'kelas_nta'         => $kelas_nta,
            ]);
    }

    private function excelDate($value)
    {
        if (is_numeric($value)) {
            return Date::excelToDateTimeObject($value);
        }
        return $value;
    }

    public function rules(): array
    {
        return [
            'tgl_inspeksi'   => 'required', // kolom Tanggal Inspeksi
            'sub_division'   => 'required', // kolom Sub Division
            'nama_inspektur' => 'required', // kolom Nama Inspektur
            'emp_code'       => 'required', // kolom Nama Inspektur
            'nama_penyadap'  => 'required', // kolom Nama Inspektur
            'block'          => 'required', // kolom Nama Inspektur
            'task'           => 'required', // kolom Nama Inspektur
            'yp'             => 'required', // kolom Nama Inspektur
            'status_kulit'   => 'required', // kolom Nama Inspektur
        ];
    }

    public function customValidationMessages()
    {
        return [
            'tgl_inspeksi.required'   => 'Kolom Bulan wajib diisi.',
            'sub_division.required'   => 'Kolom Tanggal Sub Division wajib diisi.',
            'nama_inspektur.required' => 'Kolom Nama Inspektur wajib diisi.',
            'nik_penyadap.required'   => 'Kolom NIK Penyadap wajib diisi.',
            'nama_penyadap.required'  => 'Kolom Nama Penyadap wajib diisi.',
            'block.required'          => 'Kolom Blok wajib diisi.',
            'task.required'           => 'Kolom Task wajib diisi.',
            'yp.required'             => 'Kolom Tahun Tanam wajib diisi.',
            'status_kulit.required'   => 'Kolom Jenis Kulit Pohon wajib diisi.',
        ];
    }
}
