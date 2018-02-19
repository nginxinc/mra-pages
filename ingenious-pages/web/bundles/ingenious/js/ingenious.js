/**
 //  ingenious.js
 //  Pages
 //
 //  Copyright © 2017 NGINX Inc. All rights reserved.
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
    });

    $("#photo-upload").submit(function(event) {
        isNewAlbum = false;
        setVar();
        bannerAlbumBool = true;
        uploadBanner(event);
    });

    $("#album-delete").submit(function(event) {
        deleteAlbum(event);
    });

    $("#create-post").submit(function (event) {
        createPost(event);
    });

    $("#add-cover-button").click(function() {
        var file = $("#add-cover-input").prop('files')[0];
        if (file) {
            var coverInfo = $("#cover-info");
            coverInfo.show();
            coverInfo.html("Uploading...");
        }
        userManagerURL = $(this).attr('userManager');
        var albumID = $(this).attr('coverPicturesID');

        uploadSupportImage(file, albumID, true);
    });

    $(".cover-thumb").click(function() {
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

    $(".remove-pp").click(function() {
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

    $("#updateProfilePicture").change(function() {
        var file = $("#profile-picture-input").prop('files')[0];
        userManagerURL = $(this).attr('userManager');
        var albumID = $(this).attr('profilePicturesID');

        uploadSupportImage(file, albumID, false);
    });

    $(".logout-btn").click(function() {
        logout();
    });

    $("#fb_login").click(function() {
        fbLogin();
    });

    $(".delete-image-btn").click(function(e) {
        e.preventDefault();

        var $lg = $('.album-container');
        $lg.data('lightGallery').destroy();

        return false;
    });
});

$(document).on( 'click', '.delete-image-btn', function( e ) {
    e.preventDefault();

    var imageID = $(this).attr('id');
    var urlS3 = $(this).attr('urlS3');
    var uuid = urlS3.substring(51, 87);

    var imageURL = imageManagerURL + "/" + imageID + "/" + uuid;
    if (confirm("Are you sure you want to delete the photo?")) {
        $.ajax({
            url: imageURL,
            data: null,
            cache: false,
            contentType: false,
            processData: false,
            type: 'DELETE',
            success: function(){
                console.log("Image deleted");
            },
            error: function(response){
                console.log("There is an error:" + response);
            },
            complete: function () {
                console.log("Completed");
                location.reload();
            }
        });

        var $lg = $('.album-container');
        $lg.data('lightGallery').destroy();
    }

    return false;
});

var isNewAlbum, isPost, isPosterImageSettedAutomatically;
var input, loading, result, uploadButton, uploadThumbProto, uploadThumbs, uploadThumbsStr;

var uploaderURL = getenv("PHOTOUPLOADER_ENDPOINT_URL") + getenv("PHOTOUPLOADER_IMAGE_PATH");
var albumManagerURL = getenv("PHOTOMANAGER_ENDPOINT_URL") + getenv("PHOTOMANAGER_CATALOG_PATH");
var imageManagerURL = getenv("PHOTOMANAGER_ENDPOINT_URL") + getenv("PHOTOMANAGER_IMAGES_PATH");
var userManagerURL = getenv("USERMANAGER_ENDPOINT_URL") + getenv("USERMANAGER_ENDPOINT_URL");
var contentServiceURL = getenv("CONTENTSERVICE_ENDPOINT_URL") + getenv("CONTENTSERVICE_ARTICLE_PATH");
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
    } else if (isPost){
        input = $("post-add-photo");
        loading = $("#post-loading");
        result = $("#post-result");
        uploadButton = $("#add-post-button");
        uploadThumbProto = $("#post-upload-thumb-proto");
        uploadThumbs = $("#post-upload-thumbs");
        uploadThumbsStr = "#post-upload-thumbs";
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
            if (resp.name === "StatusCodeError") {
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
    event.preventDefault();
    userManagerURL = $("#account-manager").attr('action');
    setUser(name, email, null, null);
    $("#name-user").html(name);
    $("#notification").html("Name is set to " + name + "</br>Email is set to " + email + "</br>");
}

function setUser(name, email, coverURL, profileURL) {
    var obj = {};
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
            if (resp.name === "StatusCodeError") {
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
            success: function(){
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
                $("#delete-list-existent-albums").load(location.href+" #delete-list-existent-albums>*","");
                $("#photos-list-existent-albums").load(location.href+" #photos-list-existent-albums>*","");
                $("#albums").load(location.href+" #albums>*","");
                $("#all-images-cover").load(location.href+" #all-images-cover>*","");
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
        filesPromise[filesIndex] = new Promise( function (resolve, reject) {
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
        $("#album-upload").find(".label").hide();
        loading.append("<br/>Click on an image to set the photo album poster image.");
        $("#photos-list-existent-albums").load(location.href+" #photos-list-existent-albums>*","");
        $("#delete-list-existent-albums").load(location.href+" #delete-list-existent-albums>*","");
        $("#all-images-cover").load(location.href+" #all-images-cover>*","");
    }).catch(function (error){
        if (isNewAlbum) {
            var albumURL = albumManagerURL + "/" + albumID;
            if (confirm("An error occurred during the uploading process. Would you like to delete the album?")) {
                $.ajax({
                    url: albumURL,
                    data: null,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'DELETE',
                    success: function(){
                        console.log("Album Deleted");
                    },
                    error: function(response){
                        console.log("There is an error:" + response);
                    },
                    complete: function () {
                        console.log("Completed");
                        $(".add-album").removeClass("open");
                        $("body").removeClass("hide-overflow");
                    }
                });
            }
        }
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
            if (resp.name === "StatusCodeError") {
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
            if (resp.name === "StatusCodeError") {
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
                if (uploaded === 1 && isNewAlbum) {
                    isPosterImageSettedAutomatically = true;
                    setAlbumPosterImage(imageID, albumID, uploadThumbnail);
                }
                $(uploadThumbnail).click(function(){
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

/*****************--------start content service section----------*****************/

function createPost(event){
    event.preventDefault();
    isPost = true;
    setVar();

    var data = {
        "title": $("#post-title").val(),
        "body": $("#post-body").val(),
        "photo": $("#post-photo").val(),
        "author": $("#post-author").val(),
        "extract": $("#post-extract").val(),
        "location": $("#post-location").val()
    };

    loading.show();
    uploadThumbProto.show();

    postPromise = new Promise(function (resolve, reject) {
        uploadPost(data, resolve, reject);
    });

    postPromise.then((successMessage) => {
        uploadThumbProto.hide();
        uploadButton.hide();
        $("#album-upload").find(".label").hide();
        loading.html("Post Upload Done");

        console.log(successMessage);
    });
}

function uploadPost(data, resolve, reject){

    $.ajax({
        type: "POST",
        url: contentServiceURL,
        data: JSON.stringify(data),
        cache: false,
        contentType: false,
        processData: false,
        success: function (resp) {
            if (resp.name === "StatusCodeError") {
                loading.html("Error Trying To Upload: " + resp.message);
                console.log("Error Trying To Upload: " + resp.message);
                reject("Error Trying To Upload: " + resp.message);
            } else {
                console.log(resp);
            }
        },
        error: function (response) {
            console.log("There is an error:" + response.message);
            loading.html("There is an error:" + response.message);
            reject("There is an error:" + response.message);
        },
        complete: function () {
            return resolve("Upload complete!");
        }
    });
}

/*****************--------start menus/login section----------*****************/

function logout() {
    var cookies = document.cookie.split(";");
    for (var i = 0; i < cookies.length; i++) {
        eraseCookie(cookies[i].split("=")[0]);
    }
    window.location.href = '/';
}

function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
    });

    // logout();
}

function eraseCookie(name) {
    document.cookie = name+"="+ "" + ";Expires=Thu, 21 Sep 1979 00:00:01 UTC; Path=/";
    if (name === 'google') {
        signOut();
    }
}

window.fbAsyncInit = function() {
    FB.init({
        appId: '999273380132142',
        cookie: true,  // enable cookies to allow the server to access
                       // the session
        xfbml: true,  // parse social plugins on this page
        version: 'v2.8' // use graph api version 2.8
    });
};

// Load the SDK asynchronously
(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

// This is called with the results from from FB.getLoginStatus().
function statusChangeCallback(response) {
    if (response.status === 'connected') {
        var d = new Date();
        var now = d.getTime();
        var expiresAt = now + response.authResponse.expiresIn;

        Cookies.set('auth_provider', 'facebook');
        Cookies.set('auth_token', response.authResponse.accessToken);
        Cookies.set('expires_at', expiresAt);

        document.getElementById( 'ing_fb_login' ).innerHTML = 'Logged in via Facebook';
        $("#left-menu").load(location.href+" #left-menu>*","");
        if (location.pathname !== '/login') {
            location.reload();
        } else {
            location.href = '/myphotos';
        }
    }
}

function fbLogin() {
    FB.login(function(response) {
        if (response.authResponse) {
            FB.getLoginStatus(function(response) {
                statusChangeCallback(response);
            });
        }
    });
}

function onSignIn(googleUser) {
    var id_token = googleUser.getAuthResponse().id_token;
    var expiresAt = googleUser.getAuthResponse().expires_at;

    Cookies.set('auth_provider', 'google');
    Cookies.set('auth_token', id_token);
    Cookies.set('expires_at', expiresAt);

    if (id_token) {
        document.getElementById('ing_gp_login').innerHTML = 'Logged in via Google';
        $("#left-menu").load(location.href+" #left-menu>*","");
        if (location.pathname !== '/login') {
            location.reload();
        } else {
            location.href = '/myphotos';
        }
    }
}

function onFailure(error) {
    console.log(error);
    console.log('google sign in failure');
}
