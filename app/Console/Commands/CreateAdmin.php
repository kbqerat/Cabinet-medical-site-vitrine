<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    protected $signature   = 'admin:create {--email= : Adresse e-mail} {--password= : Mot de passe} {--name= : Nom complet}';
    protected $description = 'Crée le compte administrateur';

    public function handle(): int
    {
        $email    = $this->option('email')    ?? $this->ask('Adresse e-mail admin');
        $name     = $this->option('name')     ?? $this->ask('Nom complet (ex: Tarek Bekkaoui)', 'Administrateur');
        $password = $this->option('password') ?? $this->secret('Mot de passe (min. 8 caractères)');

        if (User::where('role', 'admin')->exists()) {
            $this->error('Un compte admin existe déjà. Utilisez admin:reset-password pour changer le mot de passe.');
            return self::FAILURE;
        }

        $parts = explode(' ', trim($name), 2);
        User::create([
            'first_name'          => $parts[0],
            'last_name'           => $parts[1] ?? '',
            'email'               => $email,
            'password'            => Hash::make($password),
            'role'                => 'admin',
            'plan'                => 'starter',
            'email_verified_at'   => now(),
            'verification_status' => 'approved',
        ]);

        $this->newLine();
        $this->line("  <fg=green;options=bold>✓ Compte admin créé avec succès !</>");
        $this->newLine();
        $this->line("  <fg=white;options=bold>Email :</> {$email}");
        $this->newLine();

        return self::SUCCESS;
    }
}
