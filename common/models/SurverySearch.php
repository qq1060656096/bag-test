<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Survey;
use common\z\ZCommonFun;
use yii\data\Pagination;
use yii\db\Query;
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
    
    public function getMyTest($uid ,$where ,$page,$page_size){
        if($uid<0){
            return [];
        }
        $queryParams['SurverySearch']['is_publish'] = 1;

        $searchModel = new SurverySearch();

        $query = $searchModel->query( $queryParams );
        $query->join('inner join', 'answer_user','answer_user.sid=survey.id');
        $query->where('answer_user.uid='.$uid);
        $query->andWhere('is_publish=1');
        $query2 = clone $query;
//         $query2->groupBy= [
//             'survey.id'
//         ];

        $query->select('survey.*');
        $query = $query->orderBy(['au_id'=>SORT_DESC]);
        $sql = $query->createCommand()->getRawSql();
        $query3 = (new Query())->from(" ($sql) as tt ");
        $query3->groupBy(['id']);
    
        //查询总条数
        $query_count = clone $query3;
        $sql_count = $query_count->createCommand()->getRawSql();
        $count = (new Query())->from(" ($sql_count) as tt_count ")->count();
//      echo $count,'<br/>',$sql_count;
//         exit;
        
        //分页
        $pagination = new Pagination();
        isset($page) && intval($page)>0 ? $pagination->page = $page : null;
        
        
        //每页现实数量
        $pagination->pageSize = $page_size;
        //总数量
        $pagination->totalCount = $count;
        $offset = $pagination->getOffset();
        $limit = $pagination->getLimit();
        $query3->offset($offset);
        $query3->limit($limit);
        
//          echo $pagination->page,$pagination->pageCount;
        //查询所有
        $models = ( new SurverySearch())->findBySql($query3->createCommand()->getRawSql())->all();
        
        isset($models[0]) ? null : $models = [];
        $temp_data['models'] = $models;  
        $temp_data['pagination'] = $pagination;
       
//         echo '<pre>';
//         echo $query3->createCommand()->getRawSql();
//         print_r($models);
//         exit;
        return $temp_data;
    }
}
