<?php

namespace App\Exports\Report;

use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProfileAccountExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Mobile No.',
            'Status',
            'Date Registered',
        ];
    }
    public function map($user): array
    {
        return [
            $user->first_name . ' ' . $user->last_name,
            $user->email,
            $user->mobile_no,
            $user->isActive ? 'Active' : 'Inactive',
            Carbon::parse($user->created_at)->format('F d, Y')


        ];
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::select('first_name', 'middle_name', 'last_name', 'email', 'mobile_no', 'isActive', 'created_at')->get();
    }
}
