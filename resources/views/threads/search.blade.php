@extends('layouts.app')

@section('content')
    <div class="container">
                <ais-index class="row col-md-12"
                        app-id="{{ config('scout.algolia.id') }}"
                        api-key="{{ config('scout.algolia.key') }}"
                        index-name="threads"
                       :query-parameters="{
                       }"

                >
                    <div class="col-md-8">
                        <ais-results inline-template>
                            {{--<template slot-scope="{ result }">--}}
                            <ol>
                                <li v-for="result in results" :key="result.id">
                                    <a :href="result.thread_path">
                                        <ais-highlight :result="result" attribute-name="title"></ais-highlight>
                                    </a>
                                </li>
                            </ol>
                            {{--</template>--}}
                        </ais-results>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <ais-search-box>
                                <ais-input placeholder="Find a thread" :autofocus="true" class="form-control"></ais-input>
                            </ais-search-box>
                        </div>
                        <div class="form-group">
                            <ais-refinement-list attribute-name="channel.name"></ais-refinement-list>
                        </div>
                    </div>
             </ais-index>
    </div>
@endsection
