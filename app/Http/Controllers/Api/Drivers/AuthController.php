<?php

namespace App\Http\Controllers\Api\Drivers;

use App\Http\Requests\Api\StartLoginRequest;
use App\Http\Requests\Api\VerifyCodeRequest;
use App\Models\Device;
use App\Models\Driver;
use App\Models\PhoneCode;
use App\Services\CreateProfileService;
use App\Services\PhoneCodeService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @param StartLoginRequest $request
     * @param PhoneCode $phoneCodeModel
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(StartLoginRequest $request, PhoneCode $phoneCodeModel): JsonResponse
    {
        PhoneCodeService::createPhoneCode($phoneCodeModel, $request);

        return response()->json(['success' => true, 'message' => 'We have sent you verification SMS']);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param VerifyCodeRequest $request
     * @param Driver $driverModel
     * @param PhoneCode $codeModel
     * @param Device $deviceModel
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(VerifyCodeRequest $request, Driver $driverModel, PhoneCode $codeModel, Device $deviceModel): JsonResponse
    {
        $driver = null;
        $code = $request->get('code');
        $phone = $request->get('phone');

        $isInvalidCode = PhoneCodeService::isValidateCode($code, $phone, $codeModel);

        if($isInvalidCode){
            return response()->json(['message' => $isInvalidCode], 422);
        }

        $driver = CreateProfileService::getProfile($driverModel, $phone, $codeModel);

        if($driver === null){
            return response()->json(['error' => 'The driver does not exist.'], 401);
        }

        if(!$token = auth('driver')->login($driver)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if($request->get('deviceToken')) {
            CreateProfileService::saveTokenDevices($deviceModel, $request, $driver, 'driver');
        }

        return $this->respondWithToken($token, $driver);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @param Request $request
     * @param Device $deviceModel
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function logout(Request $request, Device $deviceModel): JsonResponse
    {
        $deviceData = $deviceModel->getDataByToken($request);

        $driver = CreateProfileService::changeDriverStatus('false');

        if($deviceData !== null){
            $deviceData->delete();
        }
        auth('driver')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $driver = auth('driver')->user();

        return $this->respondWithToken(auth('driver')->refresh(), $driver);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $driver)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'driverId' => $driver->id,
            'expires_in' => config('auth.phone_code_ttl') . ' minutes'
        ]);
    }
}
