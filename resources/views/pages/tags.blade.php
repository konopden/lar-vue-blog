@extends('app')
@section('content')
    <section class="ftco-section ftco-no-pt ftco-no-pb">
        <div class="container">
            <h2>Tags</h2>
            <div class="row d-flex">
                <section class="ftco-about img ftco-section ftco-no-pt ftco-no-pb" id="about-section">
                    <div class="container-fluid px-0">
                        <div class="row d-flex">
                            <div class="row mb-2">
                                @foreach($tags as $tag)
                                    @if($tag->articles->count() > 0)
                                        <div class="col-md-6">
                                            <div class="card flex-md-row mb-4 box-shadow h-md-250">
                                                <div class="card-body d-flex flex-column align-items-start">
                                                    <a href="{{ url('tag', ['tag' => $tag->tag]) }}"
                                                       class="d-inline-block mb-2 text-primary">#{{$tag->tag}}</a>
                                                    <p class="card-text mb-auto">
                                                        {{$tag->title}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection
