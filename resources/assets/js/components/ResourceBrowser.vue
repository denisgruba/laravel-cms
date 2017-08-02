<script>
    export default {
        template: '#resource-browser',
        data(){
            return{
                resourceFiles: [],
                fetchingData: true,
                fetchingFailed: false,
                fetchingError: 'There was an error loading your site details. Have you tried reloading?',
            };
        },
        props: [
            'siteId',
            'categoryId',
            'postId',
        ],
        methods:{
            fetchResourceFiles: function(siteId, postId){
                this.$http.get('/api/getResourceFiles/'+ this.siteId+'/'+this.postId).then(function(resourceFiles){
                    this.resourceFiles = resourceFiles.body;
                    this.fetchingData = false;
                }, function(){
                    this.fetchingFailed = true;
                });
            }
        },
    }
</script>
