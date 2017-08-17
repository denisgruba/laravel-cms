
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.Vuex = require('vuex');
Vue.config.devtools=true;
Vue.use(require('vue-resource'));
Vue.use(Vuex);
// Vue.use(require('vue-moment'));


// import VueMaterial from 'vue-material';
// Vue.use(VueMaterial);
import moment from "moment";
Vue.use( moment);
// import {tabs as mdcTabs} from 'material-components-web';

import CategoryLatestUpdates from './components/CategoryLatestUpdates.vue';
import Categories from './components/Categories.vue';
import ResourceBrowser from './components/ResourceBrowser.vue';
import Site from './components/Site.vue';
import NavQuickCreate from './components/NavQuickCreate.vue';
import ActivityLog from './components/ActivityLog.vue';
import Tutorial from './components/Tutorial.vue';
// import VueCharts from './vue-charts/index.js';
// import { Bar } from './vue-charts/index.js';
// import Stats from './components/Stats.vue';
// import BlocksLayout from './components/Blocks/Layout.vue';


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('example', require('./components/Example.vue'));

Vue.filter('fromNow', function (value) {
    return moment(value).fromNow();
});

// Vue.material.registerTheme('default', {
//     primary: {
//         color: 'grey',
//         hue: 800,
//         textColor: 'white' // text will be black
//     },
//     accent: 'white',
//     textColor: 'white',
//     warn: 'red',
// });
//
// Vue.material.setCurrentTheme('default');

const store = new Vuex.Store({
    state: {

    },
    mutations: {
        toggleThumbs (state) {
            state.hideThumbs = !state.hideThumbs;
        },
    },
    actions: {
        
    }
});
window.store = store;


const app = new Vue({

    el: '#app',

    http: {
        root: 'http://www.cms.dev/'
    },

    components: {
        Categories, CategoryLatestUpdates, ResourceBrowser, Site, NavQuickCreate, ActivityLog, Tutorial
    },


    props: {
        currentElement: {
            default: false
        },
        elementDistance: {
            default: 0
        },
        timeout: {
            default: 0
        },
        settings: {},
        // openOverlayHelp: null,
        tutorialID: 0,
        userTutorialStatus: false,
        openTutorial: false,
        startTutorial: {
            default: '',
        },
    },

    events: {
        startOpenOverlayCategories: function(){
            this.tutorialID=1;
            this.fetchUserTutorialStatus(function(){
                vm.openOverlayWelcome();
            });
         },
        startOpenOverlayEvents: function(){
            this.tutorialID=2;
            this.fetchUserTutorialStatus(function(){
                vm.openOverlayEvents();
            });
        },
        startOpenOverlayStaff: function(){
            this.tutorialID=3;
            this.fetchUserTutorialStatus(function(){
                vm.openOverlayStaffActions();
            });
        },
        startOpenOverlayCreateNews: function(){
            this.tutorialID=4;
            this.fetchUserTutorialStatus(function(){
                vm.openOverlayCreateNewsTitle();
            });
        },
        startOpenOverlayCreateEvent: function(){
            this.tutorialID=5;
            this.fetchUserTutorialStatus(function(){
                vm.openOverlayCreateEventTitle();
            });
        },
        startOpenOverlayCreateDocument: function(){
            this.tutorialID=6;
            this.fetchUserTutorialStatus(function(){
                vm.openOverlayCreateDocumentTitle();
            });
        },
        startOpenOverlayCreateStaff: function(){
            this.tutorialID=7;
            this.fetchUserTutorialStatus(function(){
                vm.openOverlayCreateStaffName();
            });
        },
        startOpenOverlaySortStaff: function(){
            this.tutorialID=8;
            this.fetchUserTutorialStatus(function(){
                vm.openOverlaySortStaffIntro();
            });
        },

    },

    methods: {
        handleScroll () {
            // this.scrolled = window.scrollY > 0;
            if(this.currentElement!=='' && this.currentElement !== false){
                this.updateCanvasSize(this.currentElement);
            }
        },
        handleResize () {
            // this.scrolled = window.scrollY > 0;
            if(this.currentElement!=='' && this.currentElement !== false){
                this.updateCanvasSize(this.currentElement);
            }
        },
        fetchUserTutorialStatus: function(callback){
            this.$http.get('/api/getUserTutorialStatus').then(function(status){
                this.userTutorialStatus = status.body;
                this.openTutorial = false;
                if(this.userTutorialStatus!=='false'){
                    if(this.userTutorialStatus!=='null'){
                        if(Array.isArray(this.userTutorialStatus) && this.userTutorialStatus.length!=0){
                            if(this.userTutorialStatus.indexOf(this.tutorialID)== -1) {
                                this.openTutorial = true;
                            }
                        } else {
                            this.userTutorialStatus=[];
                            this.openTutorial = true;
                        }
                    } else {
                        this.userTutorialStatus=[];
                        this.openTutorial = true;
                    }
                } else {
                    this.userTutorialStatus='false';
                }
                if(this.openTutorial) callback();
            }, function(){
                this.userTutorialStatus = 'false';
                this.openTutorial = false;
            });
        },
        updateUserTutorialStatus: function(){
            this.$http.get('/api/updateUserTutorialStatus/'+this.tutorialID).then(function(status){

            }, function(){

            });
        },
        stopUserTutorial: function(){
            this.$http.get('/api/stopUserTutorial').then(function(status){

            }, function(){

            });
        },
        resetUserTutorial: function(){
            this.$http.get('/api/resetUserTutorial').then(function(status){

            }, function(){

            });
        },
        openOverlay: function (options){
            var defaults = {
                elem: '',
                title: "Welcome to tutorial",
                message: "Click Continue or stop.",
                rightButtonText: 'Continue',
                rightButtonClass: 'green',
                rightButtonAction: function() {},
                middleButtonText: 'Back',
                middleButtonClass: 'hide',
                middleButtonAction: function() {},
                leftButtonText: 'Stop Tour',
                leftButtonClass: 'red',
                leftButtonAction: function(){ vm.openOverlayFinished() },
                highlightButtonAction: function() {},
            };
            var settings = jQuery.extend(defaults, options);


            this.currentElement = document.getElementById(settings.elem);
            if(this.currentElement!=='' && this.currentElement !== false){

                this.settings = settings;

                $(document).scrollTop(0);

                this.elementDistance = this.currentElement.getBoundingClientRect().top;

                $(document).scrollTop(this.elementDistance-200);

                var tutorialOverlayElements = '';

                this.updateCanvasSize(this.currentElement);
                $('#tutorial-wrapper').fadeIn(500);
            }
        },
        updateCanvasSize: function (elem){
            var tutorialWrapper = document.getElementById('tutorial-wrapper');
            var tutorialCanvas = document.getElementById('tutorial-canvas');
            var tutorialOverlay = document.getElementById('tutorial-overlay');
            var tutorialHighlighted = elem;
            var tutorialHighlightBox = document.getElementById('tutorial-highlight-box');
            if(tutorialCanvas!==null){
                var windowOffset = $(document).scrollTop();
                var offsetTopPosition = this.elementDistance-windowOffset;
                tutorialCanvas.setAttribute("width", $(window).width());
                tutorialCanvas.setAttribute("height", $(window).height());

                var ctx = tutorialCanvas.getContext('2d');

                ctx.fillRect(0, 0, $(window).width(), $(window).height());

                ctx.clearRect(tutorialHighlighted.getBoundingClientRect().left, offsetTopPosition, tutorialHighlighted.offsetWidth, tutorialHighlighted.offsetHeight);

                tutorialHighlightBox.setAttribute("style", "left:"+tutorialHighlighted.getBoundingClientRect().left+"px;top:"+offsetTopPosition+"px;width:"+ tutorialHighlighted.offsetWidth+"px;height:"+ tutorialHighlighted.offsetHeight+"px;" );
            }
        },
        newOverlay: function (callback=function(){}){
            this.closeOverlay(function(){
                callback();
            });
        },
        closeOverlay: function (callback=function(){}) {
            $('body').css({overflow: ''});
            $('#tutorial-wrapper').fadeOut(500, function(){
                // $(this).remove();
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
        windowChanged: function (){
            clearTimeout(this.timeout)
            this.timeout = setTimeout(function(){
                if(!this.currentElement==false){
                    this.updateCanvasSize(this.currentElement);
                }
            }, 100);
        },
        openOverlayWelcome: function (){
            this.openOverlay({
                elem: 'tutorial-info-card',
                title: 'Welcome to the Bee Hub!',
                message: 'It looks like you haven\'t taken the Bee Hub tour before! Would you like to learn how to use some of the important Bee Hub functions?',
                rightButtonText: 'Take the tour',
                rightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlayCategories() } ) },
                highlightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlayCategories() } ) },
                leftButtonText: 'Stop the tour',
                leftButtonClass: 'red',
            });
        },
        openOverlayFinished: function (){
            this.openOverlay({
                elem: 'tutorial-help',
                title: 'You can start now!',
                message: 'If you ever get stuck, you can click the this Help button for some useful information. You can also restart a tour there.',
                rightButtonText: '',
                rightButtonClass: 'hide',
                rightButtonAction: function () {},
                leftButtonText: 'Close',
                leftButtonClass: 'red',
                leftButtonAction: function () { vm.stopUserTutorial(); vm.closeOverlay(); vm.currentElement = false; },
                highlightButtonAction: function () { vm.stopUserTutorial(); vm.closeOverlay( function(){ $('#helpcentre').modal('open'); vm.currentElement = false; } ) },
            });
        },
        openOverlayHelp: function (){
            this.openOverlay({
                elem: 'tutorial-help',
                title: 'Bee Hub Tour',
                message: 'That is all for now. More hints will appear, if you go to another area you haven\'t visited yet.  Plus you can always click the Help button for more information.',
                rightButtonText: '',
                rightButtonClass: 'hide',
                rightButtonAction: function () {},
                leftButtonText: 'Continue',
                leftButtonClass: 'green',
                leftButtonAction: function () { vm.closeOverlay(); vm.currentElement = false; vm.updateUserTutorialStatus(); },
                highlightButtonAction: function () { vm.updateUserTutorialStatus(); vm.closeOverlay( function(){ $('#helpcentre').modal('open'); vm.currentElement = false; } ) },
            });
        },
        openOverlayCategories: function (){
            this.openOverlay({
                elem: 'tutorial-categories',
                title: 'Choose a category you want to work on here',
                message: 'Website updates are categorised by these tabs. You can choose to view and update your news/events/documents/etc by clicking the appropriate tab.',
                highlightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlayActions() } ) },
                rightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlayActions() } ) },
            });
        },
        openOverlayActions: function (){
            this.openOverlay({
                elem: 'tutorial-actions',
                title: 'Actions Panel (specific to the tab you have selected)',
                message: 'To see all the items that have already been added, click "List...". To create a new item, click "Create...". You can view items sorted by their type with "List ... by types".',
                rightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlayRecent() } ) },
                highlightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlayRecent() } ) },
            });
        },
        openOverlayRecent: function (){
            this.openOverlay({
                elem: 'tutorial-recent',
                title: 'Latest changes',
                message: 'A list of the most recent changes made to your website. You may click on an update to view or edit it.',
                rightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlayQuickpost() } ) },
                highlightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlayQuickpost() } ) },
            });
        },
        openOverlayQuickpost: function (){
            this.openOverlay({
                elem: 'tutorial-quickpost',
                title: 'Quick post area',
                message: 'This allows you to add to the selected category quickly and without clicking on the create action button. Please not that not all functions are accessible via the quick post form.',
                rightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlayHelp() } ) },
                highlightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlayHelp() } ) },
            });
        },
        openOverlayEvents: function (){
            this.openOverlay({
                elem: 'tutorial-calendar',
                title: 'Events calendar',
                message: 'All the events are displayed here.',
                highlightButtonAction: function () { vm.closeOverlay(); vm.currentElement = false; vm.updateUserTutorialStatus();  },
                rightButtonAction: function () { vm.closeOverlay(); vm.currentElement = false;  vm.updateUserTutorialStatus(); },
            });
        },
        openOverlayStaffActions: function (){
            this.openOverlay({
                elem: 'tutorial-staff-actions',
                title: 'Staff actions panel',
                message: 'You can view all the staff listed on your website. You can edit/remove them, and change the order of their sorting by clicking "Sort staff". To create a new staff member, click "Add Staff Member". By clicking "Manage Groups" you can also create, rename or remove groups, this is how the staff are filtered on the website.',
                rightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlayStaffGroups() } ) },
                highlightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlayStaffGroups() } ) },
            });
        },
        openOverlayStaffGroups: function (){
            this.openOverlay({
                elem: 'tutorial-staff-groups',
                title: 'Staff list overview',
                message: 'You can quickly view the number of the staff members for each groups.',
                highlightButtonAction: function () {  vm.closeOverlay(); vm.currentElement = false; vm.updateUserTutorialStatus(); },
                rightButtonAction: function () { vm.closeOverlay(); vm.currentElement = false; vm.updateUserTutorialStatus(); },
            });
        },
        openOverlayCreateNewsTitle: function (){
            this.openOverlay({
                elem: 'tutorial-create-title',
                title: 'Add a title to your post',
                message: 'Here you set up the title of your new post. This is "required" which means you cannot submit this form without it being filled out',
                highlightButtonAction: function () {  vm.newOverlay( function(){ vm.openOverlayCreateNewsContent() } ) },
                rightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlayCreateNewsContent() } ) },
            });
        },
        openOverlayCreateNewsContent: function (){
            this.openOverlay({
                elem: 'tutorial-create-content',
                title: 'Add a content to your post',
                message: 'Here you set up the content of your new post.',
                highlightButtonAction: function () {  vm.newOverlay( function(){ vm.openOverlayCreateNewsType() } ) },
                rightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlayCreateNewsType() } ) },
            });
        },
        openOverlayCreateNewsType: function (){
            this.openOverlay({
                elem: 'tutorial-create-type',
                title: 'Choose you post\'s type',
                message: 'You can use the dropdown to select where to display your new post.',
                highlightButtonAction: function () {  vm.newOverlay( function(){ vm.openOverlayCreateNewsAttachments() } ) },
                rightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlayCreateNewsAttachments() } ) },
            });
        },
        openOverlayCreateNewsAttachments: function (){
            this.openOverlay({
                elem: 'tutorial-create-attachments',
                title: 'Here you add attachments',
                message: 'Here you add any optional attachments. If adding images, it is recommended to resize all the images before uploading them. The images should be less than 1MB each and preferably be no wider and no higher than 2000px. Maximum filesize of a single file should be 10MB.',
                highlightButtonAction: function () {  vm.newOverlay( function(){ vm.openOverlayCreateNewsDrawer() } ) },
                rightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlayCreateNewsDrawer() } ) },
            });
        },
        openOverlayCreateNewsDrawer: function (){
            this.openOverlay({
                elem: 'tutorial-drawer',
                title: 'Submit, extra settings and shortcuts',
                message: 'Used to submit your post and access additional settings. You can enable publish settings to set the published and expires dates (these are not required, if not set the post displays imminently and infinitely respectively), and you can find some handy shourtcuts to quickly get to other areas of the Bee Hub.',
                highlightButtonAction: function () {  vm.closeOverlay(); vm.currentElement = false; vm.updateUserTutorialStatus(); },
                rightButtonAction: function () { vm.closeOverlay(); vm.currentElement = false; vm.updateUserTutorialStatus(); },
            });
        },
        openOverlayCreateEventTitle: function (){
            this.openOverlay({
                elem: 'tutorial-create-title',
                title: 'Add a title to your post',
                message: 'Here you set up the title of your new post. This is "required" which means you cannot submit this form without it being filled out.',
                highlightButtonAction: function () {  vm.newOverlay( function(){ vm.openOverlayCreateEventContent() } ) },
                rightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlayCreateEventContent() } ) },
            });
        },
        openOverlayCreateEventContent: function (){
            this.openOverlay({
                elem: 'tutorial-create-content',
                title: 'Add a content to your post',
                message: 'Here you set up the content of your new post.',
                highlightButtonAction: function () {  vm.newOverlay( function(){ vm.openOverlayCreateEventVenue() } ) },
                rightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlayCreateEventVenue() } ) },
            });
        },
        openOverlayCreateEventVenue: function (){
            this.openOverlay({
                elem: 'tutorial-create-venue',
                title: 'Event venue',
                message: 'If you\'d like to inform the audience about the location of the event, type it here.',
                highlightButtonAction: function () {  vm.newOverlay( function(){ vm.openOverlayCreateEventStartDate() } ) },
                rightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlayCreateEventStartDate() } ) },
            });
        },
        openOverlayCreateEventStartDate: function (){
            this.openOverlay({
                elem: 'tutorial-create-start-date',
                title: 'Date that the event starts',
                message: 'Upon clicking on this field you may select a date from the now opened calendar. Do this once again for the end date to the right.',
                highlightButtonAction: function () {  vm.newOverlay( function(){ vm.openOverlayCreateEventStartTime() } ) },
                rightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlayCreateEventStartTime() } ) },
            });
        },
        openOverlayCreateEventStartTime: function (){
            this.openOverlay({
                elem: 'tutorial-create-start-time',
                title: 'All day event or custom time?',
                message: 'This is used to add and display custom times to your events. To specify toggle the switch and select a time (much like adding a date). If you don\'t know the start time of the event, do not toggle and no time will be displayed. Replicate for the end time',
                highlightButtonAction: function () {  vm.newOverlay( function(){ vm.openOverlayCreateEventType() } ) },
                rightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlayCreateEventType() } ) },
            });
        },
      //   openOverlayCreateEventEndDate: function (){
      //       this.openOverlay({
      //           elem: 'tutorial-create-end-date',
      //           title: 'Ending date of the event',
      //           message: 'Choose the end date of the event here.',
      //           highlightButtonAction: function () {  vm.newOverlay( function(){ vm.openOverlayCreateEventEndTime() } ) },
      //           rightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlayCreateEventEndTime() } ) },
      //       });
      //   },
      //   openOverlayCreateEventEndTime: function (){
      //       this.openOverlay({
      //           elem: 'tutorial-create-end-time',
      //           title: 'All day event or custom end time?',
      //           message: 'If you don\'t know the ending time of the event, leave this box unchecked. It will ignore the ending time when displaying the event. If you want to specify the time click the box and select your own time.',
      //           highlightButtonAction: function () {  vm.newOverlay( function(){ vm.openOverlayCreateEventType() } ) },
      //           rightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlayCreateEventType() } ) },
      //       });
      //   },
        openOverlayCreateEventType: function (){
            this.openOverlay({
                elem: 'tutorial-create-type',
                title: 'Choose you post\'s type',
                message: 'You can use the dropdown to select where to display your new post.',
                highlightButtonAction: function () {  vm.newOverlay( function(){ vm.openOverlayCreateEventAttachments() } ) },
                rightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlayCreateEventAttachments() } ) },
            });
        },
        openOverlayCreateEventAttachments: function (){
            this.openOverlay({
                elem: 'tutorial-create-attachments',
                title: 'Here you add attachments',
                message: 'Here you add any optional attachments. If adding images, it is recommended to resize all the images before uploading them. The images should be less than 1MB each and preferably be no wider and no higher than 2000px. Maximum filesize of a single file should be 10MB.',
                highlightButtonAction: function () {  vm.newOverlay( function(){ vm.openOverlayCreateEventDrawer() } ) },
                rightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlayCreateEventDrawer() } ) },
            });
        },
        openOverlayCreateEventDrawer: function (){
            this.openOverlay({
                elem: 'tutorial-drawer',
                title: 'Submit, extra settings and shortcuts',
                message: 'Used to submit your post and access additional settings. You can enable publish settings to set the published and expires dates (these are not required, if not set the post displays imminently and infinitely respectively), and you can find some handy shourtcuts to quickly get to other areas of the Bee Hub.',
                highlightButtonAction: function () {  vm.closeOverlay(); vm.currentElement = false; vm.updateUserTutorialStatus(); },
                rightButtonAction: function () { vm.closeOverlay(); vm.currentElement = false; vm.updateUserTutorialStatus(); },
            });
        },
        openOverlayCreateDocumentTitle: function (){
            this.openOverlay({
                elem: 'tutorial-create-title',
                title: 'Add a title to your post',
                message: 'Here you set up the title of your new post.',
                highlightButtonAction: function () {  vm.newOverlay( function(){ vm.openOverlayCreateDocumentType() } ) },
                rightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlayCreateDocumentType() } ) },
            });
        },
        openOverlayCreateDocumentType: function (){
            this.openOverlay({
                elem: 'tutorial-create-type',
                title: 'Choose you post\'s type',
                message: 'You can use the dropdown to select where to display your new post.',
                highlightButtonAction: function () {  vm.newOverlay( function(){ vm.openOverlayCreateDocumentAttachments() } ) },
                rightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlayCreateDocumentAttachments() } ) },
            });
        },
        openOverlayCreateDocumentAttachments: function (){
            this.openOverlay({
                elem: 'tutorial-create-attachments',
                title: 'Here you attach your document',
                message: 'Drag and drop the .PDF file here. Maximum filesize is 10MB.',
                highlightButtonAction: function () {  vm.newOverlay( function(){ vm.openOverlayCreateDocumentDrawer() } ) },
                rightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlayCreateDocumentDrawer() } ) },
            });
        },
        openOverlayCreateDocumentDrawer: function (){
            this.openOverlay({
                elem: 'tutorial-drawer',
                title: 'Submit, extra settings and shortcuts',
                message: 'Used to submit your post and access additional settings. You can enable publish settings to set the published and expires dates (these are not required, if not set the post displays imminently and infinitely respectively), and you can find some handy shourtcuts to quickly get to other areas of the Bee Hub.',
                highlightButtonAction: function () {  vm.closeOverlay(); vm.currentElement = false; vm.updateUserTutorialStatus(); },
                rightButtonAction: function () { vm.closeOverlay(); vm.currentElement = false; vm.updateUserTutorialStatus(); },
            });
        },
        openOverlayCreateStaffName: function (){
            this.openOverlay({
                elem: 'tutorial-staff-create-name',
                title: 'Add your staff member\'s name',
                message: 'Type in your staff member\'s  details with any name format you prefer.',
                highlightButtonAction: function () {  vm.newOverlay( function(){ vm.openOverlayCreateStaffJob() } ) },
                rightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlayCreateStaffJob() } ) },
            });
        },
        openOverlayCreateStaffJob: function (){
            this.openOverlay({
                elem: 'tutorial-staff-create-job',
                title: 'Your staff member job postition.',
                message: 'Specify the position if needed.',
                highlightButtonAction: function () {  vm.newOverlay( function(){ vm.openOverlayCreateStaffEmail() } ) },
                rightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlayCreateStaffEmail() } ) },
            });
        },
        openOverlayCreateStaffEmail: function (){
            this.openOverlay({
                elem: 'tutorial-staff-create-email',
                title: 'Your staff member email address',
                message: 'If you\'re allowing email addresses to be set up, specify one here.',
                highlightButtonAction: function () {  vm.newOverlay( function(){ vm.openOverlayCreateStaffGroup() } ) },
                rightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlayCreateStaffGroup() } ) },
            });
        },
        openOverlayCreateStaffGroup: function (){
            this.openOverlay({
                elem: 'tutorial-staff-create-group',
                title: 'Select the group',
                message: 'Assign your staff member to an appropriate group e.g "Support Staff". This is done by selecting a group from the dropdown. They will be added to the end of the selected group, but you can customise the order in which staff are displayed on the website by sorting in the staff sort page.',
                highlightButtonAction: function () {  vm.newOverlay( function(){ vm.openOverlayCreateStaffPhoto() } ) },
                rightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlayCreateStaffPhoto() } ) },
            });
        },
        openOverlayCreateStaffPhoto: function (){
            this.openOverlay({
                elem: 'tutorial-staff-create-photo',
                title: 'Staff member photo',
                message: 'You can add a photo if needed.',
                highlightButtonAction: function () {  vm.newOverlay( function(){ vm.openOverlayCreateStaffDrawer() } ) },
                rightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlayCreateStaffDrawer() } ) },
            });
        },
        openOverlayCreateStaffDrawer: function (){
            this.openOverlay({
                elem: 'tutorial-drawer',
                title: 'Submit and shortcuts',
                message: 'When you\'re ready you can click Submit. You can find some handy shourtcuts to quickly get to Staff Sort and other areas of the Bee Hub.',
                highlightButtonAction: function () {  vm.closeOverlay(); vm.currentElement = false; vm.updateUserTutorialStatus(); },
                rightButtonAction: function () { vm.closeOverlay(); vm.currentElement = false; vm.updateUserTutorialStatus(); },
            });
        },
        // openOverlaySortStaffDrag: function (){
        //     this.openOverlay({
        //         elem: 'staff-sort-drag',
        //         title: 'Staff sorting list',
        //         message: 'Used to define the order in which staff are displayed on the website. The staff sorting list is reorganised by dragging the current staff into different positions. Staff can be reordered within their current group or even moved from one group to another. If you would like a staff member to be displayed in more than one group, perhaps they are a teacher and additionally part of a leadership team, you may copy that staff memeber using the blue icon to the right of their name. Once copied it will go to the bottom of the current group where you may move it to the additional group. Also using the additional icons on the right hand side of the list you can edit and remove staff memebers. Along with the organisation of staff you can also reorder the groups they are contained in. Do this by clicking and holding the title of the group and moving it to the required position.',
        //         highlightButtonAction: function () {  vm.newOverlay( function(){ vm.openOverlaySortStaffDrawer() } ) },
        //         rightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlaySortStaffDrawer() } ) },
        //     });
        // },
        openOverlaySortStaffIntro: function (){
            this.openOverlay({
                elem: 'tutorial-staff-sort-drag',
                title: 'Staff sorting list',
                message: 'Used to define the order in which staff are displayed on the website. The staff sorting list is reorganised by dragging the current staff into different positions. Staff can be reordered within their current group or even moved from one group to another.',
                highlightButtonAction: function () {  vm.newOverlay( function(){ vm.openOverlaySortStaffMember() } ) },
                rightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlaySortStaffMember() } ) },
                leftButtonAction: function() { vm.openOverlayFinished(); $('#tutorial-staff-sort-drag').remove();  },
            });
        },
        openOverlaySortStaffMember: function (){
            this.openOverlay({
                elem: 'tutorial-staff-sort-member',
                title: 'Staff member details',
                message: 'If you would like a staff member to be displayed in more than one group, perhaps they are a teacher and additionally part of a leadership team, you may copy that staff memeber using the blue icon to the right of their name. Once copied it will go to the bottom of the current group where you may move it to the additional group. Also using the additional icons on the right hand side of the list you can edit and remove staff memebers.',
                highlightButtonAction: function () {  vm.newOverlay( function(){ vm.openOverlaySortStaffGroup() } ) },
                rightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlaySortStaffGroup() } ) },
                leftButtonAction: function() { vm.openOverlayFinished(); $('#tutorial-staff-sort-drag').remove();  },
            });
        },
        openOverlaySortStaffGroup: function (){
            this.openOverlay({
                elem: 'tutorial-staff-sort-group',
                title: 'Staff group',
                message: 'Along with the organisation of staff you can also reorder the groups they are contained in. Do this by clicking and holding the title of the group and moving it to the required position.',
                highlightButtonAction: function () {  vm.newOverlay( function(){ vm.openOverlaySortStaffDrawer() } ) },
                rightButtonAction: function () { vm.newOverlay( function(){ vm.openOverlaySortStaffDrawer() } ) },
                leftButtonAction: function() { vm.openOverlayFinished(); $('#tutorial-staff-sort-drag').remove();  },
            });
        },
        openOverlaySortStaffDrawer: function (){
            this.openOverlay({
                elem: 'staff-sort-drawer',
                title: 'Submit and shortcuts',
                message: 'Once you have finished reordering the staff list you must commit those changes by clicking on the submit button on this panel.',
                highlightButtonAction: function () {  vm.closeOverlay(); vm.currentElement = false; vm.updateUserTutorialStatus(); $('#tutorial-staff-sort-drag').remove(); },
                rightButtonAction: function () { vm.closeOverlay(); vm.currentElement = false; vm.updateUserTutorialStatus(); $('#tutorial-staff-sort-drag').remove(); },
                leftButtonAction: function() { vm.openOverlayFinished(); $('#tutorial-staff-sort-drag').remove();  },
            });
        },

    },

    watch: {

    },

    init: function(){

        // $('template').replaceWith(function(){
		// 	return $("<script />").append($(this).contents()).attr("type", "x/templates").attr("id", 'dashboard-site');
		// });
		// $('main').replaceWith(function(){
		// 	return $("<div />").append($(this).contents()).addClass("main");
		// });
    },

    created: function(){
        this.fetchUserTutorialStatus();
        this.$on('startOpenOverlayCreateNews', this.startOpenOverlayCreateNews);
        this.$on('startOpenOverlayCreateEvent', this.startOpenOverlayCreateEvent);
        this.$on('startOpenOverlayCreateDocument', this.startOpenOverlayCreateDocument);
        this.$on('startOpenOverlayCreateStaff', this.startOpenOverlayCreateStaff);
        this.$on('startOpenOverlaySortStaff', this.startOpenOverlaySortStaff);
        window.addEventListener('scroll', this.handleScroll);
        window.addEventListener('resize', this.handleResize);
        $('#jswarning').remove();
    },


});
