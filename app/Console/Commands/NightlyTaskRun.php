<?php

namespace App\Console\Commands;

use App\Models\Tasks\Entity\Task;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class NightlyTaskRun extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nightlytasks:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run task';

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
     * @return void
     */
    public function handle()
    {
        $tasks = Task::where('start', '18:00:00')->get()->toArray();
        foreach ($tasks as $task) {
            if ($task['status'] === '1') {
                Http::post(env('API_BASE_URL').'enable_task_detection/'.$task['id']);
            }
        }
    }
}
