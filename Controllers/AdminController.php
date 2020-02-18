<?php
class AdminController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Admin();
        session_start();
    }

    public function login()
    {
        //if(isset($_SESSION["admin"]))
        $connected = (isset($_SESSION["admin"])) ? true : false;
        $pageTwig = 'Admin/login.html.twig';
        $template = $this->twig->load($pageTwig);
        echo $template->render(['connected' => $connected]);
    }

    public function checklogin()
    {
        $error = "";
        if (isset($_POST['form_submit']) && $_POST['pseudo'] != "" && $_POST['password'] != "") {
            if ($adminInfo = $this->model->adminPseudoExist($_POST['pseudo'])) {
                if (password_verify($_POST['password'], $adminInfo['password'])) {
                    //Tout est ok --> redirection header('Location: la route désirée')
                    $_SESSION["admin"] = true;
                    header("Location: $this->baseUrl/admin/index");
                } else {
                    //Mdp faux
                    $error = "Mot de passe incorrect";
                }
            } else {
                //Nom d'utilisateur n'existe pas dans la BDD
                $error = "Identifiant incorrect";
            }
            $pageTwig = 'Admin/login.html.twig';
            $template = $this->twig->load($pageTwig);
            echo $template->render(['error' => $error]);
        }
    }

    private function isConnected()
    {
        if (!isset($_SESSION['admin'])) {
            header("Location: $this->baseUrl/admin");
        }
    }

    public function index()
    {
        $this->isConnected();
        $pageTwig = 'Admin/index.html.twig';
        $template = $this->twig->load($pageTwig);
        echo $template->render(["session" => $_SESSION]);
    }

    //Méthodes pour Genre 
    public function genre()
    {
        $this->isConnected();
        $genre = new Genre();
        $genres = $genre->getAllGenre();
        $pageGenre = 'Admin/genre.html.twig';
        $template = $this->twig->load($pageGenre);
        echo $template->render(["session" => $_SESSION, 'genres' => $genres]);
    }

    public function genreUpdate($id)
    {
        $this->isConnected();
        $instanceGenre = new Genre();
        if (!empty($_POST)) {
            $instanceGenre->update($id, $_POST["genre"]);
            header("Location: $this->baseUrl/admin/genre");
        }
        $genre = $instanceGenre->getOneGenre($id);
        $pageGenre = 'Admin/genreUpdate.html.twig';
        $template = $this->twig->load($pageGenre);
        echo $template->render(["genre" => $genre]);
    }

    public function genreDelete($id)
    {
        $this->isConnected();
        $instanceGenre = new Genre();
        $instanceGenre->delete($id);
        header("Location: $this->baseUrl/admin/genre");
    }

    public function genreAdd()
    {
        $this->isConnected();
        $instanceGenre = new Genre();
        if (!empty($_POST)) {
            $instanceGenre->add($_POST["genre"]);
            header("Location: $this->baseUrl/admin/genre");
        }
        $pageGenreAdd = 'Admin/genreAdd.html.twig';
        $template = $this->twig->load($pageGenreAdd);
        echo $template->render();
    }

    //Méthodes pour Films
    public function film()
    {
        $this->isConnected();
        $film = new Film();
        $films = $film->getAllFilm();
        //var_dump($films);
        $pageFilm = 'Admin/film.html.twig';
        $template = $this->twig->load($pageFilm);
        echo $template->render(["session" => $_SESSION, 'films' => $films]);
    }

    public function filmUpdate($id)
    {
        $this->isConnected();
        $instanceFilm = new Film();
        if (!empty($_POST)) {
            var_dump($_POST);
            $instanceFilm->updateFilm($id, $_POST["film-titre"], $_POST["film-date"]);
            header("Location: $this->baseUrl/admin/film");
        }
        $film = $instanceFilm->getOneFilmAdmin($id);
        $pageFilm = 'Admin/filmUpdate.html.twig';
        $template = $this->twig->load($pageFilm);
        echo $template->render(["film" => $film]);
    }
/*
    public function filmUpdateDate($id)
    {
        $this->isConnected();
        $instanceFilm = new Film();
        if (!empty($_POST)) {
            $instanceFilm->updateDate($id, $_POST["film-date"]);
            header("Location: $this->baseUrl/admin/film");
        }
        $film = $instanceFilm->getOneFilmAdmin($id);
        $pageFilm = 'Admin/filmUpdate.html.twig';
        $template = $this->twig->load($pageFilm);
        echo $template->render(["film" => $film]);
    }*/

    public function filmDelete($id)
    {
        $this->isConnected();
        $instanceFilm = new Film();
        $instanceFilm->delete($id);
        header("Location: $this->baseUrl/admin/film");
    }

    public function filmAdd()
    {
        $this->isConnected();
        $instanceFilm = new Film();
        if (!empty($_POST)) {
            $instanceFilm->add($_POST["film"]);
            header("Location: $this->baseUrl/admin/film");
        }
        $pageFilmAdd = 'Admin/filmAdd.html.twig';
        $template = $this->twig->load($pageFilmAdd);
        echo $template->render();
    }

    //Méthodes pour Acteurs
    /*public function acteur()
    {
        $this->isConnected();
        $pageActeur = 'Admin/acteur.html.twig';
        $template = $this->twig->load($pageActeur);
        echo $template->render(["session" => $_SESSION]);
    }*/

    public function acteur()
    {
        $this->isConnected();
        $instanceArtist = new Artist();
        $acteurs = $instanceArtist->getAllActor();
        $pageActeur = 'Admin/acteur.html.twig';
        $template = $this->twig->load($pageActeur);
        echo $template->render(["acteurs" => $acteurs]);
    }

    public function acteurUpdate($id)
    {
        $this->isConnected();
        $instanceArtist = new Artist();
        $acteur = $instanceArtist->getOneActor($id);
        $pageActeurUpdate = 'Admin/acteurUpdate.html.twig';
        $template = $this->twig->load($pageActeurUpdate);
        echo $template->render(["acteur" => $acteur]);
    }
    public function acteurDelete($id)
    {
        $this->isConnected();
        $instanceActeur = new Artist();
        $instanceActeur->delete($id);
        header("Location: $this->baseUrl/admin/acteur");
    }

    public function acteurAdd()
    {
        $this->isConnected();
        $instanceArtist = new Artist();
        if (!empty($_POST)) {
            //gérer l'upload de file
            $photo = $_FILES['photo'];
            $photoTmpName = $_FILES['photo']['tmp_name'];
            $photoError = $_FILES['photo']['error'];
            $photoSize = $_FILES['photo']['size'];
            $photoExt = explode('.', $photo);
            $photoActualExt = strtolower(end($photoExt));

            $allowed = array('jpg', 'jpeg', 'png', 'pdf');

            if (in_array($photoActualExt, $allowed)) {
                if ($photoError === 0) {
                    if ($photoSize < 1000000) {
                        $photoNew = uniqid(', true') . "." . $photoActualExt;
                        $photoDestination      = 'unploads/' . $photoNew;
                        move_uploaded_file($photoTmpName, $photoDestination);
                        header("Location : $this->baseUrl/asset/img/acteurs/uploadsuccess");
                    } else {
                        echo 'votre image est trop grand !';
                    }
                } else {
                    echo 'ya une erreur de téléchargement';
                }
            } else {
                echo " vous ne pouvez pas télécharger des fichiers de ce type ";
            }


            //fin gestion upload de file
            //$instanceArtist->add($_POST["nom"], $_POST["prenom"], $_POST["date_de_naissance"],  $_POST["biographie"], $_FILES['photo] );
            //header("Location: $this->baseUrl/admin/acteur");
            //var_dump($_POST);
        }
        $pageActeurAdd = 'Admin/acteurAdd.html.twig';
        $template = $this->twig->load($pageActeurAdd);
        echo $template->render();
    }

    //Méthodes pour Réalisateurs
    public function realisateur()
    {
        $this->isConnected();
        $pageRealisateur = 'Admin/realisateur.html.twig';
        $template = $this->twig->load($pageRealisateur);
        echo $template->render(["session" => $_SESSION]);
    }
}

 











/*class Form
 {
    public function __construct()
{
    $nom = "";
    $password = "";
}
    public function form(){
if (isset($_POST ['form_submit']) && $_POST['user'] != "" && $_POST['password'] != "")
{
   $nom = $_POST['user'];
   $password = $_POST['password'];
   echo "<p>Nom : $nom, password : ". $password ."</p>" ;
}
else
{
    echo "merci de remplir tous les champs du formulaire<br>";
    $nom = "";
    $password = "";
    }
 }
}*/
