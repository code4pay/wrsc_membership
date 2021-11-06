<?php

namespace Tests\Unit;

use \App\User;
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
        $user =    User::factory()->create();
        $this->assertEquals(15, $user->renewalAmount(),  'Correct Renewal Amount');
    }

    public function testFamilyMemberFee()
    {

         $this->seed();
        $user =   User::factory()->create(
            [
                'member_type_id' => DB::table('membershiptypes')->where('name','Family')->value('id'),
                'primary_member_id' => 1
            ]
        );
        $this->assertEquals(5, $user->renewalAmount(),  'Correct Renewal Amount');
    }
    public function testApplicationFee()
    {
        $this->seed();
        $user =    User::factory()->create(
            [
                'member_type_id' => DB::table('membershiptypes')->where('name','Primary')->value('id'),
            ]
        );
        $family_member =    User::factory()->create(
            [
                'member_type_id' => DB::table('membershiptypes')->where('name','Family')->value('id'),
                'primary_member_id' => 1
            ]
        );
        
        $this->assertEquals(50, $user->totalApplicationAmount(),  'Correct Application Amount');
        
    }

    public function testApplicationFeeWithOverrideOnApplication()
    {
        config(['app.primary_member_fee_override_on_application' => 30]);
        $this->seed();
        $user =    User::factory()->create(
            [
                'member_type_id' => DB::table('membershiptypes')->where('name','Primary')->value('id'),
            ]
        );
        $family_member =    User::factory()->create(
            [
                'member_type_id' => DB::table('membershiptypes')->where('name','Family')->value('id'),
                'primary_member_id' => 1
            ]
        );
        
        $this->assertEquals(65, $user->totalApplicationAmount(),  'Correct Application Amount');
        
    }
}
