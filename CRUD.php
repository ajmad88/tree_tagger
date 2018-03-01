<?php
class CRUD
{
  private $Db;
  function __construct($DB_CON){
    $this->Db = $DB_CON;
}

  public function checkCredentials($username, $password)
  {
      $user = $this->getUserByUsername($username);
      if (!$user) {
          // No user found with provided username
          return false;
      }
      if (!password_verify($password, $user['password'])) {
          // Password does not match
          return false;
      }
      if (password_needs_rehash($user['password'], PASSWORD_DEFAULT)) {
          // This password was hashed using an older algorithm, update with new hash.
          $this->updatePassword($user['id'], $password);
      }
      // The password is no longer needed from the user data
      unset($user['password']);
      return $user;
  }

  public function getUserByUsername($username)
  {
      $sth = $this->Db->prepare("SELECT * FROM users WHERE username LIKE :username");
      $sth->bindValue(":username", $username);
      $sth->execute();
      return $sth->fetch(PDO::FETCH_ASSOC);
	
  }

  public function updatePassword($id, $password)
  {
      $hash = password_hash($password, PASSWORD_DEFAULT);
      $sth = $this->Db->prepare("UPDATE users SET password = :password WHERE user_id = :id");
      $sth->bindValue(":password", $hash);
      $sth->bindValue(":id", $id, PDO::PARAM_INT);
      return $sth;
  }




  public function createUser($role, $username, $email, $fname, $lname, $password){
    try {
      $hashpass = password_hash($password, PASSWORD_DEFAULT);
      $statement = $this->Db->prepare("INSERT INTO users(role, username, email, fname, lname, password) VALUES (:role, :uname, :email, :fname, :lname, :pass)");
      $statement->bindparam(":role", $role);
      $statement->bindparam(":uname", $username);
      $statement->bindparam(":email", $email);
      $statement->bindparam(":fname", $fname);
      $statement->bindparam(":lname", $lname);
      $statement->bindparam(":pass", $hashpass);
      $statement->execute();
      return true;

    }
    catch (Exception $ex) {
      echo $ex->getMessage();
      return false;
    }
  }

  public function getUser($username, $password)
  {
    try
    {
      $statement = $this->Db->prepare("SELECT * FROM users WHERE username=:uname AND password=:pass");
      $statement->execute(array(":uname"=>$username, ":pass"=>$password));
      $dataRows = $statement->fetch(PDO::FETCH_ASSOC);
      return $dataRows;
    }
    catch (PDOException $ex)
    {
      echo $ex->getMessage();
    }
  }

  public function viewUser()
  {
    echo"<table class='table table-hover table-bordered table-responsive' align='center'>
      <tr>
        <td>User Role</td>
        <td>Username</td>
        <td>Password</td>
        <td>Email</td>
        <td>Firstname</td>
        <td>Lastname</td>
        <td>Edit</td>
        <td>Delete</td>
        </tr>
        ";
    try
    {
      $statement = $this->Db->prepare("SELECT * FROM users");
      $statement->execute();
      while($dataRows = $statement->fetch(PDO::FETCH_ASSOC))
      {
        echo "
          <tr>
            <td>".$dataRows['role']."</td>
            <td>".$dataRows['username']."</td>
            <td>".$dataRows['password']." </td>
            <td>".$dataRows['email']." </td>
            <td>".$dataRows['fname']." </td>
            <td>".$dataRows['lname']." </td>
            <td><button><a href='edituser.php?id=".$dataRows['user_id']."'>Edit</a></button></td>
            <td><button><a href='deleteuser.php?id=".$dataRows['user_id']."'>Delete</a></button></td>
          </tr>";
      }
      return $dataRows;
      echo "</table>";
    }
    catch (PDOException $ex)
    {
        echo $ex->getMessage();
    }
  }

  public function editUser()
  {
    try
    {
      $id = $_GET['id'];
      $statement=$this->Db->prepare("SELECT * FROM users WHERE user_id='".$id."'");
      $statement->execute();
      while($dataRows = $statement->fetch(PDO::FETCH_ASSOC))
      {
        echo"
        <form method='post'>
        <table border='0' align='center'>
        <tr><td>User Role: <input type='text' name='role' value='".$dataRows['role']."'></td></tr>
        <tr><td>First Name: <input type='text' name='fname' value='".$dataRows['fname']."'></td></tr>
        <tr><td>Last Name: <input type='text' name='lname' value='".$dataRows['lname']."'></td></tr>
        <tr><td>Username: <input type='text' name='uname' value='".$dataRows['username']."'></td></tr>
        <tr><td>Email: <input type='text' name='email' value='".$dataRows['email']."'></td></tr>
        <tr><td><button type='submit' name='submit'>Submit</button></td></tr>
        </table>
        </form>";
      }
      return $dataRows;
      return true;
    }
    catch(PDOException $ex)
    {
      echo $ex->getMessage();
      return false;
    }
  }

  public function delUser()
  {
      try{
        $id = $_GET['id'];
        $statement=$this->Db->prepare("DELETE * FROM users WHERE user_id='".$id."'");
        $statement->execute();
        echo "Entry Deleted!";
        return true;
      }
      catch(PDOException $ex)
      {
        echo $ex->getMessage();
        return false;
      }
  }

  public function updateUser($role, $fname, $lname, $username, $email)
  {
    $id = $_GET['id'];
    try
    {
        $statement = $this->Db->prepare("UPDATE users SET role = :urole, fname = :fname, lname = :lname, username = :uname, email = :email WHERE user_id = '$id'");
        $statement->bindparam(":urole", $role);
        $statement->bindparam(":fname", $fname);
        $statement->bindparam(":lname", $lname);
        $statement->bindparam(":uname", $username);
        $statement->bindparam(":email", $email);
        $statement->execute();
        echo "User Updated";
        return true;
    } catch(PDOException $ex)
    {
      echo $ex->getMessage();
      return false;
    }
  }

  public function addData($species, $description, $age, $city, $state, $lat, $lng)
  {
    try {
      $statement = $this->Db->prepare("INSERT INTO tree_info(species, tree_desc, age, city, state, lat, lng) VALUES (:spec, :tdesc, :age, :city, :state, :lat, :lng)");
      $statement->bindparam(":spec", $species);
      $statement->bindparam(":tdesc", $description);
      $statement->bindparam(":age", $age);
      $statement->bindparam(":city", $city);
      $statement->bindparam(":state", $state);
      $statement->bindparam(":lat", $lat);
      $statement->bindparam(":lng", $lng);
      $statement->execute();
      return true;

    } catch (PDOException $ex) {
        echo $ex->getMessage();
        return false;
    }
  }
}
?>
