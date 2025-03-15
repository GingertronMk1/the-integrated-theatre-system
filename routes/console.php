<?php

\Illuminate\Support\Facades\Schedule::call(\App\Console\Commands\CheckCrewRoles::class)->dailyAt('15:00');
