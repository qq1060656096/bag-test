<?php
use common\z\ZCommonSessionFun;
$role = ZCommonSessionFun::get_role();
$data['data'] = '';
if($pagination->page<$pagination->pageCount){
    $data['data'] = '';
}
foreach ($a_models as $key=>$row){
    if($row->tax==1){
        $url = Yii::$app->urlManager->createUrl(['answer/step1','id'=>$row->id]);
    }else{
        $url = Yii::$app->urlManager->createUrl(['answer/step2-answer2','id'=>$row->id]);
    }
     
    $image = common\models\Survey::getImageUrl($row);
    $is_top_text = '';
    $is_top_url = '';
    $op0 = Yii::$app->urlManager->createUrl(['survey/recommend','id'=>$row->id,'op'=>0]);
    $op1 = Yii::$app->urlManager->createUrl(['survey/recommend','id'=>$row->id,'op'=>1]);
    $is_top = 0;
    if( $row->is_top > 0 ):
    $is_top_text = '取消推荐';
    $is_top = 0;
    else:
    $is_top_text = '推荐';
    $is_top = 1;
    endif;
    $str_recommend = '';
    if( $role == 1 ):
    $str_recommend = <<<str
       				<a
       					is_top="{$is_top}" op0="{$op0}" op1="{$op1}"
       					class="play recommend" data-ui="danger small icon-right" style="right: 75px;"> {$is_top_text}<i
       						class="iconfont icon-right"></i>
       				</a>
str;
    	
    endif;

				
                   $data['data'].= <<<str
                   <dl>
					<a href="{$url}">
						<dt>
							<img src="{$image}"
								alt="{$row->title}">
						</dt>
						<dd>
							<h3>{$row->title}</h3>
						</dd>
						<dd>{$row->intro}</dd>
						<dd>
						      <a class="btn_bg" href="{$url}">去测试</a>
						      &nbsp; &nbsp;
						      
							  <span>测试过：{$row->answer_count}</span>
						</dd>
					</a>
				</dl>
str;
                                      
           
}
echo json_encode($data);