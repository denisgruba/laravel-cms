@extends('layouts.app2')

@section('content')
    <main>
        @include('partials.breadcrumbs.staff-sort')
        <div class="card-panel">
            <p>Drag and drop to sort Groups and Staff.</p>
        </div>
        @php

        $index1 = 0;
        $index2 = 0;

        @endphp

        <div class="row" style="margin-bottom: 300px;">
            <div class="col m12">
                <div id="staff-sort-drag" class="ui-contain" style="overflow: hidden; width: 100%; height: 100%;">
                    <ul id="sortable0">
                        {{-- @{{openTutorial}} --}}

                        <tutorial :tutorial-page="'SortStaff'"></tutorial>

                        @foreach($groups as $group)
                            <li id="group_{{$group->id}}" class="ui-state-default ui-group">
                                {{-- @if($index1 == 0)
                                    <div id="tutorial-staff-sort-drag">
                                    @endif --}}

                                    <ul id="sortable{{$group->id}}" class="collection with-header connectedSortable">
                                        {{-- @if($index1 == 0)
                                            <div id="tutorial-staff-sort-group">
                                            @endif --}}
                                            <li class="ui-state-default collection-header ui-state-disabled group-handle">

                                                <h4>
                                                    {{$group->name}}
                                                    <div class="switch right tooltipped" data-position="bottom" data-delay="50" data-tooltip="If you have a long list, you can fold the groups you don't edit to save up some space on the screen. This Does not affect the sorting in any way.">
                                                        <label>
                                                            Fold
                                                            <input type="checkbox" checked="checked"
                                                            {{-- @if($index1 == 0)
                                                                class="hide-toggle-extra"
                                                            @else --}}
                                                                class="hide-toggle"
                                                            {{-- @endif --}}

                                                            >
                                                            <span class="lever"></span>
                                                            Unfold
                                                        </label>
                                                    </div>
                                                </h4>
                                            </li>
                                            {{-- @if($index2 == 0)
                                            </div>
                                        @endif --}}
                                        @foreach($group->staff->sortBy('order') as $staff)
                                            {{-- @if($index2 == 0)
                                                <span id="tutorial-staff-sort-member">
                                                @endif --}}
                                                <li id="sort_{{$staff->id}}" class="ui-state-default collection-item avatar collection-staff">
                                                    @if(isset($staff->photo))
                                                        <img src="{{url('/')}}/img/staff/{{$staff->id}}/{{$staff->photo}}?h=250&w=250&fit=crop-top" alt="" class="circle" onerror="this.onerror=null;this.src='/img/nostaffimage.png'">
                                                    @else
                                                        <img src="{{url('/')}}/img/nostaffimage.png" alt="" class="circle">
                                                    @endif
                                                    <span class="title"><strong>{{$staff->title}} {{$staff->name}}</strong></span>
                                                    <p>{{$staff->position}}
                                                        @if(isset($staff->email))
                                                            <br><a href="mailto:{{$staff->email}}">{{$staff->email}}</a>
                                                        @endif
                                                    </p>

                                                    <p class="secondary-content">
                                                        <a href="{{url('/')}}/staff/duplicate/{{$staff->id}}/{{$site->id}}" class="blue-text tooltipped" data-position="bottom" data-delay="50" data-tooltip="Duplicate member"><i class="material-icons">content_copy</i></a>
                                                        <a href="{{url('/')}}/staff/edit/{{$staff->id}}/{{$site->id}}" class="green-text tooltipped" data-position="bottom" data-delay="50" data-tooltip="Edit member"><i class="material-icons">mode_edit</i></a>
                                                        <a href="{{url('/')}}/staff/delete/{{$staff->id}}/{{$site->id}}" class="red-text tooltipped" data-position="bottom" data-delay="50" data-tooltip="Remove member"><i class="material-icons">delete</i></a>
                                                    </p>


                                                </li>
                                                {{-- @if($index2 == 0)
                                                </span>
                                            @endif --}}

                                            {{-- @php
                                            $index2++;
                                            @endphp --}}
                                        @endforeach
                                    </ul>
                                    {{-- @if($index1 == 0)
                                    </div>
                                @endif --}}
                            </li>

                            {{-- @php
                            $index1++;
                            @endphp --}}
                        @endforeach
                    </ul>
                </div>
                <div id="staff-sort-drawer" class="row white z-depth-1" style="margin-bottom: 80px; padding-top:20px;">
                    <div class="col m12">
                        {{ Form::open(array('url' => 'staff/sort', 'class' => 'col m12')) }}
                        <input type="hidden" name="groupOrder[]" id="group" value="">
                        @foreach($groups as $group)
                            <input type="hidden" name="staffOrderOfGroup{{$group->id}}[]" id="sort{{$group->id}}" value="">
                        @endforeach
                        @include('partials.drawer', [
                            'drawerSubmit' => true,
                            'drawerPage' => 'staff'
                        ])

                        {{ Form::close() }}
                    </div>

                </div>
            </div>
        </div>
    </main>

@endsection

@section('vue-template')

    <script type="text/x-template" id="tutorial-component">
        @if($enableSortTutorial)
        <li id="tutorial-staff-sort-drag">
            <ul class="collection with-header connectedSortable">
                <div id="tutorial-staff-sort-group">
                    <li class="collection-header">
                        <h4>
                            Example Group
                            <div class="switch right tooltipped" data-position="bottom" data-delay="50" data-tooltip="If you have a long list, you can fold the groups you don't edit to save up some space on the screen. This Does not affect the sorting in any way.">
                                <label>
                                    Fold
                                    <input type="checkbox" checked="checked"
                                    {{-- @if($index1 == 0)
                                        class="hide-toggle-extra"
                                    @else --}}
                                        class="hide-toggle"
                                    {{-- @endif --}}

                                    >
                                    <span class="lever"></span>
                                    Unfold
                                </label>
                            </div>
                        </h4>
                    </li>
                </div>
                <div id="tutorial-staff-sort-member">
                    <li class=" collection-item avatar collection-staff">
                        <img src="{{url('/')}}/img/nostaffimage.png" alt="" class="circle">

                        <span class="title"><strong>This is Example Staff Member</strong></span>
                        <p>
                        </p>

                        <p class="secondary-content">
                            <a href="" class="blue-text tooltipped" data-position="bottom" data-delay="50" data-tooltip="Duplicate member"><i class="material-icons">content_copy</i></a>
                            <a href="" class="green-text tooltipped" data-position="bottom" data-delay="50" data-tooltip="Edit member"><i class="material-icons">mode_edit</i></a>
                            <a href="" class="red-text tooltipped" data-position="bottom" data-delay="50" data-tooltip="Remove member"><i class="material-icons">delete</i></a>
                        </p>


                    </li>
                </div>

            </ul>
        </li>
        @endif
    </script>

@endsection

@section('scripts')

    <script>
    $( function() {
        $("#sortable0").sortable({
            items: "li.ui-group",
            placeholder: "collection-item collection-placeholder big blue",
            forcePlaceholderSize: true,
            handle: ".group-handle",
            axis: "y",
            tolerance: "pointer",
            //                start: function(event, ui) {
            //                    $('.collection-staff').hide( 1000 );
            //                },
            //                stop: function(event, ui) {
            //                    $('.collection-staff').show( 1000 );
            //                },
            //                containment: ".ui-contain",
            update: function( event, ui ) {
                var sorted =  $('#sortable0').sortable("toArray");
                $('#group').val(sorted);
            }
        }).disableSelection();
        var sorted =  $('#sortable0').sortable("toArray");
        $('#group').val(sorted);
        @foreach($groups as $group)
        $( "#sortable{{$group->id}}" ).sortable({
            items: "li:not(.ui-state-disabled)",
            placeholder: "collection-item collection-placeholder yellow",
            forcePlaceholderSize: true,
            connectWith: ".connectedSortable",
            axis: "y",
            update: function( event, ui ) {
                var sorted =  $('#sortable{{$group->id}}').sortable("toArray");
                $('#sort{{$group->id}}').val(sorted.join(","));
            }
        }).disableSelection();

        var sorted =  $('#sortable{{$group->id}}').sortable("toArray");
        $('#sort{{$group->id}}').val(sorted);
        @endforeach

        $('.hide-toggle').change(function(){
            if($(this).prop( "checked" )){
                $(this).parent().parent().parent().parent().parent().removeClass("collapsed");
            } else {
                $(this).parent().parent().parent().parent().parent().addClass("collapsed");
            }

        });
        $('.hide-toggle-extra').change(function(){
            if($(this).prop( "checked" )){
                $(this).parent().parent().parent().parent().parent().parent().removeClass("collapsed");
            } else {
                $(this).parent().parent().parent().parent().parent().parent().addClass("collapsed");
            }

        });

        $('.hide-button').click(function(){
            $(this).parent().parent().parent().toggleClass("collapsed");
            if($(this).parent().parent().parent().hasClass("collapsed")){
                $(this).html('<i class="material-icons">visibility_on</i>');
            } else{
                $(this).html('<i class="material-icons">visibility_off</i>');
            }
        });
    } );
    </script>

@endsection
