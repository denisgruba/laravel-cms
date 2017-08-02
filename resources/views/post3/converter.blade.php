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
            {{ Form::open(array('url' => '/convertnow', 'files' => true, 'class' => '')) }}
                <div class="row" style="padding-left: 15px; padding-right: 15px; margin-bottom: 150px;">
                    <div class="col s12 card-panel white">
                        <h3>Convert</h3>
                        <div class="file-field input-field col s12">
                            <div class="btn">
                                <span>Upload</span>
                                <input type="file" name="files[]" multiple required accept="pdf">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" placeholder="Upload PDF Files" accept="pdf">
                            </div>
                        </div>
                        @php
                            $dir = scandir('../public/converter/pdf');
                            $items = [];
                            foreach($dir as $file) {
                                if(!($file =='.' || $file =='..')) {
                                    array_push($items, $file);
                                }
                            }

                        @endphp
                        @if(count($items))
                            <table class="bordered highlight">
                                <thead>
                                    <tr>
                                        <th>PDF</th>
                                        <th>Thumbnail</th>
                                        <th>Fullsize</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                        <tr>
                                            <td><a href="{{url('/')}}/converter/pdf/{{$item}}" download class="waves-effect waves-light btn">{{$item}}</a></td>
                                            <td><img src="{{url('/')}}/converter/converted-thumbs/{{preg_replace('/\\.[^.\\s]{3,4}$/', '', $item)}}.jpg" alt="" style="max-height: 200px;"></td>
                                            <td><img src="{{url('/')}}/converter/converted-full/{{preg_replace('/\\.[^.\\s]{3,4}$/', '', $item)}}.jpg" alt="" style="max-height: 200px;"></td>
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
