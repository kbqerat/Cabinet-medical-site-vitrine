<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanConfig extends Model
{
    protected $fillable = [
        'starter_price_monthly', 'starter_price_annual', 'starter_desc', 'starter_features_json',
        'pro_price_monthly', 'pro_price_annual', 'pro_desc', 'pro_features_json',
        'licence_price', 'licence_desc', 'licence_suffix', 'licence_features_json',
    ];

    public static function defaults(): array
    {
        return [
            'starter_price_monthly' => 290,
            'starter_price_annual'  => 232,
            'starter_desc'          => 'Pour les médecins solo qui débutent',
            'starter_features_json' => json_encode([
                ['text' => '1 médecin',             'ok' => true],
                ['text' => "Jusqu'à 300 patients",   'ok' => true],
                ['text' => 'Agenda & RDV',           'ok' => true],
                ['text' => 'Ordonnances PDF',        'ok' => true],
                ['text' => 'Multi-utilisateurs',     'ok' => false],
                ['text' => 'App mobile',             'ok' => false],
                ['text' => 'Support prioritaire',    'ok' => false],
            ]),
            'pro_price_monthly'     => 490,
            'pro_price_annual'      => 392,
            'pro_desc'              => 'Le plus populaire pour les cabinets actifs',
            'pro_features_json'     => json_encode([
                ['text' => '1 à 3 médecins',         'ok' => true],
                ['text' => 'Patients illimités',      'ok' => true],
                ['text' => 'Agenda & RDV avancé',     'ok' => true],
                ['text' => 'Ordonnances & analyses',  'ok' => true],
                ['text' => 'Multi-utilisateurs',      'ok' => true],
                ['text' => 'App mobile incluse',      'ok' => true],
                ['text' => 'Support prioritaire',     'ok' => false],
            ]),
            'licence_price'         => 4900,
            'licence_desc'          => 'Paiement unique, hébergé chez vous',
            'licence_suffix'        => 'MAD · paiement unique',
            'licence_features_json' => json_encode([
                ['text' => '1 cabinet',                     'ok' => true],
                ['text' => 'Installation sur votre serveur', 'ok' => true],
                ['text' => 'Accès illimité à vie',          'ok' => true],
                ['text' => 'MAJ incluses 1 an',             'ok' => true],
                ['text' => 'Code source fourni',            'ok' => true],
                ['text' => 'App mobile',                    'ok' => false],
                ['text' => 'Hébergement cloud',             'ok' => false],
            ]),
        ];
    }

    public static function getOrCreate(): array
    {
        $config = static::first();
        if (!$config) {
            $config = static::create(static::defaults());
        }
        return array_merge(static::defaults(), $config->toArray());
    }
}
