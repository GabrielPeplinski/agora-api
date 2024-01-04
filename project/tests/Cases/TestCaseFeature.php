<?php

namespace Tests\Cases;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\CreatesApplication;

abstract class TestCaseFeature extends BaseTestCase
{
    use CreatesApplication;
    use LazilyRefreshDatabase;
}
