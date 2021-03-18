<?php

namespace Tests\Unit;

use App\CoreService\CallService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SampleServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testNormal()
    {
        $input = [];
        $output = CallService::call("SampleService", $input);
        $this->assertTrue($output["me"] == null);
    }

    public function testWithParam()
    {
        $input = ["aaa" => 1];
        $output = CallService::call("SampleService", $input);
    }
}
