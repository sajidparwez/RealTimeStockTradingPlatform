<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;


use Illuminate\Queue\{InteractsWithQueue, SerializesModels};
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessTrade implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
   public $tradeData;

    public function __construct(array $tradeData)
    {
        $this->tradeData = $tradeData;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Log::info('Received Trade Job: ', $this->tradeData);
    }
}
