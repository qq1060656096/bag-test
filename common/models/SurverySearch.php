<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Survey;
use common\z\ZCommonFun;

/**
 * SurverySearch represents the model behind the search form about `common\models\Survey`.
 */
class SurverySearch extends Survey
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'tax', 'uid', 'theme', 'theme_mobile', 'is_publish', 'answer_count', 'visit_count', 'is_public', 'is_statistics_public', 'max_answer_count', 'is_share_template', 'answer_total_time', 'answer_average_time', 'answer_limit_time', 'reward_count'], 'integer'],
            [['type', 'title', 'intro', 'created', 'start_date', 'end_date', 'pass'], 'safe'],
            [['reward_total', 'reward_average'], 'number'],
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
        $query = Survey::find();

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
            'tax' => $this->tax,
            'uid' => $this->uid,
            'theme' => $this->theme,
            'theme_mobile' => $this->theme_mobile,
            'is_publish' => $this->is_publish,
            'created' => $this->created,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'answer_count' => $this->answer_count,
            'visit_count' => $this->visit_count,
            'is_public' => $this->is_public,
            'is_statistics_public' => $this->is_statistics_public,
            'max_answer_count' => $this->max_answer_count,
            'is_share_template' => $this->is_share_template,
            'answer_total_time' => $this->answer_total_time,
            'answer_average_time' => $this->answer_average_time,
            'answer_limit_time' => $this->answer_limit_time,
            'reward_total' => $this->reward_total,
            'reward_average' => $this->reward_average,
            'reward_count' => $this->reward_count,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'intro', $this->intro])
            ->andFilterWhere(['like', 'pass', $this->pass]);

        return $dataProvider;
    }
    
    public function query($params)
    {
        $query = Survey::find();
    
      
    
        $this->load($params);
    
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $query;
        }
//         ZCommonFun::print_r_debug($this->attributes);
        $query->andFilterWhere([
            'id' => $this->id,
            'tax' => $this->tax,
            'uid' => $this->uid,
            'theme' => $this->theme,
            'theme_mobile' => $this->theme_mobile,
            'is_publish' => $this->is_publish,
            'created' => $this->created,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'answer_count' => $this->answer_count,
            'visit_count' => $this->visit_count,
            'is_public' => $this->is_public,
            'is_statistics_public' => $this->is_statistics_public,
            'max_answer_count' => $this->max_answer_count,
            'is_share_template' => $this->is_share_template,
            'answer_total_time' => $this->answer_total_time,
            'answer_average_time' => $this->answer_average_time,
            'answer_limit_time' => $this->answer_limit_time,
            'reward_total' => $this->reward_total,
            'reward_average' => $this->reward_average,
            'reward_count' => $this->reward_count,
        ]);
    
        $query->andFilterWhere(['like', 'type', $this->type])
        ->andFilterWhere(['like', 'title', $this->title])
        ->andFilterWhere(['like', 'intro', $this->intro])
        ->andFilterWhere(['like', 'pass', $this->pass]);
    
        return $query;
    }
}
