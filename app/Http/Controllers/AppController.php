<?php

namespace App\Http\Controllers;

use App\Http\Resources\AppResource;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function index(Request $request)
    {
        return new AppResource($request->user());
    }
}
