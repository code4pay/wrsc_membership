<?php

namespace Tests\Feature;

use Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use \App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;



class SiteAdminTest extends TestCase
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


    public function test_presidents_report_upload()
    {

        $user =    User::factory()->create();

        $user->assignRole('admin');
        Storage::fake('private');
        $file = UploadedFile::fake()->create('presidents_report.pdf', 100);
        $form_fields['presidents_report'] = $file;
        $response = $this->actingAs($user)->post('/site_admin/presidents_report', $form_fields);
        $response->assertStatus(200);
        $response->assertSessionHasNoErrors();
        Storage::disk('private')->assertExists('/documents/presidents_report.pdf');
    }

    public function test_presidents_report_download()
    {

        $user =    User::factory()->create();
        $user->givePermissionTo('View Documents');
        Storage::disk('private')->put('/documents/presidents_report.pdf','rubbish');
        $response = $this->actingAs($user)->get('/site_admin/presidents_report');
        $response->assertStatus(200);
        $response->assertSessionHasNoErrors();
    }

    public function test_admin_page_load_no_access()
    {
        
        $user =    User::factory()->create();
        $response = $this->actingAs($user)->get('/site_admin');
        $response->assertStatus(403);

    }

    public function test_admin_page_load_admin_access()
    {
        
        $user =    User::factory()->create();

        $user->assignRole('admin');
        $response = $this->actingAs($user)->get('/site_admin');
        $response->assertStatus(200);
    }

    public function test_set_current_paid_to()
    {

        $current_paid_to = \App\Models\Setting::where('name', '=', 'current_paid_to')->first();
        $current_paid_to->value = '2022-07-13';
        $current_paid_to->save();
        $user =    User::factory()->create();
        $user->assignRole('admin');

        $response = $this->actingAs($user)->post('/site_admin/currentPaidTo',['current_paid_to' => '2022-06-30'] );
        $current_paid_to = \App\Models\Setting::where('name', '=', 'current_paid_to')->first();
        $this->assertEquals('2022-06-30', $current_paid_to->value);
        $response = $this->actingAs($user)->get('/site_admin');
        $response->assertSessionHasNoErrors();
        $response->assertStatus(200);
        $response->assertSee('2022-06-30');
 

    
    }
}
