<?php

namespace yuncms\oauth2\backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yuncms\oauth2\models\Client;

/**
 * ClientSearch represents the model behind the search form about `yuncms\oauth2\models\Client`.
 */
class ClientSearch extends Client
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'user_id'], 'integer'],
            [['client_secret', 'redirect_uri', 'grant_type', 'scope', 'name', 'domain', 'provider', 'icp', 'registration_ip'], 'safe'],
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
        $query = Client::find()->orderBy(['client_id' => SORT_DESC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'client_id' => $this->client_id,
            'user_id' => $this->user_id
        ]);

        $query->andFilterWhere(['like', 'client_secret', $this->client_secret])
            ->andFilterWhere(['like', 'redirect_uri', $this->redirect_uri])
            ->andFilterWhere(['like', 'grant_type', $this->grant_type])
            ->andFilterWhere(['like', 'scope', $this->scope])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'domain', $this->domain])
            ->andFilterWhere(['like', 'provider', $this->provider])
            ->andFilterWhere(['like', 'icp', $this->icp])
            ->andFilterWhere(['like', 'registration_ip', $this->registration_ip]);

        return $dataProvider;
    }
}
