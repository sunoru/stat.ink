<?php
namespace app\components\widgets;

use Yii;
use app\assets\FontAwesomeAsset;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class UserIcon extends Widget
{
    public $user;
    public $size;
    public $options = [];

    public function init()
    {
        parent::init();
        if (!$this->user) {
            $this->user = Yii::$app->user->identity;
        }
        if (!$this->size) {
            $this->inline();
        }
    }

    public function inline(): self
    {
        return $this->size('1em');
    }

    public function size(string $size): self
    {
        $this->size = $size;
        return $this;
    }

    public function run()
    {
        return Html::img(
            $this->user->iconUrl ?? 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7',
            ArrayHelper::merge((array)$this->options, [
                'id' => $this->id,
                'style' => [
                    'width' => $this->size,
                    'height' => $this->size,
                ],
            ])
        );
    }
}
