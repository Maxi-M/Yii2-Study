<?php


namespace app\controllers;

use app\models\Activity;
use Yii;
use yii\base\ErrorException;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\web\Controller;

class ActivityController extends Controller
{
    private const ERROR_TITLE = 'Ошибка работы с событиями';
    private const ERROR_PARAMETER_MISSING = 'Обязательный параметр задан некорректно, или отсутствует';
    private const ERROR_ACCESS_DENIED = 'Доступ запрещён';
    private const ERROR_NO_SUCH_ACTIVITY = 'Событие не найдено';
    private const ERROR_OPERATION_FAILED = 'Операция не удалась.';

    /**
     * Отображает список событий с использованием ActiveDataProvider
     */
    public function actionIndex()
    {
        $activitiesProvider = new ActiveDataProvider([
            'query' => Yii::$app->user->can('admin') ?
                Activity::find() : Activity::find()->where(['id_author' => Yii::$app->user->id]),
            'pagination' => [
                'pageSize' => 15,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ]
        ]);
        return $this->render('index', ['provider' => $activitiesProvider]);
    }

    /**
     * Отображает событие с параметром $id события
     * @return string
     */
    public function actionShow(): string
    {
        if ($id = (int)Yii::$app->request->get('id')) {
            if ($model = Activity::findOne($id)) {
                if (Yii::$app->user->can('view_activity', ['activity' => $model])) {
                    return $this->render('show', [
                        'model' => $model
                    ]);
                }
                return $this->render('activity-error', [
                    'name' => self::ERROR_TITLE,
                    'message' => self::ERROR_ACCESS_DENIED
                ]);
            }
            return $this->render('activity-error', [
                'name' => self::ERROR_TITLE,
                'message' => self::ERROR_NO_SUCH_ACTIVITY
            ]);
        }
        return $this->render('activity-error', [
            'name' => self::ERROR_TITLE,
            'message' => self::ERROR_PARAMETER_MISSING
        ]);
    }

    /**
     * Отображает страницу редактирования выбранного события
     * @return string
     */
    public function actionEdit()
    {
        if ($id = (int)Yii::$app->request->get('id')) {
            if ($model = Activity::findOne(['id' => $id])) {
                if (Yii::$app->user->can('edit_activity', ['activity' => $model])) {
                    if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                        $model->save();
                        return Yii::$app->getResponse()->redirect(['activity/show', 'id' => $model->id]);
                    }
                    return $this->render('form', [
                        'model' => $model,
                    ]);
                }
                return $this->render('activity-error', [
                    'name' => self::ERROR_TITLE,
                    'message' => self::ERROR_ACCESS_DENIED
                ]);
            }
            return $this->render('activity-error', [
                'name' => self::ERROR_TITLE,
                'message' => self::ERROR_NO_SUCH_ACTIVITY
            ]);
        }
        return $this->render('activity-error', [
            'name' => self::ERROR_TITLE,
            'message' => self::ERROR_PARAMETER_MISSING
        ]);

    }

    /**
     * Выводит форму создания нового события и отвечает за обработку результата.
     * @return string
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->can('create_activity')) {
            return $this->render('activity-error', [
                'name' => self::ERROR_TITLE,
                'message' => self::ERROR_ACCESS_DENIED
            ]);
        }
        $model = new Activity();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            return $this->render('show', ['model' => $model]);
        }

        return $this->render('form', ['model' => $model]);
    }

    /**
     * Обрабатывает запрос на удаление события
     */
    public function actionDelete() {
        if ($id = (int)Yii::$app->request->get('id')) {
            if ($model = Activity::findOne(['id' => $id])) {
                if (Yii::$app->user->can('delete_activity', ['activity' => $model])) {
                    try {
                        $model->delete();
                    } catch (\Throwable $e) {
                        return $this->render('activity-error', [
                            'name' => self::ERROR_TITLE,
                            'message' => self::ERROR_OPERATION_FAILED
                        ]);
                    }
                    return Yii::$app->getResponse()->redirect('/activity/index');
                }
                return $this->render('activity-error', [
                    'name' => self::ERROR_TITLE,
                    'message' => self::ERROR_ACCESS_DENIED
                ]);
            }
            return $this->render('activity-error', [
                'name' => self::ERROR_TITLE,
                'message' => self::ERROR_NO_SUCH_ACTIVITY
            ]);
        }
        return $this->render('activity-error', [
            'name' => self::ERROR_TITLE,
            'message' => self::ERROR_PARAMETER_MISSING
        ]);
    }
}