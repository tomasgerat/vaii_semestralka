<?php


namespace App\Controllers;


use App\Config\Configuration;
use App\Core\AControllerBase;
use App\Models\Authentificator;
use App\Models\DataModels\TopicInCategoriesCnt;
use App\Models\DataModels\UserInTopic;
use App\Models\DataModels\EntriesCount;
use App\Models\DbSelector;
use App\Models\Tools;
use App\Models\Topic;
use App\Models\User;

class ContentController extends AControllerBase
{
    public function index()
    {
        return $this->redirect("?c=Content&a=home");
    }

    public function home()
    {
        if (!Authentificator::getInstance()->isLogged()) {
            return $this->redirect("?c=User&a=login");
        } else {
            $data = [];
            $data["tabTitle"] = "Home";
            $data["tabCss"] = "main.css";
            $data["tabActive"] = "home";
            $errors["unknown"] = "";
            $topics = null;

            /** @var User $user */
            $user = Authentificator::getInstance()->getLoggedUser();

            $data["url"] = "?c=Content&a=home";
            $data["category_url"] = "?c=Content&a=home";
            $category = isset($_GET["category"]) ? $_GET["category"] : null;
            if($category != null) {
                $data["url"] .= ("&category=".$category);
                $data["category"] = $category;
            } else {
                $data["category"] = -1;
            }
            try {
                $currentPage = isset($_GET['page']) ? $_GET['page'] : 0;
                /** @var UserInTopic[] $topics */
                $topics = DbSelector::getAllTopicsWhereUser($user->getId(), $currentPage * 10, 10, $category);
                /** @var EntriesCount $countObj */
                $countObj = DbSelector::countAllTopicsWhereUser($user->getId(), $category);
                /** @var TopicInCategoriesCnt[] $categories */
                $categories = DbSelector::getAllCategoriesCntForUser($user->getId());
                $data["topics"] = $topics;
                $data["categories"] = $categories;
                $data["topics_count"] = $countObj[0]->count;
            } catch (\Exception $e) {
                $errors["unknown"] .= "Could not get data from database. " . (Configuration::DEBUG_EXCEPTIONS ? $e->getMessage() : "");
                $data["errors"] = $errors;
            }
            return $this->html($data, "home");
        }
    }

    public function recent()
    {
        if (!Authentificator::getInstance()->isLogged()) {
            return $this->redirect("?c=User&a=login");
        } else {
            $data = [];
            $data["tabTitle"] = "Recent";
            $data["tabCss"] = "main.css";
            $data["tabActive"] = "recent";
            $errors["unknown"] = "";
            $topics = null;

            /** @var User $user */
            //$user = Authentificator::getInstance()->getLoggedUser();
            $data["url"] = "?c=Content&a=recent";
            $data["category_url"] = "?c=Content&a=recent";
            $category = isset($_GET["category"]) ? $_GET["category"] : null;
            if($category != null) {
                $data["url"] .= ("&category=".$category);
                $data["category"] = $category;
            } else {
                $data["category"] = -1;
            }
            try {
                $currentPage = isset($_GET['page']) ? $_GET['page'] : 0;
                /** @var UserInTopic[] $topics */
                $topics = DbSelector::getAllTopics($currentPage * 10, 10, $category);
                /** @var EntriesCount $countObj */
                $countObj = DbSelector::countAllTopics($category);
                $categories = DbSelector::getAllCategoriesCnt();
                $data["topics"] = $topics;
                $data["categories"] = $categories;
                $data["topics_count"] = $countObj[0]->count;
            } catch (\Exception $e) {
                $errors["unknown"] .= "Could not get data from database. " . (Configuration::DEBUG_EXCEPTIONS ? $e->getMessage() : "");
                $data["errors"] = $errors;
            }
            return $this->html($data, "home");
        }
    }

    public function search()
    {
        if (!Authentificator::getInstance()->isLogged()) {
            return $this->redirect("?c=User&a=login");
        } else {
            $data = [];
            $data["tabTitle"] = "Search";
            $data["tabCss"] = "main.css";
            $data["tabActive"] = "";
            $errors["unknown"] = "";
            $topics = null;

            if (!Tools::checkIssetGet(["searchText"]) || $_GET["searchText"] == "") {
                return $this->redirect("?c=Content&a=recent");
            }


            $searchText =  "%".$_GET["searchText"]."%" ;
            $data["url"] = "?c=Content&a=search&searchText=".$_GET["searchText"];
            $data["category_url"] = "?c=Content&a=search&searchText=".$_GET["searchText"];
            $category = isset($_GET["category"]) ? $_GET["category"] : null;
            if($category != null) {
                $data["url"] .= ("&category=".$category);
                $data["category"] = $category;
            } else {
                $data["category"] = -1;
            }

            try {
                $currentPage = isset($_GET['page']) ? $_GET['page'] : 0;
                /** @var UserInTopic[] $topics */
                $topics = DbSelector::searchAllTopics($currentPage * 10, 10, $searchText, $category);
                /** @var EntriesCount $countObj */
                $countObj = DbSelector::countAllSearchedTopics($searchText, $category);
                $categories = DbSelector::getAllCategoriesCntForSearch($searchText);
                $data["topics"] = $topics;
                $data["categories"] = $categories;
                $data["topics_count"] = $countObj[0]->count;
            } catch (\Exception $e) {
                $errors["unknown"] .= "Could not get data from database. " . (Configuration::DEBUG_EXCEPTIONS ? $e->getMessage() : "");
                $data["errors"] = $errors;
            }
            return $this->html($data, "home");
        }
    }
}