@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('words.user_register') }}</div>
                <div class="panel-body">
                    <?php
                    /**
                     * @var \App\Forms\UserRegisterForm $userRegisterForm
                     */
                    ?>
                    @if ($userRegisterForm->hasRenderFields())
                        {!! $userRegisterForm->render() !!}
                    @else
                        <div>
                            {{ trans('phrases.this_form_contains_no_entries') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
