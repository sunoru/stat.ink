<?php
/**
 * @copyright Copyright (C) 2016 AIZAWA Hina
 * @license https://github.com/fetus-hina/stat.ink/blob/master/LICENSE MIT
 * @author AIZAWA Hina <hina@bouhime.com>
 */

namespace app\actions\api\internal;

use Yii;

class ActivityAction extends BaseStatAction
{
    public function getCacheFormatVersion()
    {
        return implode(';', [
            parent::getCacheFormatVersion(),
            Yii::$app->timeZone,
        ]);
    }

    protected function makeData()
    {
        Yii::$app->db
            ->createCommand(sprintf(
                'SET TIMEZONE TO %s',
                Yii::$app->db->quoteValue(Yii::$app->timeZone)
            ))
            ->execute();

        $query = (new \yii\db\Query())
            ->select([
                'date'      => '{{battle}}.[[at]]::date',
                'battles'   => 'COUNT(*)',
            ])
            ->from('battle')
            ->where(['and',
                ['{{battle}}.[[user_id]]' => $this->user->id],
            ])
            ->groupBy('{{battle}}.[[at]]::date')
            ->orderBy('{{battle}}.[[at]]::date DESC')
            ->limit(371);
        return $query->createCommand()->queryAll();
    }
}
