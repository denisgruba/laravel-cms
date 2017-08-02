<script>
    export default {
      template: '#category-latest-updates',
    //   props: [
    //       'siteId',
    //       'categoryId'
    //   ],
      data(){
        return{
            categoryLatestUpdates: [],
            selected: []
        };
      },
      created(){
        // this.fetchCategoryLatestUpdates(siteId, categoryId);
      },
      methods: {
        fetchCategoryLatestUpdates: function(siteId, categoryId){
            this.$http.get('/api/getCategoryLatestUpdates/'+siteId+'/'+categoryId).then(function(categoryLatestUpdates){
                this.categoryLatestUpdates = categoryLatestUpdates.body;
            });
        },
      },
      watch: {
          selected: function(currentValue) {
            //   this.$http.get('/api/getCategory/'+ this.selected ,function(groupinfo){
            //         this.groupinfo = groupinfo;
            //       });
            this.$http.get('/api/getCategoryLatestUpdates/3/'+this.selected).then(function(categoryLatestUpdates){
                this.categoryLatestUpdates = categoryLatestUpdates.body;
            });
          }
      }
    }
</script>
