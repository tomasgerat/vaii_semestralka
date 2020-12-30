<?php


namespace App\Models;


class Tools
{
    /**
     * @param string[] $dataArray
     * @return bool
     */
    public static function checkIssetPost($dataArray): bool
    {
        /** @var string $param */
        foreach ($dataArray as $param) {
            if (!isset($_POST[$param]))
                return false;
        }
        return true;
    }

    public static function checkIssetGet($dataArray): bool
    {
        /** @var string $param */
        foreach ($dataArray as $param) {
            if (!isset($_GET[$param]))
                return false;
        }
        return true;
    }

    public static function getErrorDiv($key, $errors): string
    {
        $result = '<div class="text text-danger mb-3 error_text" id="' . 'err_' . $key . /*'" name="' . 'err_' . $key .*/ '">';
        if (isset($errors[$key])) {
            $result = $result . $errors[$key];
        }
        $result = $result . '</div>';
        return $result;
    }

    public static function getPaggination($pagesCount, $currentPage, $url, $currentPageId = "current_page")
    {
        if($pagesCount == 0)
            $pagesCount = 1;
        //$pagesCount = ceil(count($topics) / 10.0);
        $page = $currentPage;
        if($pagesCount <= 0)
            return "";
        //previsious
        $paggination = '<div class="float-left"> <a href="' .
            ($page < 1 ? "#" : $url . "&page=" . ($page - 1)) .
            '" class="navigation_angle  mt-1"> <i class="fa fa-angle-left"></i> </a> </div>';
        $paggination .= '<div class="float-left"> <ul class="paggination_ul">';

        if ($pagesCount < 5) {

            for ($i = 0; $i < $pagesCount; $i++) {
                $paggination .= '<li class="navigation_page_num"> <a href="' .
                    $url . '&page=' . $i . '"> <span class="badge '. ($i == $currentPage ? 'badge-dark">' : 'badge-secondary mt-1">') . ($i + 1) .
                    '</span> </a> </li>';
            }
        } else if ($pagesCount >= 5) {
            $startIndex = $page;
            $diff = $pagesCount - $page;
            if ($diff < 5) {
                $startIndex = $pagesCount - 5;
            }
            $endIndex = $startIndex + 5;
            if ($startIndex != 0) {
                $paggination .= '<li class="navigation_page_num"><a href="' . $url . '&page=0">' .
                    '<span class="badge badge-secondary mt-1">1</span></a></li>' .
                    '<li class="navigation_page_num"><a href="#"> ' .
                    '<span class="badge badge-secondary mt-1">...</span></a></li>';
            }
            for ($i = $startIndex; $i < $endIndex; $i++) {
                $paggination .= '<li class="navigation_page_num"> <a href="' .
                    $url . '&page=' . $i . '"> <span class="badge '. ($i == $currentPage ? 'badge-dark mt-1">' : 'badge-secondary mt-1">') .
                    ($i + 1) . '</span></a> </li>';
            }
            if ($endIndex != $pagesCount) {
                $paggination .= '<li class="navigation_page_num"> <a href="#">' .
                    '<span class="badge badge-secondary mt-1">...</span></a> </li>' .
                    '<li class="navigation_page_num"> <a href="' . $url .
                    '&page=' . ($pagesCount - 1) . '"><span class="badge badge-secondary mt-1">' .
                    $pagesCount . '</span></a></li>';
            }
        }
        $paggination .= '</ul> </div>';

        //next
        $paggination .= '<div class="float-left"> <a href="' .
            ($page + 1 >= $pagesCount ? "#" : $url . "&page=" . ($page + 1)) .
            '" class="navigation_angle mt-1"> <i class="fa fa-angle-right"></i> </a> </div>';

        $paggination .= '<p hidden id="'.$currentPageId.'">'.$currentPage.'</p>';
        return $paggination;
    }
}