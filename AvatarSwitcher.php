#!/usr/bin/php
<?php
//TODO: Automatic authentication.
//TODO: Do NOT store keys with code! Read from the environment.

//
// CONFIG:
// 

$path_to_avatars         = './Avatars/Zdzislaw_Beksinski/';
/* Your Steam ID: */
$sid                     = "";
/* Login to Steam in a browser like Firefox. View the cookies set for Steamcommunity.com.
   Put the values of the cookies here: */
$cookie_sessionid        = "";
$cookie_steamLoginSecure = "";

//
// CODE:
//

otog:

$picture_files = array_diff(scandir($path_to_avatars), array('.', '..'));
foreach($picture_files as $picture_file) {	
	echo "Loaded $picture_file\r\n";
	$picture_filepath = $path_to_avatars . $picture_file;
 
 	$POST_data = array(); 
	$POST_data['MAX_FILE_SIZE'] = "1048576";
	$POST_data['type']          = "player_avatar_image";
	$POST_data['sId']           = $sid;
	$POST_data['sessionid']     = $cookie_sessionid;
	$POST_data['doSub']         = "1"; 
	$POST_data['json']          = "1"; 
	$POST_data['avatar']        = "@$picture_filepath";
	
	$cookie_header = "sessionid=$cookie_sessionid; " . 
			 "steamLoginSecure=$cookie_steamLoginSecure";
 
	$curl_handle = curl_init();
	curl_setopt($curl_handle, CURLOPT_URL, 'https://steamcommunity.com/actions/FileUploader');
	curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl_handle, CURLOPT_POST, true);
	curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $POST_data); 
	curl_setopt($curl_handle, CURLOPT_COOKIE, $cookie_header);
	
	echo "Send Request...\r\n";
	$curl_return = curl_exec($curl_handle);
	echo $curl_return . "\r\n";
	sleep(1);
}

goto otog;
