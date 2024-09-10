<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tache;
use Carbon\Carbon;
use App\Jobs\TaskLatemailJob;
use Illuminate\Http\Request;

class DailyTaskLate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:daily-task-late';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        $threeDaysFromNow = Carbon::today()->addDays(3);
        
        // Récupérer les tâches dont la date limite est comprise entre aujourd'hui et dans trois jours
        $tasks = Tache::whereBetween('deadline', [$today, $threeDaysFromNow])->where('statut','!=',env('ID_STATUT_TERMINE'))->get();
        foreach($tasks as $task)
        {
            $details = [
                'email' => $task->porteur->email,
                'porteur' => $task->porteur->name.' '.$task->porteur->prenom,
                'titre_tache' => $task->titre,
                'delais' => format_date($task->deadline),
                'desc_tache' => $task->description,
                'title' => "Tâche dont la date limite de traitement reste est dans mois de trois jours",
            ];
            TaskLatemailJob::dispatch($details);
        }

    }
}
