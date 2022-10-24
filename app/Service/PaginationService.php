<?php

class PaginationService
{

    public function __construct()
    {
    }

    /**
     * Paginate from array
     *
     * @param int $currentPage
     * @param int $totalPages
     * @return array
     */
    public function paginate(int $currentPage, int $totalPages): array
    {
        $return = [];
        $us = new UrlService();

        for ($i = 1; $i <= $totalPages; $i++) {
            $currentForPage = $i;
            $dataPage = [
                "page" => $i,
                "url" => $us->replaceUrlParameters("http://{$_SERVER["HTTP_HOST"]}{$_SERVER["REQUEST_URI"]}", ["page" => $currentForPage])
                ];

            // Check if $i (page) has next page
            if (($currentForPage + 1) <= $totalPages) {
                $dataPage["next"] = [
                    "page" => $currentForPage + 1,
                    "url" => $us->replaceUrlParameters("http://{$_SERVER["HTTP_HOST"]}{$_SERVER["REQUEST_URI"]}", ["page" => $currentForPage + 1])
                ];
            } else {
                $dataPage["next"] = null;
            }

            // Check if $i (page) has previous page
            if (($currentForPage + 1) >= $totalPages) {
                $dataPage["prev"] = [
                    "page" => $currentForPage - 1,
                    "url" => $us->replaceUrlParameters("http://{$_SERVER["HTTP_HOST"]}{$_SERVER["REQUEST_URI"]}", ["page" => $currentForPage - 1])
                ];
            } else {
                $dataPage["prev"] = null;
            }

            // Check if it's current page
            $dataPage["current"] = $i == $currentPage;


            $return[$i] = $dataPage;
        }

        return $return;
    }
}