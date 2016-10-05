<?php
/*
 Copyright Game Server Services, Inc.

 Licensed under the Apache License, Version 2.0 (the "License");
 you may not use this file except in compliance with the License.
 You may obtain a copy of the License at

 http://www.apache.org/licenses/LICENSE-2.0

 Unless required by applicable law or agreed to in writing, software
 distributed under the License is distributed on an "AS IS" BASIS,
 WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 See the License for the specific language governing permissions and
 limitations under the License.
 */

namespace GS2\Ranking;

use GS2\Core\Gs2Credentials as Gs2Credentials;
use GS2\Core\AbstractGs2Client as AbstractGs2Client;
use GS2\Core\Exception\NullPointerException as NullPointerException;

/**
 * GS2-Ranking クライアント
 *
 * @author Game Server Services, inc. <contact@gs2.io>
 * @copyright Game Server Services, Inc.
 *
 */
class Gs2RankingClient extends AbstractGs2Client {

	public static $ENDPOINT = 'ranking';
	
	/**
	 * コンストラクタ
	 * 
	 * @param string $region リージョン名
	 * @param Gs2Credentials $credentials 認証情報
	 * @param $options オプション
	 */
	public function __construct($region, Gs2Credentials $credentials, $options = []) {
		parent::__construct($region, $credentials, $options);
	}
	
	/**
	 * ランキングテーブルリストを取得
	 * 
	 * @param string $pageToken ページトークン
	 * @param integer $limit 取得件数
	 * @return array
	 * 
	 * * items
	 * 	* array
	 * 		* rankingTableId => ランキングテーブルID
	 * 		* ownerId => オーナーID
	 * 		* name => ランキングテーブル名
	 * 		* description => 説明文
	 * 		* createAt => 作成日時
	 * 		* updateAt => 更新日時
	 * * nextPageToken => 次ページトークン
	 */
	public function describeRankingTable($pageToken = NULL, $limit = NULL) {
		$query = [];
		if($pageToken) $query['pageToken'] = $pageToken;
		if($limit) $query['limit'] = $limit;
		return $this->doGet(
					'Gs2Ranking', 
					'DescribeRankingTable', 
					Gs2RankingClient::$ENDPOINT, 
					'/ranking',
					$query);
	}
	
	/**
	 * ランキングテーブルを作成<br>
	 * <br>
	 * GS2-Ranking を利用するには、まずランキングテーブルを作成する必要があります。<br>
	 * 1つのランキングテーブルには複数のゲームモードのランキングを格納することができます。<br>
	 * 
	 * @param array $request
	 * * name => ランキングテーブル名
	 * * description => 説明文
	 * @return array
	 * * item
	 * 	* rankingTableId => ランキングテーブルID
	 * 	* ownerId => オーナーID
	 * 	* name => ランキングテーブル名
	 * 	* description => 説明文
	 * 	* createAt => 作成日時
	 * 	* updateAt => 更新日時
	 */
	public function createRankingTable($request) {
		if(is_null($request)) throw new NullPointerException();
		$body = [];
		if(array_key_exists('name', $request)) $body['name'] = $request['name'];
		if(array_key_exists('description', $request)) $body['description'] = $request['description'];
		$query = [];
		return $this->doPost(
					'Gs2Ranking', 
					'CreateRankingTable', 
					Gs2RankingClient::$ENDPOINT, 
					'/ranking',
					$body,
					$query);
	}

	/**
	 * ランキングテーブルを取得
	 *
	 * @param array $request
	 * * rankingTableName => ランキングテーブル名
	 * @return array
	 * * item
	 * 	* rankingTableId => ランキングテーブルID
	 * 	* ownerId => オーナーID
	 * 	* name => ランキングテーブル名
	 * 	* description => 説明文
	 * 	* createAt => 作成日時
	 * 	* updateAt => 更新日時
	 *
	 */
	public function getRankingTable($request) {
		if(is_null($request)) throw new NullPointerException();
		if(!array_key_exists('rankingTableName', $request)) throw new NullPointerException();
		if(is_null($request['rankingTableName'])) throw new NullPointerException();
		$query = [];
		return $this->doGet(
				'Gs2Ranking',
				'GetRankingTable',
				Gs2RankingClient::$ENDPOINT,
				'/ranking/'. $request['rankingTableName'],
				$query);
	}

	/**
	 * ランキングテーブルを更新
	 *
	 * @param array $request
	 * * rankingTableName => ランキングテーブル名
	 * * description => 説明文
	 * @return array 
	 * * item
	 * 	* rankingTableId => ランキングテーブルID
	 * 	* ownerId => オーナーID
	 * 	* name => ランキングテーブル名
	 * 	* description => 説明文
	 * 	* createAt => 作成日時
	 * 	* updateAt => 更新日時
	 */
	public function updateRankingTable($request) {
		if(is_null($request)) throw new NullPointerException();
		if(!array_key_exists('rankingTableName', $request)) throw new NullPointerException();
		if(is_null($request['rankingTableName'])) throw new NullPointerException();
		$body = [];
		if(array_key_exists('description', $request)) $body['description'] = $request['description'];
		$query = [];
		return $this->doPut(
				'Gs2Ranking',
				'UpdateRankingTable',
				Gs2RankingClient::$ENDPOINT,
				'/ranking/'. $request['rankingTableName'],
				$body,
				$query);
	}
	
	/**
	 * ランキングテーブルを削除
	 * 
	 * @param array $request
	 * * rankingTableName => ランキングテーブル名
	 */
	public function deleteRankingTable($request) {
		if(is_null($request)) throw new NullPointerException();
		if(!array_key_exists('rankingTableName', $request)) throw new NullPointerException();
		if(is_null($request['rankingTableName'])) throw new NullPointerException();
		$query = [];
		return $this->doDelete(
					'Gs2Ranking', 
					'DeleteRankingTable', 
					Gs2RankingClient::$ENDPOINT, 
					'/ranking/'. $request['rankingTableName'],
					$query);
	}

	/**
	 * ゲームモードリストを取得
	 *
	 * @param array $request
	 * * rankingTableName => ランキングテーブル名
	 * @param string $pageToken ページトークン
	 * @param integer $limit 取得件数
	 * @return array
	 * * items
	 * 	* array
	 * 		* gameModeId => ゲームモードID
	 * 		* rankingTableId => ランキングテーブルID
	 * 		* gameMode => ゲームモード名
	 * 		* ownerId => オーナーID
	 * 		* asc => ソート方向
	 * 		* calcInterval => 集計間隔(分)
	 * 		* lastCalcAt => 最終集計日時
	 * 		* createAt => 作成日時
	 * 		* updateAt => 更新日時
	 * * nextPageToken => 次ページトークン
	 */
	public function describeGameMode($request, $pageToken = NULL, $limit = NULL) {
		if(is_null($request)) throw new NullPointerException();
		if(!array_key_exists('rankingTableName', $request)) throw new NullPointerException();
		if(is_null($request['rankingTableName'])) throw new NullPointerException();
		$query = [];
		if($pageToken) $query['pageToken'] = $pageToken;
		if($limit) $query['limit'] = $limit;
		return $this->doGet(
				'Gs2Ranking',
				'DescribeGameMode',
				Gs2RankingClient::$ENDPOINT,
				'/ranking/'. $request['rankingTableName']. '/mode',
				$query);
	}
	
	/**
	 * ゲームモードを作成<br>
	 * <br>
	 * ゲームモードを作成すると、ゲームモードの設定としてランキングが昇順なのか、降順なのかを設定できます。<br>
	 * レースゲームのようなタイムの値が小さいほど上位のランキングの場合は昇順を、<br>
	 * アクションゲームなどで、スコアの値が大きいほど上位のランキングの場合は降順を選択します。<br>
	 * <br>
	 * 他に、集計間隔を15分以上、24時間以下で分単位で設定できます。<br>
	 * ランキングを更新したい間隔に合わせて設定することになります。<br>
	 * 集計処理毎に費用が発生するため、高頻度であればあるほど利用料金は高くなります。<br>
	 *
	 * @param array $request
	 * 	* rankingTableName => ランキングテーブル名
	 * 	* gameMode => ゲームモード名
	 * 	* asc => ソート方向
	 * 	* calcInterval => 集計間隔(分)
	 * @return array
	 * * item
	 * 	* gameModeId => ゲームモードID
	 * 	* rankingTableId => ランキングテーブルID
	 * 	* gameMode => ゲームモード名
	 * 	* ownerId => オーナーID
	 * 	* asc => ソート方向
	 * 	* calcInterval => 集計間隔(分)
	 * 	* lastCalcAt => 最終集計日時
	 * 	* createAt => 作成日時
	 * 	* updateAt => 更新日時
	 */
	public function createGameMode($request) {
		if(is_null($request)) throw new NullPointerException();
		if(!array_key_exists('rankingTableName', $request)) throw new NullPointerException();
		if(is_null($request['rankingTableName'])) throw new NullPointerException();
		$body = [];
		if(array_key_exists('gameMode', $request)) $body['gameMode'] = $request['gameMode'];
		if(array_key_exists('asc', $request)) $body['asc'] = $request['asc'];
		if(array_key_exists('calcInterval', $request)) $body['calcInterval'] = $request['calcInterval'];
		$query = [];
		return $this->doPost(
				'Gs2Ranking',
				'CreateGameMode',
				Gs2RankingClient::$ENDPOINT,
				'/ranking/'. $request['rankingTableName']. '/mode',
				$body,
				$query);
	}
	
	/**
	 * ゲームモードを取得
	 *
	 * @param array $request
	 * * rankingTableName => ランキングテーブル名
	 * * gameMode => ゲームモード名
	 * @return array
	 * * item
	 * 	* gameModeId => ゲームモードID
	 * 	* rankingTableId => ランキングテーブルID
	 * 	* gameMode => ゲームモード名
	 * 	* ownerId => オーナーID
	 * 	* asc => ソート方向
	 * 	* calcInterval => 集計間隔(分)
	 * 	* lastCalcAt => 最終集計日時
	 * 	* createAt => 作成日時
	 * 	* updateAt => 更新日時
	 *
	 */
	public function getGameMode($request) {
		if(is_null($request)) throw new NullPointerException();
		if(!array_key_exists('rankingTableName', $request)) throw new NullPointerException();
		if(is_null($request['rankingTableName'])) throw new NullPointerException();
		if(!array_key_exists('gameMode', $request)) throw new NullPointerException();
		if(is_null($request['gameMode'])) throw new NullPointerException();
		$query = [];
		return $this->doGet(
				'Gs2Ranking',
				'GetGameMode',
				Gs2RankingClient::$ENDPOINT,
				'/ranking/'. $request['rankingTableName']. '/mode/'. $request['gameMode'],
				$query);
	}
	
	/**
	 * ゲームモードを更新
	 *
	 * @param array $request
	 * * rankingTableName => ランキングテーブル名
	 * * gameMode => ゲームモード名
	 * * calcInterval => 集計間隔(分)
	 * @return array 
	 * * item
	 * 	* gameModeId => ゲームモードID
	 * 	* rankingTableId => ランキングテーブルID
	 * 	* gameMode => ゲームモード名
	 * 	* ownerId => オーナーID
	 * 	* asc => ソート方向
	 * 	* calcInterval => 集計間隔(分)
	 * 	* lastCalcAt => 最終集計日時
	 * 	* createAt => 作成日時
	 * 	* updateAt => 更新日時
	 */
	public function updateGameMode($request) {
		if(is_null($request)) throw new NullPointerException();
		if(!array_key_exists('rankingTableName', $request)) throw new NullPointerException();
		if(is_null($request['rankingTableName'])) throw new NullPointerException();
		if(!array_key_exists('gameMode', $request)) throw new NullPointerException();
		if(is_null($request['gameMode'])) throw new NullPointerException();
		$body = [];
		if(array_key_exists('calcInterval', $request)) $body['calcInterval'] = $request['calcInterval'];
		$query = [];
		return $this->doPut(
				'Gs2Ranking',
				'UpdateGameMode',
				Gs2RankingClient::$ENDPOINT,
				'/ranking/'. $request['rankingTableName']. '/mode/'. $request['gameMode'],
				$body,
				$query);
	}
	
	/**
	 * ゲームモードを削除
	 * 
	 * @param array $request
	 * * rankingTableName => ランキングテーブル名
	 * * gameMode => ゲームモード名
	 */
	public function deleteGameMode($request) {
		if(is_null($request)) throw new NullPointerException();
		if(!array_key_exists('rankingTableName', $request)) throw new NullPointerException();
		if(is_null($request['rankingTableName'])) throw new NullPointerException();
		if(!array_key_exists('gameMode', $request)) throw new NullPointerException();
		if(is_null($request['gameMode'])) throw new NullPointerException();
		$query = [];
		return $this->doDelete(
				'Gs2Ranking',
				'DeleteGameMode',
				Gs2RankingClient::$ENDPOINT,
				'/ranking/'. $request['rankingTableName']. '/mode/'. $request['gameMode'],
				$query);
	}
	
	/**
	 * ランキングを取得<br>
	 * <br>
	 * ランキングを取得します。<br>
	 * ランキングにはユーザID、スコア、メタデータといった基本情報のほかに、インデックスと順位が付加されています。<br>
	 * インデックスは先頭を1とした位置情報で、順位は同一スコアのユーザを同一順位として計算された値です。<br>
	 * ランキングの性質上、同一スコアでも別順位として扱いたい場合は順位の代わりにインデックスを利用することで実現できます。<br>
	 * <br>
	 * ランキングデータはランダムアクセスができますので、{@link getMyRank()} で自分の順位を取得して、<br>
	 * その前後のランキンデータを取得する。というような処理も実現できます。<br>
	 *
	 * @param array $request
	 * * rankingTableName => ランキングテーブル名
	 * * gameMode => ゲームモード名
	 * @param integer $offset 取得開始オフセット
	 * @param integer $limit 取得件数
	 * @return array
	 * * items
	 * 	* array
	 * 		* index => インデックス
	 * 		* rank => 順位
	 * 		* userId => ユーザID
	 * 		* score => スコア
	 * 		* meta => メタ情報
	 * 		* updateAt => 更新日時
	 * * nextPageToken => 次ページトークン
	 */
	public function getRanking($request, $offset = NULL, $limit = NULL) {
		if(is_null($request)) throw new NullPointerException();
		if(!array_key_exists('rankingTableName', $request)) throw new NullPointerException();
		if(is_null($request['rankingTableName'])) throw new NullPointerException();
		if(!array_key_exists('gameMode', $request)) throw new NullPointerException();
		if(is_null($request['gameMode'])) throw new NullPointerException();
		$query = [];
		if($offset) $query['offset'] = $offset;
		if($limit) $query['limit'] = $limit;
		return $this->doGet(
				'Gs2Ranking',
				'GetRanking',
				Gs2RankingClient::$ENDPOINT,
				'/ranking/'. $request['rankingTableName']. '/mode/'. $request['gameMode']. '/ranking',
				$query);
	}
	
	/**
	 * スコアを登録<br>
	 * <br>
	 * スコアの登録は一時的にバッファリングされ、定期的にランキングデータとして書き込まれます。<br>
	 * そのため、スコア登録直後にランキング集計が開始された場合は、集計結果に含まれない可能性があります。<br>
	 * <br>
	 * accessToken には {@link http://static.docs.gs2.io/php/auth/class-GS2.Auth.Gs2AuthClient.html#_login GS2\Auth\Gs2AuthClient::login()} でログインして取得したアクセストークンを指定してください。<br>
	 * 
	 * @param array $request
	 * * rankingTableName => ランキングテーブル名
	 * * gameMode => ゲームモード名
	 * * score => スコア
	 * * meta => メタ情報
	 * * accessToken => アクセストークン
	 * @return array 
	 * * item
	 * 	* rankingTableId => ランキングテーブルID
	 * 	* gameMode => ゲームモード名
	 * 	* userId => ユーザID
	 * 	* score => スコア
	 * 	* meta => メタ情報
	 * 	* updateAt => 更新日時
	 */
	public function putScore($request) {
		if(is_null($request)) throw new NullPointerException();
		if(!array_key_exists('rankingTableName', $request)) throw new NullPointerException();
		if(is_null($request['rankingTableName'])) throw new NullPointerException();
		if(!array_key_exists('gameMode', $request)) throw new NullPointerException();
		if(is_null($request['gameMode'])) throw new NullPointerException();
		if(!array_key_exists('accessToken', $request)) throw new NullPointerException();
		if(is_null($request['accessToken'])) throw new NullPointerException();
		$body = [];
		if(array_key_exists('score', $request)) $body['score'] = $request['score'];
		if(array_key_exists('meta', $request)) $body['meta'] = $request['meta'];
		$extparams = [
				'headers' => [
						'X-GS2-ACCESS-TOKEN' => $request['accessToken']
				]
		];
		$query = [];
		return $this->doPost(
				'Gs2Ranking',
				'PutScore',
				Gs2RankingClient::$ENDPOINT,
				'/ranking/'. $request['rankingTableName']. '/mode/'. $request['gameMode']. '/ranking',
				$body,
				$query,
				$extparams);
	}

	/**
	 * 自分の順位を取得<br>
	 * <br>
	 * 自分の順位を取得できます、応答される値は集計時点での正確な値となります。<br>
	 * <br>
	 * accessToken には {@link http://static.docs.gs2.io/php/auth/class-GS2.Auth.Gs2AuthClient.html#_login GS2\Auth\Gs2AuthClient::login()} でログインして取得したアクセストークンを指定してください。<br>
	 * 
	 * @param array $request
	 * * rankingTableName => ランキングテーブル名
	 * * gameMode => ゲームモード名
	 * * accessToken => アクセストークン
	 * @return array 
	 * * index => インデックス
	 * * rank => 順位
	 */
	public function getMyRank($request) {
		if(is_null($request)) throw new NullPointerException();
		if(!array_key_exists('rankingTableName', $request)) throw new NullPointerException();
		if(is_null($request['rankingTableName'])) throw new NullPointerException();
		if(!array_key_exists('gameMode', $request)) throw new NullPointerException();
		if(is_null($request['gameMode'])) throw new NullPointerException();
		if(!array_key_exists('accessToken', $request)) throw new NullPointerException();
		if(is_null($request['accessToken'])) throw new NullPointerException();
		$extparams = [
				'headers' => [
						'X-GS2-ACCESS-TOKEN' => $request['accessToken']
				]
		];
		$query = [];
		return $this->doGet(
				'Gs2Ranking',
				'GetMyRank',
				Gs2RankingClient::$ENDPOINT,
				'/ranking/'. $request['rankingTableName']. '/mode/'. $request['gameMode']. '/ranking/rank',
				$query,
				$extparams);
	}

	/**
	 * スコアを指定しておおよその順位を取得<br>
	 * <br>
	 * 指定したスコアを取ったと仮定して何位ぐらいになれるのか、といった指標を計算する際に利用します。<br>
	 * 原則1000位単位でおおよその順位を応答します。<br>
	 * <br>
	 * 上位プレイヤーに対しては1000位単位の解像度では情報が不足している場合があると思いますので、<br>
	 * 応答が上位プレイヤーだった場合は、更に {@link getRanking()} で上位のスコアを取得して<br>
	 * さらに詳細な順位に絞り込んで情報提供する。というのもユーザ体験をよく出来ると思います。<br>
	 *
	 * @param array $request
	 * * rankingTableName => ランキングテーブル名
	 * * gameMode => ゲームモード名
	 * * score => スコア
	 * @return array 
	 * * min => おおよその順位の最小値
	 * * max => おおよその順位の最大値
	 */
	public function getEstimateRank($request) {
		if(is_null($request)) throw new NullPointerException();
		if(!array_key_exists('rankingTableName', $request)) throw new NullPointerException();
		if(is_null($request['rankingTableName'])) throw new NullPointerException();
		if(!array_key_exists('gameMode', $request)) throw new NullPointerException();
		if(is_null($request['gameMode'])) throw new NullPointerException();
		$query = [];
		if($request['score']) $query['score'] = $request['score'];
		return $this->doGet(
				'Gs2Ranking',
				'GetEstimateRank',
				Gs2RankingClient::$ENDPOINT,
				'/ranking/'. $request['rankingTableName']. '/mode/'. $request['gameMode']. '/ranking/estimate',
				$query);
	}
	
}