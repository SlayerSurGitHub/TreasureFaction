<?php

namespace Treasure\Faction\registration;

final readonly class FactionRegistration extends Registration
{
    public function getText(): string
    {
        return "Première log de la faction !";
    }

}