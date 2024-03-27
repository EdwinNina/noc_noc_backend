<?php

namespace App\Jobs;

use App\Models\TaskHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class TaskReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $dateFrom;
    public $dateTo;

    /**
     * Create a new job instance.
     */
    public function __construct(string $dateFrom, string $dateTo)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $data = TaskHistory::join('users', 'users.id','=', 'task_histories.user_id')
        ->join('tasks', 'tasks.id','=', 'task_histories.task_id')
        ->select('tasks.id', 'tasks.title', 'tasks.description','users.name','task_histories.status', 'task_histories.created_at')
        ->whereBetween('tasks.created_at', [$this->dateFrom, $this->dateTo])
        ->get();

        $dompdf = Pdf::loadView('report', ['data' => $data, 'dateFrom' => $this->dateFrom, 'dateTo' => $this->dateTo]);
        $dompdf->render();

        $dompdf->output();
        $output = $dompdf->output();
        file_put_contents(storage_path('app/users_report.pdf'), $output);
    }
}
