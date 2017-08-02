<script>
    export default {
      template: '#site-create',
      data(){
        return{
            // sites: [],
            fetchingData: true,
            fetchingFailed: false,
            fetchingError: 'There was an error loading your sites list. Have you tried reloading?',
        };
      },
      props: [
          siteColor,
      ],
      created(){
        // this.fetchSites();
      },
      methods: {

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
