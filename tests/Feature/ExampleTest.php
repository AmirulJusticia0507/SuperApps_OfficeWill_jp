<?php

it('shows the login page to unauthenticated visitors', function () {
    $response = $this->get(route('login'));

    $response->assertStatus(200);
});
