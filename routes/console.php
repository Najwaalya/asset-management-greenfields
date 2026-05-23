<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('maintenance:check')->dailyAt('07:00');