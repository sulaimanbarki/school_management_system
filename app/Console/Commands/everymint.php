<?php

namespace App\Console\Commands;

use App\Models\addsection;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class everymint extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'min:insert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'every mintine insert data to server';

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
        $i=0;
        while($i<10){

            $class = new addsection();
            $class->SectionName='A';
            $class->SectionSequence =1;
            $class->campusid = 1;
            if ($class->save()) {
                echo "save";
            } else {
                echo "error";
            }
            $i++;
        }




    }
}
