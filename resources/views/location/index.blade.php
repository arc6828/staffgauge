@extends('layout.main')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">Location</div>
                    <div class="card-body">
                        <a href="{{ url('/location/create') }}" class="btn btn-success btn-sm" title="Add New Location">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New 
                        </a>

                        <form method="GET" action="{{ url('/location') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request('search') }}">
                                <span class="input-group-append">
                                    <button class="btn btn-secondary" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>

                        <br/>
                        <br/>
                        <div class="table-responsive" >
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>address</th>
                                        <th>latitude</th>
                                        <th>longitude</th>
                                        <th>typegroup</th>
                                        <th>lineid</th>
                                        <th>staffgaugeid</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($location as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->address }}</td>
                                        <td>{{ $item->latitude }}</td>
                                        <td>{{ $item->longitude }}</td>
                                        <td>{{ $item->typegroup }}</td>
                                        <td>{{ $item->lineid }}</td>
                                        <td>{{ $item->staffgaugeid }}</td>
                                        <td>
                                            <a href="{{ url('/location/' . $item->id) }}" title="View Location"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/location/' . $item->id . '/edit') }}" title="Edit Location"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                            <form method="POST" action="{{ url('/location' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Location" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $location->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>

               
                
            </div>
        </div>
    </div>
@endsection