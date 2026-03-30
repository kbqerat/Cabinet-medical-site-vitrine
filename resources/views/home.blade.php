@extends('layouts.app')

@section('content')
    @include('sections.hero')
    @include('sections.stats')
    @include('sections.features')
    @include('sections.how-it-works')
    @include('sections.screenshots')
    @include('sections.pricing')
    @include('sections.testimonials')
    @include('sections.faq')
    @include('sections.cta-banner')
    @include('components.contact')
@endsection
