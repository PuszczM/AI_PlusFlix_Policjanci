<?php

namespace App\Filter;

enum MovieTypeFilter: string {
    case ALL = 'all';
    case FILM = 'film';
    case SERIES = 'series';
}
