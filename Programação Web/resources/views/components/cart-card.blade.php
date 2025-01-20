
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


<div class="card">
    <div class="row">
        <div class="col-md-8 cart">
            <div class="title">
                <div class="row">
                    <div class="col"><h4><b>Carrinho</b></h4></div>
                    <div class="col align-self-center text-right text-muted">{{count($items)}} itens</div>
                </div>
            </div>
            @foreach($items as $item)
                <div class="row border-top border-bottom">
                    <div class="row main align-items-center">
                        <div class="col-2"><img class="img-fluid" src="/images/{{$item['medicamento']->imagem}}"></div>
                        <div class="col">
                            <div>{{$item['medicamento']->nome}}</div>
                            <div class="row text-muted" style="font-size: small">&euro; {{$item['medicamento']->preco}} / unidade</div>
                            <div class="row"></div>
                        </div>
                        <div class="col">
                            <form action="{{ route('carrinho.update') }}" method="POST" class="d-flex align-items-center">
                                @csrf
                                <input type="hidden" name="medicamento_referencia" value="{{ $item['medicamento']->referencia }}">

                                <button type="submit" name="action" value="decrease" class="increaseordecrease">
                                    <i class="fas fa-minus"></i>
                                </button>

                                <input type="number" name="quantidade" value="{{ $item['quantidade'] }}"
                                       class="form-control mx-2 text-center" style="width: 60px;" min="1">

                                <button type="submit" name="action" value="increase" class="increaseordecrease">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </form>

                        </div>
                        <form action={{route("carrinho.remove")}} method="POST" class="col">
                            <input type="hidden" name="medicamento_referencia" value="{{ $item['medicamento']->referencia }}">
                            @csrf &euro; {{$item['quantidade'] * $item['medicamento']->preco}}
                            <button type="submit" class="close">&#10005;</button>
                        </form>
                    </div>
                </div>
            @endforeach
            <div class="back-to-shop"><a href="/">&leftarrow;</a><span>Voltar à pagina inicial</span></div>
        </div>
        <div class="col-md-4 summary">
            <img src="/images/medivitta-high-resolution-logo-black-transparent.png" style="transform: scale(0.5)" class="img-fluid">
            <div><h5><b>Resumo</b></h5></div>
            <hr>
            <div class="row">
                <div class="col" style="padding-left:0;">ITENS {{count($items)}}</div>
                <div class="col text-right">&euro; {{$total}}</div>
            </div>
            <form>
                <p>Taxa de Envio</p>
                <select><option class="text-muted">CTT Express - &euro;5.00</option></select>
                <p>Código promocional</p>
                <input type="text" id="code" placeholder="Introduza o código">
            </form>
            <div class="row" style="padding: 2vh 0;">
                <div class="col" style="color: rgba(0, 0, 0, 0.5)">Subtotal</div>
                <div class="col text-right" style="color: rgba(0, 0, 0, 0.5)">&euro; {{$total}}</div>
            </div>
            <div class="row" style="padding: 1vh 0;">
                <div class="col" style="color: rgba(0, 0, 0, 0.5)">Taxa de envio</div>
                <div class="col text-right" style="color: rgba(0, 0, 0, 0.5)">&euro; {{5}}</div>
            </div>
            <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
                <div class="col">TOTAL</div>
                <div class="col text-right">&euro; {{$total + 5}}</div>
            </div>
            @if(count($items) != 0)
                <a href="checkout" class="btn">CHECKOUT</a>
            @else
                <h1 class="btn" style="text-transform: uppercase">Adicione items ao carrinho</h1>
            @endif
        </div>
    </div>
</div>

@if (session('error'))
    <div class="alerta" id="alerta" style="background-color: red; color: white">{{ session('error') }}</div>
@endif


<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('input[name="quantidade"]').forEach(input => {
            input.addEventListener('keypress', (event) => {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    input.closest('form').submit();
                }
            });
        });
    });


    document.addEventListener("DOMContentLoaded", function () {
        const alerta = document.getElementById("alerta");
        if (alerta) {
            setTimeout(() => {
                alerta.style.opacity = '0';
                alerta.style.transform = 'translateY(-20px)';
                setTimeout(() => alerta.remove(), 300);
            }, 1500);}
    });
</script>

<style>
    body {
        background: white;
        min-height: 100vh;
        vertical-align: middle;
        display: flex;
        font-family: sans-serif;
        font-size: 1rem;
        font-weight: bold;
        padding: 2% 2%;
    }

    .card {
        margin: auto;
        max-width: 1200px;
        width: 95%;
        box-shadow: 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        border-radius: 1rem;
        border: transparent;
    }
    .cart {
        background-color: white;
        padding: 6vh 6vh;
        border-bottom-left-radius: 1rem;
        border-top-left-radius: 1rem;
    }
    @media (max-width: 767px) {
        .cart {
            padding: 6vh;
            border-bottom-left-radius: unset;
            border-top-right-radius: 1rem;
        }
    }
    .summary {
        background-color: #f7f7f7;
        border-top-right-radius: 1rem;
        border-bottom-right-radius: 1rem;
        padding: 6vh;
        color: rgb(65, 65, 65);
    }
    @media (max-width: 767px) {
        .summary {
            border-top-right-radius: unset;
            border-bottom-left-radius: 1rem;
        }
    }
    .title b {
        font-size: 2rem;
    }
    .main {
        margin: 0;
        padding: 3vh 0;
        width: 100%;
    }
    .row {
        margin: 0;
    }
    .col-2 img {
        width: 5rem;
    }
    .col-2, .col {
        padding: 0 2vh;
    }
    a {
        padding: 0 2vh;
        font-size: 1.2rem;
    }
    .close {
        font-size: 1rem;
    }
    h5 {
        font-size: 1.5rem;
        margin-top: 1vh;
    }
    hr {
        margin-top: 1.5rem;
    }
    form {
        padding: 3vh 0;
    }
    select, input[type="text"] {
        font-size: 1rem;
        padding: 2vh;
        margin-bottom: 5vh;
        outline: none;
        width: 100%;
        background-color: rgb(247, 247, 247);
    }
    select {
        border: 1px solid rgba(0, 0, 0, 0.137);
    }
    input[type="text"] {
        border: 1px solid rgba(0, 0, 0, 0.137);
    }
    input[type="text"]:focus::-webkit-input-placeholder {
        color: transparent;
    }
    .btn {
        background-color: #149FA8;
        color: white;
        width: 100%;
        font-size: 1rem;
        margin-top: 5vh;
        padding: 2vh;
        border-radius: 0.5rem;
    }
    .btn:focus {
        box-shadow: none;
        outline: none;
        color: white;
        transition: none;
    }
    .btn:hover {
        color: white;
    }
    a {
        color: black;
    }
    a:hover {
        color: black;
        text-decoration: none;
    }
    .back-to-shop {
        margin-top: 6vh;
    }
    #code {
        background-image: linear-gradient(to left, rgba(255, 255, 255, 0.253), rgba(255, 255, 255, 0.185)),
        url("https://img.icons8.com/small/16/000000/long-arrow-right.png");
        background-repeat: no-repeat;
        background-position-x: 95%;
        background-position-y: center;
    }
    ::-webkit-scrollbar {
        display: none;
    }

    .increaseordecrease {
        background-color: #149FA8;
        color: white;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        font-size: 1rem;
        cursor: pointer;
    }

    button:focus {
        outline: none;
    }

    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
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



    @media (max-width: 600px) {
        .alerta {
            top: 1rem;
            right: 1rem;
            padding: 0.8rem 1.5rem;
            font-size: 0.875rem;
        }
    }


</style>

