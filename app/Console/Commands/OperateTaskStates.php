<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use TaskStatesManager;


class OperateTaskStates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:operate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     */

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command
     * @param TaskStatesManager $checkResultManager
     * @return mixed
     */
    public function handle(TaskStatesManager $checkResultManager)
    {
        $i = 0;
       while(true){

           try {
               $tasks = $checkResultManager->operateTaskStates();
           }
           catch(Exception $e){

               echo $e->getMessage();
           }
                $i++;
                foreach($tasks as $task){

                    echo "Ключ: ".$task->key."Состояние: ".$task->state."\n";
                }
                sleep(1);
           }


    }


}
