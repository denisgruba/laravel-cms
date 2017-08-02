<script>
    export default {
        template: '#nav-quick-create',
        data(){
            return{
                categories: [],
                site: [],
            };
        },
        props: [
            'siteId',
            'category',
        ],
        created(){
            this.fetchSite();
        },
        methods:{
            fetchSite: function(siteId){
                this.$http.get('/api/getSite/'+ this.siteId).then(function(site){
                    this.site = site.body;
                }, function(){
                });
                this.fetchCategories();
            },
            fetchCategories: function(){
                this.$http.get('/api/getSiteCategories/'+this.siteId).then(function(categories){
                    this.categories = categories.body;
                }, function(){
                });
            },
        },
    }
</script>
