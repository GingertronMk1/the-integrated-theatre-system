<?php

namespace App;

enum FileTypeEnum: string
{
    case TYPE_POSTER = 'poster';
    case TYPE_HEADSHOT = 'headshot';
    case TYPE_PUBLICITY_PHOTO = 'publicity_photo';
    case TYPE_OTHER = 'other';
}
