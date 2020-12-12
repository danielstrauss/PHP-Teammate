<?php
include_once("header.php");
class User extends dbconnect {

    public function getAllUsersInLogin() {
        $stmt = $this->funcDbConnect()->query("SELECT * FROM login");
        /*while($userComplete = $stmt->fetch(PDO::FETCH_ASSOC)){
            return $userComplete;
        }*/
        $userComplete = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $userComplete;
        }

    public function getUserViaIdInLogin($id){
        $stmt = $this->funcDbConnect()->prepare("SELECT * FROM login WHERE id=?");
        $stmt->execute([$id]);
        $resultGetUserViaId = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultGetUserViaId;
    }

    public function getUserViaEmailadressInLogin($emailadress){
        $stmt = $this->funcDbConnect()->prepare("SELECT * FROM login WHERE emailadress=?");
        $stmt->execute([$emailadress]);
        $resultGetUserViaEmailadressInLogin = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultGetUserViaEmailadressInLogin;
    }

    public function setLastLoginTimeInLogin($timelogin_fin, $id){
        $stmt = $this->funcDbConnect()->prepare("UPDATE login SET last_login=? WHERE id=?");
        $stmt->execute([$timelogin_fin,$id]);
    }
    
    public function setNewUserToLogin($username,$encrypted_password,$time_fin,$emailadress,$role){
        $stmt = $this->funcDbConnect()->prepare("INSERT INTO login (username, password, reg_date, emailadress, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$username,$encrypted_password,$time_fin,$emailadress,$role]);
        if($stmt)
        {
        echo '<div class="w3-text-green w3-small w3-container">New useraccount created successfully! <a href="index.php"> Login here </a></div>';
        }
        else{
            '<div class="w3-text-red w3-small w3-container">Error! Useraccount could not be added!</div>';
        }
        
    }

    public function setAttendToMeetingId($id){

        $stmt = $this->funcDbConnect()->prepare("SELECT attend FROM teammate WHERE meeting_id=?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    
    public function setAttendToMeetingIdInTeammate($result_fin,$id){
        $stmt = $this->funcDbConnect()->prepare("UPDATE teammate SET attend=? WHERE meeting_id=?");
        $stmt->execute([$result_fin,$id]);

    }
    
    public function getAttendToMeetingId($delid)
    {
        $stmt = $this->funcDbConnect()->prepare("SELECT attend FROM teammate WHERE meeting_id =?");
        $stmt->execute([$delid]);
        $delfetch = $stmt->fetch();
        return $delfetch;
    }

    public function delAttendToMeetingId($str,$delid){
        $stmt = $this->funcDbConnect()->prepare("UPDATE teammate SET attend=? WHERE meeting_id=?");
        $stmt->execute([$str,$delid]);
    }

        
    public function getAllMeetingsInTeammate(){
        $stmt = $this->funcDbConnect()->query("SELECT * from teammate ORDER BY order_id ASC");
        $return = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $return;
    }

    public function getAttendFromSpecificMeeting($ex_user_id){
        $stmt = $this->funcDbConnect()->prepare("SELECT username FROM login WHERE id =?");
        $stmt->execute([$ex_user_id]);
        $sql_fetch = $stmt->fetch(PDO::FETCH_ASSOC);
        return $sql_fetch;
    }
    public function deleteImgpathFromUser($img_path){
        $stmt = $this->funcDbConnect()->prepare("UPDATE login SET img_path=? WHERE img_path=?");
        $newpath="";
        $stmt->execute([$newpath,$img_path]);

    }
    public function setNewMeeting($meeting,$creator, $nextId){
        $stmt = $this->funcDbConnect()->prepare("INSERT INTO teammate (meeting,creator, order_id) VALUES (?, ?, ?)");
        $return = $stmt->execute([$meeting,$creator, $nextId]);
        return $return;
    }

    public function deleteMeetingFromTeammate($delmeetingid){
        $stmt = $this->funcDbConnect()->prepare("DELETE FROM teammate WHERE meeting_id = ?");
        $stmt->execute([$delmeetingid]);
    }
    public function getNextIncrementIdFromTeammate(){

        $stmt = $this->funcDbConnect()->query("SHOW TABLE STATUS LIKE 'teammate'");
        $fetch = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fetch["Auto_increment"];
    }

    public function updateOrderidFromTeammate($newValueOrderId, $meeting_id){
        $stmt = $this->funcDbConnect()->prepare("UPDATE teammate SET order_id=? WHERE meeting_id=?");
        $return = $stmt->execute([$newValueOrderId,$meeting_id]);
        return $return;
    }

    public function getActualOrderIdFromTeammate($meeting_id)
    {
        $stmt = $this->funcDbConnect()->prepare("SELECT order_id FROM teammate WHERE meeting_id =?");
        $stmt->execute([$meeting_id]);
        $delfetch = $stmt->fetch();
        return $delfetch["order_id"];
    }
}
?>
