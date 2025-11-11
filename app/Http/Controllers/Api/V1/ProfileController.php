<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * @group Profile
     * @authenticated
     * @response 200 {
     *   "user": {
     *      "id": 1,
     *      "name": John,
     *      "email": "email@mail.com",
     *  }
     * }
     */
    public function me() {
        return response()->json([
            "status" => 200,
            "user" => request()->user()
        ]);
    }
}
