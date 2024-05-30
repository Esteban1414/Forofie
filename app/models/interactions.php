<?php 
    namespace app\models;

    class interactions extends Model{

        protected $table;
        protected $fillable = [
            'userId',
            'postId',
            'tipo',
        ];
        public $values = [];

        public function __construct(){      
            parent::__construct();     
            $this->table = $this->connect();                    
        }

        public function toggleLike($pid,$uid,$t=1){            
            $result = $this -> count('postId')
                            -> where([['userId',$uid],['postId',$pid]])        
                            -> get();            
            if(json_decode($result)[0]->tt == 0){
                $this -> values = [$uid,$pid,$t];
                $this -> create();                
            }else{
                $this -> where([['userId',$uid],['postId',$pid]]) -> delete();                
            }
            return;
        }
    }
