<?php

namespace LambdaDigamma\MMFeeds\Commands;

use Illuminate\Console\Command;

class MMFeedsCommand extends Command
{
    public $signature = 'mm-feeds';

    public $description = 'My command';

    public function handle(): void
    {
        $this->comment('All done');
    }
}
