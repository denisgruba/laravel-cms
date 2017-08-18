<script>
export default {
    template: '#dashboard-categories',
    name: 'dashboard-categories',
    data(){
        return{
            categories: [],
            i: 0,
            site: [],
            url: '',
            title: '',
            categoryLatestUpdates: [],
            categoryTypes: [],
            selectedCategory: 0,
            groups: [],
            firstLoadCategory: true,
            fetchingData: true,
            fetchingFailed: false,
            fetchingError: 'There was an error loading your site details. Have you tried reloading?',
        };
    },
    props: [
        'siteId',
        'category',
        // 'openOverlayCategories',
    ],
    created(){
        this.fetchSite();
    },
    methods:{
        fetchSite: function(siteId){
            this.$http.get('/api/getSite/'+ this.siteId).then(function(site){
                this.site = site.body;
                this.fetchingData = false;
            }, function(){
                this.fetchingFailed = true;
            });
            this.fetchCategories();
        },
        fetchCategories: function(){
            this.$http.get('/api/getSiteCategories/'+this.siteId).then(function(categories){
                this.categories = categories.body;
                this.fetchingData = false;
                if(window.location.hash.substr(4)!==''){
                    // $('.tab').find('a[href="#' + window.location.hash.substr(1) + '"]').delay(1000).trigger('click');
                    // console.log('a[href="#' + window.location.hash.substr(1) + '"]');
                    // $('ul.tabs').tabs();
                    // $('ul.tabs').delay(2000).tabs('select_tab', "'"+window.location.hash.substr(1)+"'");
                    this.selectedCategory = window.location.hash.substr(4);
                } else {
                    this.selectedCategory = 0;
                };
                // $('ul.tabs').tabs();
            }, function(){
                this.fetchingFailed = true;
            });
        },
        fetchCategoryLatestUpdates: function(){
            if(this.selectedCategory==2) this.url='/api/getCategoryLatestUpdates/'+this.siteId+'/'+this.selectedCategory+'/9999';
            else if(this.selectedCategory==9) this.url='/api/getVacancies/'+this.siteId;
            else this.url='/api/getCategoryLatestUpdates/'+this.siteId+'/'+this.selectedCategory;

            this.$http.get(this.url).then(function(categoryLatestUpdates){
                this.categoryLatestUpdates = categoryLatestUpdates.body;
                this.fetchingData = false;
            }, function(){
                this.fetchingFailed = true;
            });
        },
        fetchCategoryTypes: function(){
            this.$http.get('/api/getCategoryTypes/'+this.siteId+'/'+this.selectedCategory).then(function(categoryTypes){
                this.categoryTypes = categoryTypes.body;
            }, function(){

            });
        },
        fetchGroupsWithStaff: function(){
            this.$http.get('/api/getGroupsWithStaff/'+this.siteId).then(function(groups){
                this.groups = groups.body;
                this.fetchingData = false;
            }, function(){
                this.fetchingFailed = true;
            });
        },
        changeGroup: function(newcategory){
            $('.editorAir').materialnote('destroy');
            this.selectedCategory = newcategory;
            if (newcategory==0){}
            else if(newcategory !== 6){
                this.fetchCategoryLatestUpdates();
                this.fetchCategoryTypes();
            } else {
                this.fetchGroupsWithStaff();
            }
            this.firstLoadCategory=false;
        },
    },
    watch: {
        selectedCategory: function(){
            if(this.firstLoadCategory){
                $(document).ready(function(){
                    $('ul.tabs').tabs({
                        'select_tab':'tab0',
                        onShow: function(){
                            console.log(this);
                        }
                    });

                });
                // // $('ul.tabs').tabs({'swipeable': false});
                // if(window.location.hash.substr(4)!==''){
                //     $(document).ready(function(){
                //         $('ul.tabs').tabs('select_tab', window.location.hash.substr(4));
                //         $('.tabs').find('a[href="#'+window.location.hash.substr(4)+'"]').trigger('click');
                //         $('.tabs').find('active').removeClass('active');
                //         $('.tabs').find('a[href="#'+window.location.hash.substr(4)+'"]').addClass('active');
                //
                //     });
                //     // this.changeGroup(window.location.hash.substr(4));
                //     // $('.tab').find('a[href="#' + window.location.hash.substr(1) + '"]').trigger('click');
                //     // $('ul.tabs').tabs('select_tab', window.location.hash.substr(1));
                // } else {
                //     $(document).ready(function(){
                //         $('ul.tabs').tabs('select_tab', 'tab1');
                //         console.log($('.tab').find('a[href="#tab1"]'));
                //         $('ul.tabs').find('a[href="#tab1"]').trigger('click');
                //         $('ul.tabs').find('active').removeClass('active');
                //         $('ul.tabs').find('a[href="#tab1"]').addClass('active');
                //     });
                //     // $('.tab').find('a[href="#tab1"]').trigger('click');
                //     // $('ul.tabs').tabs('select_tab', 'tab1');
                // };
                // // $('.tab').find('a[href="#' + window.location.hash.substr(1) + '"]').trigger('click');
                // // $('ul.tabs').tabs('select_tab', window.location.hash.substr(1));
                // // this.changeGroup(window.location.hash.substr(4));
                // // $('ul.tabs').children().removeAttr('style');
                // // $(document).ready(function(){
                // //     $('ul.tabs').tabs('select_tab', window.location.hash.substr(4));
                // //     $('.tab').find('a[href="#'+window.location.hash.substr(4)+'"]').trigger('click');
                // //     $('.tab').find('active').removeClass('active');
                // //     $('.tab').find('a[href="#'+window.location.hash.substr(4)+'"]').addClass('active');
                // //
                // // });
                //
                // // $('.tab-link-tab1').trigger('click');
                // // console.log($('.tab').find('a[href="#' + 'tab1' + '"]'));
                // this.firstLoadCategory=false;
            };
            if(this.userTutorialStatus!=='false'){

                if(this.selectedCategory==2){
                    store.dispatch('startOpenOverlayEvents');
                } else if(this.selectedCategory==6){
                    store.dispatch('startOpenOverlayStaff');
                } else{
                    store.dispatch('startOpenOverlayCategories');
                }
            }
        },
        categoryTypes: function(){
            // $('#material-editor'+this.selectedCategory).materialnote('destroy');
            Materialize.updateTextFields();
            $('select').material_select();
            $('#calendar').fullCalendar({
                editable: true,
                customButtons: {
                    fullscreentoggle: {
                        text: 'Full Screen',
                        click: function() {
                            $('#calendar').addClass('modal');
                            $('#calendar').modal('open');
                        }
                    }
                },
                'header': {  left: 'prev,next', center: 'title', right: 'today fullscreentoggle'},
                'height': 'auto',
            });
            $('#material-editor'+this.selectedCategory).materialnote({
                // airMode: true,
                height: 100,
                minHeight: 50,
                maximumImageFileSize: 1000,
                disableDragAndDrop: true,
                toolbar: [
                    ['font', ['bold', 'italic', 'clear']],
                    ['list', ['ul', 'ol']],
                    ['para', ['leftButton', 'centerButton', 'rightButton']],
                ]
            });
            $(".note-editor")
            .find("button")
            .attr("type", "button");
            for(this.i=0; this.i < this.categoryLatestUpdates.length; this.i++){

            }

        },
        categoryLatestUpdates: function(){
            if(this.selectedCategory==2){
                for(this.i=0; this.i < this.categoryLatestUpdates.length; this.i++){
                    $('#calendar').fullCalendar( 'renderEvent', {
                        id: this.categoryLatestUpdates[this.i].id,
                        title: this.categoryLatestUpdates[this.i].title,
                        start: this.categoryLatestUpdates[this.i].start,
                        end: this.categoryLatestUpdates[this.i].end,
                    }, true);
                };
            };

        },
        fetchingFailed: function(){
            if(this.fetchingFailed==true){
                Materialize.toast("There was an error loading your site details. Have you tried reloading?", 10000, "red");
            }
        }
    }
}
</script>
