<?php

namespace App\Console\Commands;

use App\FileTypeEnum;
use App\Models\File;
use App\Models\Person;
use Illuminate\Console\Command;

class AddHeadshots extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-headshots';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @throws \Exception
     */
    public function handle()
    {
        $this->withProgressBar(Person::all(), function (Person $person) {
            $picture = File::generatePlaceholder(type: FileTypeEnum::TYPE_HEADSHOT);
            $person->files()->save($picture);
        });
    }
}
