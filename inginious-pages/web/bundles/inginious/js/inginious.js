/**
 * Created by chrisstetson on 11/16/15.
 */




//<script> //this fakes out Intellij to thinking it is Javascript but doesn't render as a script tag in the browser

$(document).ready(function() {
    $( ".hero-field" ).on( "change blur reset", function()
    {
        $('.pg-bd .hero').css('background-image', 'url(' + $(this).val() + ')');
    });
    $( "input[name='headLine']" ).on( "change reset keyup", function()
    {
        $('.pg-bd .hero .wrapper .headline span').text($(this).val().substring(0,1));
        $('.pg-bd .hero .wrapper .headline ').contents().filter(function()
        {
            return this.nodeType == Node.TEXT_NODE;
        })[0].nodeValue = $(this).val().substring(1);//this gets the text after the span
    });
    $( "input[name='subHead']" ).on( "change reset keyup", function()
    {
        $('.pg-bd .hero .wrapper .subhead').text($(this).val());
    });
    $("input[name='heroImagePositionRange'],input[name='heroImagePositionNumber']").on("input change", function()
    {
        var yPosition = this.value + "%";
        $('.pg-bd .hero').css('background-position', '50% ' + yPosition);
    });
    $("input[name='headlineFontSizeRange'],input[name='headlineFontSizeNumber']").on("input change", function()
    {
        var fontSize = this.value + "em";
        $('.pg-bd .hero .wrapper .headline ').css('font-size', fontSize);
    });
    $("input[name='subheadFontSizeRange'],input[name='subheadFontSizeNumber']").on("input change", function()
    {
        var fontSize = this.value + "em";
        $('.pg-bd .hero .wrapper .subhead ').css('font-size', fontSize);
    });
    $("input[name='subheadVerticalPositionRange'],input[name='subheadVerticalPositionNumber']").on("input change", function()
    {
        //this.value = 2.8 - this.value;
        var vertPosi = this.value + "em";
        $('.pg-bd .hero .wrapper .subhead ').css('margin-top', vertPosi);
    });
    $("input[name='subheadHorizontalPositionRange'],input[name='subheadHorizontalPositionNumber']").on("input change", function()
    {
        var horizPosi = this.value + "em";
        $('.pg-bd .hero .wrapper .subhead ').css('margin-left', horizPosi);
    });
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

function showHideSubMenu(menu,img,subNavBool)
{

    if(!subNavBool.bool){
        $(menu).slideToggle('fast');
        $(img).attr('src','http://www.metadogs.com/images/icon/v-up.png');
        subNavBool.bool = true;
        return false;
    }else{
        $(menu).slideToggle('fast');
        $(img).attr('src','http://www.metadogs.com/images/icon/v-down.png');
        subNavBool.bool = false;
        return false;
    };
}

function LoadMoreStories(url)
{
    var contenturl = "";
    contenturl = "/includes/main_content.jsp?morestories=y"
        + "&story=null"
        + "&mainURL=" + url
        + "&author=y"
        + "&dateline=y"
        + "&singlestory=n";
    $('#next-content').load(contenturl + " .articles-container");
    $('#more-stories').toggle();

}

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

function showHideMovie(folder, title, movieSet)
{
    var moviePlayer = "";
    folder = "folder=" + folder;
    title = "title=" + title;
    movieSet = "movieSet=" + movieSet;
    movieURL = "/includes/movie.jsp?" + folder + "&" + title + "&" + movieSet;
    moviePlayer = encodeURI(movieURL);

    if (galleryIsOpen)
    {
        $('#photo-list').removeClass('is-visible');
        galleryIsOpen = false;
    }else {
        $('#photo-list').load(moviePlayer);
        $('#photo-list').toggleClass('is-visible');
        galleryIsOpen = true;
    }
    return false;
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
$( "#album-upload" ).submit(function( event ) {

    var data = new FormData($(this)[0]);

    event.preventDefault();

    var jqxhr = $.post($(form).attr("action"), data, function(result) {
        alert(result);
    }).done(function( data ) {
        var content = $( data );
        $( "#result" ).empty().append( content );
    })
    .fail(function() {
        alert( "error" );
    })
    .always(function() {
        alert( "finished" );
    });

     return false;
});

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
