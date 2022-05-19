<?php

namespace jobvink\tools\Contracts;

interface Addressable
{
    public function isDuplicate();
    public function displayInformation();
    public function fullName();
}