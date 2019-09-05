@extends('fastadminpanel.layouts.app')

@section('content')
<div class="topbar">
    <div>Admin panel</div>
    <div class="langs">
        <div class="langs-elm" :class="{'active': lang.is_active}" v-for="lang in languages" v-text="lang.tag" v-on:click="set_language(lang)"></div>
    </div>
</div>
<main>
    <template-sidebar :is_dev="is_dev" :menu="menu"></template-sidebar>
    <template-content></template-content>
</main>
@endsection

@section('javascript')
<script>
    var languages = JSON.parse('{!! $languages !!}')
</script>
@include('fastadminpanel.components.languages')
@include('fastadminpanel.components.sidebar')
@include('fastadminpanel.components.content')
@include('fastadminpanel.components.menu')
@include('fastadminpanel.components.edit')
@include('fastadminpanel.components.index')
<script src="/vendor/fastadminpanel/js/components/app.js"></script>
@endsection