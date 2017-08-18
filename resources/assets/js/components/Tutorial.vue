<template>
    <div></div>
</template>
<script>
    export default {
        data(){
            return{
                // categories: [],
                // openTutorial: false,
            };
        },
        props: [
            'tutorialPage',
            'siteId',
            'category',
            'openTutorial'
        ],
        created(){
            if(this.tutorialPage == 'CreateNews') store.dispatch('startOpenOverlayCreateNews');
            if(this.tutorialPage == 'CreateEvent') store.dispatch('startOpenOverlayCreateEvent');
            if(this.tutorialPage == 'CreateDocument') store.dispatch('startOpenOverlayCreateDocument');
            if(this.tutorialPage == 'CreateStaff') store.dispatch('startOpenOverlayCreateStaff');
            if(this.tutorialPage == 'SortStaff') {store.dispatch('startOpenOverlaySortStaff')} else { $('#tutorial-staff-sort-drag').remove() } ;
            // this.openTutorial = $vm.root.openTutorial;
        },
        methods:{

        },
        watch: {

        }
    }
</script>
