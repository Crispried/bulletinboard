<?php

namespace app\models\rules;

use app\models\entities\Bulletin;

interface IBulletinRepository
{
    public function getBulletins();
    public function saveBulletin(Bulletin $bulletin);
    public function deleteBulletin($bulletinId);
}