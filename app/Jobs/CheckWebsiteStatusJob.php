<?php

namespace App\Jobs;

use App\Mail\WebsiteDownMail;
use App\Models\Website;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class CheckWebsiteStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    public function __construct(public Website $website) {}

    public function handle(): void
    {
        try {
            $response = Http::timeout(10)->get($this->website->url);

            if ($response->failed()) {
                $this->markDown();
            } else {
                $this->markUp();
            }

        } catch (\Throwable) {
            $this->markDown();
        }
    }

    protected function markDown(): void
    {
        if ($this->website->is_down) {
            return;
        }

        $this->website->update(['is_down' => true]);

        Mail::to($this->website->client->email)
            ->send(new WebsiteDownMail($this->website));
    }

    protected function markUp(): void
    {
        $this->website->update([
            'is_down' => false,
            'last_checked_at' => now(),
        ]);
    }
}

