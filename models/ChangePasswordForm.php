<?php
namespace app\models;

use yii\base\Model;
use yii\base\InvalidParamException;
use app\models\User;

class ChangePasswordForm extends Model
{
	public $password;

	public $_user;

	public function __construct($id, $config = [])
	{
		$this->_user = User::findIdentity($id);
		if (!$this->_user) {
			throw new InvalidParamException('Wrong password reset user id.');
		}
		parent::__construct($config);
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['password', 'required'],
			['password', 'string', 'min' => 5],
		];
	}

	public function changePassword()
	{
		$user = $this->_user;
		$user->setPassword($this->password);

		return $user->save(false);
	}
}