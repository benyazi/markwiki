@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h2>{{$page->title}}</h2>
                <div>
                    {!! $page->renderContent() !!}
                </div>
            </div>
            <div class="col-3">
                <div class="card" style="width: 18rem;">
                    <div class="card-header">
                        Articles:
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach($page->project->pages()->get() as $page)
                            <li class="list-group-item">
                                <a href="{{$page->getUrl()}}">{{$page->title}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
