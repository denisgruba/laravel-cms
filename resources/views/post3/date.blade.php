@extends('layouts.app2')

@section('content')
    <main>
        @include('partials.breadcrumbs.post-create')
        @if (count($errors) > 0)
            <div class="row" style="padding-left: 15px; padding-right: 15px;">
                <ul class="collection with-header">
                    <li class="collection-header"><h4>We've encountered some errors:</h4></li>
                    @foreach ($errors->all() as $error)
                        <li class="collection-item red-text">{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            @if(count($types))
                {{ Form::open(array('url' => '/post/store', 'files' => true, 'class' => '')) }}
                    <div class="row" style="padding-left: 15px; padding-right: 15px; margin-bottom: 150px;">
                        <div class="col s12 card-panel white">
                            <h3>Create {{$category->name}}</h3>
                                <div class="row">
                                    <div class="col s6">
                                        <div class=""><label for=""><h6>Start Date (Required)</h6></label></div>
                                        <div id="tutorial-create-start-date" class="input-field">
                                            <input id="datepicker1" name="start_date" type="text" class="" required placeholder="Date" value="{{ old('start_date') }}">
                                        </div>
                                        <div id="tutorial-create-start-time" class="switch">
                                            <label class="not-absolute">
                                                No Start time
                                                <input type="checkbox" name="enable_starttime" id="enable_starttime">
                                                <span class="lever"></span>
                                                Custom Start Time
                                            </label>
                                        </div>
                                        <div class="input-field" id="start">
                                            <input id="timepicker1" name="start_time" type="text" class="" placeholder="Time" value="{{ old('start_time') }}">
                                        </div>
                                    </div>
                                    <div class="col s6">
                                        <div class=""><label for=""><h6>End Date (Required)</h6></label></div>
                                        <div id="tutorial-create-end-date" class="input-field">
                                            <input id="datepicker2" name="end_date" type="text" class="" required placeholder="Date" value="{{ old('end_date') }}">
                                        </div>
                                        <div id="tutorial-create-end-time" class="switch">
                                            <label class="not-absolute">
                                                No End Time
                                                <input type="checkbox" name="enable_endtime" id="enable_endtime">
                                                <span class="lever"></span>
                                                Custom End Time
                                            </label>
                                        </div>
                                        <div class="input-field" id="end">
                                            <input id="timepicker2" name="end_time" type="text" class="" placeholder="Time" value="{{ old('end_time') }}">
                                        </div>
                                    </div>
                                    <div class="col s6">
                                        @include('partials.datepicker')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                {{ Form::close() }}
            @endif
        </div>
    </main>

@endsection

@section('scripts')

    <script>
        $(document).ready(function(){

            $('select').material_select();
            $("select[required]").css({display: "inline", height: 1, padding: 0, width: 1, border: 0, margin: 0, position: "relative", top: -30});

            $('.pin-panel').each(function() {
                var $this = $(this);
                $this.pushpin({
                    top: $this.offset().top
                });
            });
            $('#clearThumbSelection').click(function(){
                $('.default-resource-radio').each(function(){
                    $(this).prop('checked', false);
                });
            });

            $('#publish_settings').modal();

            var pinState = $('#pinCheckbox').val();
            var changePinState = function(){
                pinState = !pinState;
                // if(pinState==true){
                //     $('#pinToggle').addClass('blue');
                // } else $('#pinToggle').removeClass('blue');

            };



        });

    </script>


@endsection
