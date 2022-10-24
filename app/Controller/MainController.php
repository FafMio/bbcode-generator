<?php

class MainController extends CoreController {

    public function home($arguments = [])
    {
        $this->show('pages/home', $arguments);
    }

    /**
     * @throws Exception
     */
    public function search($arguments = [])
    {
        if(isset($_GET['search'])) {
            $page = $_GET['page'] ?? 1;
            $type = $_GET['type'] ?? "multi";
            $search = $_GET['search'];

            $ps = new PaginationService();

            $hs = new HttpService($_ENV['KEY_IMDB_API']);
            $req = $hs->search($_GET['search'], $type, $page);


            $arguments['data_url'] = [
                "search" => $search,
                "type" => $type,
                "page" => $page,
            ];
            $arguments['list'] = $req->getData()->results;
            $arguments['pagination'] = [
                "page" => $req->getData()->page,
                "total_pages" => $req->getData()->total_pages,
                "total_results" => $req->getData()->total_results,
                "pages" => json_decode(json_encode($ps->paginate($page, $req->getData()->total_pages)), false),
            ];
        }

        $this->show('pages/search', $arguments);
    }

    /**
     * @throws Exception
     */
    public function generate_tv($arguments = [])
    {
        if(isset($arguments['id'])) {
            $id = $arguments['id'];

            $rs = new RatingService();
            $cs = new ConvertionService();
            $hs = new HttpService($_ENV['KEY_IMDB_API']);

            $req = $hs->find($id, "tv");
            $data = $req->getData();

            $cast = json_decode(json_encode($hs->credits($id)->getData()->cast), true);
            setlocale(LC_TIME, "fr_FR");
            $release_date = new DateTime($data->first_air_date);

            $countryResult = "";
            for ($i = 0; $i < sizeof($data->origin_country); $i++) {
                if($i < sizeof($data->origin_country)) {
                    $countryResult .= "{$data->origin_country[$i]}";
                } else {
                    $countryResult .= "{$data->origin_country[$i]}, ";
                }
            }

            $arguments['isTv'] = true;
            $arguments['tv'] = $data;
            $arguments['generator'] = [
                "rating" => [
                    "image" => $rs->getStars($data->vote_average),
                    "note" => $data->vote_average,
                ],
                "casts" => array_slice($cast, 0, 4),
                "release" => $release_date,
                "countries" => $countryResult,
                "run_time" => $cs->timeToString($data->episode_run_time[0] ?? "0"),
                "type" => "tv"
            ];
            $arguments['images'] = $hs->images($id, "tv")->getData();

            if(isset($_POST['quality'])) {
                $_POST['txts'] = $cs->parseRepeater($_POST, "txt");
                $_POST['audios'] = $cs->parseRepeater($_POST, "audio");

                $arguments['rendered'] = json_decode(json_encode($_POST), false);
            }

            dump($arguments);
        }

        $this->show('pages/generate', $arguments);
    }

    /**
     * @throws Exception
     */
    public function generate_movie($arguments = [])
    {
        if(isset($arguments['id'])) {
            $id = $arguments['id'];

            $rs = new RatingService();
            $cs = new ConvertionService();
            $hs = new HttpService($_ENV['KEY_IMDB_API']);

            $req = $hs->find($id, "movie");
            $data = $req->getData();

            $cast = json_decode(json_encode($hs->credits($id, "movie")->getData()->cast), true);
            $crew = json_decode(json_encode($hs->credits($id, "movie")->getData()->crew), true);
            setlocale(LC_TIME, "fr_FR");
            $release_date = new DateTime($data->release_date);

            $countryResult = "";
            for ($i = 0; $i < sizeof($data->production_countries); $i++) {
                if($i < sizeof($data->production_countries)) {
                    $countryResult .= "{$data->production_countries[$i]->iso_3166_1}";
                } else {
                    $countryResult .= "{$data->production_countries[$i]->iso_3166_1}, ";
                }
            }

            $arguments['isTv'] = false;
            $arguments['tv'] = $data;
            $arguments['casts'] = $cast;
            $arguments['tv']->name = $data->title;
            $arguments['generator'] = [
                "rating" => [
                    "image" => $rs->getStars($data->vote_average),
                    "note" => $data->vote_average,
                ],
                "run_time" => $cs->timeToString($data->runtime),
                "casts" => array_slice($cast, 0, 4),
                "release" => $release_date,
                "countries" => $countryResult,
                "type" => "movie",
                "directors" => $cs->getCrew($crew, "Director"),
            ];
            $arguments['images'] = $hs->images($id, "movie")->getData();

            if(isset($_POST['quality'])) {
                $_POST['txts'] = $cs->parseRepeater($_POST, "txt");
                $_POST['audios'] = $cs->parseRepeater($_POST, "audio");

                $arguments['rendered'] = json_decode(json_encode($_POST), false);
            }
        }

        $this->show('pages/generate', $arguments);
    }

    public function page404() {
        $this->show('pages/404');
    }
}