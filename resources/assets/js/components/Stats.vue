<script>

import { Bar } from './../vue-charts/index.js';
export default{
    template: '#stats',
    name: 'stats',
    components: {
        Bar
    },
    data () {
      return {
        datacollection: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            datasets: [
                {
                    label: 'GitHub Commits',
                    backgroundColor: '#f87979',
                    data: [40, 20, 12, 39, 10, 40, 39, 80, 40, 20, 12, 11]
                }
            ]
        }
      }
    },
    mounted () {
        console.log('test');
      this.renderChart(this.datacollection, {responsive: true, maintainAspectRatio: false})
    },
}
</script>
