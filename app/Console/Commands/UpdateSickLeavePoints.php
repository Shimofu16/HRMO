<?php

namespace App\Console\Commands;

use App\Models\Employee;
use Illuminate\Console\Command;

class UpdateSickLeavePoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'employee:slp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update sick leave points';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // update sick leave points
        $employees = Employee::all();
        foreach ($employees as $employee) {
            $employee->sickLeave()->update(['points' => $employee->sickLeave->points + 1.25]);
        }
    }
}
