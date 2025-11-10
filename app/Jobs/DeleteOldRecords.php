<?php

namespace App\Jobs;

use App\Models\Client;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class DeleteOldRecords implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $dateLimit = now()->subDays(env('DAYS_TO_PERMANENT_DELETE', 60))->format('Y-m-d');

        OrderProduct::whereDate("deleted_at", "<", $dateLimit)->forceDelete();
        Client::whereDate("deleted_at", "<", $dateLimit)->forceDelete();
        Product::whereDate("deleted_at", "<", $dateLimit)->forceDelete();
    }
}
