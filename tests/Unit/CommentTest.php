<?php

namespace Tests\Unit;

use \App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CommentTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCommentAdded()
    {
         $this->seed();
         // factory user defaults to Primary
        $user =    factory(\App\User::class)->create();
        $user->addComment('this is a comment');
        $user->save();
       // dd($user->fresh()->comments); 
        $comments = $user->getCommentsAsArray();
        $this->assertEquals('this is a comment', $comments[0]['comment'],  'Comment saved');
    }

   
}
