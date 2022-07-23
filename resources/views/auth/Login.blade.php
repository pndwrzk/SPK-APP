
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SPK APP | Log in</title>

  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="text-center " >
 <h3 class="font-weight-bold"> SPK-APP </h3>
  </div>
    <div class="text-center font-weight-bold" style="margin-top: -10px;">
<h3 class="font-weight-bold">SDN JURUMUDI 1 </h3>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Login</p>

      {{ session()->get('user'); }}

       @if(session('success'))
                <div class="alert alert-success mb-3 alert-dismissible fade show" role="alert">
                     {{ session('success') }}
                   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
        
                @endif

                @if(session('failed'))
               <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                     {{ session('failed') }}
                   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
                @endif

      <form action="/login" method="post">
        @csrf
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

        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
             
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Masuk</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <span class="text-sm">Belum punya akun? <a href="/registrasi" class="text-center">Registrasi</a></span>
      

     
      <!-- /.social-auth-links -->

      
     
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

 <script src="{{ asset('js/app.js') }}"></script>
</body>


</html>
