<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet"  href="/css/app.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>JAAW</title>
</head>
<body>
    
    @include('inc.navbar')

    <div class="container">
        @include('inc.messages')
    </div>
    @if(Request::is('/'))   
    @include('inc.searchbar')
    @endif
    <div class="container" style="margin-top: 50px;" >
         @if(Request::is('/'))   
         @include('inc.carousel')
         @endif
         
         <div class="row">
          
    
           <div class="col-md-8 col-lg-8" style="padding-top: 10px;"> 
                    @yield('content')
    </div>        
        </div> 
            </div> 
         @yield('categories')
            <footer id="footer" class="text-center" style= "margin-top: 45%;" >
                <p><b>Copyright 2018 &copy; JAAW</b></p>
            </footer>          
    <script src="{{ asset('js/app.js') }}" defer></script>

</body>
</html>