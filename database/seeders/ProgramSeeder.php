<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\Video;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        $descHomme = <<<'TXT'
Nous avons l’ambition de vous proposer un programme d’entraînement « tout en un » pour les passionnés de musculation.

Le programme débutant est spécialement conçu pour les personnes ayant peu d’expérience en musculation : il vous offre des outils concrets pour comprendre le « quoi » et le « pourquoi » de votre entraînement et progresser vers vos objectifs.
TXT;

        $debutantHomme = Program::query()->updateOrCreate(
            ['slug' => 'programme-debutant-homme'],
            [
                'title' => 'Débutant homme',
                'description' => trim($descHomme),
                'price' => 490.00,
                'image' => 'programmes/programme-debutant-homme.png',
            ]
        );

        Video::query()->updateOrCreate(
            [
                'program_id' => $debutantHomme->id,
                'title' => 'Aperçu — échauffement',
            ],
            [
                'url' => 'https://youtu.be/8TfibLuZQKE?si=GZayoTtbwEcn2CYm',
                'description' => 'Exemple de vidéo liée au programme (remplacez l’URL par vos contenus).',
            ]
        );

        $descDebutantFemme = <<<'TXT'
Nous ne faisons pas dans la vente de rêves ni dans les promesses tapageuses. L’entraînement et la nutrition sont des leviers sérieux : ils demandent régularité, patience et lucidité sur son point de départ.

Nous vous proposons des outils concrets : des séances lisibles, des explications pour vous entraîner en sécurité, et des repères nutritionnels simples pour ne pas vous disperser. Pas de méthode miracle — une progression encadrée pour installer des habitudes durables.

|||OBJECTIFS|||
Vous avez peu ou pas d’expérience en salle ou avec les charges : ce programme privilégie la progressivité. L’objectif est d’apprendre les bons réflexes — posture, respiration, dosage de l’effort — avant d’augmenter l’intensité.

Les bénéfices visés : des bases solides en musculation et en alimentation, une meilleure confiance dans la pratique, et des repères pour suivre votre progression avec des indicateurs simples. Vous construisez une assise pour envisager ensuite des programmes plus exigeants.
TXT;

        $debutantFemme = Program::query()->updateOrCreate(
            ['slug' => 'debutant-femme'],
            [
                'title' => 'Programme femme débutante',
                'description' => trim($descDebutantFemme),
                'price' => 490.00,
                'image' => 'programmes/programme-femme-debutante.png',
            ]
        );

        Program::query()->where('slug', 'programme-debutant-femme')->delete();

        Video::query()->updateOrCreate(
            [
                'program_id' => $debutantFemme->id,
                'title' => 'Présentation — débutant femme',
            ],
            [
                'url' => 'https://youtu.be/Xl4GWijuWU0?si=2iAJowr9jdYyjc1a',
                'description' => 'Exemple de vidéo (remplacez l’URL par vos contenus).',
            ]
        );

        $descHypertrophieHomme = <<<'TXT'
Nous avons l’ambition de vous accompagner vers un physique musclé et affirmé, avec une approche structurée et réaliste.

Ce programme d’hypertrophie n’est pas une méthode miracle : il repose sur des outils concrets, issus de plus de 15 ans d’expérience en coaching et de données scientifiques, pour vous permettre de progresser en sécurité.

Vous y trouverez des séances progressives, des repères nutritionnels et des indicateurs pour piloter votre entraînement sur la durée.
TXT;

        $hypertrophieHomme = Program::query()->updateOrCreate(
            ['slug' => 'programme-hypertrophie-homme'],
            [
                'title' => 'Développement musculaire homme',
                'description' => trim($descHypertrophieHomme),
                'price' => 890.00,
                'image' => 'programmes/programme-hypertrophie-homme.png',
            ]
        );

        Video::query()->updateOrCreate(
            [
                'program_id' => $hypertrophieHomme->id,
                'title' => 'Présentation — hypertrophie',
            ],
            [
                'url' => 'https://youtu.be/wIynl3at0Rs?si=m9EdftBEi2_gjCJE',
                'description' => 'Exemple de vidéo (remplacez l’URL par vos contenus).',
            ]
        );

        $descAmincissementFemme = <<<'TXT'
Nous avons l’ambition de vous proposer un programme d’entraînement « tout en un » pour les passionnés de fitness et de musculation.

Notre programme amincissement femme a été spécialement conçu pour les personnes souhaitant réduire leur taux de masse grasse, tout en maximisant leur gain musculaire et leur force. Il vous guide pas à pas dans une approche structurée, avec des séances claires et des repères nutritionnels adaptés à votre objectif.

Mesdames, nous n’allons pas vous vendre une promesse creuse : nous vous proposons une méthode concrète, progressive et respectueuse de votre corps pour progresser en toute sécurité.
TXT;

        $amincissementFemme = Program::query()->updateOrCreate(
            ['slug' => 'programme-amincissement-et-developpement-musculaire-femme'],
            [
                'title' => 'Programme femme confirmé',
                'description' => trim($descAmincissementFemme),
                'price' => 890.00,
                'image' => 'programmes/programme-femme-confirme.png',
            ]
        );

        Video::query()->updateOrCreate(
            [
                'program_id' => $amincissementFemme->id,
                'title' => 'Présentation — amincissement',
            ],
            [
                'url' => 'https://youtu.be/ZLeYIWW99r4?si=4DqMvrU4Ang7nBH4',
                'description' => 'Exemple de vidéo (remplacez l’URL par vos contenus).',
            ]
        );

        Program::query()->updateOrCreate(
            ['slug' => 'programme-nutrition-sportive'],
            [
                'title' => 'Programme nutrition sportive',
                'description' => trim(<<<'TXT'
💪 Programme Nutrition “Prise de Masse – Tape Dure”
🎯 Objectif

Augmenter la masse musculaire rapidement avec une alimentation riche en calories et en protéines.

🍳 Petit-déjeuner (7h – 9h)
4 œufs entiers 🥚
100g flocons d’avoine
1 banane 🍌
1 cuillère de beurre de cacahuète
1 verre de lait 🥛

👉 Apport : protéines + glucides complexes + énergie

🍗 Collation Matin (10h – 11h)
1 sandwich pain complet + poulet / thon
1 fruit (pomme ou orange 🍊)
Poignée d’amandes

🍛 Déjeuner (13h – 14h)
150–200g poulet / viande / poisson
150g riz ou pâtes 🍝
Légumes (brocoli, carottes, etc.)
1 cuillère d’huile d’olive

🥤 Collation Pré-entraînement (16h – 17h)
1 banane
1 shaker protéiné (ou yaourt)
1 poignée de noix

🏋️ Après entraînement
1 shaker whey protein
1 fruit (rapide à digérer)

🍽️ Dîner (20h – 21h)
150–200g poisson ou poulet
100g riz / patate douce
Légumes

🌙 Avant de dormir
Fromage blanc ou yaourt
Quelques noix

📊 Conseils importants
🔥 Mange en surplus calorique ( +300 à +500 kcal )
💧 Bois 2 à 3L d’eau par jour
🏋️ Entraîne-toi 4–6 fois/semaine
😴 Dors au moins 7–8h
TXT),
                'price' => 390.00,
                'image' => 'programmes/programme-nutrition-sportive.png',
            ]
        );
    }
}
