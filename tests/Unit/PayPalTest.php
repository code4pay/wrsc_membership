<?php

namespace Tests\Unit;

use \App\Models\BackpackUser;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PayPalTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPrimaryMemberApplicationFee()
    {
         $this->seed();
         // factory user defaults to Primary
        $user =    factory(\App\Models\BackpackUser::class)->create();
        $pay_pal_data = json_decode($user->applicationAmountForPayPal(),1);
        $amount = $pay_pal_data[0]['amount']['value'];
        $this->assertEquals(45, $amount,  'Correct application Amount');
    }

    public function testPrimaryMemberRenewalFee()
    {
         $this->seed();
         // factory user defaults to Primary
        $user =    factory(\App\Models\BackpackUser::class)->create();
        $pay_pal_data = json_decode($user->renewalAmountForPayPal(),1);
        $amount = $pay_pal_data[0]['amount']['value'];
        $this->assertEquals(15, $amount,  'Correct application Amount');
    }
}
