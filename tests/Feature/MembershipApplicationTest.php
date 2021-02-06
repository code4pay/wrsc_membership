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
    /**
     *
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
        $this->assertEquals($saved_comment[0]->comment,'I left Wires in 2013');
    
    }

    /** Helper Functions */

    private function build_application()
    {

        return ([

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
        ]);
    }
}
