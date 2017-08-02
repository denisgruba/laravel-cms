<script>
export default {
    template: '#list',
    name: 'list',
    props: ['item', 'list', 'index', 'selected', 'disable'],
    methods: {
        selectedEvent(item){
            this.selected = item;
        }
    }
};
</script>
