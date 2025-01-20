<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registar</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
        .error-message {
            color: #ff3333;
            font-size: 0.875rem;
            margin-top: 0.25rem;
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

        .short-inputs {
            display: flex;
            gap: 1rem;
        }

        .short-inputs .input-group {
            flex: 1;
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

        #have-account {
            margin-top: 1.5rem;
            font-size: 0.875rem;
            color: #4b5563;
            text-align: center;
        }

        #have-account a {
            color: #149FA8;
            text-decoration: none;
            font-weight: 600;
        }

        #have-account a:hover {
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
    </style>
</head>
<body>
<div class="container">
    <div class="left-column">
        <img src="/images/medivitta-high-resolution-logo.png" alt="Medivitta Logo">
    </div>
    <div class="right-column">
        <h2>Registar</h2>
        <form method="post" action="/auth/register">
            {{ csrf_field() }}

            <div class="input-group">
                <label for="name">Nome</label>
                <input type="text" id="name" name="name" placeholder="Digite seu nome" value="{{ old('name') }}" required>
                @error('name')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Digite seu email" value="{{ old('email') }}" required>
                @error('email')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-group">
                <label for="password">Senha</label>
                <input type="password" id="password" name="password" placeholder="Digite sua senha" required>
                @error('password')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-group">
                <label for="nif">NIF</label>
                <input type="text" id="nif" name="nif" placeholder="Digite seu NIF" pattern="\d{9}" maxlength="9" value="{{ old('nif') }}" required>
                @error('nif')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-group">
                <label for="rua">Rua</label>
                <input type="text" id="rua" name="rua" placeholder="Digite sua rua" value="{{ old('rua') }}" required>
                @error('rua')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="short-inputs">
                <div class="input-group">
                    <label for="codigoPostal">Código Postal</label>
                    <input type="text" id="codigoPostal" name="codigoPostal" placeholder="Código Postal" pattern="^\s*?\d{5}(?:[-\s]\d{4})?\s*?$" value="{{ old('codigoPostal') }}" required>
                    @error('codigoPostal')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="input-group">
                    <label for="porta">Porta</label>
                    <input type="text" id="porta" name="porta" placeholder="Porta" value="{{ old('porta') }}" required>
                    @error('porta')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit">Criar</button>
        </form>
        <p id="have-account">Já tens uma conta? <a href="/auth/login">Login</a></p>
    </div>
</div>
</body>
</html>
