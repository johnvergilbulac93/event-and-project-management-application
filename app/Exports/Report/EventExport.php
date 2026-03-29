<?php

namespace App\Exports\Report;

use App\Models\Event;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EventExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Title',
            'Description',
            'Start Time',
            'End Time',
            'Date',
            'Status'
        ];
    }
    public function map($event): array
    {
        return [
            $event->title,
            $event->description,
            Carbon::parse($event->start_time)->format('h:i A'),
            Carbon::parse($event->end_time)->format('h:i A'),
            Carbon::parse($event->date)->format('Y-m-d'),
            $event->status ? 'Active' : 'Inactive'
        ];
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Event::select('title', 'description', 'start_time', 'end_time', 'date', 'status', 'created_at')->get();
    }
}
