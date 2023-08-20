<?php

namespace Mrshoikot\Scrud\Tests\Feature;

use Mrshoikot\EncryptAndExport\EncryptAndExportServiceProvider;
use Orchestra\Testbench\TestCase;

class EncryptAndExportCommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
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
        $cmd = $this->artisan('securecsv')
            ->expectsQuestion(trans('securecsv::translations.q_table_name'), 'users');
    }
}
