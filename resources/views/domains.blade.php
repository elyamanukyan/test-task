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
                        <button type="button" class="close" data-dismiss="alert">&times</button>
                        {{ Session::get('message') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">Domains</div>

                    <div class="card-body">
                        <div class="col-4 mb-4">
                            <form method="POST" action="{{url('domains')}}">
                                @csrf
                                <input type="text"
                                       class="btn btn-info new-domain form-control{{ $errors->has('domain') ? ' is-invalid' : '' }}"
                                       name="domain" placeholder="ADD NEW DOMAIN" value="{{old('domain')}}">
                                @if ($errors->has('domain'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('domain') }}</strong>
                                    </span>
                                @endif
                                <p class="hidden domain-status"></p>
                                <button type="submit" class="btn btn-success hidden add-domain">Add</button>
                            </form>
                        </div>
                        <h3>Your domains</h3>
                        @if(count($user->domains) > 0)
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Domain</th>
                                    <th>Created</th>
                                    <th>Updated</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                    <th>Restore</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($user->domains as $domain)
                                    <tr>
                                        <td>{{$domain->domain}}</td>
                                        <td>{{$domain->created_at ? $domain->created_at->format('Y-m-d') : "-"}}</td>
                                        <td>{{$domain->updated_at ? $domain->updated_at->format('Y-m-d') : "-"}}</td>
                                        <td><a href="{{url('/domains/'.$domain->id.'/edit')}}"
                                               class="btn btn-info">edit</a></td>
                                        <td>
                                            @if(!$domain->deleted_at)
                                                <button class="btn btn-danger delete-domain" data-id="{{$domain->id}}">
                                                    delete
                                                </button>
                                            @else
                                                deleted
                                            @endif
                                        </td>
                                        <td>
                                            @if($domain->deleted_at)
                                                <button class="btn btn-warning restore-domain"
                                                        data-id="{{$domain->id}}">restore
                                                </button>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            You have not any domain yet.
                        @endif
                        <h3>All domains</h3>
                        @if(count($domains) > 0)
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Domain</th>
                                    <th>Created</th>
                                    <th>Updated</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($domains as $domain)
                                    <tr>
                                        <td>{{$domain->domain}}</td>
                                        <td>{{$domain->created_at ? $domain->created_at->format('Y-m-d') : "-"}}</td>
                                        <td>{{$domain->updated_at ? $domain->updated_at->format('Y-m-d') : "-"}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $domains->links() }}
                        @else
                            No domains.
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/domains.js')}}"></script>
@endsection
