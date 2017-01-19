/**
 * Created by chrisstetson on 11/16/15.
 */

$(document).ready(function() {
    $("#update-account-button").click(function(event) {
        var name = $("#name").val();
        var email = $("#email").val();
        updateUser(event, name, email);
    });

    $("#album-upload").submit(function(event) {
        isNewAlbum = true;
        setVar();
        bannerAlbumBool = true;
        uploadBanner(event);
        $("#albums").load(location.href+" #albums>*","");
        $("#photos-list-existent-albums").load(location.href+" #photos-list-existent-albums>*","");
        $("#delete-list-existent-albums").load(location.href+" #delete-list-existent-albums>*","");
    });

    $("#photo-upload").submit(function(event) {
        isNewAlbum = false;
        setVar();
        bannerAlbumBool = true;
        uploadBanner(event);
    });

    $("#album-delete").submit(function(event) {
        deleteAlbum(event);
        $("#delete-list-existent-albums").load(location.href+" #delete-list-existent-albums>*","");
        $("#photos-list-existent-albums").load(location.href+" #photos-list-existent-albums>*","");
        $("#albums").load(location.href+" #albums>*","");
    });

    $("#add-cover-button").click(function(event) {
        $("#cover-info").show();
        $("#cover-info").html("Uploading...");

        var file = $("#add-cover-input").prop('files')[0];
        userManagerURL = $(this).attr('userManager');
        var albumID = $(this).attr('coverPicturesID');

        uploadSupportImage(file, albumID, true);
    });

    $(".cover-thumb").click(function(evt) {
        var imageURL = this.id;
        $(".cover-thumb").css({"border-width": "0px"});
        $("#cover-info").show();

        $(this).css({
            "border-color": "#00974c",
            "border-width": "3px",
            "border-style": "solid"
        });
        setBanner(imageURL);

        userManagerURL = $("#add-cover-button").attr('userManager');

        setUser(null, null, imageURL, null);
    });

    $(".remove-pp").click(function(event) {
        $(".hexagon1").css({
            "background": "url(/bundles/ingenious/images/profile-picture.png)",
            "background-repeat": "no-repeat",
            "background-attachment": "scroll",
            "background-size": "cover",
            "background-position": "center"
        });

        userManagerURL = $("#remove-pp-id").attr('action');

        setUser(null, null, null, "generic");
    });

    $("#updateProfilePicture").change(function(event) {
        var file = $("#profile-picture-input").prop('files')[0];
        userManagerURL = $(this).attr('userManager');
        var albumID = $(this).attr('profilePicturesID');

        uploadSupportImage(file, albumID, false);
    });

    $(".logout-btn").click(function(event) {
        logout();
    });

    $("#fb_login").click(function(event) {
        fbLogin();
    });
});

var isNewAlbum, isPosterImageSettedAutomatically;
var input, loading, result, uploadButton, uploadThumbProto, uploadThumbs, uploadThumbsStr;

var uploaderURL = "/uploader/image";//this should be set with environment variables
var albumManagerURL = "/albums";//this should be set with environment variables
var userManagerURL = "/account/users";//this should be set with environment variables
var uploaded = 0;
var filesIndex = 0;
var bannerAlbumBool = false;
var posterBannerImage = false;
var posterBannerImageInWaiting;
var posterBannerContainerInWaiting;

function setVar() {
    if (isNewAlbum) {
        input = $("#album-photo-input");
        loading = $("#album-loading");
        result = $("#album-result");
        uploadButton = $("#create-album-button");
        uploadThumbProto = $("#album-upload-thumb-proto");
        uploadThumbs = $("#album-upload-thumbs");
        uploadThumbsStr = "#album-upload-thumbs";
    } else {
        input = $("#add-photo-input");
        loading = $("#photos-loading");
        result = $("#photos-result");
        uploadButton = $("#add-photo-button");
        uploadThumbProto = $("#photos-upload-thumb-proto");
        uploadThumbs = $("#photos-upload-thumbs");
        uploadThumbsStr = "#photos-upload-thumbs";
    }
}

/*****************--------start user account section----------*****************/

function uploadSupportImage(file, albumID, cover) {
    var data = new FormData;
    data.append("image", file );
    data.append("album_id", albumID);

    $.ajax({
        url: uploaderURL,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(resp){
            if (resp.name == "StatusCodeError") {
                console.log("Error Trying To Upload: " + resp.message);
            } else {
                if (cover) {
                    var coverURL = resp.large_url;
                    setBanner(coverURL);
                    setUser(null, null, coverURL, null);
                } else {
                    profileURL = resp.thumb_url;
                    $(".hexagon1").css({
                        "background": "url(" + profileURL + ")",
                        "background-repeat": "no-repeat",
                        "background-attachment": "scroll",
                        "background-size": "cover",
                        "background-position": "center"
                    });
                    setUser(null, null, null, profileURL);
                }
            }
        },
        error: function(response){
            console.log("There is an error:" + response.message);
        }
    });
}

function setBanner(imageURL) {
    $(".hero-banner").css({
        "background": "url(" + imageURL + ")",
        "background-repeat": "no-repeat",
        "background-attachment": "scroll",
        "background-size": "cover",
        "background-position": "center"
    });

    $("#cover-info").html("Cover photo added.");
}

function updateUser(event, name, email) {
    event.preventDefault()
    userManagerURL = $("#account-manager").attr('action');
    setUser(name, email, null, null);
    $("#name-user").html(name);
    $("#notification").html("Name is set to " + name + "</br>Email is set to " + email + "</br>");
}

function setUser(name, email, coverURL, profileURL) {
    var obj = new Object();
    if (name) { obj.name = name; }
    if (email) { obj.email = email; }
    if (coverURL) { obj.banner_url = coverURL; }
    if (profileURL) { obj.profile_picture_url = profileURL; }
    var data = JSON.stringify(obj);

    $.ajax({
        url: userManagerURL,
        data: data,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        cache: false,
        processData: false,
        type: 'PUT',
        success: function(resp) {
            if (resp.name == "StatusCodeError") {
                if (!coverURL) { $(".photo-set-list").html("Error Trying To Update User Account: " + resp.message); }
                console.log("Error Trying To Update User Account: " + resp.message);
            } else {
                name = resp.name;
                email = resp.email;
            }
        },
        error: function() {
            console.log("There is an error in the AJAX request to set a user");// + response.message);
        }
    });
}

function deleteAlbum(event) {
    event.preventDefault();
    var album_id = $("#delete-album-id").val();
    var albumURL = albumManagerURL + "/" + album_id;
    if (album_id) {
        $.ajax({
            url: albumURL,
            data: null,
            cache: false,
            contentType: false,
            processData: false,
            type: 'DELETE',
            success: function(resp){
                console.log("Album Deleted");
            },
            error: function(response){
                console.log("There is an error:" + response);
            },
            complete: function () {
                console.log("Completed");
                var deleteInfo = $("#delete-info");
                deleteInfo.show();
                deleteInfo.html("Album deleted.");
            }
        });
    }
}
/*****************--------start uploader section----------*****************/

function uploadBanner(event) {
    event.preventDefault();
    if (isNewAlbum) {
        createAlbum(event);
    } else {
        manageUpload($("#add-photos-album-id").val());
    }
}

function createAlbum(event) {
    event.preventDefault();
    uploaded = 0;
    var albumIDPromise = new Promise(function(resolve, reject) {
        initAlbum($("#album-name").val(), resolve, reject);
    });
    albumIDPromise.then(function(data) {
        manageUpload(data);
        return data;
    });
    albumIDPromise.catch(function(error) {
        loading.show();
        loading.html(error);
        console.log("ERROR: " + error);
    });
}

function manageUpload(albumID){
    var filesPromise = [];
    uploaded = 0;
    var photoInputLength = input.prop('files').length;
    loading.show();
    loading.html(uploaded + " of " + photoInputLength + " Images Uploaded");
    result.show();
    uploadThumbs.data("album-id", albumID);
    for(filesIndex = 0; filesIndex < photoInputLength; filesIndex++) {
        var file = input.prop('files')[filesIndex];
        var thumbID = "upload-thumb-" + $('.upload-thumb').length;
        filesPromise[filesIndex]= new Promise( function (resolve, reject) {
            uploadFile("#" + thumbID, file, albumID, resolve, reject);
        });
        if(bannerAlbumBool) {
            uploadThumbProto.clone().prependTo(uploadThumbsStr).attr('id',thumbID).attr('display','inline');
        } else {
            uploadThumbProto.clone().appendTo(uploadThumbsStr).attr('id',thumbID).attr('display','inline');
        }
    }
    Promise.all(filesPromise).then(function(){
        uploadButton.hide();
        $("#album-upload .label").hide(); // TODO
        loading.append("<br/>Click on an image to set the photo album poster image.");
    }).catch(function (error){
        loading.html(error);
    })
}

function initAlbum(albumName, resolve, reject) {
    var data = new FormData;
    data.append("album[name]", albumName);
    var album_id = 0;
    $.ajax({
        url: albumManagerURL,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(resp){
            if (resp.name == "StatusCodeError") {
                $("#album-loading").html("Error Trying To Upload: " + resp.message);
                console.log("Error Trying To Upload: " + resp.message);
                reject("Error Trying To Upload: " + resp.message);
            } else {
                album_id = resp.id;
                uploadThumbs.data("album-id", album_id);
            }
        },
        error: function(response){
            reject("There is an error:" + response.message);
        },
        complete: function () {
            resolve(album_id);
        }
    });
}

function uploadFile(uploadThumbnail, file, albumID, resolve, reject) {
    var data = new FormData;
    data.append("image", file );
    data.append("album_id",albumID);

    $.ajax({
        url: uploaderURL,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(resp) {
            if (resp.name == "StatusCodeError") {
                loading.html("Error Trying To Upload: " + resp.message);
                console.log("Error Trying To Upload: " + resp.message);
                reject("Error Trying To Upload: " + resp.message);
            } else {
                var thumbnail = resp.thumb_url;
                var imageID = resp.id;
                $(uploadThumbnail + " img").show();
                $(uploadThumbnail + " img").attr('src',thumbnail);
                $(uploadThumbnail).data('image-id',imageID);
                loading.html(++uploaded + " of " + filesIndex + " Images Uploaded");
                if (uploaded == 1 && isNewAlbum) {
                    isPosterImageSettedAutomatically = true;
                    setAlbumPosterImage(imageID, albumID, uploadThumbnail);
                }
                $(uploadThumbnail).click(function(evt){
                    isPosterImageSettedAutomatically = false;
                    setAlbumPosterImage(imageID, albumID, uploadThumbnail);
                });
                posterBannerImageInWaiting = imageID;
                posterBannerContainerInWaiting = uploadThumbnail;
            }
        },
        error: function(response) {
            console.log("There is an error:" + response.message);
            loading.html("There is an error:" + response.message);
            reject("There is an error:" + response.message);
        },
        complete: function() {
            return resolve($(uploadThumbnail).data('image-id'));
        }
    });
}

function setAlbumPosterImage(imageID, album_id, container) {
    var data = new FormData;
    data.append("album[poster_image_id]", imageID);
    var putURL = albumManagerURL + "/" +  album_id;
    var thumbURL;
    $.ajax({
        url: putURL,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'PUT',
        success: function(resp) {
            thumbURL = resp.poster_image.thumb_url;
        },
        error: function(response) {
            console.log("There is an error:" + response);
        },
        complete: function(resp) {
            if (!isPosterImageSettedAutomatically) {
                $(".upload-thumb img").removeClass("selected");
                $(container +" img").addClass("selected");
                loading.html("Poster Image is set.");
                if(bannerAlbumBool) {
                    $(".hero").css('background-image', 'url(' + resp.responseJSON.poster_image.large_url + ')');
                    $(".file-size").empty();
                    $(container + " .file-size").html("Poster Image");
                }
            }
            posterBannerImage = true;
            $("#albums").load(location.href+" #albums>*","");
        }
    });
}

/*****************--------start menus/login section----------*****************/

function logout() {
    var cookies = document.cookie.split(";");
    for (var i = 0; i < cookies.length; i++) {
        eraseCookie(cookies[i].split("=")[0]);
    }
    Cookies.set('logged_in', false);
    window.location.href = '/';
}

function eraseCookie(name) {
    document.cookie = name+"="+ "" + ";expires=Thu, 21 Sep 1979 00:00:01 UTC; path=/";
}

function fbLogin() {
    window.fbAsyncInit = function() {
        FB.init({
            appId: '999273380132142',
            cookie: true, // enable cookies to allow the server to access
            // the session
            xfbml: true, // parse social plugins on this page
            version: 'v2.6' // use version 2.2
        });

        // Now that we've initialized the JavaScript SDK, we call
        // FB.getLoginStatus().  This function gets the state of the
        // person visiting this page and can return one of three states to
        // the callback you provide.  They can be:
        //
        // 1. Logged into your app ('connected')
        // 2. Logged into Facebook, but not your app ('not_authorized')
        // 3. Not logged into Facebook and can't tell if they are logged into
        //    your app or not.
        //
        // These three cases are handled in the callback function.

        FB.getLoginStatus(function(response) {
            statusChangeCallback(response);
        });

    };

// Load the SDK asynchronously
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
}

// This is called with the results from from FB.getLoginStatus().
function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
        // Logged into your app and Facebook.
        Cookies.set('auth_provider', 'facebook');
        Cookies.set('auth_token', response.authResponse.accessToken);

        document.getElementById( 'ing_fb_login' ).innerHTML = 'Logged in via Facebook';
        //Cookies.set('logged_in', 'true');
    } else if (response.status === 'not_authorized') {
        // The person is logged into Facebook, but not your app.
        document.getElementById('status').innerHTML = 'Please log ' +
            'into this app.';
    } else {
        // The person is not logged into Facebook, so we're not sure if
        // they are logged into this app or not.
        document.getElementById('status').innerHTML = 'Please log ' +
            'into Facebook.';
    }
}

function onSignIn(googleUser) {
    // Useful data for your client-side scripts:
    var profile = googleUser.getBasicProfile();
    console.log("ID: " + profile.getId()); // Don't send this directly to your server!
    console.log("Name: " + profile.getName());
    console.log("Image URL: " + profile.getImageUrl());
    console.log("Email: " + profile.getEmail());

    // The ID token you need to pass to your backend:
    var id_token = googleUser.getAuthResponse().id_token;
    var auth_provider =  Cookies.get('auth_provider');
    console.log("ID Token: " + id_token);

    var loggedIn = Cookies.get('logged_in');
    Cookies.set('auth_provider', 'google');
    Cookies.set('auth_token', id_token);

    // TODO
    //if (loggedIn === 'true') {
        document.getElementById( 'ing_gp_login' ).innerHTML = 'Logged in via Google';
    //}
    //Cookies.set('logged_in', 'true');
}
