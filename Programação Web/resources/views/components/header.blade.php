<header>
    <div class="contentor">
        <a href="/" class="logo-container">
            <img src="/images/medivitta-high-resolution-logo.png" alt="Medivitta Logo" id="logo">
        </a>

        <div class="search-container">
            <form action="/medicamentos" method="GET">
                {{csrf_field()}}
                <input id="search-bar" type="search" name="search" placeholder="Pesquisar" value="@isset($search){{ $search }}@endisset">
                <img src="/images/search-icon.svg" alt="Search" class="search-icon">
            </form>
        </div>
        <div class="nav-section">
            @guest
                <span class="login"><a href="auth/login">Login</a></span>
            @endguest
            @auth
                <nav>
                    <div class="user-dropdown">
                        <button class="user-name" onclick="toggleDropdown()" aria-haspopup="true" aria-expanded="false">
                            @if(Auth::user()->image)
                                <img src="{{ asset('images/user_images/' . Auth::user()->image) }}" alt="User Image" class="user-avatar">

                                {{ Auth::user()->name }}
                            @endif
                        </button>
                        <div class="dropdown-content" id="userDropdown">
                            <a href="/perfil">Perfil</a>
                            <a href="/auth/logout">Logout</a>
                        </div>
                    </div>
                </nav>
                    <a href="{{ route('carrinho.index') }}" class="cart-link">
                        <img src="{{ asset('images/shopping-cart.png') }}" width="25px">

                    </a>
            @endauth

        </div>
    </div>
    <div class="header-separator"></div>
</header>


<script>
    function toggleDropdown() {
        var dropdown = document.getElementById("userDropdown");
        dropdown.classList.toggle("show");
        var userNameElement = document.querySelector(".user-name");
        var isExpanded = userNameElement.getAttribute("aria-expanded") === "true";
        userNameElement.setAttribute("aria-expanded", !isExpanded);
    }

    document.addEventListener('click', function(event) {
        var dropdown = document.getElementById("userDropdown");
        var userNameElement = document.querySelector(".user-name");
        if (!userNameElement.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.classList.remove("show");
            userNameElement.setAttribute("aria-expanded", "false");
        }
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            var dropdown = document.getElementById("userDropdown");
            var userNameElement = document.querySelector(".user-name");
            dropdown.classList.remove("show");
            userNameElement.setAttribute("aria-expanded", "false");
        }
    });
</script>

<style>
    body {
        margin: 0;
        font-family: 'Inter', sans-serif;
    }

    .header-separator {
        width: 100%;
        height: 1px;
        background-color: #E0E0E0;
        margin-bottom: 2%;
    }

    .contentor {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.5% 2%;
        gap: 1rem;
        flex-wrap: nowrap;
    }

    .logo-container {
        flex-shrink: 0;
        flex-basis: 50px;
    }

    #logo {
        width: 50px;
        height: auto;
        border-radius: 100%;
    }

    .search-container {
        position: relative;
        display: flex;
        align-items: center;
        flex-grow: 1;
        max-width: 400px;
        left: 7%;
    }

    #search-bar {
        width: 100%;
        height: 50px;
        padding: 10px 40px 10px 20px;
        border-radius: 30px;
        border: 1px solid #ccc;
        font-size: 16px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        box-sizing: border-box;
    }

    .search-icon {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        width: 35px;
        height: 35px;
        color: white;
        cursor: pointer;
    }

    .nav-section {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-shrink: 0;
        flex-basis: 200px;
        justify-content: flex-end;
    }

    .login {
        margin-right: 1rem;
    }

    .user-dropdown {
        position: relative;
    }
    .user-avatar {
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 0.5rem;
    }



    .user-name {
        display: flex;
        align-items: center;
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 9999px;
        transition: background-color 0.2s;
        background-color: transparent;
        border: none;
    }

    .user-name:hover, .user-name:focus {
        background-color: #f3f4f6;
    }



    .dropdown-content {
        visibility: hidden;
        opacity: 0;
        position: absolute;
        right: 0;
        top: calc(100% + 0.5rem);
        background-color: #ffffff;
        min-width: 200px;
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        border-radius: 0.5rem;
        transform: translateY(-10px);
        transition: opacity 0.2s ease-in-out, transform 0.2s ease-in-out;
        z-index: 1;
    }

    .show {
        visibility: visible;
        opacity: 1;
        transform: translateY(0);
    }

    .dropdown-content a {
        color: #374151;
        padding: 0.75rem 1rem;
        display: block;
        font-size: 0.875rem;
        transition: background-color 0.2s ease-in-out;
    }

    .dropdown-content a:hover {
        background-color: #f3f4f6;
    }

    .cart-link {
        display: flex;
        align-items: center;
        color: #374151;
        text-decoration: none;
    }

    .cart-link:hover {
        color: #1f2937;
    }

    .cart-icon {
        width: 1.5rem;
        height: 1.5rem;
    }

    @media (max-width: 768px) {
        .contentor {
            flex-direction: column;
            align-items: flex-start;
        }
        .search-container {
            width: 100%;
            margin: 1rem 0;
        }
        .nav-section {
            width: 100%;
            justify-content: flex-end;
        }
    }

    a {
        text-decoration: none;
        color: #000;
    }
    form {
        width: 100%;
    }

    input[type=search]::-ms-clear { display: none; width : 0; height: 0; }
    input[type=search]::-ms-reveal { display: none; width : 0; height: 0; }
    input[type="search"]::-webkit-search-decoration,
    input[type="search"]::-webkit-search-cancel-button,
    input[type="search"]::-webkit-search-results-button,
    input[type="search"]::-webkit-search-results-decoration { display: none; }

</style>
