<?php

namespace Tests\Unit\Support;

use App\Support\AddressCityNameFormatter;
use Tests\Cases\TestCaseUnit;

class AddressCityNameFormatterTest extends TestCaseUnit
{
    public function test_should_format_name_with_possessive_prepositions()
    {
        $testName = 'são gabriel da cachoeira';
        $expected = 'São Gabriel da Cachoeira';

        $result = AddressCityNameFormatter::formatCityName($testName);

        $this->assertEquals($expected, $result);
    }

    public function test_should_format_name_with_possessive_prepositions_2()
    {
        $testName = 'fake name dos santos do brasil';
        $expected = 'Fake Name dos Santos do Brasil';

        $result = AddressCityNameFormatter::formatCityName($testName);

        $this->assertEquals($expected, $result);
    }

    public function test_should_format_name_with_preposition_and()
    {
        $testName = 'Cidade e estados';
        $expected = 'Cidade e Estados';

        $result = AddressCityNameFormatter::formatCityName($testName);

        $this->assertEquals($expected, $result);
    }
}
