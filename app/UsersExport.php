<?php
  
namespace App;
  
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings; 
  
class UsersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'Student Name',
            'Student Email',
            'Student Contact Number',
            'Session',
        // etc


        ];
    }
    
    public function collection()
    {
        return DB::table('users')
            ->join('tbl_student', 'users.id', '=', 'tbl_student.sid')
            ->select('users.name','users.email','tbl_student.contact_number','tbl_student.session')
            ->get();
    }
    
    
    
}
