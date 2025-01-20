<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
            color: #333;
            line-height: 1.5;
        }

        .container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            height: 100vh;
        }

        .left-column {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .left-column img {
            max-width: 70%;
            height: auto;
        }

        .right-column {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .right-column h2 {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            color: #149FA8;
            text-align: center;
            font-weight: 600;
        }

        form {
            width: 100%;
            max-width: 400px;
        }

        .input-group {
            margin-bottom: 1.25rem;
            position: relative;
        }

        .input-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            color: #4b5563;
            font-weight: 500;
        }

        .input-group input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-size: 1rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            font-family: 'Inter', sans-serif;
        }

        .input-group input:focus {
            outline: none;
            border-color: #149FA8;
            box-shadow: 0 0 0 3px rgba(20, 159, 168, 0.1);
        }

        .error-message {
            color: #ff3333;
            font-size: 0.875rem;
            margin-top: 0.2rem;
        }

        button[type="submit"] {
            width: 100%;
            padding: 0.75rem 1rem;
            background-color: #149FA8;
            color: white;
            border: none;
            border-radius: 0.375rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.15s ease-in-out;
            font-family: 'Inter', sans-serif;
        }

        button[type="submit"]:hover {
            background-color: #0f7d86;
        }

        #no-account {
            margin-top: 1.5rem;
            font-size: 0.875rem;
            color: #4b5563;
            text-align: center;
        }

        #no-account a {
            color: #149FA8;
            text-decoration: none;
            font-weight: 600;
        }

        #no-account a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
            }

            .left-column {
                display: none;
            }

            .right-column h2 {
                font-size: 2rem;
            }
        }
        .password-container {
            position: relative;
        }

        .input-group .toggle-password {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #9ca3af;
        }

        .input-group .toggle-password:hover {
            color: #6b7280;
        }


        #forgot {
            margin-top: 1.5rem;
            font-size: 0.875rem;
            color: #4b5563;
            text-align: right;
            margin-top: 10px;
        }

        #forgot a {
            color: #149FA8;
            text-decoration: none;
            font-weight: 600;
        }

        #forgot a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="left-column">
        <img src="/images/medivitta-high-resolution-logo.png" alt="Medivitta Logo">
    </div>
    <div class="right-column">
        <h2>Recuperar password</h2>
        <form method="post" action="/forgot">
            {{ csrf_field()  }}
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Introduza o seu email" required>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit">Enviar</button>
        </form>
        <p id="no-account">Já tens conta? <a href="/auth/login">Login</a></p>
    </div>
</div>
</body>
</html>

