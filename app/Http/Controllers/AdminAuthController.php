<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Vérification dans la base de données
        $admin = Admin::where('email', $credentials['email'])->first();

        if ($admin && Hash::check($credentials['password'], $admin->password)) {
            session(['admin_logged_in' => true, 'admin_email' => $admin->email, 'admin_id' => $admin->id]);
            return redirect()->route('dashboard');
        }

        // Pour compatibilité, maintien des identifiants par défaut
        $adminEmail = 'admin@govoyage.com';
        $adminPassword = 'admin123';

        if ($credentials['email'] === $adminEmail && $credentials['password'] === $adminPassword) {
            session(['admin_logged_in' => true, 'admin_email' => $adminEmail]);
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Les identifiants sont incorrects.',
        ]);
    }

    public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_email', 'admin_id']);
        return redirect()->route('admin.login');
    }

    public function profile()
    {
        $adminId = session('admin_id');
        $adminEmail = session('admin_email', 'admin@xairlines.com');
        
        // Récupérer l'admin connecté si disponible
        $currentAdmin = null;
        if ($adminId) {
            $currentAdmin = Admin::find($adminId);
        }
        
        $admins = Admin::all();
        return view('admin.profile', compact('adminEmail', 'admins', 'currentAdmin'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'email' => 'required|email',
            'password' => 'nullable|min:6|confirmed',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $adminEmail = session('admin_email', 'admin@xairlines.com');
        
        // Vérifier si c'est un admin en base de données
        $admin = Admin::where('email', $adminEmail)->first();
        
        if ($admin) {
            // Vérification du mot de passe actuel dans la base de données
            if (!Hash::check($request->current_password, $admin->password)) {
                return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
            }
            
            // Gestion de la photo de profil
            if ($request->hasFile('profile_photo')) {
                // Supprimer l'ancienne photo si elle existe
                if ($admin->profile_photo) {
                    $oldPhotoPath = public_path('storage/' . $admin->profile_photo);
                    if (file_exists($oldPhotoPath)) {
                        unlink($oldPhotoPath);
                    }
                }
                $admin->profile_photo = $request->file('profile_photo')->store('profile_photos', 'public');
            }
            
            // Mise à jour de l'email dans la base de données
            $admin->email = $request->email;
            if ($request->password) {
                $admin->password = Hash::make($request->password);
            }
            $admin->save();
            
            // Mise à jour de la session
            session(['admin_email' => $request->email]);
        } else {
            // Pour le compte par défaut
            $adminPassword = 'admin123';
            if ($request->current_password !== $adminPassword) {
                return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
            }
            
            // Gestion de la photo de profil
            $profilePhotoPath = null;
            if ($request->hasFile('profile_photo')) {
                $profilePhotoPath = $request->file('profile_photo')->store('profile_photos', 'public');
            }
            
            // Créer le compte par défaut dans la base de données
            Admin::create([
                'name' => 'Admin Principal',
                'email' => $request->email,
                'password' => Hash::make($request->password ?: $adminPassword),
                'profile_photo' => $profilePhotoPath,
            ]);
            
            session(['admin_email' => $request->email]);
        }

        return back()->with('success', 'Profil mis à jour avec succès.');
    }

    public function addAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:6|confirmed',
            'is_deletable' => 'boolean',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $profilePhotoPath = null;
        if ($request->hasFile('profile_photo')) {
            $profilePhotoPath = $request->file('profile_photo')->store('profile_photos', 'public');
        }

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_deletable' => $request->boolean('is_deletable'),
            'profile_photo' => $profilePhotoPath,
        ]);

        return back()->with('success', 'Nouvel administrateur ajouté avec succès.');
    }

    public function deleteAdmin($id)
    {
        $admin = Admin::find($id);
        
        if (!$admin) {
            return back()->with('error', 'Administrateur non trouvé.');
        }

        // Empêcher la suppression du premier admin, de soi-même, ou des comptes non supprimables
        $adminId = session('admin_id');
        $adminEmail = session('admin_email', 'admin@xairlines.com');
        
        if ($admin->id === 1 || 
            ($adminId && $admin->id === $adminId) || 
            $admin->email === $adminEmail ||
            !$admin->is_deletable) {
            return back()->with('error', 'Vous ne pouvez pas supprimer ce compte.');
        }

        $admin->delete();
        return back()->with('success', 'Administrateur supprimé avec succès.');
    }
}
