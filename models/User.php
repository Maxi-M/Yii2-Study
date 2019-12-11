<?php

namespace app\models;

use app\components\behaviors\TimestampTransformBehavior;
use yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 * Class User
 * @package app\models
 * @property int $id [int(11) autoincrement]
 * @property string $username [varchar(255)]
 * @property string $auth_key [varchar(32)]
 * @property string $password_hash [varchar(255)]
 * @property string $password_reset_token [varchar(255)]
 * @property string $email [varchar(255)]
 * @property int $created_at [timestamp]
 * @property int $updated_at [timestamp]
 * @property string $name [varchar(100)]
 * @property string $surname [varchar(100)]
 * @property string $phone [varchar(50)]
 * @property string $path_to_photo [varchar(255)]
 * @property \yii\db\ActiveQuery $activities
 * @property string $authKey
 */
class User extends ActiveRecord implements IdentityInterface
{
    public const SCENARIO_CREATE_USER = 'create_new_user';

    public $password;
    public $password2;

    public static function tableName()
    {
        return 'users';
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'email' => 'E-mail',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'phone' => 'Телефон',
            'password' => 'Пароль',
            'password2' => 'Пароль повторно',
        ];
    }

    public function rules()
    {
        return [
            ['id', 'integer'],
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => User::class, 'message' => 'This username has already been taken.', 'on' => self::SCENARIO_CREATE_USER],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'This email address has already been taken.', 'on' => self::SCENARIO_CREATE_USER],

            [['name'], 'required'],
            [['name', 'surname'], 'string', 'min' => 2, 'max' => 255],

            [['password', 'password2'], 'required', 'on' => self::SCENARIO_CREATE_USER],
            ['password2', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match", 'on' => self::SCENARIO_CREATE_USER],
            ['phone', 'string'],
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp_behavior' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
            'TimestampTransform' => [
                'class' => TimestampTransformBehavior::className(),
                'attributes' => ['created_at', 'updated_at'],
            ]
        ];
    }

    /**
     * Связь с таблицей Activities
     * @return yii\db\ActiveQuery
     */
    public function getActivities()
    {
        return $this->hasMany(Activity::className(), ['id_author' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     * @throws yii\base\Exception
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
}
