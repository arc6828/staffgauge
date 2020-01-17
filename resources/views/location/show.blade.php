@extends('layout.main')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Location {{ $location->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/location') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/location/' . $location->id . '/edit') }}" title="Edit Location"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('location' . '/' . $location->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Location" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $location->id }}</td>
                                    </tr>
                                    <tr><th> Address </th><td> {{ $location->address }} </td></tr>
                                    <tr><th> Latitude </th><td> {{ $location->latitude }} </td></tr>
                                    <tr><th> Longitude </th><td> {{ $location->longitude }} </td></tr>
                                    <tr><th> TypeGroup </th><td> {{ $location->typegroup }} </td></tr>
                                    <tr><th> LineId </th><td> {{ $location->lineid }} </td></tr>
                                    <tr><th> StaffgaugeId </th><td> {{ $location->staffgaugeid }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection