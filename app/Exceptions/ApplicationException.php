<?php
/**
 * Created by PhpStorm.
 * User: huynguyen
 * Date: 9/9/16
 * Time: 8:47 AM
 */

namespace App\Exceptions;


class ApplicationException extends \Exception
{

    public $code;

    public $message;

    public $key;



    public function __construct($code, $message = null, $key = null)
    {
        $this->code = $code;
        $this->message = $message;
        $this->key = $key;
    }

    public function toJson(){
        return json_encode($this);
    }
}