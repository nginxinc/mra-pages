
(function($) {

    // Toggle main offcanvas navigation
    $(".main-nav-btn a").click(function() {
        $(".main-nav").addClass("nav-open");
        $(".nav-btn").addClass("hide-nav-btn");
    });

    $(".main-nav a.nav-close-btn").click(function() {
        $(".main-nav").removeClass("nav-open");
        $(".nav-btn").removeClass("hide-nav-btn");
    });

    // Toggle right offcanvas navigation
    $(".right-nav-btn a").click(function() {
        $(".right-nav").addClass("nav-open");
        $(".right-nav-btn").addClass("hide-nav-btn");
    });

    $(".right-nav a.nav-close-btn").click(function() {
        $(".right-nav").removeClass("nav-open");
        $(".right-nav-btn").removeClass("hide-nav-btn");
    });

    // Edited by Ash
    $( '.google-login' ).click( function( e ) {
        e.preventDefault();
        $( '.abcRioButtonContentWrapper' ).click();
        return false;
    } );

    $( '.fb-login' ).click( function( e ) {
        e.preventDefault();
        $(".login-content iframe").contents().find(".uiGrid").click();
        return false;
    } );
    
    // Smooth transition to section
    $(".scroll-down").click(function() {
        $('html, body').animate({
            scrollTop: $("#about").offset().top
        }, 1000);
        return false;
    });

    // Lightbox for album
    $('.album-container').lightGallery({
        mode: 'lg-fade',
        cssEasing : 'cubic-bezier(0.25, 0, 0.25, 1)',
        counter: false,
        download: false,
    });
    
    $( document ).on( 'click', '.back-to-album', function( e ) {
        e.preventDefault();
        
        var $lg = $( '.album-container' );
        $lg.data( 'lightGallery' ).destroy();
        
        return false;
    } );
    
    // Add photo
    $(".add-photo-btn").click(function() {
        $(".add-photo").toggleClass("open");
        $("body").toggleClass("hide-overflow");
    });

    $(".add-photo .cancel-upload").click(function() {
        $(".add-photo").removeClass("open");
        $("body").removeClass("hide-overflow");
    });

    // Add album
    $(".add-album-btn").click(function() {
        $("#banner-album-id").val("");
        $(".add-album").toggleClass("open");
        $("body").toggleClass("hide-overflow");         
    });
    
    $(".add-album .cancel-upload").click(function() {
        $(".add-album").removeClass("open");         
        $("body").removeClass("hide-overflow");         
    });

    // Delete album
    $(".delete-album-btn").click(function() {
        $(".delete-album").toggleClass("open");
        $("body").toggleClass("hide-overflow");
    });
    $(".delete-album .cancel-upload").click(function() {
        $(".delete-album").removeClass("open");
        $("body").removeClass("hide-overflow");
    });

    // Add cover photo
    $(".add-cover").click(function() {
        $(".add-cover-photo").toggleClass("open");         
        $("body").toggleClass("hide-overflow");         
    });
    
    $(".add-cover-photo .cancel-upload").click(function() {
        $(".add-cover-photo").removeClass("open");         
        $("body").removeClass("hide-overflow");         
    });

    $("#album-photo-input").change(function(){
          var files = $(this)[0].files;
          $("#browse-button-album").text(files.length + " photos selected");
    });

    $("#add-photo-input").change(function(){
        var files = $(this)[0].files;
        $("#browse-button-photo").text(files.length + " photos selected");
    });

})(jQuery);
