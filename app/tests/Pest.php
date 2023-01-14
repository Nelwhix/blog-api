<?php

use App\Models\User;

uses(Tests\TestCase::class)->in('Feature');


function login($user = null) {
    return test()->actingAs($user ?? User::factory()->create()->assignRole('Guest'));
}

function adminLogin($user = null) {
    return test()->actingAs($user ?? User::factory()->create()->assignRole('Admin'));
}
