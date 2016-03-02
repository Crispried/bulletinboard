<?php

namespace app\models\rules;


use app\models\entities\Comment;

interface ICommentRepository
{
    public function getComments();
    public function saveComment(Comment $comment);
    public function deleteComment($commentId);
}