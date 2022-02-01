@extends('layouts.app')


@section('content')

<?php //$s = new Single('Home', 10, 5); ?>

<section>
	<h1>HW!</h1>
</section>

@endsection


@section('meta')

{{-- <title>{{ $s->field('Meta', 'Title', 'textarea', true, 'Digiants') }}</title>
<meta name="description" content="{{ $s->field('Meta', 'Description', 'textarea', true, '') }}">
<meta name="keywords" content="{{ $s->field('Meta', 'Keywords', 'textarea', true, '') }}"> --}}

@endsection


@section('javascript')

<script>
	console.log('HW!')
</script>

@endsection