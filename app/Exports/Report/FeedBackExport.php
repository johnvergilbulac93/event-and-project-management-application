<?php

namespace App\Exports\Report;

use App\Models\Feedback;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FeedBackExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Name',
            'Subject',
            'Comment',
            'Date Submitted',
        ];
    }
    public function map($feedback): array
    {
        return [
            $feedback->name,
            $feedback->subject,
            $feedback->comment,
            Carbon::parse($feedback->created_at)->format('F d, Y')
        ];
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Feedback::select('name', 'subject', 'comment', 'created_at')->get();
    }
}
