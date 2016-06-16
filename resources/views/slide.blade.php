<!DOCTYPE html>
<html lang="en">
<head>
    <title>Circle Navigation Effect with CSS3</title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Circle Navigation Effect with CSS3" />
    <meta name="keywords" content="css3, circle, hover, navigation, effect, preview, thumbnails, images, slider, jquery, previous, next" />
    <meta name="author" content="Codrops" />
    <link rel="shortcut icon" href="../favicon.ico">
    <link rel="stylesheet" type="text/css" href="css/demo.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link href='http://fonts.googleapis.com/css?family=Rochester' rel='stylesheet' type='text/css' />
    <noscript>
        <style>
            .cn-images img{position: relative;display: block;border-bottom: 5px solid #d0ab47;}
            .cn-slideshow{height: auto;}
        </style>
    </noscript>
    <script id="barTmpl" type="text/x-jquery-tmpl">
            <div class="cn-bar">
                <div class="cn-nav">
					<a href="#" class="cn-nav-prev">
                        <span>Previous</span>
						<div style="background-image:url(${prevSource});"></div>
					</a>
					<a href="#" class="cn-nav-next">
                        <span>Next</span>
						<div style="background-image:url(${nextSource});"></div>
					</a>
                </div><!-- cn-nav -->
                <div class="cn-nav-content">
                    <div class="cn-nav-content-prev">
                        <span>Предыдущая картинка</span>
                        <h3>${prevTitle}</h3>
                    </div>

                    <div class="cn-nav-content-next">
                        <span>Следующяя картинка</span>
                        <h3>${nextTitle}</h3>
                    </div>
                </div><!-- cn-nav-content -->
            </div><!-- cn-bar -->
		</script>
</head>
<body class="body_slide">


    <div class="wrapper">
        <div id="cn-slideshow" class="cn-slideshow">
            <div class="cn-images">
                @foreach($slide_img as $img)
                    <img src="images/large/{{$img}}" alt="image01" title="Картинка" data-thumb="images/thumbs/{{$img}}" style="display:block;"/>
                @endforeach
            </div><!-- cn-images -->
        </div><!-- cn-slideshow -->
    </div>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.tmpl.min.js"></script>
<script type="text/javascript" src="js/jquery.slideshow.js"></script>
<script type="text/javascript">
    $(function() {
        $('#cn-slideshow').slideshow();
    });
</script>
</body>
</html>
