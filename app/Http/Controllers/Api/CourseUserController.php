<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CourseUser;

class CourseUserController extends Controller
{
    public function index(Request $request)
    {
        $search_term = $request->input('q');
        $page = $request->input('page');

        if ($search_term)
        {
            $results = CourseUser::where('user_id', 'LIKE', '%'.$search_term.'%')->paginate(10);
        }
        else
        {
            $results = City::paginate(10);
        }

        return $results;
    }

    public function show($id)
    {
        return City::find($id);
    }
}