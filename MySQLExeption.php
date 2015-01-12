<?php
  /**
  * Gestion des erreurs avec les exeptions
  */
  class MySQLExeption  extends Exception
  {
    public function __construct($Msg) {
      parent :: __construct($Msg);
    }
    public function RetourneErreur() {
      $msg  = '<div><strong>' . $this->getMessage() . '</strong>';
      $msg .= ' Ligne : ' . $this->getLine() . '</div>';
      return $msg;
    }
  }
?>