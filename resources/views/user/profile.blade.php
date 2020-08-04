@extends('app')

@section('content')
    <div class="row d-flex">
        <section class="user col-lg-8 px-md-5 d-flex py-5">
            <div class="col-md-4">
                <upload-avatar src="{{ $user->avatar ?? config('settings.image_cap')}}"></upload-avatar>
            </div>
            <div class="col-md-6">
                <form action="{{ url('/'.app()->getLocale().'/user/profile', ['id' => $user->id]) }}"
                      method="POST"
                      class="form mt-2"
                >
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}

                    <fieldset>
                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label">{{__('blog.userName')}}</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="name" value="{{ $user->name }}" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-3 col-form-label">{{__('blog.userEmail')}}</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="email" value="{{ $user->email }}" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="info" class="col-md-3 col-form-label">
                                {{__('blog.userInfo')}}
                            </label>
                            <div class="col-md-9">
                                <textarea class="form-control" rows="3" name="info"
                                          id="info">{{ $user->info }}</textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-action row">
                            <div class="offset-md-3 col-md-9">
                                <button class="btn btn-primary btn-block" type="submit">
                                    {{__('blog.updateProfile')}}
                                </button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </section>
        @include('partials.right_side')
    </div>
@endsection
