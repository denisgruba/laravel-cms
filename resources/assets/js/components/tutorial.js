$(document).ready(function(){

    var currentElement = false;

    var elementDistance = 0;

    function openOverlay(options){
        var defaults = {
            elem: document,
            title: "Welcome to tutorial",
            message: "Click Continue or stop.",
            rightButtonText: 'Continue',
            rightButtonClass: 'green',
            rightButtonAction: function () {},
            leftButtonText: 'Stop Tutorial',
            leftButtonClass: 'red',
            leftButtonAction: function(){ newOverlay( function(){ openOverlayHelp() } ) },
            onHighlightClick: function () {},
            // onSelect: function () {}
        };

        var settings = jQuery.extend(defaults, options);

        currentElement = $(document).find(settings.elem)[0];

        $(document).scrollTop(0);

        elementDistance = currentElement.getBoundingClientRect().top;

        $(document).scrollTop(currentElement.elementDistance-200);

        var tutorialOverlayElements = '<div style="display: none;" id="tutorial-wrapper" class="tutorial-wrapper"><canvas id="tutorial-canvas"></canvas><div id="tutorial-overlay"><div class="card"><div class="card-content"><span class="card-title">'+settings.title+'</span><p>'+settings.message+'</p><div class="card-action"><a id="rightButton" class="waves-effect waves-light btn right '+settings.rightButtonClass+'">'+settings.rightButtonText+'</a><a id="leftButton" class="waves-effect waves-light btn left '+settings.leftButtonClass+'">'+settings.leftButtonText+'</a></div></div></div><div id="tutorial-highlight-box"></div></div>';

        $("#app").append(tutorialOverlayElements);

        $('#rightButton').click(function(){
            settings.rightButtonAction();
        });
        $('#leftButton').click(function(){
            settings.leftButtonAction();
        });
        $('#tutorial-highlight-box').on('click', function(){
            settings.onHighlightClick();
        });

        updateCanvasSize(settings.elem);
        // $('body').css({overflow: 'hidden'});
        $('#tutorial-wrapper').fadeIn(500);
    }

    function newOverlay(callback=function(){}){
        closeOverlay(function(){
            callback();
        });
    };

    function closeOverlay(callback=function(){}) {
        $('body').css({overflow: ''});
        $('#tutorial-wrapper').fadeOut(300, function(){
            $(this).remove();
            callback();
         });
    }

    function updateCanvasSize(elem){
        var tutorialWrapper = $('#tutorial-wrapper');
        var tutorialCanvas = $('#tutorial-canvas');
        var tutorialOverlay = $('#tutorial-overlay');
        var tutorialHighlighted = elem;
        var tutorialHighlightBox = $('#tutorial-highlight-box');

        // if(!isElementInViewport(elem)){
        //     $(window).scrollTop(elem.position().top);
        // };
        // console.log($(window).scrollTop());/
        // console.log(tutorialHighlighted.position().top);
        // console.log();
        // if(navigator.userAgent.toLowerCase().indexOf('firefox') > -1){
        //     var windowOffset = $(window).scrollTop()*2;
        // } else {
        //     var windowOffset = $(window).scrollTop();
        // }

        var windowOffset = $(document).scrollTop();
        // console.log(windowOffset);
        var offsetTopPosition = elementDistance-windowOffset;
        // console.log(tutorialHighlighted.scrollTop());
        tutorialCanvas.prop('width', $(window).width());
        tutorialCanvas.prop('height', $(window).height());
        if( $("#tutorial-canvas").length ) var ctx = $("#tutorial-canvas").get(0).getContext('2d');
        ctx.fillRect(0, 0, $(window).width(), $(window).height());
        ctx.clearRect(tutorialHighlighted.position().left, offsetTopPosition, tutorialHighlighted.width(), tutorialHighlighted.height());
        tutorialHighlightBox.css({ left: tutorialHighlighted.position().left, top: offsetTopPosition, width: tutorialHighlighted.width(), height: tutorialHighlighted.height() });
    }

    function isElementInViewport (el) {

        //special bonus for those using jQuery
        if (typeof jQuery === "function" && el instanceof jQuery) {
            el = el[0];
        }

        var rect = el.getBoundingClientRect();

        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight-200 || document.documentElement.clientHeight) && /*or $(window).height() */
            rect.right <= (window.innerWidth || document.documentElement.clientWidth) /*or $(window).width() */
        );
    }

    // var overlayItem1next="Would you like to see a quick guide on how to use the Bee Hub?" ;
    // openOverlay1();


    // openOverlayHelp();

    function openOverlayCategories(){
        openOverlay({
            elem: $('#tutorial-categories'),
            title: 'Choose a category you want to work on here.',
            message: 'All the work areas are grouped by the categories. You can choose to see your news/events/documents/etc by clicking the correct tab.',
            onHighlightClick: function () { newOverlay( function(){ openOverlayContent() } ) },
            rightButtonAction: function () { newOverlay( function(){ openOverlayContent() } ) },
        });
    }

    function openOverlayActions(){
        openOverlay({
            elem: $('#tutorial-actions'),
            title: 'Choose a category you want to work on here.',
            message: 'All the work areas are grouped by the categories. You can choose to see your news/events/documents/etc by clicking the correct tab.',
            onHighlightClick: function () { newOverlay( function(){ openOverlayContent() } ) },
            rightButtonAction: function () { newOverlay( function(){ openOverlayContent() } ) },
        });
    }

    function openOverlayStaffactions(){
        openOverlay({
            elem: $('#tutorial-staffactions'),
            title: 'Choose a category you want to work on here.',
            message: 'All the work areas are grouped by the categories. You can choose to see your news/events/documents/etc by clicking the correct tab.',
            onHighlightClick: function () { newOverlay( function(){ openOverlayContent() } ) },
            rightButtonAction: function () { newOverlay( function(){ openOverlayContent() } ) },
        });
    }

    function openOverlayQuickpost(){
        openOverlay({
            elem: $('#tutorial-quickpost'),
            title: 'Choose a category you want to work on here.',
            message: 'All the work areas are grouped by the categories. You can choose to see your news/events/documents/etc by clicking the correct tab.',
            onHighlightClick: function () { newOverlay( function(){ openOverlayContent() } ) },
            rightButtonAction: function () { newOverlay( function(){ openOverlayContent() } ) },
        });
    }

    function openOverlayTitle(){
        openOverlay({
            elem: $('#tutorial-title'),
            title: 'Your post title',
            message: 'Here you set up the title of the post',
            onHighlightClick: function () { newOverlay( function(){ openOverlayContent() } ) },
            rightButtonAction: function () { newOverlay( function(){ openOverlayContent() } ) },
        });
    }

    function openOverlayContent(){
        openOverlay({
            elem: $('#tutorial-content'),
            title: 'Your post content',
            message: 'Here you add all your content\'s message',
            onHighlightClick: function () { newOverlay( function(){ openOverlayType() } ) },
            rightButtonAction: function () { newOverlay( function(){ openOverlayType() } ) },
        });
    }

    function openOverlayType(){
        openOverlay({
            elem: $('#tutorial-type'),
            title: 'Your post location',
            message: 'Here you set up the title of the post',
            onHighlightClick: function () { newOverlay( function(){ openOverlayAttachments() } ) },
            rightButtonAction: function () { newOverlay( function(){ openOverlayAttachments() } ) },
        });
    }

    function openOverlayAttachments(){
        openOverlay({
            elem: $('#tutorial-attachments'),
            title: 'Your post Attachments',
            message: 'Drag and drop files here, or click and choose the files to upload.',
            onHighlightClick: function () { newOverlay( function(){ openOverlayDrawer() } ) },
            rightButtonAction: function () { newOverlay( function(){ openOverlayDrawer() } ) },
        });
    }

    function openOverlayDrawer(){
        openOverlay({
            elem: $('#tutorial-drawer'),
            title: 'Options, Shrotcuts and Save',
            message: 'You can have an access to other options',
            onHighlightClick: function () { newOverlay( function(){ openOverlayHelp() } ) },
            rightButtonAction: function () { newOverlay( function(){ openOverlayHelp() } ) },
        });
    }

    function openOverlayHelp(){
        openOverlay({
            elem: $('#tutorial-help'),
            title: 'You can start now!',
            message: 'If you ever get stuck, you can click the this Help button for some useful information. You can also restart a tutorial there.',
            rightButtonText: '',
            rightButtonClass: 'hide',
            rightButtonAction: function () {},
            leftButtonText: 'Close',
            leftButtonClass: 'red',
            leftButtonAction: function () { closeOverlay(); currentElement = false; },
            onHighlightClick: function () { closeOverlay( function(){ $('#helpcentre').modal('open'); currentElement = false; } ) },
        });
    };




    var id;
    $(window).resize(function() {
        clearTimeout(id);
        id = setTimeout(doneResizing, 100);

        doneResizing();
    });
    $(window).scroll(function() {
        clearTimeout(id);
        id = setTimeout(doneResizing, 100);
            doneResizing();
    });
    function doneResizing(){
        if(!currentElement==false){
            updateCanvasSize(currentElement);
        }
    }

});
