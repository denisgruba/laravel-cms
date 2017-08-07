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
            if(this.tutorialPage == 'CreateNews') this.$emit('startOpenOverlayCreateNews');
            if(this.tutorialPage == 'CreateEvent') this.$emit('startOpenOverlayCreateEvent');
            if(this.tutorialPage == 'CreateDocument') this.$emit('startOpenOverlayCreateDocument');
            if(this.tutorialPage == 'CreateStaff') this.$emit('startOpenOverlayCreateStaff');
            if(this.tutorialPage == 'SortStaff') {this.$emit('startOpenOverlaySortStaff')} else { $('#tutorial-staff-sort-drag').remove() } ;
            // this.openTutorial = $vm.root.openTutorial;
        },
        methods:{

        },
        watch: {

        }
    }
</script>
