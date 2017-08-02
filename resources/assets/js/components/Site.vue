<script>
    export default {
      template: '#dashboard-site',
      name: 'dashboard-site',
      data(){
        return{
            sites: [],
            fetchingData: true,
            fetchingFailed: false,
            fetchingError: 'There was an error loading your sites list. Have you tried reloading?',
        };
      },
      created(){
        this.fetchSites();
      },
      methods: {
        fetchSites: function(){
          this.$http.get('/api/getUserSites').then(function(sites) {
              this.sites = sites.body;
              this.fetchingData = false;
          }, function(){
              this.fetchingFailed = true;
          });
         },
      },
      watch: {
        //   selected: function() {
        //     if (this.selected == 1){
        //        this.$http.get('/api/getBlogs' ,function(getBlogs){
        //         this.blogs = getBlogs;
        //         }.bind(this));
        //     }
        //     else{
        //       this.$http.get('/api/getBlogs/'+ this.selected ,function(getBlogs){
        //       this.blogs = getBlogs;
        //         }.bind(this));
        //     }
        //   }
      }
    }
</script>
