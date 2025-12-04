<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SPARTIX</title>

    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #587d84, #20373f);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            display: flex;
            width: 75%;
            max-width: 1050px;
            background: rgba(255, 255, 255, 0.12);
            border-radius: 22px;
            overflow: hidden;
        }

        .left {
            flex: 1;
            background: rgba(255, 255, 255, 0.13);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 20px;
        }

        .left img {
            width: 250px;
            margin-bottom: 10px;
        }

        .right {
            flex: 1.2;
            background: rgba(255, 255, 255, 0.20);
            padding: 50px 45px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-radius: 0px 20px 20px 0px;
        }

        h2 {
            text-align: center;
            margin-bottom: 40px;
            font-weight: 600;
            color: #133c44;
        }

        input {
            width: 100%;
            padding: 14px;
            margin: 12px 0;
            border: none;
            border-bottom: 2px solid #000000ff;
            background: transparent;
            font-size: 15px;
            outline: none;
            color: #0e2a30;
        }

        .btn {
            width: 100%;
            margin-top: 22px;
            padding: 14px;
            background: linear-gradient(to right, #144f57, #2f7b83);
            color: white;
            font-size: 16px;
            font-weight: 600;
            border-radius: 30px;
            border: none;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover {
            opacity: 0.85;
        }

        .links {
            display: flex;
            justify-content: space-between;
            margin-top: 18px;
            font-size: 14px;
        }

        .links a {
            color: #0f3341;
            text-decoration: none;
        }

        .error {
            text-align: center;
            margin-top: 12px;
            color: red;
            font-size: 14px;
        }

        @media (max-width: 780px) {
            .container {
                flex-direction: column;
                width: 90%;
            }

            .right {
                border-radius: 0 0 15px 15px;
            }

            .left img {
                width: 180px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="left">
        <img src="{{ asset('spartix.png') }}" alt="logo">
    </div>

    
    <div class="right">
        <h2>Login</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <input type="email" name="email" placeholder="Email" required>

            <input type="password" name="password" placeholder="Password" required>

            <button class="btn">Login</button>

            <div class="links">
                <a href="/register">Create an account</a>
                <a href="#">Forgot password?</a>
            </div>

            @if($errors->any())
                <p class="error">{{ $errors->first() }}</p>
            @endif

        </form>
    </div>
</div>

</body>
</html>
