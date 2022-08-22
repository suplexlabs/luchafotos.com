<?php

namespace App\Models;

use Plank\Mediable\Media as MediableMedia;

class Media extends MediableMedia
{
    public function getBasenameAttribute(): string
    {
        if (!empty($this->extension)) {
            return $this->filename . '.' . $this->extension;
        }

        return $this->filename;
    }
}
