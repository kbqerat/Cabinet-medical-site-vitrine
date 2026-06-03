<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetAdminPassword extends Command
{
    protected $signature   = 'admin:reset-password {--password= : Mot de passe à définir (sinon généré automatiquement)}';
    protected $description = 'Réinitialise le mot de passe du compte administrateur';

    public function handle(): int
    {
        $password = $this->option('password') ?: $this->generatePassword();
        $admin    = User::where('role', 'admin')->first();

        if (!$admin) {
            $this->error('Aucun compte admin trouvé. Utilisez admin:create pour en créer un.');
            return self::FAILURE;
        }

        $admin->update(['password' => Hash::make($password)]);

        $this->newLine();
        $this->line("  <fg=green;options=bold>✓ Mot de passe mis à jour avec succès !</>");
        $this->newLine();
        $this->line("  <fg=white;options=bold>Email    :</> {$admin->email}");
        $this->line("  <fg=white;options=bold>Password :</> <fg=yellow;options=bold>{$password}</>");
        $this->newLine();

        return self::SUCCESS;
    }

    private function generatePassword(): string
    {
        $chars = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789!@#$';
        $pass  = '';
        for ($i = 0; $i < 12; $i++) {
            $pass .= $chars[random_int(0, strlen($chars) - 1)];
        }
        return $pass;
    }
}
