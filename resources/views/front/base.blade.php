<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chat</title>
 

{{-- <link rel="preconnect" href="https://fonts.googleapis.com"> --}}
{{-- <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> --}}
{{-- <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Source+Sans+Pro:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet"> --}}

<link href="{{ asset('css/front/bootstrap.min.css')}}" rel="stylesheet">
{{-- <link href="{{ asset('css/front/bootstrap-icons.css')}}" rel="stylesheet"> --}}
{{-- <link href="{{ asset('css/front/aos.css')}}" rel="stylesheet"> --}}
{{-- <link href="{{ asset('css/front/glightbox.min.css')}}" rel="stylesheet"> --}}
{{-- <link href="{{ asset('css/front/swiper-bundle.min.css')}}" rel="stylesheet"> --}}
 

<link href="{{ asset('css/front/main.min.css')}}" rel="stylesheet">

<script src="https://www.gstatic.com/firebasejs/8.7.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.7.0/firebase-firestore.js"></script>


<script src="{{ asset('js/front/vue/vue.js') }}"></script>
 
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-i18n/8.26.0/vue-i18n.min.js"></script>
 



   <style>
#loading {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height:100%;
    background-color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
   
   
  }
  
  #loading.fade-in {
    display: flex;
    justify-content: center;
    align-items: center;
    opacity: 1;
  }
  #loading img {
    max-width: 100%;
    max-height: 100%;
  }
   
      </style>
</head>
<body>
    
    <div id="loading">
        <img src="https://eduz-app.com/images/77942277logo.png" alt="Loading" />
      </div>
     @yield('content')


     @stack('scripts')



     <script>
        // Get the loading element by ID
        var loadingElement = document.getElementById('loading');
        
        // Set the display property to 'none'
        // loadingElement.style.display = 'none';

        setTimeout(function() {
  loadingElement.style.display = 'none';
}, 1000);
        </script>
</body>
</html>