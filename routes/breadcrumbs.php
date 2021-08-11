<?php

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home'));
});

// Home > List Users 
Breadcrumbs::for('list-user', function ($trail) {
    $trail->parent('home');
    $trail->push('List Users', route('staff-management.index'));
});
