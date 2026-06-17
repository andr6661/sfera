<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход в панель управления | Сфера</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #23519D 0%, #2E7EB8 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Анимированный фон */
        body::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1%, transparent 1%);
            background-size: 50px 50px;
            animation: bgMove 20s linear infinite;
            opacity: 0.3;
        }

        @keyframes bgMove {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }

        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 450px;
            margin: 20px;
            animation: fadeInUp 0.6s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-card {
            background: white;
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
        }

        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #23519D, #2E7EB8);
            border-radius: 50%;
            box-shadow: 0 8px 20px rgba(35, 81, 157, 0.3);
        }

        .login-logo svg {
            width: 50px;
            height: 50px;
        }

        .login-header h1 {
            font-size: 28px;
            color: #1a1a2e;
            margin-bottom: 8px;
            font-family: "Comfortaa", sans-serif;
        }

        .login-header p {
            color: #666;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 500;
            color: #333;
        }

        .input-group {
            position: relative;
        }

        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 16px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-control:focus {
            outline: none;
            border-color: #23519D;
            box-shadow: 0 0 0 3px rgba(35, 81, 157, 0.1);
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #23519D, #2E7EB8);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(35, 81, 157, 0.3);
        }

        .error-message {
            background: #fee;
            border-left: 4px solid #e74c3c;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: #c0392b;
        }

        .error-message i {
            font-size: 18px;
        }

        .footer-links {
            text-align: center;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid #eee;
        }

        .footer-links a {
            color: #666;
            text-decoration: none;
            font-size: 13px;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: #23519D;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 30px 24px;
            }

            .login-header h1 {
                font-size: 24px;
            }

            .login-logo {
                width: 60px;
                height: 60px;
            }

            .login-logo svg {
                width: 35px;
                height: 35px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <div class="login-logo">
                <svg viewBox="0 0 140 128" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M130.583 88.1726C130.386 88.1923 130.484 87.936 130.524 87.8374C130.957 86.2995 131.647 84.7222 132.101 83.1449C142.038 48.3451 119.719 12.4806 84.2487 6.19102C51.0657 0.276039 19.1642 22.2206 13.3084 55.3445C6.09213 96.0987 39.9061 131.707 80.9166 126.876C81.2321 126.837 84.6825 126.206 84.6825 126.383C83.322 126.64 81.9419 126.916 80.5814 127.093C37.4218 132.712 1.73476 94.4425 10.6072 51.7561C15.5561 28.037 34.3657 8.95134 57.927 3.48984C85.4317 -2.87862 113.686 9.8583 127.231 34.366C136.32 50.7899 137.503 70.7037 130.563 88.1726H130.583Z" fill="white"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M101.324 0C84.111 39.7881 43.1399 63.724 0 59.2484C43.3371 59.2484 80.0099 36.9095 101.324 0Z" fill="white"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M139.14 52.1701C119.226 97.2225 72.5173 123.879 23.7188 118.418C71.7484 119.581 116.032 94.4425 139.14 52.1701Z" fill="white"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M129.085 17.0154C107.436 67.4308 55.6994 97.6957 1.24219 92.2145C55.8374 92.2145 102.388 63.2903 129.085 17.0154Z" fill="white"/>
                </svg>
            </div>
            <h1>Добро пожаловать</h1>
            <p>Войдите в панель управления</p>
        </div>

        @if ($errors->any())
            <div class="error-message">
                <i class="fas fa-exclamation-triangle"></i>
                <span>{{ $errors->first('name') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <div class="form-group">
                <label><i class="fas fa-user"></i> Логин</label>
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="name" class="form-control" placeholder="Введите логин" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label><i class="fas fa-lock"></i> Пароль</label>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" class="form-control" placeholder="Введите пароль" required>
                </div>
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i>
                Войти в систему
            </button>
        </form>

        <div class="footer-links">
            <a href="/">← Вернуться на сайт</a>
        </div>
    </div>
</div>
</body>
</html>
