<?php
class ColourGame extends User{
    protected $pdo;
    public function __construct($pdo){
        $this->pdo = $pdo;
    }
    
}
?>