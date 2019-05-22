<?php

namespace Nbs\BaseResource\Traits;

use Bromo\Auth\Entities\Modifier;

trait ModifierModelTrait
{
    public function refreshModifierField()
    {
        $this->modified_by = auth()->user()->id;
        $this->modifier_role = Modifier::ADMIN;
    }
}