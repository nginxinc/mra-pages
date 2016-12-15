/**
 * Created by chrisstetson on 11/16/15.
 */

$(document).ready(function() {
    $("#update-account-button").click(function(event) {
        updateUser(event)
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
    $("#cover-upload").submit(function(event) {

    });

    $(".cover-thumb").click(function(evt) {
        var idCoverLarge = this.id;
        $(".cover-thumb").css({"border-width": "0px"});
        $("#cover-info").show();
        $("#cover-info").html("Cover photo added.");
        $(this).css({
            "border-color": "#00974c",
            "border-width": "3px",
            "border-style": "solid"
        });
        $(".hero-banner").css({"background": "url(" + idCoverLarge + ")"});

        userManagerURL = $("#cover-upload").attr('action');
        var data = '{';
        data = data + '"banner_url": "' + idCoverLarge + '"';
        data = data + '}';
        $.ajax({
            url: userManagerURL,
            data: data,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            processData: false,
            type: 'PUT',
            success: function (resp) {
                if (resp.name == "StatusCodeError") {
                    console.log("Error Trying To Update User Account: " + resp.message);
                }
                console.log("success");
            },
            error: function (response) {
                console.log("There is an error in the AJAX request to set a user");// + response.message);
            },
            complete: function () {
                resolve(JSON.parse(data));
            }

        });
    });

    $(".remove-pp").click(function(event) {
        $("#profile-picture").attr("src", "/bundles/ingenious/images/profile-picture.png");

        userManagerURL = $("#remove-pp-id").attr('action');
        var data = '{';
        data = data + '"profile_picture_url": "' + 'generic' + '"';
        data = data + '}';
        $.ajax({
            url: userManagerURL,
            data: data,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            processData: false,
            type: 'PUT',
            success: function (resp) {
                if (resp.name == "StatusCodeError") {
                    console.log("Error Trying To Update User Account: " + resp.message);
                }
                console.log("success");
            },
            error: function (response) {
                console.log("There is an error in the AJAX request to set a user");// + response.message);
            }
        });
    });

    $(".update-pp").change(function(event) {
        var file = $("#profile-picture-input").prop('files')[0];
        userManagerURL = $(this).attr('title');
        var data = new FormData;
        data.append("image", file );
        var albumID = $(this).attr('id');
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
                    var thumbnail = resp.thumb_url;
                    $("#profile-picture").attr("src", thumbnail);

                    var data = '{';
                    data = data + '"profile_picture_url": "' + thumbnail + '"';
                    data = data + '}';
                    $.ajax({
                        url: userManagerURL,
                        data: data,
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        cache: false,
                        processData: false,
                        type: 'PUT',
                        success: function (resp) {
                            if (resp.name == "StatusCodeError") {
                                console.log("Error Trying To Update User Account: " + resp.message);
                            }
                            console.log("success");
                        },
                        error: function (response) {
                            console.log("There is an error in the AJAX request to set a user");// + response.message);
                        },
                        complete: function () {
                            resolve(JSON.parse(data));
                        }

                    });

                }
            },
            error: function(response){
                console.log("There is an error:" + response.message);
            },
        });
    });
});

var isNewAlbum, isPosterImageSettedAutomatically;
var input, loading, result, uploadButton, uploadThumbProto, uploadThumbs, uploadThumbsStr;

var galleryIsOpen = false;
var slideToPosition = 0;
var photoListUlWidth = {width:0};
var displayPhoto;
var photoHammer = {};
var photoListHammer = {};
var previousDisplayPhoto = "#photo-list-image-1";
var menuIsOpen = false;
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

function updateUser(event) {
    event.preventDefault();
    uploaded = 0;
    var userPromise = new Promise(function(resolve, reject) {
        setUser(resolve, reject, $("#name").val(), $("#email").val());
    });
    userPromise.then(function(data) {
        $("#name-user").html(data.name);
        $("#notification").html("Name is set to " + data.name + "</br>Email is set to " + data.email + "</br>");
    });
    userPromise.catch(function (error){
        $(".photo-set-list").html(error);
        console.log("ERROR: " + error);
    });
}

function setUser(resolve, reject, userName, email, bannerAlbumID) {
    userManagerURL = $("#account-manager").attr('action');
    var data = '{';
    if (userName != undefined && userName != '') {data = data + '"name": "' + userName + '",';}
    if (email != undefined && email != '') {data = data + '"email": "' + email + '"';}
    data = data + '}';
    $.ajax({
        url: userManagerURL,
        data: data,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        cache: false,
        processData: false,
        type: 'PUT',
        success: function(resp){
            if (resp.name == "StatusCodeError")
            {
                $(".photo-set-list").html("Error Trying To Update User Account: " + resp.message);
                console.log("Error Trying To Update User Account: " + resp.message);
                reject("Error Trying To Update User Account: " + resp.message);

            }
            else {
                userName = resp.name;
                email = resp.email;
                if(bannerAlbumID)
                {
                    $("#banner-album-id").val(bannerAlbumID);
                }
            }
        },
        error: function(response){
            console.log("There is an error in the AJAX request to set a user");// + response.message);
            reject("There is an error in the AJAX request to set a user");// + response.message);
        },
        complete: function () {
            resolve(JSON.parse(data));
        }

    });
}
/** DELETE ALBUM **/

function deleteAlbum(event) {
    event.preventDefault();
    var album_id = $("#delete-album-id").val();
    var albumURL = albumManagerURL + "/" + album_id;
    if (album_id != "" || album_id != null) {
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
                //resolve(album_id);
                console.log("Completed");
                $("#delete-info").show();
                $("#delete-info").html("Album deleted.");
            }
        });
    }
}
/*****************--------start uploader section----------*****************/

function uploadBanner(event) {
    event.preventDefault();
    if (isNewAlbum) {
        createAlbum(event, function(albumID) { new Promise(function(resolve, reject) {
            setUser(resolve, reject,"","", albumID)})
        });
    } else {
        manageUpload($("#add-photos-album-id").val());
    }
}

function createAlbum(event, thisPromise ) {
    event.preventDefault();
    uploaded = 0;
    var albumIDPromise = new Promise(function(resolve, reject) {
        initAlbum($("#album-name").val(), resolve, reject);
    });
    albumIDPromise.then(function(data) {
        manageUpload(data);
        thisPromise(data);
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

function getFileSize(file) {
    var totalFileSize = file.size;
    if (totalFileSize > 1024 * 1024)
        totalFileSize = (Math.round(totalFileSize * 100 / (1024 * 1024)) / 100).toString() + 'MB';
    else
        totalFileSize = (Math.round(totalFileSize * 100 / 1024) / 100).toString() + 'KB';
    return totalFileSize;
}

function initAlbum(albumName, resolve, reject, albumDescription) {
    var data = new FormData;
    data.append("album[name]", albumName );
    if(albumDescription !== undefined)
    {
        data.append("album[description]", albumDescription );
    }
    var album_id = 0;
    $.ajax({
        url: albumManagerURL,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(resp){
            if (resp.name == "StatusCodeError")
            {
                $("#album-loading").html("Error Trying To Upload: " + resp.message);
                console.log("Error Trying To Upload: " + resp.message);
                reject("Error Trying To Upload: " + resp.message);
            }
            else {
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
    var fileSize = getFileSize(file);
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
        success: function(resp){
            if (resp.name == "StatusCodeError") {
                loading.html("Error Trying To Upload: " + resp.message);
                console.log("Error Trying To Upload: " + resp.message);
                reject("Error Trying To Upload: " + resp.message);
            } else {
                var thumbnail = resp.thumb_url;
                var imageID = resp.id;
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
        error: function(response){
            console.log("There is an error:" + response.message);
            loading.html("There is an error:" + response.message);
            reject("There is an error:" + response.message);
            //retry logic
        },
        progress: function (evt) {
            var percentComplete = evt.loaded / evt.total;
            $('#progressCounter').html(Math.round(percentComplete * 100) + "%");
        },
        beforeSend:function (){
            $(uploadThumbnail + " img").show();
            $(uploadThumbnail + " .file-size").html(getFileSize(file));
        },
        complete: function () {
            //$("#loading").html();
            //$('#result').hide();
            return resolve($(uploadThumbnail).data('image-id'));
        }
    });
}

function setAlbumPosterImage(imageID,album_id,container) {
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
        success: function(resp){
            thumbURL = resp.poster_image.thumb_url;
            //return album_id;
        },
        error: function(response){
            console.log("There is an error:" + response);
            //retry logic
        },
        complete: function (resp) {
            //clear the previous selected img
            //change to class=selected
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

function showHideUploadPanel(callingImage, panel, reloadCatalog) {
    var img = $(callingImage).offset();
    var leftPosi = img.left ;
    var topPosi;
    topPosi = img.top;
    $(panel).css({
        left: leftPosi, top: topPosi
    });
    $(panel).toggle();
    Cookies.set('logged_in', 'true');
    $( "#album-upload" ).off('submit');
    if($(panel).css('display') == 'none')
    {
        if(!posterBannerImage && $('.upload-button').css('display') == 'none')
        {
            setAlbumPosterImage(posterBannerImageInWaiting, uploadThumbs.data("album-id"), posterBannerContainerInWaiting);//auto sets the poster/Banner image
        }
        $('#photo-input').val('');
        loading.empty();
        $(panel).height("");
        $(panel).width("");
        if(reloadCatalog) {
            $('.photo-set-list').load("/catalog");
            uploadThumbs.empty();
            $("#album-results").hide();
        }
        $(".upload-button").show();
        $("#album-upload .label").show();
        posterBannerImage = false;
        //bannerAlbumBool = false;
    }
    else if(reloadCatalog)//acts as an indicator that it is the photouploads page
    {
        $( "#album-upload" ).submit(function( event ) {
            createAlbum(event);
        });
    }
    else
    {
        $( "#album-upload" ).submit(function( event ) {
            uploadBanner(event);bannerAlbumBool=true;
        });
    }


}
/*****************--------start menus/login section----------*****************/

function hidePanel(sentPanel)
{
    $(sentPanel).hide();
}

function logout()
{
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

function showHideMenu()
{
    if(!menuIsOpen){
        $('.topdown-menu').slideToggle('slow');
        $('.hamburger').attr('src','http://www.metadogs.com/images/icon/hamburger_x.png');
        $('.pg-bd').toggle();
        $('.pg-ft').toggle();
        menuIsOpen = true;
        return false;
    }else{
        $('.topdown-menu').slideToggle('slow');
        $('.hamburger').attr('src','http://www.metadogs.com/images/icon/hamburger.png');
        $('.pg-bd').toggle();
        $('.pg-ft').toggle();
        menuIsOpen = false;
        return false;
    }
}

/*****************--------start photo gallery section----------*****************/
function initPhotoGallery()
{//this is a callback function for when done that loads and processes the image list
    //alert('the document is ready');
    displayPhoto = document.getElementById('display-photo');
    var displayPhotoList = document.getElementById('photo-list-ul');
    //console.log('DisplayPhoto Object :' + displayPhoto);
    photoHammer = new Hammer(displayPhoto);
    photoListHammer = new Hammer(displayPhotoList);
    //console.log('photoHammer Object :' + photoHammer);
    photoHammer.on('swipeleft', function(){advancePhoto('right');});
    photoHammer.on('swiperight', function(){advancePhoto('left');});
    photoHammer.on('press', function() {$('hover-arrows').toggle();});
    photoListHammer.on('swipeleft', function(){slidePhotoList('right');});
    photoListHammer.on('swiperight', function(){slidePhotoList('left');});
    photoListHammer.on('press', function() {$('hover-arrows').toggle();});
    photoListUlWidth = {width:0};
    previousDisplayPhoto = '#photo-list-image-0';
    $('.inline-list').each(function(index)
    {
        var imageWidth = Number($(this).find('img').data('image-width'));
        photoListUlWidth.width = Number(photoListUlWidth.width) + Number(imageWidth) + 4;
        var postion = (Number(photoListUlWidth.width) - Number(imageWidth/2)) * .995;
        //the .995 is to deal with some hidden extra spacing browsers put into linear UL/LIs
        $(this).data('linear-position', postion);
    });
    if (photoListUlWidth.width < $(window).width())
    {
        $('#photo-list-left-arrow').hide();
        $('#photo-list-right-arrow').hide();
    }
}

function showHidePhotoGallery(folder, title, photoset)
{
    var photoGalleryURL = "/album/" + folder + "/" + photoset;
    photoGalleryURL = encodeURI(photoGalleryURL);

    if (galleryIsOpen)
    {
        $('#photo-list').removeClass('is-visible');
        galleryIsOpen = false;
        previousDisplayPhoto = '#photo-list-image-1';
    }else {
        $('#photo-list').load(photoGalleryURL, function(){initPhotoGallery();});
        $('#photo-list').toggleClass('is-visible');
        galleryIsOpen = true;
    }
    return false;
}

function setDisplayPhoto(img, photoID, imgID)
{
    if(imgID.substring(0, '#'.length) != '#')
    {
        imgID = '#' + imgID;
    }
    $('#display-photo').attr('src',img);
    $('#display-photo').data('image-list-id',photoID);
    $(imgID).addClass('selected');
    $(previousDisplayPhoto).removeClass('selected');
    previousDisplayPhoto = imgID;
    var sliderPosition = Number($(imgID).parent().data('linear-position'));
    //sliderPosition = sliderPosition * .99; //this is accounted for in the original linear-position setting
    slidePhotoList(sliderPosition);
    var photoPathArray = img.split('/');
    var photoFileName = photoPathArray[photoPathArray.length -1];
    $('#crumb-photo').text(photoFileName);//this splits the img path and gets the last of the split array
    $('#display-photo-link').attr('href',img);
    $('#crumb-photo').attr('href',img);
}

function advancePhoto(direction)
{
    var index = 0;
    var endOfList = $('.inline-list').length - 1;//takes care 0 based counting on index
    if(direction == 'right')
    {
        //alert('right');
        index = Number($('#display-photo').data('image-list-id'));
        index++;
    }
    else
    {
        //alert('left');
        index = Number($('#display-photo').data('image-list-id'));
        index--;
    }
    if (index > endOfList) {index = 0;}
    if (index < 0) { index = endOfList;}
    var imgID = '#photo-list-image-' + index;
    var img = $(imgID).attr('src').replace('thumb','medium');
    setDisplayPhoto(img, index, imgID);
    //return false;
}

function slidePhotoList(direction)//overloading direction with direct scroll numbers
{
    if(direction == 'left')
    {
        slideToPosition = slideToPosition - $( window ).width();
    }
    else if (direction == 'right')
    {
        slideToPosition = slideToPosition + $( window ).width();
    }
    else //this deals with the direct scroll-to values
    {
        slideToPosition = Number(direction) - ($( window ).width()/2) - 2;
    }
    if (slideToPosition > (photoListUlWidth.width - $( window ).width()))
    {
        slideToPosition = photoListUlWidth.width - $( window ).width();
    }
    if (slideToPosition < 0) {slideToPosition = 0;}
    var duration =  {duration: 500};
    var animateDistance = {right: '0px'};
    animateDistance.right = slideToPosition + 'px';
    $('#photo-list-ul').animate(animateDistance, duration);
    return false;
}

/*****************--------start utils section----------*****************/
function showHideControlPanel(callingImage, panel)
{
    //var elementCalled = document.getElementById(callingImage);
    var img = $(callingImage).position();
    var leftPosi = img.left - $(panel).width() + $(callingImage).width();
    var topPosi;
    topPosi = img.top + $(callingImage).height();

    //var panelArray = ['login-panel'];
    //var index = panelArray.indexOf(panel);
    //panelArray.splice( index, 1 );

    //panelArray.forEach(hidePanel);

    $(panel).css({
        left: leftPosi, top: topPosi
    });
    $(panel).toggle();
    Cookies.set('logged_in', 'true');
}

$(document).keyup(function(e)
{
    if (galleryIsOpen)
    {
        if (e.which == 27 )  // esc
        {
            showHidePhotoGallery();
        }
        if (e.which == 37)
        {
            advancePhoto('left','keyup');
            //slidePhotoList('left');
        }
        if (e.which == 39)
        {
            advancePhoto('right','keyup');
            //slidePhotoList('right');
        }
    }
});

//function createAlbum(form,uploader)

$(window).resize(function()
{
    //Good to use for resizing of the window
});

// modified version of * emRemToPx.js | @whatsnewsisyphus
var pxToEm = function( value, scope, suffix )
{
    if (!scope || value.toLowerCase().indexOf("rem") >= 0) {
        scope = 'body';
    }
    if (suffix === true) {
        suffix = 'em';
    } else {
        suffix = null;
    }
    var divisor = parseFloat(value);
    var scopeTest = $('<span style="display: none; font-size: 1em; margin: 0; padding:0; height: auto; line-height: 1; border:0;">&nbsp;</span>').appendTo(scope);
    var scopeVal = scopeTest.height();
    scopeTest.remove();
    return +(divisor / scopeVal).toFixed(4) + suffix;
};
