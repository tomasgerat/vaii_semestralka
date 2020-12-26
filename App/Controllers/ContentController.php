<?php


namespace App\Controllers;


use App\Config\Configuration;
use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Authentificator;
use App\Models\DataModels\TopicInCategoriesCnt;
use App\Models\DataModels\UserInTopic;
use App\Models\DataModels\EntriesCount;
use App\Models\DbSelector;
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
            $errors["unknow"] = "";
            $topics = null;

            /** @var User $user */
            $user = Authentificator::getInstance()->getLoggedUser();
            try {
                $currentPage = isset($_GET['page']) ? $_GET['page'] : 0;
                /** @var UserInTopic[] $topics */
                $topics = DbSelector::getAllTopicsWhereUser($user->getId(), $currentPage * 10, 10 );
                /** @var EntriesCount $countObj */
                $countObj = DbSelector::countAllTopicsWhereUser($user->getId());
                $categories = DbSelector::getAllCategoriesCnt($user->getId());
                $data["topics"] = $topics;
                $data["categories"] = $categories;
                $data["topics_count"] = $countObj[0]->count;
            } catch (\Exception $e) {
                $errors["unknow"] .= "Could not get data from database. " . (Configuration::DEBUG_EXCEPTIONS ? $e->getMessage() : "");
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
            $errors["unknow"] = "";
            $topics = null;

            /** @var User $user */
            $user = Authentificator::getInstance()->getLoggedUser();
            try {
                $currentPage = isset($_GET['page']) ? $_GET['page'] : 0;
                /** @var UserInTopic[] $topics */
                $topics = DbSelector::getAllTopics($currentPage * 10, 10 );
                /** @var EntriesCount $countObj */
                $countObj = DbSelector::countAllTopics();
                $categories = DbSelector::getAllCategoriesCnt($user->getId());
                $data["topics"] = $topics;
                $data["categories"] = $categories;
                $data["topics_count"] = $countObj[0]->count;
            } catch (\Exception $e) {
                $errors["unknow"] .= "Could not get data from database. " . (Configuration::DEBUG_EXCEPTIONS ? $e->getMessage() : "");
                $data["errors"] = $errors;
            }
            return $this->html($data, "home");
        }
    }

    public function find()
    {
        //TODO
    }
}