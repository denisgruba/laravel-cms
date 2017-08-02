<script>

// import './../components/vue-drag-and-drop-list.js';
import row from './../components/Blocks/Row.vue';
// Vue.use(VueDragAndDropList);
export default {
    template: '#blocks-layout',
    name: 'blocks-layout',
    components: {
        row
    },
    data(){
        return {
            toolbarActive: false,
            "selected": null,
            templates: {type: "new element", id: 1},
            disable: false,
            components: {
                list
            },
            layout:  [
                {
                    "type": "row",
                    "id": 1,
                    "layout": "2col",
                    "columns": [
                        {
                            "type": "item",
                            "id": "2"
                        },
                        {
                            "type": "item",
                            "id": "3"
                        }
                    ]
                },
                {
                    "type": "row",
                    "id": 1,
                    "layout": "1col",
                    "columns": [
                        {
                            "type": "item",
                            "id": "2"
                        }
                    ]
                },
            ],
        }
    },
    methods: {

    }
}
</script>
<style>
.no-padding{
    padding: 0px;
}
.no-margin{
    margin: 0px;
}
.secondary-content{
    display: none;
}
.collection-item:hover > .secondary-content{
    display: block;
}
.drag-icon{
    display: none!important;
}
.collection-item:hover > .drag-icon{
    display: inline-block!important;
}
</style>
