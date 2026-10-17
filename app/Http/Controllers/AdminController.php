<?php

namespace App\Http\Controllers;

use App\Models\{Reservation, EspaceCoworking, Utilisateur, Paiement, CodePromo};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AdminController extends Controller
{
    private function checkAdmin()
    {
        if (!Auth::user()->isAdmin()) abort(403);
    }

    public function dashboard()
    {
        $this->checkAdmin();
        $stats = [
            'total_reservations'   => Reservation::count(),
            'confirmed'            => Reservation::where('statut', 'confirmed')->count(),
            'pending'              => Reservation::where('statut', 'pending')->count(),
            'revenue_month'        => Paiement::where('statut', 'paid')->whereMonth('paid_at', now()->month)->sum('montant'),
            'cash_to_validate'      => Paiement::where('methode', 'cash')->where('statut', 'pending')->count(),
            'users_total'          => Utilisateur::where('role', 'user')->count(),
            'espaces_total'        => EspaceCoworking::count(),
        ];

        $recentReservations = Reservation::with(['utilisateur', 'espace'])
            ->orderBy('created_at', 'desc')->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentReservations'));
    }

    // Space management
    public function spaces()
    {
        $this->checkAdmin();
        $espaces = EspaceCoworking::withCount('reservations')->paginate(10);
        return view('admin.spaces.index', compact('espaces'));
    }

    public function createSpace() { $this->checkAdmin(); return view('admin.spaces.form', ['espace' => null]); }

    public function storeSpace(Request $request)
    {
        $this->checkAdmin();
        $data = $request->validate([
            'nom'        => 'required|string|max:200',
            'adresse'    => 'required|string|max:200',
            'latitude'   => 'nullable|numeric|between:-90,90',
            'longitude'  => 'nullable|numeric|between:-180,180',
            'prix_heure' => 'required|numeric|min:0',
            'prix_jour'  => 'required|numeric|min:0',
            'capacite'   => 'required|integer|min:1',
            'description'=> 'nullable|string',
            'type'       => 'required|in:bureau_prive,espace_ouvert,salle_reunion,studio',
            'amenities'  => 'nullable|array',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'disponible' => 'boolean',
        ]);
        if ($request->hasFile('image')) {
            Storage::disk('public')->makeDirectory('spaces');
            $data['image'] = $request->file('image')->store('spaces', 'public');
        }
        $data['disponible'] = $request->boolean('disponible', true);
        EspaceCoworking::create($data);
        return redirect()->route('admin.spaces.index')->with('success', 'Espace créé.');
    }

    public function editSpace(EspaceCoworking $espace) { $this->checkAdmin(); return view('admin.spaces.form', compact('espace')); }

    public function updateSpace(Request $request, EspaceCoworking $espace)
    {
        $this->checkAdmin();
        $data = $request->validate([
            'nom'         => 'required|string|max:200',
            'adresse'     => 'required|string|max:200',
            'latitude'    => 'nullable|numeric|between:-90,90',
            'longitude'   => 'nullable|numeric|between:-180,180',
            'prix_heure'  => 'required|numeric|min:0',
            'prix_jour'   => 'required|numeric|min:0',
            'capacite'    => 'required|integer|min:1',
            'description' => 'nullable|string',
            'type'        => 'required|in:bureau_prive,espace_ouvert,salle_reunion,studio',
            'amenities'   => 'nullable|array',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'disponible'  => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($espace->image && Storage::disk('public')->exists($espace->image)) {
                Storage::disk('public')->delete($espace->image);
            }
            Storage::disk('public')->makeDirectory('spaces');
            $data['image'] = $request->file('image')->store('spaces', 'public');
        } else {
            // Keep existing image
            unset($data['image']);
        }

        $espace->update($data);
        return redirect()->route('admin.spaces.index')->with('success', 'Espace "' . $espace->nom . '" mis à jour.');
    }

    public function deleteSpace(EspaceCoworking $espace)
    {
        $this->checkAdmin();
        $espace->delete();
        return redirect()->route('admin.spaces.index')->with('success', 'Espace supprimé.');
    }

    // Promo codes
    public function promoCodes()
    {
        $this->checkAdmin();
        $codes = CodePromo::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.promo.index', compact('codes'));
    }

    public function storePromo(Request $request)
    {
        $this->checkAdmin();
        $data = $request->validate([
            'code'              => 'required|string|max:50|unique:code_promos,code',
            'type'              => 'required|in:percent,fixed',
            'valeur'            => 'required|numeric|min:0',
            'valeur_min_commande'=> 'nullable|numeric|min:0',
            'date_expiration'   => 'nullable|date|after:today',
            'usage_max'         => 'nullable|integer|min:1',
            'actif'             => 'boolean',
        ]);
        CodePromo::create($data);
        return redirect()->route('admin.promo')->with('success', 'Code promo créé.');
    }

    public function deletePromo(CodePromo $code)
    {
        $this->checkAdmin();
        $code->delete();
        return redirect()->route('admin.promo')->with('success', 'Code supprimé.');
    }

    public function reservations(Request $request)
    {
        $this->checkAdmin();

        $query = Reservation::with(['utilisateur', 'espace', 'latestPaiement']);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('code_confirmation', 'like', "%$s%")
                    ->orWhereHas('utilisateur', fn($u) => $u->where('nom', 'like', "%$s%")->orWhere('prenom', 'like', "%$s%")->orWhere('email', 'like', "%$s%"))
                    ->orWhereHas('espace', fn($e) => $e->where('nom', 'like', "%$s%"));
            });
        }

        if ($request->filled('payment')) {
            $query->whereHas('latestPaiement', fn($p) => $p->where('methode', $request->payment));
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $reservations = $query->latest()->paginate(12)->withQueryString();
        return view('admin.reservations.index', compact('reservations'));
    }

    public function validateCashPayment(Reservation $reservation)
    {
        $this->checkAdmin();

        $paiement = $reservation->paiements()
            ->where('methode', 'cash')
            ->where('statut', 'pending')
            ->latest('id_paiement')
            ->first();

        if (!$paiement) {
            return back()->withErrors(['cash' => 'Aucun paiement cash en attente pour cette réservation.']);
        }

        $paiement->update(['statut' => 'paid', 'paid_at' => now()]);
        $reservation->update(['statut' => 'confirmed']);

        return back()->with('success', 'Paiement cash validé et réservation confirmée.');
    }

    // Users management
    public function users()
    {
        $this->checkAdmin();
        $users = Utilisateur::withCount('reservations')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $this->checkAdmin();
        $data = $request->validate([
            'nom'       => 'required|string|max:100|regex:/^[A-Za-zÀ-öø-ÿ\s\-\']+$/',
            'prenom'    => 'required|string|max:100|regex:/^[A-Za-zÀ-öø-ÿ\s\-\']+$/',
            'email'     => 'required|email|unique:utilisateurs,email',
            'telephone' => 'nullable|string|max:20',
            'role'      => 'required|in:user,admin',
            'password'  => 'required|string|min:8|confirmed',
        ]);

        Utilisateur::create([
            'nom'       => $data['nom'],
            'prenom'    => $data['prenom'],
            'email'     => $data['email'],
            'telephone' => $data['telephone'] ?? null,
            'role'      => $data['role'],
            'password'  => \Illuminate\Support\Facades\Hash::make($data['password']),
        ]);

        return redirect()->route('admin.users')->with('success', 'Utilisateur créé avec succès.');
    }

    public function updateUserRole(Request $request, Utilisateur $utilisateur)
    {
        $this->checkAdmin();
        $request->validate(['role' => 'required|in:user,admin']);
        $utilisateur->update(['role' => $request->role]);
        return back()->with('success', 'Rôle mis à jour.');
    }

    public function deleteUser(Utilisateur $utilisateur)
    {
        $this->checkAdmin();
        if ($utilisateur->id_user === Auth::id()) {
            return back()->withErrors(['delete' => 'Vous ne pouvez pas supprimer votre propre compte.']);
        }
        $utilisateur->delete();
        return back()->with('success', 'Utilisateur supprimé.');
    }

    // Payments overview
    public function payments()
    {
        $this->checkAdmin();
        $paiements = Paiement::with(['reservation.espace', 'reservation.utilisateur'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = [
            'total_paid'    => Paiement::where('statut', 'paid')->sum('montant'),
            'count_paid'    => Paiement::where('statut', 'paid')->count(),
            'count_pending' => Paiement::where('statut', 'pending')->count(),
            'count_stripe'  => Paiement::where('methode', 'stripe')->where('statut', 'paid')->count(),
            'count_cash'    => Paiement::where('methode', 'cash')->where('statut', 'paid')->count(),
        ];

        return view('admin.payments.index', compact('paiements', 'stats'));
    }

}
