/**
 * Created by chrisstetson on 11/16/15.
 */

//<script> //this fakes out Intellij to thinking it is Javascript but doesn't render as a script tag in the browser

$(document).ready(function() {
});
var mobileMenuIsOpen = false;
var galleryIsOpen = false;
var displayImageIndex = {int:1};
var slideToPosition = 0;
var photoListUlWidth = {width:0};
var displayPhoto;
var photoHammer = {};
var photoListHammer = {};
var previousDisplayPhoto = '#photo-list-image-1';
var menuIsOpen = false;
var uploaderURL = "/uploader/image";//this should be set with environment variables
var uploaderAlbumURL = "/uploader/album";//this should be set with environment variables
var albumManagerURL = "/albums";//this should be set with environment variables
var uploaded = 0;
var filesIndex = 0

/*****************--------start uploader section----------*****************/

function uploadImages( event ) {

    /*
     * Get name of album
     * Submit name and get back album_id
     * Get images from the form
     * Make a map of images
     * Create progress event listeners for each image
     * submit images to uploader with album_id (I may need to put this as a header/alternate value because of the way files are submitted)
     * get response back for each image with the thumbnail URL
     * place into page showing upload progress and thumbnail when done
     * close panel refreshes album list
     */
    event.preventDefault();
    uploaded = 0;
    var filesPromise = [];
    $('#upload-panel').animate({width:'90%'});
    $('#result').show();
    var i = 0;
    var album_id;
    var albumIDPromise = new Promise( function (resolve, reject) {
            initAlbum($("#album-name").val(), resolve, reject);
        }
    );
    albumIDPromise.then(function(data) {
        $("#loading").html(uploaded + " of " + filesIndex + " Images Uploaded");
        album_id = data;
        for( filesIndex = 0; $("#photo-input").prop('files').length > filesIndex; filesIndex++)
        {
            var file = $("#photo-input").prop('files')[filesIndex]
            filesPromise[filesIndex]= new Promise( function (resolve, reject) {
                uploadFile("#upload-thumb-" + i++, file, album_id,resolve, reject);
            });
            $('#upload-thumb-proto').clone().appendTo('#upload-thumbs').attr('id',"upload-thumb-" + filesIndex).attr('display','inline');
        }
        Promise.all(filesPromise).then(function(){
            $("#create-album-button").hide();
            $("#loading").append("<br/> Click on an image to set the photo album poster image.");
            $(".upload-thumb").click(function(evt){
                //var setAlbumPromise = new Promise( function (resolve, reject) {
                //setAlbumPosterImage(evt.target, resolve, reject,$("#upload-thumbs").data("album-id"));
                evt.stopPropagation();
                setAlbumPosterImage(evt.target, $("#upload-thumbs").data("album-id"));
                // }
                //);
            });
        }).catch(function (error){
                $("#loading").html(error);
            })
    });
    albumIDPromise.catch(function (error){
        $("#loading").html(error);
    });
    return album_id;
}

function getFileSize(file) {
    var totalFileSize = file.size;
    if (totalFileSize > 1024 * 1024)
        totalFileSize = (Math.round(totalFileSize * 100 / (1024 * 1024)) / 100).toString() + 'MB';
    else
        totalFileSize = (Math.round(totalFileSize * 100 / 1024) / 100).toString() + 'KB';
    return totalFileSize;
}

function initAlbum(albumName,resolve, reject, albumDescription)
{
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
            album_id = resp.id;
            $("#upload-thumbs").data("album-id",album_id);
        },
        error: function(response){
            reject("There is an error:" + response);
        },
        complete: function () {
            resolve(album_id);
        }

    });
}

function uploadFile(uploadThumbnail, file, albumID, resolve, reject)
{
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
            var thumbnail = resp.thumb_url;
            var imageID = resp.id;
            $(uploadThumbnail + " img").attr('src',thumbnail);
            $(uploadThumbnail).data('image-id',imageID);
            $("#loading").html(++uploaded + " of " + filesIndex + " Images Uploaded");
        },
        error: function(response){
            console.log("There is an error:" + response);
            $("#loading").html("There is an error:" + response);
            reject("There is an error:" + response);
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

//function setAlbumPosterImage(thumbnail,resolve, reject, album_id)
function setAlbumPosterImage(thumbnail,album_id)
{
    var data = new FormData;
    var imageID = $("#" + thumbnail.parentElement.id).data("image-id");
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
        complete: function () {
            //clear the previous selected img
            $("#" + thumbnail.parentElement.id +" img").css({"border-color": "#00974c",
                "border-width":"3px",
                "border-style":"solid"});
            $("#loading").html("Poster Image is set.");
        }
    });
}

function showHideUploadPanel(callingImage, panel)
{
    var img = $(callingImage).offset();
    var leftPosi = img.left ;
    var topPosi;
    topPosi = img.top;

    $(panel).css({
        left: leftPosi, top: topPosi
    });
    $(panel).toggle();
    Cookies.set('logged_in', 'true');
    $('#upload-thumbs').empty();
    $(panel).height("");
    $(panel).width("");
    $("#results").hide();
    if($(panel).css('display') == 'none')
    {
        $('.photo-set-list').load("/catalog");
    }
    else
    {
        $( "#album-upload" ).submit(function( event ) {
            uploadImages(event);
        });
    }
    $("#create-album-button").show();

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
    };
}

/*****************--------start photo gallery section----------*****************/
function initPhotoGallery()
{//this is a callback function for when done that loads and processes the image list
    //alert('the document is ready');
    displayPhoto = document.getElementById('display-photo');
    displayPhotoList = document.getElementById('photo-list-ul');
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
    var photoGalleryURL = "";
    photoGalleryURL = "/album/" + folder + "/" + photoset;
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
    var currentText = $('#crumb-photo').text();
    $('#crumb-photo').text(photoFileName);//this splits the img path and gets the last of the split array
    $('#display-photo-link').attr('href',img);
    $('#crumb-photo').attr('href',img);
}

function advancePhoto(direction)
{
    var index = 0;
    var img = '';
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
    };
    if (index > endOfList) {index = 0;}
    if (index < 0) { index = endOfList;}
    var imgID = '#photo-list-image-' + index
    img = $(imgID).attr('src').replace('thumb','medium');
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



//</script>
