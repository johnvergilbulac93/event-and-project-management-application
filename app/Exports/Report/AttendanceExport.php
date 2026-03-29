<?php

namespace App\Exports\Report;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    private $data;

    function __construct($data)
    {
        $this->data = $data;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //

        return $this->data;
    }
    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Name',
            'Event',
            'Date of Event'
        ];
    }
    public function map($attendance): array
    {
        return [
            $attendance->household->full_name,
            $attendance->event->title,
            Carbon::parse($attendance->event->date)->format('Y-m-d'),
        ];
    }
}
