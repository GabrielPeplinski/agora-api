<?php

namespace Tests\Cases;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\CreatesApplication;

abstract class TestCaseFeature extends BaseTestCase
{
    use CreatesApplication;
    use LazilyRefreshDatabase;

    protected ?string $currentController = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Origin' => 'http://localhost',
        ]);
    }

    protected function useActionsFromController(string $controllerClass): static
    {
        $this->currentController = $controllerClass;

        return $this;
    }

    protected function controllerAction($action = null, $params = []): ?string
    {
        if (! $action) {
            return action($this->currentController, $params);
        }

        return action([$this->currentController, $action], $params);
    }
}
