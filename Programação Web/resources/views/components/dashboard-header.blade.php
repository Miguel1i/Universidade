<header>
    <div class="contentor">
        <a href="/" class="logo-container">
            <img src="/images/medivitta-high-resolution-logo.png" alt="Medivitta Logo" id="logo">
        </a>

        <h1 class="header-title">Medicamentos</h1>

        @auth
        <nav class="user-section">
            <a href="/" class="
            home">Home</a>
            <div class="user-dropdown">
                <button class="user-name" onclick="toggleDropdown()" aria-haspopup="true" aria-expanded="false">
                    @if(Auth::user()->image)
                        <img src="images/user_images/{{ Auth::user()->image }}" alt="User Image" class="user-avatar">
                        {{ Auth::user()->name }}
                    @endif

                </button>
                <div class="dropdown-content" id="userDropdown">
                    <a href="/perfil">Perfil</a>
                    <a href="/auth/logout">Logout</a>
                </div>
            </div>
        </nav>
        @endauth
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
.home {
    text-decoration: none;
    color: black;
    font-weight: bold;
}

.home:hover{
    color: black;
}

.user-avatar {
    width: 2rem;
    height: 2rem;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 0.5rem;
}
.contentor {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.5% 2%;
    height: 60px;
    background-color: #ffffff;
    position: relative;
}

.header-title {
    margin: 0;
    font-size: 1.5rem;
    font-weight: bold;
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
}

.logo-container {
    display: flex;
    align-items: center;
}

#logo {
    width: 50px;
    height: 50px;
    border-radius: 100%;
}

.user-section {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.user-dropdown {
    position: relative;
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

.user-name:hover,
.user-name:focus {
    background-color: #f3f4f6;
}

.user-icon {
    width: 2rem;
    height: 2rem;
    margin-right: 0.5rem;
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

.header-separator {
    width: 100%;
    height: 1px;
    background-color: #E0E0E0;
    margin-bottom: 0%;
}
</style>

