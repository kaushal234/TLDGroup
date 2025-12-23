<?php

use App\Http\Controllers\GithubCommitController;
use Illuminate\Support\Facades\Route;

Route::get('{user}/{repository}', [GithubCommitController::class, 'index']);
