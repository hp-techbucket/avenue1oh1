<?php

class Details_modification_model extends MY_Model {
    
    const DB_TABLE = 'details_modification';
    const DB_TABLE_PK = 'details_modification_id';

	
	/**
     * email_address of the modifier.
     * @var string 
     */
    public $email_address;

     /**
     * Modified by.
     * @var string
     */
    public $modified_by; 


	 /**
     * Date Modified.
     * @var string 
     */
    public $date_modified;
	

	
	
	
}