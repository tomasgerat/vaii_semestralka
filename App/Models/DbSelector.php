<?php


namespace App\Models;

use App\Core\DB\Connection;
use App\Core\DB\DebugStatement;
use App\Models\DataModels\UserInTopic;
use PDO;
use PDOException;



class DbSelector
{
    /**
     * @var Connection
     */
    private static $connection = null;

    /**
     * Gets DB connection for other model methods
     * @return null
     * @throws \Exception
     */
    private static function connect()
    {
        self::$connection = Connection::connect();
    }

    /**
     * @return null
     */
    public static function getConnection()
    {
        return self::$connection;
    }

    static  public function getAllCategoriesCnt() : array
    {
        $sql =  "select (select count(*) from topic where category=0) as computers,".
                        "(select count(*) from topic where category=1) as games,".
                        "(select count(*) from topic where category=2) as science,".
                        "(select count(*) from topic where category=3) as movies,".
                        "(select count(*) from topic where category=4) as music,".
                        "(select count(*) from topic where category=5) as other";
        $params = [];
        try {
            return DbSelector::doQuery($sql, $params, "App\\Models\\DataModels\\TopicInCategoriesCnt");
        } catch (\Exception $e) {
            throw new \Exception('Query failed: ' . $e->getMessage());
        }
    }

    static  public function getAllCategoriesCntForUser($autor) : array
    {
        $sql =  "select (select count(*) from topic where category=0 and (( id in ".
            " (SELECT DISTINCT topic from comment where autor = ? )) or (autor = ? ))) as computers,".
            "(select count(*) from topic where category=1 and (( id in ".
            " (SELECT DISTINCT topic from comment where autor = ? )) or (autor = ? ))) as games,".
            "(select count(*) from topic where category=2 and (( id in ".
            " (SELECT DISTINCT topic from comment where autor = ? )) or (autor = ? ))) as science,".
            "(select count(*) from topic where category=3 and (( id in ".
            " (SELECT DISTINCT topic from comment where autor = ? )) or (autor = ? ))) as movies,".
            "(select count(*) from topic where category=4 and (( id in ".
            " (SELECT DISTINCT topic from comment where autor = ? )) or (autor = ? ))) as music,".
            "(select count(*) from topic where category=5 and (( id in ".
            " (SELECT DISTINCT topic from comment where autor = ? )) or (autor = ? ))) as other";
        $params = [$autor,$autor,$autor,$autor,$autor,$autor,
                    $autor,$autor,$autor,$autor,$autor,$autor];
        try {
            return DbSelector::doQuery($sql, $params, "App\\Models\\DataModels\\TopicInCategoriesCnt");
        } catch (\Exception $e) {
            throw new \Exception('Query failed: ' . $e->getMessage());
        }
    }

    static  public function getAllCategoriesCntForSearch($searchText) : array
    {
        $sql =  "select (select count(*) from topic where category=0 and text like ?) as computers,".
            "(select count(*) from topic where category=1 and text like ?) as games,".
            "(select count(*) from topic where category=2 and text like ?) as science,".
            "(select count(*) from topic where category=3 and text like ?) as movies,".
            "(select count(*) from topic where category=4 and text like ?) as music,".
            "(select count(*) from topic where category=5 and text like ?) as other";
        $params = [$searchText,$searchText,$searchText,$searchText,$searchText, $searchText];
        try {
            return DbSelector::doQuery($sql, $params, "App\\Models\\DataModels\\TopicInCategoriesCnt");
        } catch (\Exception $e) {
            throw new \Exception('Query failed: ' . $e->getMessage());
        }
    }

    /**
     *  $count = -1  vsetky zaznamy
     */
    static  public function getAllCommentsWhereTopic($topic, $start, $count) : array
    {
        $sql =  'select *, (select login from user where cc.autor = id ) as login from comment as cc where topic = ?'.
                ' order by created asc'. ($count == -1 ? '' :  ' limit ?,?') ;
        if($count == - 1)
            $params = [ $topic ];
        else
            $params = [ $topic, $start, $count];

        try {
            return DbSelector::doQuery($sql, $params, "App\\Models\\DataModels\\UserInComment");
        } catch (\Exception $e) {
            throw new \Exception('Query failed: ' . $e->getMessage());
        }
    }

    static  public function countAllCommentsInTopic($topic) : array
    {
        $sql =  "SELECT count(*) as count FROM comment where topic = ?";
        $params = [ $topic ];
        try {
            return DbSelector::doQuery($sql, $params, "App\\Models\\DataModels\\EntriesCount");
        } catch (\Exception $e) {
            throw new \Exception('Query failed: ' . $e->getMessage());
        }
    }

    /**
     *  $count = -1  vsetky zaznamy
     */
    static  public function getAllTopicsWhereUser($autor, $start, $count, $category = null) : array
    {
        $sql =  "SELECT DISTINCT *, (select count(*) from comment where tt.id = topic) as comments," .
            " (select login from user where tt.autor = id) as login FROM topic" .
            " as tt where (( id in ".
            " (SELECT DISTINCT topic from comment where autor = ? )) or (autor = ? )) " .
            ($category == null ? '' : 'and category = ? ' ) .
            'order by created desc'. ($count == -1 ? '' :  ' limit ?,?') ;

        $params = [ $autor, $autor ];
        if($category != null) {
            $params[] = $category;
        }
        if($count != - 1) {
            $params[] = $start;
            $params[] = $count;
        }

        try {
            return DbSelector::doQuery($sql, $params, "App\\Models\\DataModels\\UserInTopic");
        } catch (\Exception $e) {
            throw new \Exception('Query failed: ' . $e->getMessage());
        }
    }

    static  public function countAllTopicsWhereUser($autor, $category = null) : array
    {
        $sql =  "SELECT DISTINCT count(*) as count FROM topic where (( id in ".
                        "(SELECT DISTINCT topic from comment where autor = ? )) or (autor = ? )) "
                        .($category == null ? '' : 'and category = ? ' );
        $params = [ $autor, $autor ];
        if($category != null) {
            $params[] = $category;
        }
        try {
            return DbSelector::doQuery($sql, $params, "App\\Models\\DataModels\\EntriesCount");
        } catch (\Exception $e) {
            throw new \Exception('Query failed: ' . $e->getMessage());
        }
    }

    static  public function getAllTopics($start, $count, $category = null) : array
    {
        $sql =  "SELECT DISTINCT *, (select count(*) from comment where tt.id = topic) as comments," .
            " (select login from user where tt.autor = id) as login FROM topic as tt " .
            ($category == null ? '' : 'where category = ? ' ) .
            'order by created desc'. ($count == -1 ? '' :  ' limit ?,?') ;

        $params = [];
        if($category != null) {
            $params[] = $category;
        }
        if($count != - 1) {
            $params[] = $start;
            $params[] = $count;
        }

        try {
            return DbSelector::doQuery($sql, $params, "App\\Models\\DataModels\\UserInTopic");
        } catch (\Exception $e) {
            throw new \Exception('Query failed: ' . $e->getMessage());
        }
    }

    static  public function countAllTopics($category = null) : array
    {
        $sql =  "SELECT DISTINCT count(*) as count FROM topic " .
                ($category == null ? '' : 'where category = ? ' );
        $params = [];
        if($category != null) {
            $params[] = $category;
        }
        try {
            return DbSelector::doQuery($sql, $params, "App\\Models\\DataModels\\EntriesCount");
        } catch (\Exception $e) {
            throw new \Exception('Query failed: ' . $e->getMessage());
        }
    }

    static  public function searchAllTopics($start, $count, $searchText, $category = null) : array
    {
        $sql =  "SELECT DISTINCT *, (select count(*) from comment where tt.id = topic) as comments, " .
            "(select login from user where tt.autor = id) as login FROM topic as tt " .
            'where text like ? '. ($category == null ? '' : 'and category = ? ' ) .
            'order by created desc'. ($count == -1 ? '' :  ' limit ?,?') ;
        $params[] = $searchText;
        if($category != null) {
            $params[] = $category;
        }
        if($count != - 1) {
            $params[] = $start;
            $params[] = $count;
        }

        try {
            return DbSelector::doQuery($sql, $params, "App\\Models\\DataModels\\UserInTopic");
        } catch (\Exception $e) {
            throw new \Exception('Query failed: ' . $e->getMessage());
        }
    }

    static public function countAllSearchedTopics($searchText, $category = null) :array
    {
        $sql =  "SELECT DISTINCT count(*) as count FROM topic ".
                'where text like ? ' .($category == null ? '' : 'and category = ? ' );
        $params = [ $searchText];
        if($category != null) {
            $params[] = $category;
        }
        try {
            return DbSelector::doQuery($sql, $params, "App\\Models\\DataModels\\EntriesCount");
        } catch (\Exception $e) {
            throw new \Exception('Query failed: ' . $e->getMessage());
        }
    }

    static private function doQuery(string $sql, array $params, string $className) : array
    {
        self::connect();
        try {
            /** @var DebugStatement $stmt */
            $stmt = self::$connection->prepare($sql);
            $i = 1;
            foreach($params as $key => $value)
            {
                if(is_int($value))
                {
                    $stmt->bindParam($i, $value, PDO::PARAM_INT);
                }
                else
                {
                    $stmt->bindParam($i, $value, PDO::PARAM_STR, 12);
                }
                $i++;
            }
            $stmt->execute(null);

            $dbModels = $stmt->fetchAll();  //vrati vsetky riadky
            $models = []; // pole UserTopic
            foreach ($dbModels as $model) {
                $tmpModel = new $className();
                $data = array_fill_keys($className::setDbColumns(), null);
                foreach ($data as $key => $item) {
                    $tmpModel->$key = $model[$key];
                }
                $models[] = $tmpModel;
            }
            return $models;
        } catch (PDOException $e) {
            throw new \Exception('Query failed: ' . $e->getMessage());
        }
    }
}