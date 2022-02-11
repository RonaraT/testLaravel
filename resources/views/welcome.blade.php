<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="/css/style.css" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
				<form id="contactform" method="POST" class="validateform">
					{{ csrf_field() }}
				 
					<div id="sendmessage">
						Ваш заказ оформлен успешно!
					</div>
					<div id="senderror">
						При оформлении заказа произошла ошибка. Проверьте, все ли данные введены корректно</span>
					</div>
					<div class="row">
						<div class="col-lg-4 field">
							<label for="#name">ФИО*</label>
							<input type="text" name="name" id="name" required />
						</div>
						<div class="col-lg-4 field">
							<label for="#article">Артикул товара*</label>
							<input type="text" name="article" id="article" required />
						</div>
						<div class="col-lg-4 field">
							<label for="#manufacturer">Бренд товара*</label>
							<input type="text" name="manufacturer" id="manufacturer" required />
						</div>
						<div class="col-lg-12 margintop10 field">
							<label for="#message">Комментарий клиента*</label>
							<textarea rows="12" name="message" id="message" class="input-block-level" required></textarea>
							<p>
								<button class="btn btn-theme margintop10 pull-left" type="submit">Оформить</button>
								<span class="pull-right margintop20">* Заполните, пожалуйста, все обязательные поля!</span>
							</p>
						</div>
					</div>
				</form>
				
				<!-- 
                <div class="title m-b-md">
                    Laravel
                </div>

                <div class="links">
                    <a href="https://laravel.com/docs">Docs</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://blog.laravel.com">Blog</a>
                    <a href="https://nova.laravel.com">Nova</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div> -->
            </div>
        </div>
		
        <script src="/js/send.js"></script>
    </body>
</html>
