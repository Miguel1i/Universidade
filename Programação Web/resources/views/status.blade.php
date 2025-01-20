@extends('layouts.status')

@section('title', 'Estado do Pedido')

@section('body_class')
    {{ session('error') ? 'error-bg' : 'success-bg' }}
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-content">
                @if(session('error'))
                    <svg class="icon error-icon" xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                    <h1>Erro</h1>
                    <p>Erro ao realizar a compra.</p>
                @else
                    <svg class="icon success-icon" xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    <h1>Sucesso!</h1>
                    <p>Compra realizada com sucesso!</p>
                @endif
            </div>
            <div class="card-footer">
                <a href="/" class="button {{ session('error') ? 'error-button' : 'success-button' }}">Voltar</a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function setConfettiCanvasSize() {
            const canvas = document.getElementById('confetti-canvas');
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }

        window.addEventListener('resize', setConfettiCanvasSize);
        setConfettiCanvasSize();

        @if(!session('error'))
        const duration = 3 * 1000;
        const animationEnd = Date.now() + duration;
        const defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 0 };

        function randomInRange(min, max) {
            return Math.random() * (max - min) + min;
        }

        const interval = setInterval(function() {
            const timeLeft = animationEnd - Date.now();

            if (timeLeft <= 0) {
                return clearInterval(interval);
            }

            const particleCount = 50 * (timeLeft / duration);
            confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 } }));
            confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 } }));
        }, 250);
        @endif
    </script>
@endsection

