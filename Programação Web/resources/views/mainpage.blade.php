@extends('layouts.main')

@section('title', 'Página Inicial')

@section('content')
    <div class="filter-container">
        <div class="filter-wrapper">
            <label for="priceRange" class="filter-label">Preço</label>
            <input type="range" id="priceRange" class="price-range" min="0" max="{{ $preco ?? '1000'}} " step="1" value="1000">
            <span id="priceDisplay" class="price-display">0€ - 1000€</span>
        </div>
    </div>

    @if(count($medicamentos) > 0)
        <div class="container">
            @foreach ($medicamentos as $medicamento)
                <x-medicine-card :medicamento="$medicamento" />
            @endforeach
        </div>
    @else
        <div class="cont2">
            <h2>Não foram encontrados medicamentos</h2>
        </div>
    @endif

    <div class="pagination-controls">
        @if(count($medicamentos) > 0)
            @if($page > 1)
                <a class="button" href="?page={{ $page - 1 }}&search={{ $search }}&price={{ request('preco', 1000) }}">Anterior</a>
            @endif

            @for($i = $start; $i <= $end; $i++)
                @if($i == $page)
                    <span class="button active">{{ $i }}</span>
                @else
                    <a class="button" href="?page={{ $i }}&search={{ $search }}&price={{ request('price', 1000) }}">{{ $i }}</a>
                @endif
            @endfor

            @if($hasMore)
                <a class="button" href="?page={{ $page + 1 }}&search={{ $search }}&price={{ request('price', 1000) }}">Avançar</a>
            @endif
        @endif

    </div>

    @if (session('success'))
        <div class="alerta" id="alerta">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alerta" id="alerta" style="background-color: red; color: white">{{ session('error') }}</div>
    @endif
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const priceRange = document.getElementById('priceRange');
        const priceDisplay = document.getElementById('priceDisplay');

        const urlParams = new URLSearchParams(window.location.search);
        const maxPrice = urlParams.get('price') || 1000;
        priceRange.value = maxPrice;
        priceDisplay.textContent = `0€ - ${maxPrice}€`;
        priceRange.addEventListener('input', function () {
            priceDisplay.textContent = `0€ - ${this.value}€`;
        });

        priceRange.addEventListener('change', function () {
            const selectedPrice = this.value;
            urlParams.set('price', selectedPrice);
            const newUrl = `${window.location.pathname}?${urlParams.toString()}`;
            window.location.href = newUrl;
        });

    });

    document.addEventListener("DOMContentLoaded", function () {
        const alerta = document.getElementById("alerta");
        if (alerta) {
            setTimeout(() => {
                alerta.style.opacity = '0';
                alerta.style.transform = 'translateY(-20px)';
                setTimeout(() => alerta.remove(), 300);
            }, 1500);
        }
    });

</script>

<style>
    html {
        scroll-behavior: smooth;
    }
    .filter-container {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.5rem;
        padding: 1rem;
        max-width: 1800px;
        margin: 0 auto 1rem;
        margin-right: 2%;
    }

    .filter-wrapper {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        position: relative;
    }

    .price-filter {
        flex-grow: 1;
        max-width: 400px;
    }

    .filter-label {
        font-weight: 500;
        color: #35a1a8;
        font-size: 0.9rem;
    }

    .price-range {
        -webkit-appearance: none;
        width: 100%;
        height: 2px;
        background: #e0e0e0;
        outline: none;
        transition: opacity 0.2s;
    }

    .price-range::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: #35a1a8;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
    }

    .price-range::-moz-range-thumb {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: #35a1a8;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
    }

    .price-range::-webkit-slider-thumb:hover,
    .price-range::-moz-range-thumb:hover {
        transform: scale(1.2);
    }

    .price-display {
        min-width: 80px;
        text-align: right;
        font-weight: 500;
        color: #35a1a8;
        font-size: 0.9rem;
    }

    .filter-select {
        appearance: none;
        -webkit-appearance: none;
        padding: 0.5rem 2rem 0.5rem 1rem;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        background-color: white;
        font-size: 0.9rem;
        color: #35a1a8;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .filter-icon {
        position: absolute;
        right: 0.5rem;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        width: 1.25rem;
        height: 1.25rem;
        color: #35a1a8;
    }

    .filter-select:hover, .filter-select:focus {
        border-color: #35a1a8;
        outline: none;
    }

    @media (max-width: 768px) {
        .filter-container {
            flex-direction: column;
            align-items: stretch;
        }

        .filter-wrapper, .price-filter {
            width: 100%;
            max-width: none;
        }
    }
    .container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(288px, 1fr));
        gap: 1rem;
        padding: 1rem;
        max-width: 1800px;
        margin: 0 auto;
        justify-items: center;
    }

    h2 {
        text-align: center;
        color: #808080;
    }

    .cont2 {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 15%;
    }

    .pagination-controls {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
        gap: 10px;
    }

    .button {
        display: flex;
        z-index: 1;
        overflow: hidden;
        text-decoration: none;
        font-family: sans-serif;
        font-weight: 600;
        font-size: 1em;
        padding: 0.75em 1em;
        color: rgba(53, 161, 168, 0.75);
        transition: 4s;
        margin: 0;
        position: relative;
        border-radius: 25%;
    }

    .button::before,
    .button::after {
        content: '';
        position: absolute;
        top: -1.5em;
        z-index: -1;
        width: 200%;
        aspect-ratio: 1;
        border-radius: 40%;
        background-color: rgba(53, 161, 168, 0.25);
        transition: 2s;
    }

    .button::before {
        left: -80%;
        transform: translate3d(0, 5em, 0) rotate(-340deg);
    }

    .button::after {
        right: -80%;
        transform: translate3d(0, 5em, 0) rotate(390deg);
    }

    .button:hover,
    .button:focus {
        color: white;
        cursor: pointer;
    }

    .button.active {
        color: rgba(53, 161, 168, 1);
    }

    .button:hover::before,
    .button:hover::after,
    .button:focus::before,
    .button:focus::after {
        transform: none;
        background-color: rgba(53, 161, 168, 0.75);
    }

    .alerta {
        position: fixed;
        top: 2rem;
        right: 2rem;
        transform: translateY(0);
        max-width: 300px;
        width: 90%;
        background-color: #e3f5f7;
        color: #149FA8;
        padding: 1rem 2rem;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: visibility 0.3s, opacity 0.3s, transform 0.3s;
        z-index: 1000;
    }

    @media (max-width: 768px) {
        .filter-container {
            flex-direction: column;
            align-items: stretch;
        }

        .filter-wrapper {
            width: 100%;
        }

        .filter-select, .price-range {
            width: 100%;
        }
    }
</style>
