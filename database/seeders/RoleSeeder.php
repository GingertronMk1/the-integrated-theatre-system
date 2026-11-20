<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->roles() as $sort => $role) {
            Role::query()->updateOrCreate(
                ['name' => $role['name']],
                ['icon' => $role['icon'], 'sort' => $sort * 10],
            );
        }
    }

    /** @return list<array{name: string, icon: string}> */
    private function roles(): array
    {
        return [
            ['name' => 'Director', 'icon' => 'ion-film-marker'],
            ['name' => 'Producer', 'icon' => 'fa fa-money'],
            ['name' => 'Production Advisor', 'icon' => 'fa fa-comments-o'],
            ['name' => 'Playwright', 'icon' => 'fa fa-pencil'],
            ['name' => 'Set Designer', 'icon' => 'ion-paintbucket'],
            ['name' => 'Designer', 'icon' => 'ion-paintbucket'],
            ['name' => 'Stage Manager', 'icon' => 'fa fa-bookmark'],
            ['name' => 'Technical Director', 'icon' => 'fa fa-plug'],
            ['name' => 'Lighting Designer', 'icon' => 'fa fa-lightbulb-o'],
            ['name' => 'Sound Designer', 'icon' => 'fa fa-volume-up'],
            ['name' => 'Video Designer', 'icon' => 'ion-videocamera'],
            ['name' => 'Technical Operator', 'icon' => 'fa fa-headphones'],
            ['name' => 'Sound Engineer', 'icon' => 'ion-levels'],
            ['name' => 'Followspot Operator', 'icon' => 'ion-aperture'],
            ['name' => 'Composer', 'icon' => 'fa fa-music'],
            ['name' => 'Musical Director', 'icon' => 'fa fa-music'],
            ['name' => 'Vocalist', 'icon' => 'fa fa-music'],
            ['name' => 'Musician', 'icon' => 'fa fa-music'],
            ['name' => 'Make Up Artist', 'icon' => 'ion-paintbrush'],
            ['name' => 'Costume Designer', 'icon' => 'ion-tshirt'],
            ['name' => 'Publicity Designer', 'icon' => 'fa fa-picture-o'],
            ['name' => 'Publicity Manager', 'icon' => 'fa fa-picture-o'],
            ['name' => 'Publicist', 'icon' => 'fa fa-picture-o'],
            ['name' => 'Poster Designer', 'icon' => 'fa fa-picture-o'],
            ['name' => 'Artwork', 'icon' => 'fa fa-picture-o'],
            ['name' => 'Photographer', 'icon' => 'fa fa-camera-retro'],
            ['name' => 'Video Editor', 'icon' => 'fa fa-file-video-o'],
            ['name' => 'Set Construction', 'icon' => 'ion-hammer'],
            ['name' => 'Choreographer', 'icon' => 'fa fa-street-view'],
        ];
    }
}
