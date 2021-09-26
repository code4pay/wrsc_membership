<?php

namespace Tests\Feature;

use \App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MembershipRenewalTest extends TestCase
{
    use RefreshDatabase;
    /**
     *
     * @return void
     */
    public function test_request_for_renewal_form_rejected_with_bad_token()
    {
        $response = $this->get('/tac_accept/asdasdasd');

        $response->assertStatus(404);
    }

    public function test_user_with_valid_token_can_display_renewal()
    {

        $this->seed();
        $this->withoutExceptionHandling();

        $user =    User::factory()->create();
        $token = $user->createToken('tac');

        $response = $this->get('/tac_accept/' . $token);

        $response->assertStatus(200);
        $response->assertSeeText('Membership Renewal Form ');
    }

    public function test_user_with_no_token_rejected_on_post()
    {
        $response = $this->put('/tac_accept/as', [
            'token' => 'asdasd',
        ]);
        $response->assertNotFound();
    }

    public function test_user_with_bad_token_rejected_on_post()
    {
        $response = $this->put('/tac_accept/as', [
            'token' => 'asdasd',
        ]);
        $response->assertNotFound();
    }

    public function test_valid_user_can_accept_T_and_C()
    {

        $this->seed();
        $this->withExceptionHandling();

        $user =    User::factory()->create();
        //  dd($user);
        $response = $this->put('/tac_accept/asd', $this->build_t_c_post($user));
        $user->refresh();
        $carbon = new Carbon('today');

        $this->assertEquals($user->tac_date->toDateString(), $carbon->toDateString() );
        $response->assertSessionHasNoErrors();
        $response->assertStatus(200);

    }

    public function test_primary_user_needs_to_pay()
    {

        $this->seed();
        $this->withExceptionHandling();

        $user =    User::factory()->create();
        // Test users are created as Primary Members by default
        $response = $this->put('/tac_accept/asd', $this->build_t_c_post($user));
        $user->refresh();
        $carbon = new Carbon('today');
        $this->assertEquals($user->tac_date->toDateString(), $carbon->toDateString() );
        $response->assertSessionHasNoErrors();
        $response->assertStatus(200);
        $response->assertSeeText('Thank You for renewing');
        $response->assertSeeText('Your renewal will be confirmed once your payment has been recieved.');
        
    }
     

    public function test_family_user_does_not_need_to_pay()
    {

        $this->seed();
        $this->withExceptionHandling();

        $user =    User::factory()->create(
            [
                'member_type_id' => DB::table('membershiptypes')->where('name', 'Family')->value('id'),
                'primary_member_id' => 1
            ]

        );
        
        // Test users are created as Primary Members by default
        $response = $this->put('/tac_accept/asd', $this->build_t_c_post($user));
        $user->refresh();
        $carbon = new Carbon('today');
        $this->assertEquals($user->tac_date->toDateString(), $carbon->toDateString() );
        $response->assertSessionHasNoErrors();
        $response->assertStatus(200);
        $response->assertSeeText('Thank You for renewing');
        $response->assertDontSee('Your renewal will be confirmed once your payment has been recieved.');
        
    }
    public function test_valid_user_can_update_details()
    {

        $this->seed();
        $this->withExceptionHandling();

        $user =    User::factory()->create();
        $user_details = $this->build_t_c_post($user);
        $user_details['city'] = 'mars';
        $response = $this->put('/tac_accept/asd', $user_details);
        $response->assertSessionHasNoErrors();
        $response->assertStatus(200);
        $updatedUser =  User::find($user->id);
        $user->refresh();
        $this->assertEquals($user->city, 'mars');
    }


    public function test_display_chose_not_to_renew_bad_token()
    {
        $response = $this->get('/dont_renew/123123');
        $response->assertNotFound();
    }


    public function test_submit_chose_not_to_renew_bad_token()
    {
        $response = $this->put('/dont_renew/123123');
        $response->assertNotFound();
    }

    public function test_chose_not_to_renew_success()
    {
        $this->withExceptionHandling();
        $this->seed();
        $user =    User::factory()->create();
        $token = $user->createToken('tac');
        $response = $this->put('/dont_renew/1', [
            'token' => $token,
            'member_number' => $user->member_number,
        ]);
        $response->assertStatus(200);
    }

    /** test  the renewal functions triggered by admin */

    public function test_send_renewal_email_not_logged_in() {
            $this->seed();
            $user =    User::factory()->create();
            $response = $this->post('admin/email_renewals',[
                
                'users' => [
                    $user
                ]
                
            ]);
            $response->assertRedirect();
    }


    public function test_send_renewal_email() {
        $this->seed();
        $user =    User::factory()->create();
        $user->givePermissionTo('Send Renewals');
        $this->actingAs($user);
       $user->refresh;
    
            $response = $this->post('admin/email_renewals',[
                
                'users' => [
                    $user->id
                ]
                
            ]);
            $response->assertOk();
    }

    /** Helper Functions */

    private function build_t_c_post($user)
    {

        $token = $user->createToken('tac');
        return ([

            'token' => $token,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'address' => $user->address,
            'city' => $user->city,
            'post_code' => $user->post_code,
            'address_residential' => $user->address_residential,
            'city_residential' => $user->city_residential,
            'post_code_residential' => $user->post_code_residential,
            'email' => $user->email,
            'mobile'  => $user->mobile,
            'home_phone' => $user->home_phone,
            'member_number' => $user->member_number,
            'agree_to_conditions' => 'yes',

        ]);
    }
}
