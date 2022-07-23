<!DOCTYPE html>
<html lang="en">
<head>
 
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SPK-APP SDN JURUMUDI 1</title>
</head>
<body class=" hold-transition sidebar-mini layout-fixed ">

<div class="wrapper" id="app">

 
                <navbar-component></navbar-component>
  
         <sidebar-component></sidebar-component>
          <input id="userlogin" type="hidden" value="{{  session('kode_user_login')[0]  }}">
        <router-view>
             
        </router-view>
       <footer-component></footer-component>
        <controlsidebar-component></controlsidebar-component>

 
       

      
       


 

    </div>
    <script src="{{ asset('js/app.js') }}"></script>

 
  



</body>



</html>