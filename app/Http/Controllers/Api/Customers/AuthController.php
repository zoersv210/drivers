<?php

namespace App\Http\Controllers\Api\Customers;

use App\Http\Requests\Api\StartLoginRequest;
use App\Http\Requests\Api\VerifyCodeRequest;
use App\Models\Customer;
use App\Models\Device;
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
     * @param Customer $customerModel
     * @return JsonResponse
     */
    public function login(StartLoginRequest $request, PhoneCode $phoneCodeModel, Customer $customerModel): JsonResponse
    {
        $phone = $request->get('phone');

        $customer = CreateProfileService::existProfile($customerModel, $phone);

        if(!$customer){
            return response()->json(['error' => 'This number does not exist'], 401);
        }

        PhoneCodeService::createPhoneCode($phoneCodeModel, $request);

        return response()->json(['success' => true, 'message' => 'We have sent you verification SMS']);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param StartLoginRequest $request
     * @param PhoneCode $phoneCodeModel
     * @param Customer $customerModel
     * @return JsonResponse
     */
    public function registration(StartLoginRequest $request, PhoneCode $phoneCodeModel, Customer $customerModel): JsonResponse
    {
        $phone = $request->get('phone');

        $customer = CreateProfileService::existProfile($customerModel, $phone);

        if($customer){
            return response()->json(['error' => 'This number already exist'], 401);
        }

        PhoneCodeService::createPhoneCode($phoneCodeModel, $request);

        return response()->json(['success' => true, 'message' => 'We have sent you verification SMS']);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param VerifyCodeRequest $request
     * @param Customer $customerModel
     * @param PhoneCode $codeModel
     * @param Device $deviceModel
     * @return JsonResponse
     */
    public function verify(VerifyCodeRequest $request, Customer $customerModel, PhoneCode $codeModel, Device $deviceModel): JsonResponse
    {
        $code = $request->get('code');
        $phone = $request->get('phone');

        $isInvalidCode = PhoneCodeService::isValidateCode($code, $phone, $codeModel);

        if($isInvalidCode){
            return response()->json(['message' => $isInvalidCode], 422);
        }

        $customer = CreateProfileService::createProfile($customerModel, $phone, $codeModel);

        if(!$token = auth('customer')->login($customer)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if($request->get('deviceToken')) {
            CreateProfileService::saveTokenDevices($deviceModel, $request, $customer, 'customer');
        }

        return $this->respondWithToken($token, $customer);
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
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
     * @return JsonResponse
     * @throws \Exception
     */
    public function logout(Request $request, Device $deviceModel): JsonResponse
    {
        $deviceData = $deviceModel->getDataByToken($request);

        if($deviceData !== null){
            $deviceData->delete();
        }

        auth('customer')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        $customer = auth('customer')->user();

        return $this->respondWithToken(auth('customer')->refresh(), $customer);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token, $customer): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'customerId' => $customer->id,
            'expires_in' => config('auth.phone_code_ttl') . ' minutes'
        ]);
    }
}
