@extends('layouts.app')

@section('title', '新規投稿')

@section('content')

    <section class="container m-5">
        <div class="row justify-content-center">
            <div class="col-8">


            <!-- エラーに関する情報を出すための・・・ -->
            @if($errors->any())

                <ul>
                    @foreach($errors->all() as $message)

                      <li class="alert alert-danger">{{$message}}</li>

                    @endforeach
                </ul>

            @endif


              <!-- form>div*3 -->
              <form action="{{ route('diary.store') }}" method="POST">
                            <!-- route + 名前 -->
                            @csrf
                            <!-- @csrf 意味を確認するdeveloper tool. -->

                <div class="form-group">
                    <label for="title">タイトル</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title')}}">
                    <!-- input等にnameをつける -->
                </div>

                <div class="form-group">
                    <label for="body">本文</label>
                    <textarea id="body" class="form-control" name="body">{{ old('title')}}</textarea>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">投稿</button>
                </div>

              </form>
            </div>
        </div>
    </section>

@endsection