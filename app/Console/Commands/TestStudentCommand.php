<?php

namespace App\Console\Commands;

use App\Models\StudentGrade;
use Illuminate\Console\Command;

class TestStudentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test_student';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (!StudentGrade::query()->exists()) {
            for ($i = 1; $i<=100; $i++) {
                StudentGrade::create([
                    'student_name' => '姓名'.$i,
                    'grade1' => mt_rand(60, 100),
                    'grade2' => mt_rand(60, 100),
                    'grade3' => mt_rand(60, 100),
                ]);
            }
        }


    }
}
