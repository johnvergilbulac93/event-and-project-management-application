<?php

namespace App\Exports\Report;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProjectExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithColumnFormatting
{
    public function columnFormats(): array
    {
        return [
            'C' => '"₱"#,##0.00', // Column C = cost
        ];
    }
    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Project Name',
            'Location',
            'Cost',
            'Start Date',
            'Completion Date',
            'Status',
        ];
    }
    public function map($project): array
    {
        return [
            $project->project_name,
            $project->location,
            $project->cost,
            $project->start_date,
            $project->completion_date,
            $project->status
        ];
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Project::select('project_name', 'location', 'cost', 'start_date', 'completion_date', 'status')->get();
    }
}
