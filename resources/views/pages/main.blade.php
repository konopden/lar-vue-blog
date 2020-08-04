@extends('app')
@section('content')
  <section class="ftco-section ftco-no-pt ftco-no-pb">
    <div class="container">
      <div class="row d-flex">
        @include('widgets.articles')
        @include('partials.right_side')
      </div>
    </div>
  </section>
@endsection
