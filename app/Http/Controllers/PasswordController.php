<?php

namespace App\Http\Controllers;

use App\Services\PasswordService;
use Illuminate\Http\Request;

final class PasswordController extends Controller
{
    public function __construct(private PasswordService $passwordService)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function validatePassword(Request $request)
    {
        $password = $request->password;
        $rules = $request->rules;

        $result = $this->passwordService->validatePassword($password, $rules);

        return response()->json($result, 200);
    }
}
