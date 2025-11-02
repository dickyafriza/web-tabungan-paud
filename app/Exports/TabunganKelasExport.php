<?php

namespace App\Exports;

use App\Models\Siswa;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class TabunganKelasExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithColumnFormatting
{
    protected $kelasId;

    public function __construct($kelasId)
    {
        $this->kelasId = $kelasId;
    }

    /**
     * Ambil data siswa + saldo tabungan
     */
    public function collection()
    {
        return Siswa::select('siswa.id', 'siswa.nama')
            ->where('siswa.kelas_id', $this->kelasId)
            ->leftJoin('tabungan as t_in', function ($join) {
                $join->on('siswa.id', '=', 't_in.siswa_id')
                    ->where('t_in.tipe', 'in');
            })
            ->leftJoin('tabungan as t_out', function ($join) {
                $join->on('siswa.id', '=', 't_out.siswa_id')
                    ->where('t_out.tipe', 'out');
            })
            ->selectRaw("
                IFNULL(SUM(CASE WHEN t_in.tipe = 'in' THEN t_in.jumlah ELSE 0 END),0) -
                IFNULL(SUM(CASE WHEN t_out.tipe = 'out' THEN t_out.jumlah ELSE 0 END),0) as saldo
            ")
            ->groupBy('siswa.id', 'siswa.nama')
            ->get();
    }

    /**
     * Header kolom Excel
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama Siswa',
            'Total Saldo Tabungan',
        ];
    }

    /**
     * Mapping baris Excel
     */
    public function map($row): array
    {
        static $index = 0;
        $index++;

        return [
            $index,
            $row->nama,
            $row->saldo,
        ];
    }

    /**
     * Format kolom Excel
     */
    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1, // Saldo
        ];
    }
}
