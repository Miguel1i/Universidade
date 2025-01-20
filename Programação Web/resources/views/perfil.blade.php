<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        :root {
            --primary-color: #149FA8;
            --primary-hover: #0D8A92;
            --gray-50: #F9FAFB;
            --gray-100: #F3F4F6;
            --gray-200: #E5E7EB;
            --gray-300: #D1D5DB;
            --gray-400: #9CA3AF;
            --gray-500: #6B7280;
            --gray-600: #4B5563;
            --gray-700: #374151;
            --gray-800: #1F2937;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: system-ui, -apple-system, sans-serif;
            background-color: var(--gray-50);
            color: var(--gray-800);
            line-height: 1.5;
        }

        .page-container {
            min-height: 100vh;
            padding: 2rem 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05),
            0 10px 15px -3px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 900px;
            padding: 2rem;
        }

        .card-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .card-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--gray-800);
        }

        .form-layout {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        @media (min-width: 768px) {
            .form-layout {
                flex-direction: row;
            }
        }

        .profile-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        @media (min-width: 768px) {
            .profile-section {
                width: 33%;
            }
        }

        .profile-pic-container {
            position: relative;
            width: 180px;
            height: 180px;
        }

        .profile-pic {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--primary-color);
            background-color: var(--gray-100);
        }

        .profile-pic-label {
            position: absolute;
            bottom: 0.5rem;
            right: 0.5rem;
            background-color: var(--primary-color);
            color: white;
            width: 2.5rem;
            height: 2.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .profile-pic-label:hover {
            background-color: var(--primary-hover);
            transform: scale(1.05);
        }

        .profile-pic-input {
            display: none;
        }

        .upload-hint {
            font-size: 0.875rem;
            color: var(--gray-500);
            text-align: center;
        }

        .form-content {
            flex-grow: 1;
            max-width: 600px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 2rem;
        }

        .form-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .input-grid {
            display: grid;
            gap: 1rem;
            grid-template-columns: 1fr;
        }

        @media (min-width: 640px) {
            .input-grid {
                grid-template-columns: 1fr;
            }
        }

        .input-container {
            position: relative;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 1rem;
            transform: translateY(-50%);
            color: var(--gray-400);
            pointer-events: none;
            width: 1.25rem;
            height: 1.25rem;
        }

        .input-field {
            width: 100%;
            padding: .75rem 0.5rem 0.75rem 2.75rem;
            border: 1px solid var(--gray-300);
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.2s ease;
            background-color: white;
        }

        .input-field:hover {
            border-color: var(--gray-400);
        }

        .input-field:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(20, 159, 168, 0.1);
        }

        .submit-button {
            width: 100%;
            background-color: var(--primary-color);
            color: white;
            padding: 0.875rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 1rem;
        }

        .submit-button:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
        }

        .submit-button:active {
            transform: translateY(0);
        }

        .profile-pic-container {
            position: relative;
            width: 180px;
            height: 180px;
        }

        .profile-pic {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--primary-color);
            background-color: var(--gray-100);
        }

        .profile-pic-label {
            position: absolute;
            bottom: 0.5rem;
            right: 0.5rem;
            background-color: var(--primary-color);
            color: white;
            width: 2.5rem;
            height: 2.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .profile-pic-label:hover {
            background-color: var(--primary-hover);
            transform: scale(1.05);
        }

        .profile-pic-container {
            position: relative;
        }
        .delete-photo-btn {
            position: relative;
            top: 70px;
            right: -140px;
            background-color: rgba(0,0,0,0.7);
            color: white;
            border: none;
            width: 2rem;
            height: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.2s ease;
            z-index: 10;
        }
        .alerta {
            flex: 1;
            flex-direction: row;
            position: fixed;
            top: 2rem;
            right: 2rem;
            transform: translateY(0);
            max-width: 500px;
            width: 95%;
            background-color: #e3f5f7;
            color: #149FA8;
            padding: 1rem 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: visibility 0.3s, opacity 0.3s, transform 0.3s;
            z-index: 1000;

        }

        .delete-photo-btn:hover {
            background-color: #e43e3e;
            transform: scale(1.1);
        }

        .profile-pic-input {
            display: none;
        }

        .button-group {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
            justify-content: center;
        }

        .nav-button {
            padding: 0.5rem 1rem;
            background-color: transparent;
            color: var(--gray-600);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            text-align: center;
            transition: all 0.2s ease;
            border: 1px solid var(--gray-300);
            border-radius: 0.25rem;
            cursor: pointer;
        }

        .nav-button:hover {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .logout-button {
            color: #ff4d4f;
            border-color: #ff4d4f;
        }

        .logout-button:hover {
            color: #e43e3e;
            border-color: #e43e3e;
        }
    </style>
</head>
<body>
<div class="page-container">
    <div class="card">
        <div class="card-header">


            @if(Auth::user()->image != 'default.png')
                <form action="/perfil/delete_foto" method="post">
                    @csrf
                    <button type="submit" id="delete-photo-btn" class="delete-photo-btn" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </form>
             </div>
            @endif



        <form action="/perfil/update" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-layout">

                <div class="profile-pic-container">
                    <img src="images/user_images/{{Auth::user()->image  }}" alt="Profile picture" id="profile-pic" class="profile-pic">
                    <label for="profile-pic-input" class="profile-pic-label">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"></path>
                            <circle cx="12" cy="13" r="3"></circle>
                        </svg>
                    </label>
                    <input type="file" id="profile-pic-input" name="profile_picture" accept="image/*" class="profile-pic-input">



                    <div class="button-group">
                        <a href="/" class="nav-button" title="Home">
                            Home
                        </a>
                        <a href="/auth/logout" class="nav-button logout-button" title="Logout">
                            Logout
                        </a>
                    </div>
                </div>


                <div class="form-content">
                    <div class="form-group">
                        <h2 class="form-title">Informação pessoal</h2>
                        <div class="input-grid">
                            <div class="input-container">
                                <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                                <input type="email" name="email" placeholder="Email" class="input-field" value="{{ Auth::user()->email }}">
                            </div>
                            <div class="input-container">
                                <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                    <line x1="1" y1="10" x2="23" y2="10"></line>
                                </svg>
                                <input type="text" name="nif" placeholder="NIF" maxlength="9" class="input-field" value="{{ Auth::user()->nif }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <h2 class="form-title">Morada</h2>
                        <div class="input-grid">
                            <div class="input-container">
                                <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <input type="text" name="rua" placeholder="Street" class="input-field" value="{{ Auth::user()->rua }}">
                            </div>
                            <div class="input-container">
                                <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="2" width="20" height="20" rx="2" ry="2"></rect>
                                    <path d="M7 12h10"></path>
                                    <path d="M12 7v10"></path>
                                </svg>
                                <input type="text" name="codigo_postal" placeholder="Postal Code" maxlength="8" class="input-field" value="{{ Auth::user()->codigoPostal }}">
                            </div>
                            <div class="input-container">
                                <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                                <input type="text" name="porta" placeholder="Door Number" class="input-field" value="{{ Auth::user()->porta }}">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="submit-button">Guardar alterações</button>
                </div>
            </div>
        </form>
        @if (session('success'))
            <div class="alerta" id="alerta">{{ session('success') }}</div>
        @endif
    </div>
</div>

<script>
    document.getElementById('profile-pic-input').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profile-pic').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
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
</body>
</html>
