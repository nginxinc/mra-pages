/**
 //  main.js
 //  Pages
 //
 //  Copyright © 2017 NGINX Inc. All rights reserved.
 */

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
        cssEasing: 'cubic-bezier(0.25, 0, 0.25, 1)',
        counter: false,
        download: false
    });

    $(document).on( 'click', '.back-to-album', function (e) {
        e.preventDefault();

        var $lg = $('.album-container');
        $lg.data('lightGallery').destroy();

        return false;
    });

    $(".hideOverflow").click(function () {
        $('html, body').css('overflow', 'hidden');
    });

    $('.album-container').lightGallery().on('onCloseAfter.lg', function () {
        $('html, body').css('overflow', 'auto');
    });

    $(document).ready(function () {
        var $lg = $('#lightgallery');
        $lg.lightGallery({
            mode: 'lg-fade',
            cssEasing: 'cubic-bezier(0.25, 0, 0.25, 1)',
            counter: false,
            download: false
        });
        $(".post-photo-thumb:first").click();
        // Had to do the click approach because the documented way of
        // $lg.data('lightGallery').slide(0) doesn't work
    });

    // Add album
    $(".add-album-btn").click(function() {
        $("#album-name").val("");
        $("#album-photo-input").val("");
        $("#browse-button-album").text("Browse");
        $("#create-album-button").show();
        $("#album-result").hide();
        var albumLoading = $("#album-loading");
        albumLoading.empty();
        albumLoading.hide();
        $("#album-upload-thumbs").empty();
        $(".add-album").toggleClass("open");
        $("body").toggleClass("hide-overflow");
    });

    $(".add-album .cancel-upload").click(function() {
        $(".add-album").removeClass("open");
        $("body").removeClass("hide-overflow");
    });

    $("#album-photo-input").change(function(){
        var files = $(this)[0].files;
        $("#browse-button-album").text(files.length + " photos selected");
    });

    // Add photo
    $(".add-photo-btn").click(function() {
        $("#add-photos-album-id").val("undefined");
        $("#add-photo-input").val("");
        $("#browse-button-photos").text("Browse");
        $("#add-photo-button").show();
        $("#photos-result").hide();
        var photosLoading = $("#photos-loading");
        photosLoading.empty();
        photosLoading.hide();
        $("#photos-upload-thumbs").empty();
        $(".add-photo").toggleClass("open");
        $("body").toggleClass("hide-overflow");
    });

    $(".add-photo .cancel-upload").click(function() {
        $(".add-photo").removeClass("open");
        $("body").removeClass("hide-overflow");
    });

    $("#add-photo-input").change(function(){
        var files = $(this)[0].files;
        $("#browse-button-photos").text(files.length + " photos selected");
    });

    // Delete album
    $(".delete-album-btn").click(function() {
        $("#delete-album-id").val("undefined");
        var deleteInfo = $("#delete-info");
        deleteInfo.empty();
        deleteInfo.hide();
        $(".delete-album").toggleClass("open");
        $("body").toggleClass("hide-overflow");
    });

    $(".delete-album .cancel-upload").click(function() {
        $(".delete-album").removeClass("open");
        $("body").removeClass("hide-overflow");
    });

    // Add post
    $(".create-post-btn").click(function () {
        $("#post-title").val("");
        $("#post-body").val("");
        $("#post-photo").val("");
        $("#browse-button-article-album").text("Browse");
        $("#post-author").val("");
        $("#post-extract").val("");
        $("#post-location").val("");
        $("#post-upload-thumb-proto").hide();
        $("#add-post-button").show();
        var postInfo = $("#post-loading");
        postInfo.empty();
        postInfo.hide();
        $(".create-post").toggleClass("open");
        $("body").toggleClass("hide-overflow");
    });

    $(".create-post .cancel-upload").click(function () {
        $(".create-post").removeClass("open");
        $("body").removeClass("hide-overflow");
    });

    $("#post-photo").change(function(){
        $("#browse-button-article-album").text("1 photo selected");
    });

    // Select post
    $(".select-post-btn").click(function() {
        $("#select-post-id").val("undefined");
        var deleteInfo = $("#post-delete-info");
        deleteInfo.empty();
        deleteInfo.hide();
        $(".select-post").toggleClass("open");
        $("body").toggleClass("hide-overflow");
        $(".delete-post-btn").attr("disabled","true");
        $("#edit-post-btn").attr("disabled","true");
    });

    $(".select-post .cancel-upload").click(function() {
        $(".select-post").removeClass("open");
        $("body").removeClass("hide-overflow");
    });

    $("#delete-list-existent-posts").on('change', '#select-post-id', function() {
        // Enable delete and edit buttons if value of option is defined
        if ($("#select-post-id").val() != "undefined"){
            $(".delete-post-btn").removeAttr("disabled");
            $("#edit-post-btn").removeAttr("disabled","true");
        }
        else {
            $(".delete-post-btn").attr("disabled","true");
            $("#edit-post-btn").attr("disabled","true");
        }
    });

    // Edit post
    // Creating of modal done in injenious.js

    $(".edit-post .cancel-upload").click(function () {
        $(".edit-post").removeClass("open");
        $("body").removeClass("hide-overflow");
    });

    $(".edit-post .back-to-post").click(function () {
        $("#select-post-id").val("undefined");
        $(".edit-post").removeClass("open");
        $(".select-post").toggleClass("open");
        var deleteInfo = $("#post-delete-info");
        deleteInfo.empty();
        deleteInfo.hide();
        $(".delete-post-btn").attr("disabled","true");
        $("#edit-post-btn").attr("disabled","true");
    });

    $("#edit-post-photo").change(function(){
        $("#browse-button-edit-article-album").text("1 photo selected");
    });

    // Add cover
    $(".add-cover-btn").click(function() {
        $(".cover-thumb").css({"border-width":"0px"});
        var coverInfo = $("#cover-info");
        coverInfo.empty();
        coverInfo.hide();
        $(".add-cover-photo").toggleClass("open");
        $("body").toggleClass("hide-overflow");
    });

    $(".add-cover-photo .cancel-upload").click(function() {
        $("#browse-button-cover").text("Browse");
        $(".add-cover-photo").removeClass("open");
        $("body").removeClass("hide-overflow");
    });

    $("#add-cover-input").change(function(){
        $("#browse-button-cover").text("Photo selected");
    });

})(jQuery);