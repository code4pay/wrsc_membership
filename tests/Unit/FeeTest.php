<?php

namespace Tests\Unit;

use \App\Models\BackpackUser;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class FeeTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPrimaryMemberFee()
    {
         $this->seed();
         // factory user defaults to Primary
        $user =    factory(\App\Models\BackpackUser::class)->create();
        $this->assertEquals(15, $user->renewalAmount(),  'Correct Renewal Amount');
    }

    public function testFamilyMemberFee()
    {

         $this->seed();
        $user =    factory(\App\Models\BackpackUser::class)->create(
            [
                'member_type_id' => DB::table('membershiptypes')->where('name','Family')->value('id'),
                'primary_member_id' => 1
            ]
        );
        $this->assertEquals(5, $user->renewalAmount(),  'Correct Renewal Amount');
    }
}
