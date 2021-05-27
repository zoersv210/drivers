<?php


namespace App\Services;


class AdminProfileService
{
    public static function getPuthAvatar($request)
    {
        $image = $request->get('avatar');
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);

        return $image;
    }
}
