<?php

namespace App;

class MachineService
{
    private string $uploadDirectory;

    public function __construct(string $uploadDirectory)
    {
        $this->uploadDirectory = $uploadDirectory;
    }

}
