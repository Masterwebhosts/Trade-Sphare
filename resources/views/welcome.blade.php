@extends('layouts.landing')


@section('title')

أعلاني | الإعلان الذكي والوصول للعملاء

@endsection


@section('content')

@include('sections.hero')
@include('sections.statistics')
@include('sections.how-it-works')
@include('sections.advertisers')
@include('sections.publishers')
@include('sections.ad-formats')
@include('sections.features')
@include('sections.dashboard')
@include('sections.api')
@include('sections.faq')
@include('sections.cta')

@endsection