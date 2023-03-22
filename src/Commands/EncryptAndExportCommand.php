<?php

namespace Mrshoikot\EncryptAndExport\Commands;

use Illuminate\Console\Command;

class EncryptAndExportCommand extends Command
{
    public $signature = 'encrypt-and-export';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
