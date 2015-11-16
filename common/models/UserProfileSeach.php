<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserProfile;

/**
 * UserProfileSeach represents the model behind the search form about `common\models\UserProfile`.
 */
class UserProfileSeach extends UserProfile
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'uid', 'sex'], 'integer'],
            [['nickname', 'head_image', 'intro', 'birthday', 'address', 'qq', 'school'], 'safe'],
            [['money', 'friend_money'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = UserProfile::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'uid' => $this->uid,
            'money' => $this->money,
            'friend_money' => $this->friend_money,
            'sex' => $this->sex,
            'birthday' => $this->birthday,
        ]);

        $query->andFilterWhere(['like', 'nickname', $this->nickname])
            ->andFilterWhere(['like', 'head_image', $this->head_image])
            ->andFilterWhere(['like', 'intro', $this->intro])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'qq', $this->qq])
            ->andFilterWhere(['like', 'school', $this->school]);

        return $dataProvider;
    }
}
