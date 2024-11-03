<?php

namespace Tests\Unit\Domains\Solicitation\Actions\Solicitation;

use App\Domains\Solicitation\Actions\Solicitation\ClearSolicitationHistoryAction;
use App\Domains\Solicitation\Models\Solicitation;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Mockery;
use Tests\Cases\TestCaseUnit;

class ClearSolicitationHistoryActionTest extends TestCaseUnit
{
    public function test_should_clear_a_solicitation_history()
    {
        $hasManyMock = Mockery::mock(HasMany::class);
        $hasManyMock->shouldReceive('delete')
            ->once()
            ->andReturn(true);

        $solicitationMock = Mockery::mock(Solicitation::class);
        $solicitationMock->shouldReceive('userSolicitations')
            ->once()
            ->andReturn($hasManyMock);

        DB::shouldReceive('beginTransaction')->once()->andReturnSelf();
        DB::shouldReceive('commit')->once()->andReturnSelf();

        (new ClearSolicitationHistoryAction)->execute($solicitationMock);
    }
}
