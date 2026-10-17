<?php

namespace Database\Seeders;

use App\Models\{Utilisateur, EspaceCoworking, CodePromo, Reservation, Paiement};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        $admin = Utilisateur::create([
            'nom'       => 'Admin',
            'prenom'    => 'Super',
            'email'     => 'admin@cowork.com',
            'password'  => Hash::make('password'),
            'role'      => 'admin',
            'telephone' => '+33 1 23 45 67 89',
        ]);

        // Regular users
        $users = [];
        $userData = [
            ['nom' => 'Martin',  'prenom' => 'Sophie',  'email' => 'sophie@exemple.com'],
            ['nom' => 'Bernard', 'prenom' => 'Thomas',  'email' => 'thomas@exemple.com'],
            ['nom' => 'Dubois',  'prenom' => 'Emma',    'email' => 'emma@exemple.com'],
            ['nom' => 'Leroy',   'prenom' => 'Nicolas', 'email' => 'nicolas@exemple.com'],
            ['nom' => 'Moreau',  'prenom' => 'Camille', 'email' => 'camille@exemple.com'],
        ];
        foreach ($userData as $u) {
            $users[] = Utilisateur::create([
                'nom'       => $u['nom'],
                'prenom'    => $u['prenom'],
                'email'     => $u['email'],
                'password'  => Hash::make('password'),
                'role'      => 'user',
                'telephone' => '+33 6 ' . rand(10,99) . ' ' . rand(10,99) . ' ' . rand(10,99) . ' ' . rand(10,99),
            ]);
        }

        // Spaces
        $spacesData = [
            [
                'nom'         => 'Studio Créatif Montmartre',
                'adresse'     => '12 Rue des Artistes, 75018 Paris',
                'prix_jour'   => 85.00,
                'prix_heure'  => 12.00,
                'capacite'    => 4,
                'description' => 'Un espace lumineux et inspirant au cœur de Montmartre, idéal pour les créatifs et startups.',
                'type'        => 'studio',
                'amenities'   => ['WiFi haut débit', 'Café/Thé', 'Tableau blanc', 'Climatisation'],
                'disponible'  => true,
            ],
            [
                'nom'         => 'Bureau Privé Opéra',
                'adresse'     => '8 Boulevard des Capucines, 75009 Paris',
                'prix_jour'   => 120.00,
                'prix_heure'  => 18.00,
                'capacite'    => 6,
                'description' => "Bureau fermé et sécurisé dans le quartier d'affaires de l'Opéra.",
                'type'        => 'bureau_prive',
                'amenities'   => ['WiFi haut débit', 'Parking', 'Climatisation', 'Café/Thé', 'Imprimante'],
                'disponible'  => true,
            ],
            [
                'nom'         => 'Salle de Réunion République',
                'adresse'     => '22 Place de la République, 75011 Paris',
                'prix_jour'   => 200.00,
                'prix_heure'  => 30.00,
                'capacite'    => 12,
                'description' => 'Grande salle de réunion équipée, parfaite pour vos présentations et workshops.',
                'type'        => 'salle_reunion',
                'amenities'   => ['WiFi haut débit', 'Vidéoprojecteur', 'Tableau blanc', 'Climatisation', 'Cuisine'],
                'disponible'  => true,
            ],
            [
                'nom'         => 'Espace Ouvert La Défense',
                'adresse'     => '1 Parvis de la Défense, 92800 Puteaux',
                'prix_jour'   => 55.00,
                'prix_heure'  => 8.00,
                'capacite'    => 20,
                'description' => "Vaste espace en open-space dans le quartier d'affaires de La Défense.",
                'type'        => 'espace_ouvert',
                'amenities'   => ['WiFi haut débit', 'Parking', 'Café/Thé', 'Climatisation'],
                'disponible'  => true,
            ],
            [
                'nom'         => 'Loft Marais',
                'adresse'     => '45 Rue de Bretagne, 75003 Paris',
                'prix_jour'   => 95.00,
                'prix_heure'  => 14.00,
                'capacite'    => 8,
                'description' => 'Loft atypique dans le Marais avec vue dégagée et ambiance industrielle chic.',
                'type'        => 'studio',
                'amenities'   => ['WiFi haut débit', 'Café/Thé', 'Terrasse', 'Tableau blanc'],
                'disponible'  => true,
            ],
        ];

        $espaces = [];
        foreach ($spacesData as $s) {
            $espaces[] = EspaceCoworking::create($s);
        }

        // Promo codes
        CodePromo::create(['code' => 'WELCOME10', 'type' => 'percent', 'valeur' => 10.00, 'date_expiration' => now()->addYear(),     'usage_max' => null, 'actif' => true]);
        CodePromo::create(['code' => 'SUMMER20',  'type' => 'percent', 'valeur' => 20.00, 'date_expiration' => now()->addMonths(3),  'usage_max' => 100,  'actif' => true]);
        CodePromo::create(['code' => 'FLAT50',    'type' => 'fixed',   'valeur' => 50.00, 'valeur_min_commande' => 200, 'date_expiration' => now()->addMonths(6), 'usage_max' => 50, 'actif' => true]);
        CodePromo::create(['code' => 'VIP30',     'type' => 'percent', 'valeur' => 30.00, 'date_expiration' => now()->addMonths(1),  'usage_max' => 20,   'actif' => true]);

        // ── Sample reservations ───────────────────────────────────────────────
        $reservationsData = [
            // 1. Confirmed — paid online (Stripe)
            [
                'id_user'          => $users[0]->id_user,
                'id_espace'        => $espaces[0]->id_espace,
                'date_debut'       => now()->addDays(5)->toDateString(),
                'date_fin'         => now()->addDays(7)->toDateString(),
                'heure_debut'      => '09:00',
                'heure_fin'        => '18:00',
                'type_reservation' => 'daily',
                'statut'           => 'confirmed',
                'payment_method'   => 'stripe',
                'expires_at'       => null, // already confirmed, no expiry needed
                'prix_total'       => 255.00,
                'remise_montant'   => 25.50,
                'prix_final'       => 229.50,
            ],
            // 2. Pending — user chose online payment, 30-min clock ticking
            [
                'id_user'          => $users[1]->id_user,
                'id_espace'        => $espaces[1]->id_espace,
                'date_debut'       => now()->addDays(10)->toDateString(),
                'date_fin'         => now()->addDays(12)->toDateString(),
                'heure_debut'      => '08:00',
                'heure_fin'        => '18:00',
                'type_reservation' => 'daily',
                'statut'           => 'pending',
                'payment_method'   => 'stripe',
                'expires_at'       => now()->addMinutes(25), // 25 min left on the clock
                'prix_total'       => 360.00,
                'remise_montant'   => 0,
                'prix_final'       => 360.00,
            ],
            // 3. Confirmed — paid online (past reservation)
            [
                'id_user'          => $users[2]->id_user,
                'id_espace'        => $espaces[2]->id_espace,
                'date_debut'       => now()->subDays(10)->toDateString(),
                'date_fin'         => now()->subDays(8)->toDateString(),
                'heure_debut'      => '09:00',
                'heure_fin'        => '17:00',
                'type_reservation' => 'daily',
                'statut'           => 'confirmed',
                'payment_method'   => 'stripe',
                'expires_at'       => null,
                'prix_total'       => 600.00,
                'remise_montant'   => 120.00,
                'prix_final'       => 480.00,
            ],
            // 4. Confirmed — hourly booking, paid online
            [
                'id_user'          => $users[3]->id_user,
                'id_espace'        => $espaces[3]->id_espace,
                'date_debut'       => now()->addDays(2)->toDateString(),
                'date_fin'         => now()->addDays(2)->toDateString(),
                'heure_debut'      => '10:00',
                'heure_fin'        => '14:00',
                'type_reservation' => 'hourly',
                'statut'           => 'confirmed',
                'payment_method'   => 'stripe',
                'expires_at'       => null,
                'prix_total'       => 32.00,
                'remise_montant'   => 0,
                'prix_final'       => 32.00,
            ],
            // 5. Pending — user chose cash, has until tomorrow to show up
            [
                'id_user'          => $users[4]->id_user,
                'id_espace'        => $espaces[4]->id_espace,
                'date_debut'       => now()->addDays(3)->toDateString(),
                'date_fin'         => now()->addDays(5)->toDateString(),
                'heure_debut'      => '09:00',
                'heure_fin'        => '18:00',
                'type_reservation' => 'daily',
                'statut'           => 'pending',
                'payment_method'   => 'cash',
                'expires_at'       => now()->addHours(20), // 20 h left on the cash window
                'prix_total'       => 285.00,
                'remise_montant'   => 0,
                'prix_final'       => 285.00,
            ],
            // 6. Expired — online payment never completed
            [
                'id_user'          => $users[0]->id_user,
                'id_espace'        => $espaces[2]->id_espace,
                'date_debut'       => now()->addDays(15)->toDateString(),
                'date_fin'         => now()->addDays(16)->toDateString(),
                'heure_debut'      => '09:00',
                'heure_fin'        => '18:00',
                'type_reservation' => 'daily',
                'statut'           => 'expired',
                'payment_method'   => 'stripe',
                'expires_at'       => now()->subMinutes(5), // deadline already passed
                'prix_total'       => 400.00,
                'remise_montant'   => 0,
                'prix_final'       => 400.00,
            ],
            // 7. Cancelled — user changed their mind manually
            [
                'id_user'          => $users[1]->id_user,
                'id_espace'        => $espaces[0]->id_espace,
                'date_debut'       => now()->addDays(8)->toDateString(),
                'date_fin'         => now()->addDays(9)->toDateString(),
                'heure_debut'      => '09:00',
                'heure_fin'        => '18:00',
                'type_reservation' => 'daily',
                'statut'           => 'cancelled',
                'payment_method'   => 'cash',
                'expires_at'       => now()->addHours(18),
                'cancelled_at'     => now()->subHours(2),
                'prix_total'       => 170.00,
                'remise_montant'   => 0,
                'prix_final'       => 170.00,
            ],
        ];

        foreach ($reservationsData as $rd) {
            $reservation = Reservation::create($rd);

            // Create payment record for confirmed reservations
            if ($rd['statut'] === 'confirmed') {
                Paiement::create([
                    'id_reservation'           => $reservation->id_reservation,
                    'montant'                  => $rd['prix_final'],
                    'statut'                   => 'paid',
                    'methode'                  => $rd['payment_method'] ?? 'stripe',
                    'stripe_payment_intent_id' => 'pi_demo_' . uniqid(),
                    'paid_at'                  => now()->subHours(rand(1, 48)),
                ]);
            }

            // Create pending payment record for cash reservations still waiting
            if ($rd['statut'] === 'pending' && ($rd['payment_method'] ?? null) === 'cash') {
                Paiement::create([
                    'id_reservation' => $reservation->id_reservation,
                    'montant'        => $rd['prix_final'],
                    'statut'         => 'pending',
                    'methode'        => 'cash',
                ]);
            }
        }

        $this->command->info('Seeder terminé avec succès !');
        $this->command->info('Admin: admin@cowork.com / password');
        $this->command->info('User:  sophie@exemple.com / password');
        $this->command->info(count($spacesData) . ' espaces créés');
        $this->command->info(count($reservationsData) . ' réservations de démonstration (confirmed / pending / expired / cancelled)');
    }
}