<?php

namespace app\modules\admin\controllers;

use app\models\Good;
use app\models\Group;
use yii\web\Controller;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $data = [];

        $cats = [
            2 => ['name', 'power', 'length', 'article', 'price'],
        ];

        foreach ($cats as $id => $fields) {
            $groups = [];
            /** @var Group $group */
            foreach (Group::find()->where(['categoryId' => $id])->orderBy('name')->all() as $group) {
                $item = [];
                $item[] = $group->name;
                $item[] = $fields;
                $goods = Good::find()->where(['groupId' => $group->id])->select($fields)->orderBy('name')->all();
                foreach ($goods as $good) {
                    $row = [];
                    foreach ($fields as $field) {
                        $row[] = $good->{$field};
                    }
                    $item[] = $row;
                }
                $data[] = $item;
            }
        }

        return $this->render('index', ['data' => $data]);
    }
}
