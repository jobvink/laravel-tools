<?php

namespace jobvink\tools\Contracts;

interface Addressable
{
    public function isDuplicate();
    public function displayInformation();
    public function fullName();
    public function firstName();
    public function lastName();
    public function email();
    public function tel();
}