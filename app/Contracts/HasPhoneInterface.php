<?php

namespace App\Contracts;

interface HasPhoneInterface
{
    /**
     * @param string $phone
     * @return $this|null
     */
    public function getByPhone(string $phone): ?HasPhoneInterface;
}
