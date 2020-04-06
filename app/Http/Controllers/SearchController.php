<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use App\User;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $users = User::
                    where('name', 'like', $request->get('search').'%')
                    ->orWhere('email', 'like', $request->get('search').'%')
                    ->orWhere('phone', 'like', $request->get('search').'%')
                    ->get();
        
        return response()->json(['status' => 1, 'result' => $users->toArray()]);
    }
}
