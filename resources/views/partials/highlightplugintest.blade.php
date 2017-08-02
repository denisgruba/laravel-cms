var Vue = require('vue');

Vue.config.devtools=true;
Vue.use(require('vue-resource'));
Vue.use(require('vue-moment'));

Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('content');

import CategoryLatestUpdates from './components/CategoryLatestUpdates.vue';
import Categories from './components/Categories.vue';
import ResourceBrowser from './components/ResourceBrowser.vue';
import Site from './components/Site.vue';
import NavQuickCreate from './components/NavQuickCreate.vue';
import ActivityLog from './components/ActivityLog.vue';
// import SiteCreate from './components/SiteCreate.vue';

new Vue({

    el: '#app-layout',

    http: {
        root: 'http://www.cms.dev/'
    },

    components: {
        Categories, CategoryLatestUpdates, ResourceBrowser, Site, NavQuickCreate, ActivityLog
    },

    // props: [
    //     'sites',
    //     'siteId',
    //     'categories',
    //     'category'
    // ],

    props: {
        currentElement: {
            default: false
        },
        elementDistance: {
            default: 0
        },
        timeout: {
            default: 0
        }
    },

    methods: {
        openOverlay: function (options){
            console.log('initialize');
            var defaults = {
                elem: document,
                title: "Welcome to tutorial",
                message: "Click Continue or stop.",
                rightButtonText: 'Continue',
                rightButtonClass: 'green',
                rightButtonAction: function() {},
                leftButtonText: 'Stop Tutorial',
                leftButtonClass: 'red',
                leftButtonAction: function(){console.log('left button')},
                onHighlightClick: function() {},
            };
            console.log('settings');



            var settings = jQuery.extend(defaults, options);

            settings.leftButtonAction();

            this.currentElement = document.getElementById(settings.elem);

            $(document).scrollTop(0);

            this.elementDistance = this.currentElement.getBoundingClientRect().top;

            $(document).scrollTop(this.elementDistance-200);

            var tutorialOverlayElements = '<div style="display: none;" id="tutorial-wrapper" class="tutorial-wrapper"><canvas id="tutorial-canvas"></canvas><div id="tutorial-overlay"><div class="card"><div class="card-content"><span class="card-title">'+settings.title+'</span><p>'+settings.message+'</p><div class="card-action"><a id="rightButton" class="waves-effect waves-light btn right '+settings.rightButtonClass+'">'+settings.rightButtonText+'</a><a id="leftButton" class="waves-effect waves-light btn left '+settings.leftButtonClass+'" onclick="'+settings.leftButtonAction+'">'+settings.leftButtonText+'</a></div></div></div><div id="tutorial-highlight-box"></div></div>';

            $("#app").append(tutorialOverlayElements);

            // document.getElementById('rightButton').addEventListener('click', settings.rightButtonAction);

            // document.getElementById('leftButton').addEventListener('click', settings.leftButtonAction);


            // $('#leftButton').click(function(){
            //     settings.leftButtonAction();
            // });
            // $('#tutorial-highlight-box').on('click', function(){
            //     settings.onHighlightClick();
            // });

            this.updateCanvasSize(this.currentElement);
            // $('body').css({overflow: 'hidden'});
            $('#tutorial-wrapper').fadeIn(500);
        },
        updateCanvasSize: function (elem){
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
            var offsetTopPosition = this.elementDistance-windowOffset;
            // console.log(tutorialHighlighted.scrollTop());
            tutorialCanvas.prop('width', $(window).width());
            tutorialCanvas.prop('height', $(window).height());
            if( $("#tutorial-canvas").length ) var ctx = $("#tutorial-canvas").get(0).getContext('2d');
            ctx.fillRect(0, 0, $(window).width(), $(window).height());
            ctx.clearRect(tutorialHighlighted.getBoundingClientRect().left, offsetTopPosition, tutorialHighlighted.offsetWidth, tutorialHighlighted.offsetHeight);
            tutorialHighlightBox.css({ left: tutorialHighlighted.getBoundingClientRect().left, top: offsetTopPosition, width: tutorialHighlighted.offsetWidth, height: tutorialHighlighted.offsetHeight });
        },
        newOverlay: function (callback=function(){}){
            this.closeOverlay(function(){
                callback();
            });
        },
        closeOverlay: function (callback=function(){}) {
            $('body').css({overflow: ''});
            $('#tutorial-wrapper').fadeOut(300, function(){
                $(this).remove();
                callback();
             });
        },
        isElementInViewport: function (el) {

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
        },
        openOverlayCategories: function(){
            this.openOverlay({
                elem: 'tutorial-categories',
                title: 'Choose a category you want to work on here.',
                message: 'All the work areas are grouped by the categories. You can choose to see your news/events/documents/etc by clicking the correct tab.',
                // onHighlightClick: function () { newOverlay( function(){ openOverlayContent() } ) },
                // rightButtonAction: function () { newOverlay( function(){ openOverlayContent() } ) },
            });
        },
        windowChanged: function (){
            clearTimeout(this.timeout);
            this.timeout = setTimeout(function(){
                if(!this.currentElement==false){
                    this.updateCanvasSize(this.currentElement);
                }
            }, 100);
        },
        openOverlayHelp: function (){
            // this.openOverlay({
            //     elem: 'tutorial-help',
            //     title: 'You can start now!',
            //     message: 'If you ever get stuck, you can click the this Help button for some useful information. You can also restart a tutorial there.',
            //     rightButtonText: '',
            //     rightButtonClass: 'hide',
            //     rightButtonAction: function () {},
            //     leftButtonText: 'Close',
            //     leftButtonClass: 'red',
            //     leftButtonAction: function () { closeOverlay(); currentElement = undefined; },
            //     onHighlightClick: function () { closeOverlay( function(){ $('#helpcentre').modal('open'); currentElement = false; } ) },
            // });
        },
    },
    created(){
        window.addEventListener('scroll', this.windowChanged());
        window.addEventListener('resize', this.windowChanged());
    },
    destroyed(){
        window.removeEventListener('scroll', this.windowChanged());
        window.removeEventListener('resize', this.windowChanged());
    },


    ready(){










        // var overlayItem1next="Would you like to see a quick guide on how to use the Bee Hub?" ;
        // openOverlay1();


        // openOverlayTitle();



        // var openOverlayCategories = function openOverlayCategories(){
        //     console.log('run');
        //     openOverlay({
        //         elem: $('#tutorial-categories'),
        //         title: 'Choose a category you want to work on here.',
        //         message: 'All the work areas are grouped by the categories. You can choose to see your news/events/documents/etc by clicking the correct tab.',
        //         onHighlightClick: function () { newOverlay( function(){ openOverlayContent() } ) },
        //         rightButtonAction: function () { newOverlay( function(){ openOverlayContent() } ) },
        //     });
        // }

        // openOverlayCategories();

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


    },

});
