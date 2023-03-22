<?php

namespace Mrshoikot\Scrud\Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Mrshoikot\EncryptAndExport\EncryptAndExportServiceProvider;
use Orchestra\Testbench\TestCase;

class EncryptAndExportCommandTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMockingConsoleOutput();
    }

    protected function getPackageProviders($app)
    {
        return [
            EncryptAndExportServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
    }

    public function testItAsksTheRightQuestions()
    {
        $cmd = $this->artisan('encrypt-and-export')
            ->expectsQuestion(trans('encrypt-and-export::translations.q_table_name'), 'users');
    }
}