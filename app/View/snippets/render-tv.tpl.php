<div class="row">
    <div class="bg-light w-100 text-center">
        <div class="row bg-light justify-content-center align-items-center py-5">
            <div class="col-xl-5 col-lg-6 col-md-7 col-11 mt-1 text-left">
                <div class="pl-xl-4 pl-lg-3 pl-md-2">
                    <div class="display-4 font-weight-lighttext-white"><?= $viewData['tv']->name ?></div>
                    <div class="mb-4">
                        <font size="4">
                            <?php if (isset($viewData['rendered']->other_season) && $viewData['isTv']) echo '<span class="badge badge-pill badge-danger mr-1 h1">' . $viewData['rendered']->other_season . '</span>'; ?>
                            <?php if (isset($viewData['rendered']->other_episode) && $viewData['isTv']) echo '<span class="badge badge-pill badge-danger mr-1 h1">' . $viewData['rendered']->other_episode . '</span>'; ?>
                            <?php foreach ($viewData['tv']->genres as $genre) echo '<span class="badge badge-pill badge-dark mr-2 h1">' . $genre->name . '</span>'; ?>
                        </font>
                    </div>

                    <div class="text-justify mb-4">
                        <font size="2" color="#999999"><?= $viewData['tv']->overview ?></font>
                    </div>

                    <div class="row justify-content-center text-center mb-4">
                        <?php
                        foreach ($viewData['generator']['casts'] as $perso)
                            echo '<div class="col-6 col-sm-3 mb-3 px-2"><img src="https://image.tmdb.org/t/p/w154' . $perso['profile_path'] . '" alt="' . $perso['original_name'] . '" class="rounded img-fluid"></div>';
                        ?>
                    </div>

                    <font size="4"
                          class="d-flex align-items-center justify-content-center p-1 pl-2 mb-3 bg-white border-dark rounded">
                        <?php if (isset($viewData['rendered']->quality)) echo '<span class="badge badge-info">' . $viewData['rendered']->quality . '</span>'; ?>
                        <span class="badge badge-success mx-1">x264</span>
                        <img class="mx-auto d-none d-sm-inline-block"
                             src="<?= $viewData['generator']['rating']['image'] ?>"
                             alt="<?= $viewData['generator']['rating']['note'] ?>">
                        <span class="alert alert-dark d-none d-sm-inline-block h5 py-2 px-3 mb-0"><?= $viewData['generator']['release']->format("Y") ?></span>
                    </font>
                </div>
            </div>
            <div class="col-lg-5 px-lg-5">
                <img src="<?= $viewData['rendered']->cover_url ?>"
                     alt="" class="img-fluid rounded w-100">
            </div>
        </div>

        <div class="row bg-dark justify-content-center align-items-center py-5 text-left">
            <div class="col-12 text-center">
                <h1 class="font-weight-light text-white mb-3 text-uppercase"><font size="5">Informations</font></h1>
            </div>

            <div class="col-sm-11 col-md-9 col-lg-7 my-3">
                <table class="table bg-light table-hover rounded mb-0">
                    <tbody>
                    <tr>
                        <td class="bg-transparent py-2 text-capitalize text-left">
                            <font size="2" class="d-flex justify-content-between">
                                <b><span class="ico_calendar"></span> Date de sortie
                                    :</b> <?= $viewData['generator']['release']->format("D j M Y") ?>
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <td class="bg-transparent py-2 text-capitalize text-left">
                            <font size="2" class="d-flex justify-content-between">
                                <b><span class="ico_clock-o"></span> Durée
                                    :</b> <?= $viewData['generator']['run_time'] ?>
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <td class="bg-transparent py-2 text-capitalize text-left">
                            <font size="2" class="d-flex justify-content-between">
                                <b><span class="ico_globe"></span> Origine
                                    :</b> <?= $viewData['generator']['countries'] ?>
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <td class="bg-transparent py-2 text-capitalize text-left">
                            <font size="2" class="d-flex justify-content-between">
                                <b><span class="ico_film"></span> Titre original
                                    :</b> <?= $viewData['tv']->original_name ?? $viewData['tv']->original_title ?>
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <td class="bg-transparent py-2 text-capitalize text-left">
                            <font size="2" class="d-flex justify-content-between">
                                <b><span class="ico_heart-o"></span> Critiques des spectateurs :</b>
                                <span>
                                                <img src="<?= $viewData['generator']['rating']['image'] ?>"
                                                     alt="<?= $viewData['generator']['rating']['note'] ?>">
                                            </span>
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <td class="bg-transparent py-2 text-capitalize text-left">
                            <font size="2" class="d-flex justify-content-between">
                                <b><span class="ico_globe"></span> TheMovieDB :</b>
                                <a href="https://www.themoviedb.org/<?= $viewData['generator']['type'] ?>/<?= $viewData['tv']->id ?>"
                                   class="font-italic">Fiche
                                    du Film</a>
                            </font>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-sm-11 col-md-9 col-lg-7 my-3">
                <table class="table bg-light table-hover rounded mb-0">
                    <thead>
                    <tr>
                        <th colspan="3" class="py-2 text-center text-dark text-uppercase">
                            <font size="3">Réalisateur<?php if(isset($viewData['tv']->created_by)) (sizeof($viewData['tv']->created_by) > 1) ? "s" : "" ?>
                            </font>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($viewData['tv']->created_by ?? $viewData['generator']['directors'] as $real) { ?>
                        <tr class="py-2">
                            <td class="py-2 text-center text-dark"><?= $real->name ?? $real['original_name'] ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="col-sm-11 col-md-9 col-lg-7 my-3">
                <table class="table bg-light table-hover rounded mb-0">
                    <thead>
                    <tr>
                        <th colspan="3" class="py-2 text-center text-dark text-uppercase"><font
                                    size="3">Acteur<?= ($viewData['generator']['casts'] > 1) ? "s" : "" ?></font>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($viewData['generator']['casts'] as $actor) { ?>
                        <tr class="py-2">
                            <td class="py-2 text-center text-dark"><?= $actor['original_name'] ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row bg-light justify-content-center py-5">
            <div class="col-12 text-center">
                <h1 class="font-weight-light text-dark mb-3 text-uppercase"><font size="5">Détails Techniques</font>
                </h1>
            </div>

            <div class="row mb-2 pt-4 w-75">
                <div class="col-md-4 my-3">
                    <h2 class="mb-3">Vidéo</h2>
                    <ul class="list-group pl-0 mb-3">
                        <li class="list-group-item bg-dark text-light p-2"><?= $viewData['rendered']->quality ?></li>
                        <li class="list-group-item bg-dark text-light p-2"><?= $viewData['rendered']->video_codec ?></li>
                        <?php if (isset($viewData['rendered']->video_debit) && !empty($viewData['rendered']->video_debit)) { ?>
                            <li class="list-group-item bg-dark text-light p-2"><?= $viewData['rendered']->video_debit ?>
                                kbps
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="col-md-4 my-3">
                    <h2 class="mb-3">Audio</h2>
                    <?php
                    foreach ($viewData['rendered']->audios as $audio) {
                        ?>
                        <ul class="list-group pl-0 mb-3">
                            <li class="list-group-item bg-dark text-light p-2"><?= $audio->lang ?></li>
                            <li class="list-group-item bg-dark text-light p-2"><?= $audio->codec ?> <?= $audio->piste ?></li>
                            <?php if (isset($audio->debit) && !empty($audio->debit)) { ?>
                                <li class="list-group-item bg-dark text-light p-2"><?= $audio->debit ?>
                                    kb/s
                                </li> <?php } ?>
                        </ul>
                        <?php
                    }
                    ?>
                </div>
                <div class="col-md-4 my-3">
                    <h2 class="mb-3">Sous-titres</h2>
                    <?php
                    foreach ($viewData['rendered']->txts as $txt) {
                        ?>
                        <ul class="list-group pl-0 mb-3">
                            <li class="list-group-item bg-dark text-light p-2"><?= $txt->lang ?></li>
                            <li class="list-group-item bg-dark text-light p-2"><?= $txt->format ?></li>
                        </ul>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="row bg-dark justify-content-center align-items-center py-5">
            <div class="col-12 text-center">
                <h1 class="font-weight-light text-light mb-3 text-uppercase"><font size="5">Détails Torrent</font></h1>
            </div>
            <div class="row mt-3 mb-1 text-center">
                <?php if (isset($viewData['rendered']->global_debit) && !empty($viewData['rendered']->global_debit)) echo '<div class="alert alert-light p-2 mx-auto mb-0 text-dark"><b>Débit global :</b> ' . $viewData['rendered']->global_debit . ' kb/s ' ?>
            </div>
            <div class="mt-3 w-100">
                <font size="2">
                    <b class="text-light">Source :</b> <span
                            class="text-warning"><?= $viewData['rendered']->source ?></span><br>
                    <b class="text-light">Nombre de Fichiers :</b> <span
                            class="badge badge-success align-middle"><?= $viewData['rendered']->global_filescount ?></span><br>
                    <b class="text-light">Poids total du torrent : <span
                                class="text-danger"><?= $viewData['rendered']->global_size ?> <?= $viewData['rendered']->global_sizeunit ?></span></b>
                </font>
            </div>
        </div>
    </div>

    <div class="row justify-content-center py-4 bg-light text-center">
        <div>
            <img src="https://static.hephe.net/images/banner/footer_banner.jpg" alt="Footer Banner" class="rounded"/>
        </div>
    </div>
</div>