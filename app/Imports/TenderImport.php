<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class TenderImport implements ToCollection, WithChunkReading
{

    public $logs;

    public function __construct(&$logs)
    {
        $this->logs = &$logs;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        //
        $this->logs = $collection;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
