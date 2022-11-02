<?php

namespace App\Console\Commands;

use App\Models\Tasks\Entity\Task;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class DailyTaskStop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dailytask:stop';

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
        Task::where('end', '18:00:00')
            ->where('status', '2')
            ->update(['status' => '1']);
    }
}
