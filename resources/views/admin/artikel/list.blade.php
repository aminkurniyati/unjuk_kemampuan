@extends('admin.layouts.app')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Semua Artikel</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('article.create')}}" class="btn btn-primary">New Article</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        @include('admin.message')
        <div class="card">
            <form action="" method="get">
                <div class="card-header">
                    <div class="card-title">
                        <button type="button" onclick="window.location.href='{{ route("article.index") }}'" class="btn btn-default btn-md">Refresh</button>
                    </div> 
                    <div class="card-tools">
                        <div class="input-group input-group" style="width: 250px;">
                            <input type="text" name="keyword" class="form-control float-right" placeholder="Search">
        
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                                </button>
                            </div>
                            </div>
                    </div>
                </div>
            </form>
            <div class="card-body table-responsive p-0">								
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th width="60">NO</th>
                            <th>Judul Artikel</th>
                            <th>Isi Artikel</th>
                            <th width="100">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($article->isNotEmpty())
                            @foreach ($article as $item)
                            <tr>
                                <td>{{ $rank++ }}</td>
                                <td>                                    
                                    {{ $item->judul }}
                                </td>
                                <td>
                                    @php
                                        $truncated = Str::of($item->isi)->limit(20);
                                    @endphp
                                    {!! $truncated !!}
                                </td>
                                <td>
                                    <a href="{{ route('article.show', $item->id) }}" class="btn btn-default btn-md">View</a>
                                    <a href="{{ route('article.edit', $item->id) }}" class="btn btn-default btn-md">Edit</a>
                                </td>
                                <td>                                        
                                    <form action="{{route('article.destroy', $item->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-md">Delete</button>
                                    </form>  
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-danger">Belum ada artikel saat ini.Silahkan anda menulis sebuah artikel.</td>
                            </tr>
                        @endif										
                    </tbody>
                </table>										
            </div>
            <div class="card-footer clearfix">
                <ul class="pagination pagination m-0 float-right">
                    {{ $article->links() }}
                </ul>
            </div>
        </div>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->

@endsection


@section('customsJs')
    <script>
        console.log('Hello');
    </script>
@endsection