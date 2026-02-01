<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class TestController extends Controller
{
    public function test(): Response
    {
        return response()->json(["message" => "test"]);
    }
}
