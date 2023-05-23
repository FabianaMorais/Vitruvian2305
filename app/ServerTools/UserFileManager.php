<?php

namespace App\ServerTools;

use Image;
use Log;

/**
 * This class is responsible for handling the creation and replacement of all
 * user files in the server
 * Any files handled by users should all pass through here
 */
class UserFileManager
{
    /**
     * Updates the passed user's avatar image in the avatars' folder
     */
    public static function saveAvatarImage($username, $newAvatar) {
        /* using the username to set the image name ensures that the image is
        bound to its user and that another user's image won't be accidentaly overridden.
        It also ensures that there is only one file per user */
        $filename = $username . '_avt'. '.jpg' ;
        Image::make($newAvatar)->fit(250)->encode('jpg', 75)->save( public_path('/user_uploads/avatars/' . $filename) );
        return $filename;
    }


}