<?php
/**
//  Insert.php
//  Pages
//
//  Copyright © 2018 NGINX Inc. All rights reserved.
 */

// Initialize url to services from environment
// The service endpoint should be same
$user_url = getenv("USERMANAGER_ENDPOINT_URL") . getenv("USERMANAGER_LOCAL_PATH");
$content_url = getenv("CONTENTSERVICE_ENDPOINT_URL") . getenv("CONTENTSERVICE_ARTICLE_PATH");
$uploader_url = getenv("PHOTOUPLOADER_ENDPOINT_URL") . getenv("PHOTOUPLOADER_IMAGE_PATH");
$album_url = getenv("ALBUMMANAGER_ENDPOINT_URL") . getenv("ALBUMMANAGER_ALBUM_PATH");

// Wait for response from uploader, album-manager, content-service
$responseCode = 0;

foreach (array($user_url, $user_url, $album_url, $uploader_url) as $service){
    echo "Testing to see if the service is up: " . $service . "\n";
    while ($responseCode == "0" || $responseCode == "502"){
        $responseCode = connect( $service);
        sleep(5);
    }
}

// GET articles to verify articles in DB
$resp = json_decode(getRequest($content_url));

if ($resp == null){

    $data = array("email" => "invisibleUser@fakewebsite.com", "password" => "securePassword");
    $post_opts = json_encode($data);

    $post_resp = json_decode(postRequest($user_url, $post_opts));
    $auth = $post_resp->id;
    echo "Auth-ID: " . $auth . "\n";

    // --------------------------NYC B&W Photos Post----------------------------------

    // Data for NYC post
    $data = array("title" => "New York City in Winter",
        "body" => "New York City takes on a quiet calm after a snowfall. The hustle and bustle fo the city-that-never-sleeps slows down as snow dampens the echoes and constant din of activity. Central Park is particularly enchanting wrapped in the mantel of winter. Trees take on eerie angles against the smooth snow and even squirrels slow down in the winter cold.",
        "extract" => "New York City takes on a quiet calm after a snowfall. The hustle and bustle fo the city-that-never-sleeps slows down...",
        "location" => "New York, NY",
        "photo" => "central_park_winter_2000_01.jpg",
        "author" => "NGINX",
        "directory" => "/ingenious-pages/web/bundles/ingenious/images/NYC_BW",
        "auth" => $auth
    );
    createAPost($data);


    // --------------------------Paris B&W Photos Post----------------------------------

    // Data for NYC post
    $data = array("title" => "Paris, France in Black and White",
        "body" => "Paris is an eloquent blend of the ancient, the old and the very modern. It has been the capital of art and European culture for centuries. The Eiffel Tower, Nortre Dame and Sculptures that dot the landscape of Paris elicit a yearning the is felt in the hearts and souls of all people.",
        "extract" => "Paris is an eloquent blend of the ancient, the old and the very modern. It has been the capital of art...",
        "location" => "Paris, FR",
        "photo" => "DSCN0225.JPG",
        "author" => "NGINX",
        "directory" => "/ingenious-pages/web/bundles/ingenious/images/PARIS_BW",
        "auth" => $auth
    );
    createAPost($data);

    // --------------------------Orchids Post----------------------------------

    // Data for NYC post
    $data = array("title" => "Summer Orchids",
        "body" => "Orchids are the flagbearers of one of the great revolutions in life on earth – the emergence of the flowering plant. From about 500 million years ago, plants began to cover the land surface, gradually becoming taller and forming forests. But they were mostly pollinated by the wind, and flower-less. The earth was simply green. Many shades of green. But green.",
        "extract" => "Orchids are the flagbearers of one of the great revolutions in life on earth...",
        "location" => "San Francisco, CA",
        "photo" => "sept_orchids_2005_06.jpg",
        "author" => "NGINX",
        "directory" => "/ingenious-pages/web/bundles/ingenious/images/ORCHIDS",
        "auth" => $auth
    );
    createAPost($data);
}
else {
    echo "Articles aready in database!";
}


function createAPost($dataSet){

    // Upload image
    $auth = $dataSet['auth'];
    $data = array("album[name]" => $dataSet['title']);
    $post_opts = json_encode($data);
    $post_resp = json_decode((postWithAuth($GLOBALS['album_url'], $post_opts, $auth)));

    $album_id = $post_resp->id;
    echo "Album ID = " . $album_id . "\n";
    $directory = $dataSet['directory'];
    $poster_photo = $directory . "/" . $dataSet['photo'];

    foreach (array_diff(scandir($directory), array('..', '.')) as $image)
    {
        $post_opts = [
            "image" => new CurlFile($directory . "/" . $image, 'image/jpg'),
            "album_id" => $album_id,
        ];

        $post_resp = json_decode(postWithAuth($GLOBALS['uploader_url'], $post_opts, $auth));
        if (strpos($image, $dataSet['photo']) !== false) {$poster_photo = $post_resp->medium_url;}
    }

    // Data for post
    $data = array("title" => $dataSet['title'],
        "body" => $dataSet['body'],
        "extract" => $dataSet['extract'],
        "location" => $dataSet['location'],
        "photo" => $poster_photo,
        "author" => $dataSet['author'],
        "album_id" => $album_id
    );
    $post_opts = json_encode($data);

    // POST to content service
    echo postWithAuth($GLOBALS['content_url'], $post_opts, $auth);
}


// GET request to specified url
// @parameter: $url: url to service
// @return: return of GET request
function getRequest($url){
    echo "getRequest url:" . $url . "\n";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    return curl_exec($ch);
}

// POST request with json to specified url without auth
// @parameters:
//  $url: url to service
//  $opts: options set for POST request
// @return: return of POST request
function postRequest($url, $opts){
    echo "postRequest url:" . $url . "\n";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $opts);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($opts))
    );
    return curl_exec($ch);
}

// POST request to specified url
// @parameters:
//  $url: url to service
//  $opts: options set for POST request
//  $auth_id: id of fake user to verify POST
// @return: return of POST request
function postWithAuth($url, $opts, $auth_id){
    echo "postWithAuth url:" . $url . "\n";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $opts);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Auth-ID: ' . $auth_id,
    ));
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    return curl_exec($ch);
}

function connect($url){
    echo "connect url:" . $url . "\n";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_exec($ch);
    return curl_getinfo($ch, CURLINFO_HTTP_CODE);
}
