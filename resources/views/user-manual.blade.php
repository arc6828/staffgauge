@extends('layout.main')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">Ocr</div>
                    <div class="card-body text-center">
                        <a class="btn btn-success" href="{{ url('/user-manual.pdf') }}">ดูคู่มือการใช้งาน</a>

                    </div>
                </div>

               
                
            </div>
        </div>
    </div>
@endsection
