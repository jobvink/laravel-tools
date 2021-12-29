<?php

namespace jobvink\tools\Models;

use Illuminate\Database\Eloquent\Model;

class FlashMessage extends Model
{
    const ERROR = 'error';

    public $type;
    public $description;

    /**
     * FlashMessage constructor.
     * @param $type
     * @param $description
     */
    public function __construct($type, $description)
    {
        parent::__construct();
        $this->type = $type;
        $this->description = $description;
    }



}
