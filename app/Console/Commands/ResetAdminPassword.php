<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Kreait\Firebase\Contract\Auth;

class ResetAdminPassword extends Command
{
    protected $signature   = 'admin:reset-password {--password= : Mot de passe à définir (sinon généré automatiquement)}';
    protected $description = 'Réinitialise le mot de passe du compte admin Firebase';

    public function handle(Auth $auth): int
    {
        $email    = env('ADMIN_EMAIL');
        $password = $this->option('password') ?: $this->generatePassword();

        try {
            // Essayer de récupérer l'utilisateur existant
            try {
                $user = $auth->getUserByEmail($email);
                $auth->changeUserPassword($user->uid, $password);
                $action = 'Mot de passe mis à jour';
            } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
                // Créer le compte s'il n'existe pas
                $user = $auth->createUserWithEmailAndPassword($email, $password);
                $action = 'Compte admin créé';
            }

            $this->newLine();
            $this->line("  <fg=green;options=bold>✓ {$action} avec succès !</>");
            $this->newLine();
            $this->line("  <fg=white;options=bold>Email    :</> {$email}");
            $this->line("  <fg=white;options=bold>Password :</> <fg=yellow;options=bold>{$password}</>");
            $this->newLine();
            $this->line('  <fg=gray>→ Connectez-vous sur /login/doctor</fg=gray>');
            $this->newLine();

            return self::SUCCESS;

        } catch (\Throwable $e) {
            $this->error('Erreur : ' . $e->getMessage());
            return self::FAILURE;
        }
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
