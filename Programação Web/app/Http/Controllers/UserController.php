<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    private $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = User::where('email', $credentials['email'])->first();
        if (auth()->attempt($credentials)){
            $request->session()->regenerate();
            if ($user->isAdmin == 1) {
                return redirect("dashboard");
            }
            return redirect("/");
        }

        return back()->withErrors([
            'email' => 'Email ou password incorretos',
            'password' => 'Email ou password incorretos',
        ]);
    }

    public function register(Request $request) {
        $incoming = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'nif' => 'required|digits:9|unique:users,nif',
            'rua' => 'required|string',
            'codigoPostal' => 'required|string',
            'porta' => 'required|string'
        ], [
            'email.unique' => 'Este email já está a ser utilizado.',
            'password.min' => 'A password deve ter pelo menos 8 caracteres.',
            'nif.unique' => 'Este NIF já está a ser utilizado.'
        ]);

        try {

            $incoming['password'] = Hash::make($incoming['password']);
            User::create($incoming);
            return redirect("auth/login")->with('success', 'Conta criada com sucesso!');
        } catch (\Exception $e) {

            return back()->withErrors([
                'error' => 'Registration failed. Please try again.'
            ])->withInput($request->except('password'));
        }
    }

    public function forgot(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'Este email não está registado.'
        ]);

        return redirect("/");
    }

    function removerPhoto()
    {
        $previousFilePath = public_path('images/user_images/' . $this->user->image);
        if (file_exists($previousFilePath) && $this->user->image != 'default.png') {
            unlink($previousFilePath);
        }
    }

    public function deletePhoto()
    {
        $this->removerPhoto();
        $this->user->image = 'default.png';
        $this->user->save();
        return redirect()->back()->with('success', 'Foto de perfil removida com sucesso!');
    }
    public function update(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'nif' => 'required|string|max:15',
            'rua' => 'nullable|string|max:255',
            'codigo_postal' => 'nullable|string|max:15',
            'porta' => 'nullable|string|max:10',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        if ($request->hasFile('profile_picture')) {
            $this->removerPhoto();
            $filename = $request->file('profile_picture')->getClientOriginalName();
            try {
                $folderPath = public_path('images/user_images/' . $this->user->name);
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0775, true);
                }
                $previousFilePath = public_path('images/user_images/' . $this->user->name . "/" . $this->user->image);
                if (!file_exists($previousFilePath)) {

                    $request->file('profile_picture')->move(public_path('images/user_images/' . $this->user->name), $filename);

                   $this->user->image = $this->user-> name . '/' . $filename;
                } else {
                    $this->user->image = $filename;
                }
            } catch (\Exception $e) {
                return back()->with('error', 'Falha no upload do ficheiro : ' . $e->getMessage());
            }

        }
        $this->user->email = $validated['email'];
        $this->user->nif = $validated['nif'];
        $this->user->rua = $validated['rua'] ?? $this->user->rua;
        $this->user->codigoPostal = $validated['codigo_postal'] ?? $this->user->codigoPostal;
        $this->user->porta = $validated['porta'] ?? $this->user->porta;
        $this->user->save();

        return redirect()->back()->with('success', 'Perfil atualizado com sucesso!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->flush();

        return redirect("/");
    }

    public function show()
    {
        return view('perfil');
    }
}
