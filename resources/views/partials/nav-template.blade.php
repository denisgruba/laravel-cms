@if(isset($site))
    <script type="text/x-template" id="nav-quick-create">
        <div>
            <li><a href="{{$site->url}}" target="_blank">Go to School Website<i class="material-icons right">language</i></a></li>
            <li class="divider"></li>
            <li v-for="category in categories">
                <a  v-if="category.id==6" :href="'{{ url('/') }}/staff/create/{{$site->id}}'">Add staff</a>
                <a v-else-if="category.id==9" :href="'{{ url('/') }}/vacancy/create/{{$site->id}}'">Create Vacancy</a>
                <a v-else :href="'{{ url('/') }}/post/create/'+category.id+'/{{$site->id}}'">Create @{{category.name}}</a>
            </li>

            @can('webteam')
                <li class="divider"></li>
                <li><a href="{{ url('/') }}/media/list/{{$site->id}}">Upload media<i class="material-icons right">insert_photo</i></a></li>
            @endcan
        </div>
    </script>
@endif
