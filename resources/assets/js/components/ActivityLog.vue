<script>
    export default {
        template: '#activity-log',
        data(){
            return{
                activities: [],
                fetchingData: true,
                fetchingFailed: false,
                fetchingError: 'There was an error loading your site details. Have you tried reloading?',
            };
        },
        props: [
            'siteId',
            'category',
        ],
        created(){
            this.fetchActivity();
        },
        methods:{
            fetchActivity: function(){
                this.$http.get('/api/getActivityLog/').then(function(activities){
                    this.activities = activities.body;
                    this.fetchingData = false;
                }, function(){
                    this.fetchingFailed = true;
                });
            },
        },
        watch: {
            fetchingFailed: function(){
                if(this.fetchingFailed==true){
                    Materialize.toast("There was an error loading your site details. Have you tried reloading?", 10000, "red");
                }
            }
        }
    }
</script>
