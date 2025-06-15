<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected function setUpTraits()
    {
        $uses = parent::setUpTraits();

        if (isset($uses[RefreshTestDatabase::class])) {
            $this->refreshTestDatabase();
        }

        return $uses;
    }
}
