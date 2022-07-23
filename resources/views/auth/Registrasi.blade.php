<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SPK-APP | Registrasi</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="hold-transition register-page">
    <div class="register-box mt-5" id="app">
      

        <div class="card">
            <div class="card-body register-card-body">
                <p class="login-box-msg">Registrasi</p>

               

                <form action="/registrasi" method="post">
                    @csrf
                    <div class="form-group @error('nama') mb-1 @enderror">
                        <div class="input-group">
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Lengkap" name="nama" value="{{old('nama')}}">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                            @error('nama')
                            <div  class="text-danger   @error('nama') invalid-feedback mt-0 @enderror">
                               {{ $message }}
                            </div> 
                            @enderror
                        </div>

                    </div>
                    <div class="form-group @error('email') mb-1 @enderror">
                        <div class="input-group ">
                            <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{old('email')}}">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                              @error('email')
                            <div  class="text-danger   @error('email') invalid-feedback mt-0 @enderror">
                               {{ $message }}
                            </div> 
                            @enderror
                        </div>
                    </div>
                    <div class="form-group @error('telepon') mb-1 @enderror">
                        <div class="input-group ">
                            <input type="number" class="form-control @error('telepon') is-invalid @enderror" placeholder="Telepon" name="telepon" value="{{old('telepon')}}">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-phone"></span>
                                </div>
                            </div>
                           @error('telepon')
                            <div  class="text-danger   @error('telepon') invalid-feedback mt-0 @enderror">
                               {{ $message }}
                            </div> 
                            @enderror
                        </div>
                    </div>
                    <div class="form-group @error('password') mb-1 @enderror">
                        <div class="input-group ">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                             @error('password')
                            <div  class="text-danger   @error('password') invalid-feedback mt-0 @enderror">
                               {{ $message }}
                            </div> 
                            @enderror
                        </div>
                    </div>
                    <div class="form-group @error('password_ulang') mb-1 @enderror">
                        <div class="input-group ">
                            <input type="password" class="form-control @error('password_ulang') is-invalid @enderror" placeholder="ketik ulang password"
                                name="password_ulang">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                             @error('password_ulang')
                            <div  class="text-danger   @error('password_ulang') invalid-feedback mt-0 @enderror">
                               {{ $message }}
                            </div> 
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-8">
                            <div class="icheck-primary">
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Daftar</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                 <span class="text-sm">Sudah punya akun? <a href="/login" class="text-center">Login</a></span>
           
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>