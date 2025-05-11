<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DynamicScanExport implements WithMultipleSheets
{
    protected $nama;
    protected $sudahScan;
    protected $belumScan;
    protected $countSudahScan;
    protected $countBelumScan;

    public function __construct($nama, $sudahScan, $belumScan, $countSudahScan, $countBelumScan)
    {
        $this->nama = $nama;
        $this->sudahScan = $sudahScan;
        $this->belumScan = $belumScan;
        $this->countSudahScan = $countSudahScan;
        $this->countBelumScan = $countBelumScan;
    }

    public function sheets(): array
    {
        $sheets = [
            new SudahScanSheet($this->nama, $this->sudahScan, $this->countSudahScan),
            new BelumScanSheet($this->nama, $this->belumScan, $this->countBelumScan)
        ];

        return $sheets;
    }
}

class SudahScanSheet implements FromCollection, WithTitle, WithHeadings, WithMapping
{
    protected $nama;
    protected $data;
    protected $count;

    public function __construct($nama, $data, $count)
    {
        $this->nama = $nama;
        $this->data = $data;
        $this->count = $count;
    }

    public function collection()
    {
        return $this->data;
    }

    public function title(): string
    {
        return 'Sudah Scan';
    }

    public function headings(): array
    {
        return [
            ['Laporan Scan Peserta: ' . $this->nama],
            ['Total Sudah Scan: ' . $this->count],
            [],
            [
                'No',
                'Nama Peserta',
                'Nomor Peserta',
                'Kecamatan',
                'Regu',
                'Rombongan',
                'Kloter',
                'Waktu Scan'
            ]
        ];
    }

    public function map($row): array
    {
        static $i = 1;
        return [
            $i++,
            $row->nama_peserta,
            $row->nomor_peserta,
            $row->kecamatan,
            $row->regu,
            $row->rombongan,
            $row->kloter,
            $row->waktu_scan ?? '-'
        ];
    }
}

class BelumScanSheet implements FromCollection, WithTitle, WithHeadings, WithMapping
{
    protected $nama;
    protected $data;
    protected $count;

    public function __construct($nama, $data, $count)
    {
        $this->nama = $nama;
        $this->data = $data;
        $this->count = $count;
    }

    public function collection()
    {
        return $this->data;
    }

    public function title(): string
    {
        return 'Belum Scan';
    }

    public function headings(): array
    {
        return [
            ['Laporan Scan Peserta: ' . $this->nama],
            ['Total Belum Scan: ' . $this->count],
            [],
            [
                'No',
                'Nama Peserta',
                'Nomor Peserta',
                'Kecamatan',
                'Regu',
                'Rombongan',
                'Kloter',
                'Waktu Scan'
            ]
        ];
    }

    public function map($row): array
    {
        static $i = 1;
        return [
            $i++,
            $row->nama_peserta,
            $row->nomor_peserta,
            $row->kecamatan,
            $row->regu,
            $row->rombongan,
            $row->kloter,
            '-'
        ];
    }
}