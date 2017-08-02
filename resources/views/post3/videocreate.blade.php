@extends('layouts.app2')

@section('content')
    <main>
        @include('partials.breadcrumbs.converter')
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
        <div class="row">
            @if (count($errors) > 0)
                <ul class="collection ">
                    @foreach ($errors->all() as $error)
                        <li class="collection-item red white-text">{{ $error }}</li>
                    @endforeach
                </ul>
            @endif


            {{-- @if(isset($conversionPath))
                <img src="{{$conversionPath}}" alt="">
            @endif --}}
            {{ Form::open(array('url' => '/video/store', 'files' => true, 'class' => '')) }}
                <div class="row" style="padding-left: 15px; padding-right: 15px; margin-bottom: 150px;">
                    <div class="col s12 card-panel white">
                        <h3>Convert Videos</h3>
                        <div class="file-field input-field col s12">
                            <div class="btn">
                                <span>Upload</span>
                                <input type="file" name="files[]" multiple required>
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" placeholder="Upload Video Files">
                            </div>
                        </div>
                        @php
                            $dir = scandir('./videos/oq/');
                            $items = [];
                            foreach($dir as $file) {
                                if(!($file =='.' || $file =='..' || $file =='.DS_Store')) {
                                    array_push($items, $file);
                                }
                            }

                        @endphp
                        @if(count($items))
                            <table class="bordered highlight">
                                <thead>
                                    <tr>
                                        <th>Original</th>
                                        <th>Low Quality</th>
                                        <th>Medium Quality</th>
                                        <th>High Quality</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                        <tr>
                                            <td>
                                                <video class="responsive-video" width="300" controls>
                                                    <source src="{{url('/')}}/videos/oq/{{$item}}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video><br />
                                                <a href="{{url('/')}}/videos/oq/{{$item}}" download class="waves-effect waves-light btn">{{$item}}</a>
                                            </td>
                                            <td>
                                                <video class="responsive-video" width="300" controls>
                                                    <source src="{{url('/')}}/videos/lq/{{preg_replace('/\\.[^.\\s]{3,4}$/', '', $item)}}.mp4" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </td>
                                            <td>
                                                <video class="responsive-video" width="300" controls>
                                                    <source src="{{url('/')}}/videos/mq/{{preg_replace('/\\.[^.\\s]{3,4}$/', '', $item)}}.mp4" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </td>
                                            <td>
                                                <video class="responsive-video" width="300" controls>
                                                    <source src="{{url('/')}}/videos/hq/{{preg_replace('/\\.[^.\\s]{3,4}$/', '', $item)}}.mp4" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                        @include('partials.drawer', [
                            'drawerSubmit' => true,
                            'drawerPage' => 'converter'
                        ])
                    </div>
                </div>
            {{ Form::close() }}


        </div>
    </main>
@endsection

@section('scripts')



@endsection
