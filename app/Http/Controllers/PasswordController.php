<?php

namespace App\Http\Controllers;

use App\Services\PasswordService;
use Illuminate\Http\Request;

/**
 * Password Controller
 *
 * @package App\Http\Services
 * @author  Thiago Silva <thiagom.devsec@gmail.com>
 * @version 1.0
 */
final class PasswordController extends Controller
{
    /**
     * Init controller with service
     *
     * @param PasswordService $passwordService
     */
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
        if (!$request->has('password') or empty($request->password)) {
            return response()->json(['error' => "You must enter a valid password"], 406);
        }

        if (!$request->has('rules') or empty($request->rules)) {
            return response()->json(['error' => 'You must enter with valid rules'], 406);
        }

        $password = strip_tags($request->password);
        $rules = $request->rules;

        $result = $this->passwordService->validatePassword($password, $rules);

        return response()->json($result, 200);
    }
}
