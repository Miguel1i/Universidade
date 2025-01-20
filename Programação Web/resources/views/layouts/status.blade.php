<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .success-bg {
            background: linear-gradient(to bottom, #e6f7e6, #c8e6c9);
        }

        .error-bg {
            background: linear-gradient(to bottom, #ffebee, #ffcdd2);
        }

        .container {
            padding: 1rem;
            width: 100%;
            max-width: 400px;
        }

        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-content {
            padding: 2rem;
            text-align: center;
        }

        .icon {
            width: 64px;
            height: 64px;
            margin-bottom: 1rem;
        }

        .success-icon {
            color: #4caf50;
        }

        .error-icon {
            color: #f44336;
        }

        h1 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #333;
        }

        p {
            color: #666;
            margin-bottom: 1rem;
        }

        .card-footer {
            padding: 1rem;
            background-color: #f5f5f5;
            text-align: center;
        }

        .button {
            display: inline-block;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .success-button {
            background-color: #4caf50;
        }

        .success-button:hover {
            background-color: #45a049;
        }

        .error-button {
            background-color: #f44336;
        }

        .error-button:hover {
            background-color: #d32f2f;
        }

        #confetti-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1000;
        }

        @media (max-width: 480px) {
            .container {
                padding: 0.5rem;
            }

            .card-content {
                padding: 1.5rem;
            }
        }
    </style>
    @yield('extra_styles')
</head>
<body class="@yield('body_class')">
<canvas id="confetti-canvas"></canvas>
<main>
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
@yield('scripts')
</body>
</html>

