<?php
  //Password Encryption code
  class HashPassword {
    public function Hash($unhashed) {
      $options = [
        'cost' => 11
        // 'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
      ];

      $hashed = password_hash($unhashed, PASSWORD_BCRYPT, $options);

      return $hashed;
    }
  }
?>
