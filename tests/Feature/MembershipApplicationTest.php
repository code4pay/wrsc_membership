<?php

namespace Tests\Feature;

use \App\Models\BackpackUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


class MembershipApplicationTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();

        // seed the database
        //$this->artisan('db:seed');
        // alternatively you can call
        $this->seed();
    }

    /*
     * @return void
     */
    public function test_membership_application_page_load()
    {
        $response = $this->get('/application');
        $response->assertstatus(200);
        $response->assertSeeText('Wildlife Rescue South Coast, Application Form');
    }

    public function test_membership_application_success_no_doc()
    {
        $response = $this->post('/application', $this->build_application());
        $response->assertSessionHasNoErrors();
        $response->assertStatus(200);
    }


    public function test_membership_application_success_with_documents()
    {
        Storage::fake('private');
        $file = UploadedFile::fake()->create('Certificate.pdf', 100);
        $form_fields = $this->build_application();
        $form_fields['documents'] = [$file];
        $response = $this->post('/application', $form_fields);
        Storage::disk('private')->assertExists('/documents/Certificate.pdf');
        $response->assertSessionHasNoErrors();
        $response->assertStatus(200);

        // With Multiple Documents. 
        
        $file1 = UploadedFile::fake()->create('Certificate1.pdf', 100);
        $file2 = UploadedFile::fake()->create('Certificate2.pdf', 100);
        $form_fields = $this->build_application();
        $form_fields['documents'] = [$file1,$file2];
        $response = $this->post('/application', $form_fields);
        Storage::disk('private')->assertExists('/documents/Certificate1.pdf');
        Storage::disk('private')->assertExists('/documents/Certificate2.pdf');
        $response->assertSessionHasNoErrors();
        $response->assertStatus(200);
 
    }

    
    public function test_membership_application_success_with_comments()
    {
        Storage::fake('private');
        $form_fields = $this->build_application();
        $form_fields['details_of_previous_group'] = "I left Wires in 2013";
        $form_fields['cared_for_wildlife'] = "I looked after my mums chickens";
        $response = $this->post('/application', $form_fields);
        $response->assertSessionHasNoErrors();
        $response->assertStatus(200);

        $new_user =  BackpackUser::latest('id')->first();
        $saved_comment = json_decode($new_user->comments);
        $this->assertEquals($saved_comment[0]->comment,"Applicant was a member of another group\nI left Wires in 2013\n\nApplicant has cared for other wildlife\nI looked after my mums chickens");
    
    }
    public function test_membership_application_user_member_type_primary()
    {
        $form_fields = $this->build_application();
        $response = $this->post('/application', $form_fields);
        $response->assertSessionHasNoErrors();
        $response->assertStatus(200);

        $new_user =  BackpackUser::latest('id')->first();
        $this->assertEquals('Primary', $new_user->memberType->name);
        $this->assertEquals('Vincentia', $new_user->city);
        $this->assertEquals('Vincentia', $new_user->city_residential);
        $response->assertSeeText('Your application will be confirmed once your payment has been recieved.');
    
    }

    public function test_show_add_family_members()
    {

        $form_fields = $this->build_application();
        $form_fields['add_family_members'] = "yes";
        $response = $this->post('/application', $form_fields);
        $response->assertSessionHasNoErrors();
        $response->assertStatus(200);
        $response->assertSeeText('Please complete the details for the family member.');
    }
    public function test_membership_application_member_member_type_family()
    {
        Storage::fake('private');
        $primary_fields = $this->build_application();
        $primary_fields['password'] = 'asdasdasd';
        $primary_member = BackpackUser::create($primary_fields);
        $primary_member->save();
        $primary_member = $primary_member->fresh(); 
        $form_fields = $this->build_application();
        $form_fields['family_member'] = 1;
        $form_fields['address'] = "woop woop";
        $form_fields['primary_member_id'] = $primary_member->id;
        $response = $this->post('/application', $form_fields);
        $response->assertSessionHasNoErrors();
        $response->assertStatus(200);

        $form_fields['add_family_members'] = "no";
        $new_member =  BackpackUser::latest('id')->first();
        $this->assertEquals('Family', $new_member->memberType->name);
        $this->assertEquals('23 some street',$new_member->address);
        $this->assertEquals($primary_member->id, $new_member->primary_member_id);
        $response->assertSeeText('Your application will be confirmed once your payment has been recieved.');
    }
    public function test_membership_application_user_set_to_pending_approval()
    {
        $form_fields = $this->build_application();
        $response = $this->post('/application', $form_fields);
        $response->assertSessionHasNoErrors();
        $response->assertStatus(200);

        $new_user =  BackpackUser::latest('id')->first();
        $this->assertEquals($new_user->pending_approval,true);
    
    }

    public function test_cant_resubmit_form()
    {

        $form_fields = $this->build_application();
        
        $response = $this->post('/application', $form_fields);
        $response->assertSessionHasNoErrors();
        $response->assertStatus(200);

        $response = $this->post('/application', $form_fields);
        $response->assertSeeText('Sorry this form can only be submitted once');
        
    }

    /** Helper Functions */

    private function build_application()
    {
        
        $token = new \App\Models\Token;
        $token->user_id = 999999;
        $token->type = "prevent_form_resubmit";
        $token->token = str_random(50);
        $token->save();
        
        return ([
            'capatcha' => 'xmqki',
            'first_name' => 'Michael',
            'address' => '23 some street',
            'city' => 'Vincentia',
            'last_name' => 'Mueller',
            'post_code' => '3456',
            'address_residential' => '23 Some street',
            'city_residential' => 'Vincentia',
            'post_code_residential' => '3456',
            'email' => 'fred@wrsc.com.au',
            'agree_to_conditions' => 'yes',
            'mobile' => '5030381293',
            'home_phone' => '44412356',
            'agree_to_conditions' => 'yes',
            'form_token' =>  $token->token,
        ]);
    }
}
