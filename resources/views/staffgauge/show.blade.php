@extends('layout.main')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Staffgauge {{ $staffgauge->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/staffgauge') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/staffgauge/' . $staffgauge->id . '/edit') }}" title="Edit Staffgauge"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('staffgauge' . '/' . $staffgauge->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Staffgauge" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $staffgauge->id }}</td>
                                    </tr>
                                    <tr><th> Addressgauge </th><td> {{ $staffgauge->addressgauge }} </td></tr>
                                    <tr><th> Amphoe </th><td> {{ $staffgauge->amphoe }} </td></tr>
                                    <tr><th> District </th><td> {{ $staffgauge->district }} </td></tr>
                                    <tr><th> Province </th><td> {{ $staffgauge->province }} </td></tr>
                                    <tr><th> Latitudegauge </th><td> {{ $staffgauge->latitudegauge }} </td></tr>
                                    <tr><th> Longitudegauge </th><td> {{ $staffgauge->longitudegauge }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection