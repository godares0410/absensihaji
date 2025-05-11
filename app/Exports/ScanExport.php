<?php
namespace App\Exports;

use App\Models\Scan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ScanExport implements FromCollection, WithHeadings
{
    protected $nama;

    public function __construct($nama)
    {
        $this->nama = $nama;
    }

    public function collection()
    {
        return Scan::where('nama', $this->nama)->select('id_scan', 'id_peserta', 'nama', 'status', 'created_at')->get();
    }

    public function headings(): array
    {
        return ['ID Scan', 'ID Peserta', 'Nama', 'Status', 'Tanggal Scan'];
    }
}
