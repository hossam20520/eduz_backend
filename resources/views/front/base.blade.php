<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chat</title>
    <link href="https://coopxl.com/assets/img/faviconn.png" rel="icon">
<link href="https://coopxl.com/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Source+Sans+Pro:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">

<link href="https://coopxl.com/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="https://coopxl.com/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
<link href="https://coopxl.com/assets/vendor/aos/aos.css" rel="stylesheet">
<link href="https://coopxl.com/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
<link href="https://coopxl.com/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
<link href="https://coopxl.com/assets/css/variables.css" rel="stylesheet">

<link href="https://coopxl.com/assets/css/main.min.css" rel="stylesheet">

<script src="https://www.gstatic.com/firebasejs/8.7.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.7.0/firebase-firestore.js"></script>


<script src="{{ asset('js/front/vue/vue.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vuetify/2.0.2/vuetify.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-i18n/8.26.0/vue-i18n.min.js"></script>

</head>
<body>
    

     @yield('content')


     @stack('scripts')
</body>
</html>