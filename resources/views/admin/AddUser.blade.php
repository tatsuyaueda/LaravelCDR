@extends('admin.layout')

@section('content')
@@parent
<section class="content">
    <form method="post" action="{{action('AdminController@postAddUser')}}">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">ユーザの追加</h3>
            </div>
            <div class="box-body">
                @include('notification')
                
                <div class="col-md-4">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="username" class="sr-only">ユーザ名</label>
                        <input type="text" id="username" name="username" class="form-control" placeholder="ユーザ名" value="{{old('username')}}" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="name" class="sr-only">表示名</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="表示名" value="{{old('name')}}" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="sr-only">メールアドレス</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="メールアドレス" value="{{old('email')}}" required>
                    </div>
                    <div class="form-group">
                        <label for="roles[]" class="sr-only">ロール</label>
                        <select name="roles[]" id="roles" class="form-control" multiple="multiple">
                            @foreach($roles as $value)
                            @if(old('roles') != null && in_array($value->id, old('roles')))
                            <option value="{{$value->id}}" selected="selcted">{{$value->display_name}}</option>
                            @else
                            <option value="{{$value->id}}">{{$value->display_name}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password" class="sr-only">パスワード</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="パスワード" required>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation" class="sr-only">パスワード(確認)</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="パスワード(確認)" required>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button class="btn btn-primary" type="submit">追加</button>
            </div>
        </div>
    </form>
</section>

<script>
<!--
    $(document).ready(function () {

        $('select[name^=roles]').select2({
            placeholder: "ロール",
            minimumResultsForSearch: Infinity,
        });

    });
    //-->
</script>
@endsection