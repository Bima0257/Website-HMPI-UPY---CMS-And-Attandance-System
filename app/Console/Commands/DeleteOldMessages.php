<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Message;
use Carbon\Carbon;

class DeleteOldMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'messages:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hapus pesan yang lebih dari 1 hari';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $deleted = Message::where('created_at', '<', Carbon::now()->subMinute())->delete();

        $this->info("Berhasil menghapus {$deleted} pesan lama.");
    }
}
