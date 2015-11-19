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
    if(setHeroValues)
    {
        var heroBackPos = $('.pg-bd .hero').css('background-position').replace(/%/g,'').split(" ",2)[1];//because background position comes as 2 percentage values
        var heroHeadFontSize = $('.pg-bd .hero .wrapper .headline ').css('font-size').replace('px','');
        var heroSubFontSize = $('h2.subhead').css('font-size').replace('px','');
        var heroSubVertPos = $('.pg-bd .hero .wrapper .subhead ').css('margin-top').replace('px','');
        var heroSubHorizPos = $('.pg-bd .hero .wrapper .subhead ').css('margin-left').replace('px','');
        heroHeadFontSize = pxToEm(heroHeadFontSize, '.pg-bd .hero .wrapper ');//because scope for font size is in the parent
        heroSubFontSize = pxToEm(heroSubFontSize,'.pg-bd .hero .wrapper ');//because scope for font size is in the parent
        heroSubVertPos = pxToEm(heroSubVertPos,'.pg-bd .hero .wrapper .subhead ');
        heroSubHorizPos = pxToEm(heroSubHorizPos,'.pg-bd .hero .wrapper .subhead ');
        $("input[name='heroImagePositionRange'],input[name='heroImagePositionNumber']").val(heroBackPos);
        $("input[name='headlineFontSizeRange'],input[name='headlineFontSizeNumber']").val(heroHeadFontSize);
        $("input[name='subheadFontSizeRange'],input[name='subheadFontSizeNumber']").val(heroSubFontSize);
        $("input[name='subheadVerticalPositionRange'],input[name='subheadVerticalPositionNumber']").val(heroSubVertPos);
        $("input[name='subheadHorizontalPositionRange'],input[name='subheadHorizontalPositionNumber']").val(heroSubHorizPos);
    }

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

}

function hidePanel(sentPanel)
{
    $(sentPanel).hide();
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
    previousDisplayPhoto = '#photo-list-image-1';
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
    folder = "folder=" + folder;
    title = "title=" + title;
    photoset = "photoSet=" + photoset;
    photoGalleryURL = "http://www.metadogs.com/includes/photoSetDisplay.jsp?" + folder + "&" + title + "&" + photoset;
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
    var endOfList = $('.inline-list').length;
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
    if (index > endOfList) {index = 1;}
    if (index == 0) { index = endOfList;}
    var imgID = '#photo-list-image-' + index
    img = $(imgID).attr('src').replace('thumbnails','medium');
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

function createDirectory(baseDir,newDir)
{
    baseDir =  $('#directory-control-select option:selected').val();
    newDir = $('#new-directory-name').val();
    baseDir = "?baseDirectory=" + baseDir;
    newDir = "&newDirectory=" + newDir;
    var newDirectoryurl = "/includes/image_directory.jsp"
        + baseDir
        + newDir;
    $('#upload-control-select').load(newDirectoryurl);
    $('#directory-controls-panel').toggle();
    return false;
}

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
