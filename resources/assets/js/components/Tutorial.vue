<script>
    export default {
        template: '#tutorial-component',
        name: 'tutorial-component',
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
            if(this.tutorialPage == 'CreateNews') this.$dispatch('startOpenOverlayCreateNews');
            if(this.tutorialPage == 'CreateEvent') this.$dispatch('startOpenOverlayCreateEvent');
            if(this.tutorialPage == 'CreateDocument') this.$dispatch('startOpenOverlayCreateDocument');
            if(this.tutorialPage == 'CreateStaff') this.$dispatch('startOpenOverlayCreateStaff');
            if(this.tutorialPage == 'SortStaff') {this.$dispatch('startOpenOverlaySortStaff')} else { $('#tutorial-staff-sort-drag').remove() } ;
            // this.openTutorial = $vm.root.openTutorial;
        },
        methods:{

        },
        watch: {

        }
    }
</script>
