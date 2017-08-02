<?php

namespace App\Http;

class Flash
{
    public function create($message, $class='', $key = 'flash_message')
    {
        session()->flash($key, [
            'message' => $message,
            'class' => $class
        ]);
    }

    public function info($message)
    {

        return $this->create($message, 'blue');

    }

    public function success($message)
    {
        return $this->create($message, 'green');

    }

    public function error($message)
    {
        return $this->create($message, 'red');

    }
}
