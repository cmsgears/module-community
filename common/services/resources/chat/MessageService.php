<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\community\common\services\resources\chat;

// Yii Imports
use Yii;
use yii\data\Sort;
use yii\helpers\ArrayHelper;

// CMG Imports
use cmsgears\core\common\services\interfaces\resources\IFileService;
use cmsgears\community\common\services\interfaces\resources\chat\IMessageService;

/**
 * MessageService provide service methods of chat message.
 *
 * @since 1.0.0
 */
class MessageService extends \cmsgears\core\common\services\base\ResourceService implements IMessageService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass = '\cmsgears\community\common\models\resources\ChatMessage';

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	private $fileService;

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	public function __construct( IFileService $fileService, $config = [] ) {

		$this->fileService = $fileService;

		parent::__construct( $config );
	}

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// MessageService ------------------------

	// Data Provider ------

	public function getPage( $config = [] ) {

		$modelClass	= static::$modelClass;
		$modelTable	= $this->getModelTable();

		$chatTable	= Yii::$app->factory->get( 'chatService' )->getModelTable();

	    $sort = new Sort([
	        'attributes' => [
	            'id' => [
	                'asc' => [ "$modelTable.id" => SORT_ASC ],
	                'desc' => [ "$modelTable.id" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Id'
	            ],
	            'chat' => [
	                'asc' => [ "$chatTable.title" => SORT_ASC ],
	                'desc' => [ "$chatTable.title" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Chat'
	            ],
	            'sender' => [
	                'asc' => [ "sender.name" => SORT_ASC ],
	                'desc' => [ "sender.name" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Sender'
	            ],
	            'recipient' => [
	                'asc' => [ "recipient.name" => SORT_ASC ],
	                'desc' => [ "recipient.name" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Recipient'
	            ],
	            'type' => [
	                'asc' => [ "$modelTable.type" => SORT_ASC ],
	                'desc' => [ "$modelTable.type" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Type'
	            ],
				'sent' => [
					'asc' => [ "$modelTable.sent" => SORT_ASC ],
					'desc' => [ "$modelTable.sent" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Sent'
				],
				'delivered' => [
					'asc' => [ "$modelTable.delivered" => SORT_ASC ],
					'desc' => [ "$modelTable.delivered" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Delivered'
				],
				'consumed' => [
					'asc' => [ "$modelTable.consumed" => SORT_ASC ],
					'desc' => [ "$modelTable.consumed" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Consumed'
				],
	            'cdate' => [
	                'asc' => [ "$modelTable.createdAt" => SORT_ASC ],
	                'desc' => [ "$modelTable.createdAt" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Created At'
	            ],
	            'udate' => [
	                'asc' => [ "$modelTable.modifiedAt" => SORT_ASC ],
	                'desc' => [ "$modelTable.modifiedAt" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Update At'
	            ]
	        ],
	        'defaultOrder' => [
	        	'cdate' => SORT_DESC
	        ]
	    ]);

		if( !isset( $config[ 'sort' ] ) ) {

			$config[ 'sort' ] = $sort;
		}

		// Query ------------

		if( !isset( $config[ 'query' ] ) ) {

			$config[ 'hasOne' ] = true;
		}

		// Filters ----------

		// Params
		$type	= Yii::$app->request->getQueryParam( 'type' );
		$filter	= Yii::$app->request->getQueryParam( 'model' );

		// Filter - Type
		if( isset( $type ) ) {

			$config[ 'conditions' ][ "$modelTable.type" ] = $type;
		}

		// Filter - Model
		if( isset( $filter ) ) {

			switch( $filter ) {

				case 'sent': {

					$config[ 'conditions' ][ "$modelTable.sent" ] = true;

					break;
				}
				case 'delivered': {

					$config[ 'conditions' ][ "$modelTable.delivered" ] = true;

					break;
				}
				case 'consumed': {

					$config[ 'conditions' ][ "$modelTable.consumed" ] = true;

					break;
				}
			}
		}

		// Searching --------

		$searchCol = Yii::$app->request->getQueryParam( 'search' );

		if( isset( $searchCol ) ) {

			$search = [
				'content' => "$modelTable.content"
			];

			$config[ 'search-col' ] = $search[ $searchCol ];
		}

		// Reporting --------

		$config[ 'report-col' ]	= [
			'type' => "$modelTable.type",
			'sent' => "$modelTable.sent",
			'delivered' => "$modelTable.delivered",
			'consumed' => "$modelTable.consumed",
			'content' => "$modelTable.content"
		];

		// Result -----------

		return parent::getPage( $config );
	}

	public function getPageByType( $type, $config = [] ) {

		$modelTable = $this->getModelTable();

		$config[ 'conditions' ][ "$modelTable.type" ] = $type;

		return $this->getPage( $config );
	}

	public function getPageByChatId( $chatId, $config = [] ) {

		$modelTable = $this->getModelTable();

		$config[ 'conditions' ][ "$modelTable.chatId" ] = $chatId;

		return $this->getPage( $config );
	}

	public function getPageByTypeChatId( $type, $chatId, $config = [] ) {

		$modelTable = $this->getModelTable();

		$config[ 'conditions' ][ "$modelTable.type" ]	= $type;
		$config[ 'conditions' ][ "$modelTable.chatId" ]	= $chatId;

		return $this->getPage( $config );
	}

	// Read ---------------

    // Read - Models ---

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	public function create( $model, $config = [] ) {

		$modelClass	= static::$modelClass;

		$avatar	= isset( $config[ 'avatar' ] ) ? $config[ 'avatar' ] : null;
		$banner	= isset( $config[ 'banner' ] ) ? $config[ 'banner' ] : null;
		$video 	= isset( $config[ 'video' ] ) ? $config[ 'video' ] : null;

		$model->type = $model->type ?? CoreGlobal::TYPE_DEFAULT;

		$this->fileService->saveFiles( $model, [ 'avatarId' => $avatar, 'bannerId' => $banner, 'videoId' => $video ] );

		return parent::create( $model, $config );
	}

	// Update -------------

	public function update( $model, $config = [] ) {

		$admin = isset( $config[ 'admin' ] ) ? $config[ 'admin' ] : false;

		$attributes = isset( $config[ 'attributes' ] ) ? $config[ 'attributes' ] : [
			'avatarId', 'bannerId', 'videoId',
			'icon', 'texture', 'content'
		];

		$avatar	= isset( $config[ 'avatar' ] ) ? $config[ 'avatar' ] : null;
		$banner	= isset( $config[ 'banner' ] ) ? $config[ 'banner' ] : null;
		$video 	= isset( $config[ 'video' ] ) ? $config[ 'video' ] : null;

		if( $admin ) {

			$attributes	= ArrayHelper::merge( $attributes, [ 'sent', 'delivered', 'consumed' ] );
		}

		$this->fileService->saveFiles( $model, [ 'avatarId' => $avatar, 'bannerId' => $banner, 'videoId' => $video ] );

		return parent::update( $model, [
			'attributes' => $attributes
		]);
	}

	// Delete -------------

	public function delete( $model, $config = [] ) {

		// Delete files
		$this->fileService->deleteMultiple( [ $model->avatar, $model->banner, $model->video ] );

		// Delete model
		return parent::delete( $model, $config );
	}

	// Bulk ---------------

	protected function applyBulk( $model, $column, $action, $target, $config = [] ) {

		switch( $column ) {

			case 'model': {

				switch( $action ) {

					case 'sent': {

						$model->sent = true;

						$model->update();

						break;
					}
					case 'delivered': {

						$model->delivered = true;

						$model->update();

						break;
					}
					case 'consumed': {

						$model->consumed = true;

						$model->update();

						break;
					}
					case 'delete': {

						$this->delete( $model );

						break;
					}
				}

				break;
			}
		}
	}

	// Notifications ------

	// Cache --------------

	// Additional ---------

	// Static Methods ----------------------------------------------

	// CMG parent classes --------------------

	// MessageService ------------------------

	// Data Provider ------

	// Read ---------------

    // Read - Models ---

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	// Delete -------------

}
