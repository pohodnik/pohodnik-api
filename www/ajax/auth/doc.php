<?php
	/**
	* @OA\Get(
    *	path="/ajax/auth/providers_list.php",
	*	summary="Список доступных провайдеров авторизации",
	*	@OA\Response(
	*		response="200",
	*		description="Список провайдеров",
    *		@OA\JsonContent(
	*			@OA\Examples(
    *           	summary="Ответ в случае успешного получения данных",
    *       		value={
    *           	    "data":{
	*						{
    *           	    		"id":"1",
    *           	    		"id_status":"1",
    *           	    		"id_connection_request":"1",
    *           	    		"phone":"76665558965",
    *           	    		"name":"TEST",
    *           	    		"id_author":"3",
    *           	    		"created_at":"2021-02-28 11:11:15",
    *           	    		"updated_at":"2021-02-28 11:11:15",
    *           			},
    *           			{
    *           	    		"id":"2",
    *           	    		"id_status":"1",
    *           	    		"id_connection_request":"1",
    *           	    		"phone":"76665554444",
    *           	    		"name":"TEST",
    *           	    		"id_author":"3",
    *           	    		"created_at":"2021-02-28 11:12:15",
    *           	    		"updated_at":"2021-02-28 12:11:15",
	*           			}
	*					}
    *           	}
    *           )
    *		)
	*	)
	* )
	*/