<?php
require "database.php";

class story{
    public $id;
    public $userId;
    public $title;
    public $content;
    public $link;
    public $time;
    public $belong;

    private function __construct($id, $userId, $title, $content, $link, $time, $belong)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->title = $title;
        $this->content = $content;
        $this->link = $link;
        $this->time = $time;
        $this->belong = $belong;
    }

    # add story
    public static function addStory($userId, $title, $content, $link, $belong){
        global $mysqli;
        $stmt = $mysqli->prepare("insert into story (userId, title, content, link, `belong`) values (?, ?, ?, ?, ?)");
        if (!$stmt) {
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }

        $stmt->bind_param('issss', $userId, $title, $content, $link, $belong);
        if($stmt->execute()){
            $stmt->close();
            return true;
        }
        $stmt->close();
        return false;
    }

    #edit story
    public static function editStory($id, $title, $content, $link, $belong){
        global $mysqli;
        $stmt = $mysqli->prepare("update story set title=?, content=?, link=?, belong=? where id=?");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('ssssi', $title, $content, $link, $belong, $id);
        if($stmt->execute()){
            $stmt->close();
            return true;
        }
        $stmt->close();
        return false;
    }

    #delete story
    public static function deleteStory($id){
        global $mysqli;
        $stmt = $mysqli->prepare("delete from story where id=?");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('i', $id);
        if($stmt->execute()){
            $stmt->close();
            return true;
        }
        $stmt->close();
        return false;
    }

    #get story by id
    public static function getStoryById($id){
        global $mysqli;
        $stmt = $mysqli->prepare("select id, userId, title, content, link, time, belong from story where id=?");
        if (!$stmt) {
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->bind_result($id, $userId, $title, $content, $link, $time, $belong);
        if ($stmt->fetch()) {
            $s = new static($id, $userId, $title, $content, $link, $time, $belong);
            $stmt->close();
            if($s->id==null) return null;
            return $s;
        }
        $stmt->close();
        return null;
    }

    #get id by belong
    public static function getIdByBelong($belong){
        global $mysqli;
        $stmt = $mysqli->prepare("select id from story WHERE belong=?");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('s', $belong);
        $stmt->execute();
        $stmt->bind_result($id);
        if($stmt->fetch()){
            $stmt->close();
            return $id;
        }
        $stmt->close();
        return null;
    }

    #get the story array
    public static function getStoryArray(){
        global $mysqli;
        $stmt = $mysqli->prepare("select id, userId, title, content, link, time, belong from story order by time DESC");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
    
        $stmt->execute();
        $stmt->bind_result($id, $userId, $title, $content, $link, $time, $belong);
        $arr = array();
        while($stmt->fetch()){
            $singleStory = new static($id, $userId, $title, $content, $link, $time, $belong);
            array_push($arr, $singleStory);
        }
        $stmt->close();
        return $arr;
    }

    #get story array by author name
    public static function getStoryByAuthor($author){
        global $mysqli;
        $id = user::getIdByUser($author);
        $stmt = $mysqli->prepare("select id, userId, title, content, link, time, belong from story where userId=? order by time DESC");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->bind_result($id, $userId, $title, $content, $link, $time, $belong);
        $arr = array();
        while($stmt->fetch()){
            $singleStory = new static($id, $userId, $title, $content, $link, $time, $belong);
            array_push($arr, $singleStory);
        }
        $stmt->close();
        return $arr;
    }

    #get story array by Type
    public static function getStoryByBelong($belong){
        global $mysqli;
        $id = story::getIdByBelong($belong);
        $stmt = $mysqli->prepare("select id, userId, title, content, link, time, belong from story where id=? order by time DESC");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->bind_result($id, $userId, $title, $content, $link, $time, $belong);
        $arr = array();
        while($stmt->fetch()){
            $singleStory = new static($id, $userId, $title, $content, $link, $time, $belong);
            array_push($arr, $singleStory);
        }
        $stmt->close();
        return $arr;
    }

}
?>