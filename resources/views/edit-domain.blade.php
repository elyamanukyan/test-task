@extends('layouts.app')
@section('links')
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="alert notification hidden">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <span></span>
                </div>
                @if(Session::has('message'))
                    <div class="alert {{ Session::get('alert-class') }}">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {{ Session::get('message') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">Edit domain</div>

                    <div class="card-body">
                        <div class="col-4 mb-4">
                            <input type="hidden" name="domain_id" value="{{$domain->id}}">
                            <input type="text"
                                   class="btn btn-info new-domain form-control"
                                   name="domain" placeholder="Add new" value="{{$domain->domain}}">
                            <span class="invalid-feedback hidden domain-error" role="alert">
                                        <strong></strong>
                                    </span>
                            <p class="hidden domain-status"></p>
                            <button type="submit" class="btn btn-success hidden add-domain update-domain">Update
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/domains.js')}}"></script>
@endsection
