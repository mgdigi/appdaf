<?php

namespace App\Repository;
interface ICitoyenRepository{
    public function selectByCni(string $cni);
    public function selectAll();

}