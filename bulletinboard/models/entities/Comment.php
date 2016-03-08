<?php

namespace app\models\entities;

use yii\db\ActiveRecord;

class Comment extends ActiveRecord
{
    public function rules()
    {
        return [
            // password rules
            'commentRequire' => ['comment', 'required'],
            'commentLength' => ['comment', 'string', 'max' => 150],
        ];
    }
    public function addComment($userId, $author){
        if ($this->validate()){
            $newComment = new Comment();
            $newComment->userId = $userId;
            $newComment->author = $author;
            $newComment->comment = $this->comment;
            if ($newComment->save()) {
                return true;
            }
        }
        return false;
    }
}