<?php
$getprofil = $_GET['profil'];
$isMyAccount = false;
$nbrAccount = 0;

// GESTION D'ERREURS
if (isset($_GET['erreur'])) {
    $errorContent = '';
    switch ($_GET['erreur']) {
        case 1:
            $errorContent = 'Erreur, l\'email entré est vide...';
            break;

        case 2:
            $errorContent = 'Erreur, un des champs est trop court (minimum 4 caractères)';
            break;

        case 3:
            $errorContent = 'Erreur, le mot de passe entré ne correspond pas à celui associé à votre compte';
            break;

        case 4:
            $errorContent = 'Erreur, Vous n\'avez pas assez de tokens.';
            break;

        case 5:
            $errorContent = 'Erreur, Pseudonyme inconnu...';
            break;

        case 6:
            $errorContent = 'Erreur, Extension non autorisée !';
            break;

        case 7:
            $errorContent = 'Erreur, Fichier trop volumineux ! <small>Maximum 2Mo</small>';
            break;

        case 8:
            $errorContent = 'Erreur, Des champs sont manquants !';
            break;

        case 9:
            $errorContent = 'Erreur, Impossible de vous abonner / désabonner à votre Newsletter...';

        case 10:
            $errorContent = 'Erreur, Impossible d\'afficher / cacher votre email...';

        default:
            $errorContent = 'Une erreur est survenue lors de l\'enregistrement de vos informations !';
            break;
    }
    //GESTION DE SUCCÈS
} elseif (isset($_GET['success'])) {
    $successContent = '';
    switch ($_GET['success']) {
        case 'true':
            $successContent = 'Vos informations ont bien été changé !';
            break;

        case 'jetons':
            if (!isset($_GET['montant']) || !is_numeric($_GET['montant'])) {
                $_GET['montant'] = 'NaN';
            }
            if (!isset($_GET['pseudo'])) {
                $_GET['pseudo'] = 'NOT_FOUND';
            }
            $successContent = 'Vous venez d\'envoyer ' . htmlspecialchars($_GET['montant']) . ' jetons à ' . htmlspecialchars($_GET['pseudo']) . ' !';
            break;

        case 'image':
            $successContent = 'Votre photo de profil a été modifiée !';
            break;

        case 'imageRemoved':
            $successContent = 'Votre photo de profil a bien été supprimée de nos serveurs !';
            break;

        default:
            $successContent = '<div class="text-danger">Message de succès introuvable...</div>';
    }
}
?>

<section id="Profil">
    <div class="container-fluid col-md-9 col-lg-9 col-sm-10">

        <?php if (isset($_Joueur_["pseudo"]) && $_Joueur_['pseudo'] != $_GET['profil']) :
            $isMyAccount = false; ?>
        <!-- Envoie d'un message à l'utilisateur -->

        <div class="row">
            <button type="button" data-toggle="modal" data-target="#modalRep"
                data-to="<?= htmlspecialchars($getprofil); ?>" class="btn btn-main ml-auto my-3">
                Envoyer un message à <?= htmlspecialchars($getprofil); ?>
            </button>
        </div>
        <?php endif; ?>

        <?php if (isset($_Joueur_) and $_GET['profil'] == $_Joueur_['pseudo']) :
            $isMyAccount = true ?>

        <!-- Edition du profil -->

        <!-- Gestion du compte -->

        <div class="row">

            <div class="d-flex flex-row-reverse">
                <a class="btn btn-main p-2 my-3 mr-3" data-toggle="collapse" href="#collapseGiveJetons" role="button"
                    aria-expanded="false" aria-controls="collapseGiveJetons">
                    <i class="fas fa-gift mr-1"></i> Offrir des jetons
                </a>
                <a class="btn btn-main p-2 my-3 mx-3" data-toggle="collapse" href="#collapseEditSettings" role="button"
                    aria-expanded="false" aria-controls="collapseEditSettings">
                    <i class="fas fa-pencil-alt mr-1"></i> Modifier mon compte
                </a>
            </div>

        </div>


        <!-- Offrir des jetons -->
        <div class="row">

            <div class="collapse mx-auto" id="collapseGiveJetons">
                <div class="card">
                    <form class="form-horizontal" method="post" action="?&action=give_jetons" role="form">

                        <div class="card-header">
                            <h4> Envoyer des jetons à un joueur </h4>
                        </div>

                        <div class="card-body">

                            <div class="form-row py-1">

                                <div class="col-md-8">
                                    <label for="pseudo"> Pseudo </label>
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <div class="input-group-text bg-main border-0">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        </span>
                                        <input type="text" name="pseudo" class="form-control custom-text-input"
                                            id="pseudo" placeholder="Pseudo du receveur" required>
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <label for="montant"> Montant </label>
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <div class="input-group-text bg-main border-0">
                                                <i class="fas fa-money-bill-alt"></i>
                                            </div>
                                        </span>
                                        <input type="number" name="montant" class="form-control custom-text-input"
                                            id="montant" placeholder="Montant" required>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-main w-100">Envoyer</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>


        <!-- Modification du compte -->
        <div class="row">
            <div class="collapse mx-auto col-10" id="collapseEditSettings">
                <div class="card">

                    <div class="card-header">
                        <h4> Modifier les informations de mon compte </h4>
                    </div>


                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-3 col-sm-12 mb-3 ml-lg-3">
                                <!-- Navigation -->
                                <div class="categories">
                                    <ul class="categorie-content nav nav-tabs">
                                        <li class="categorie-item nav-item">
                                            <a href="#editPersonal" class="nav-link categorie-link active"
                                                data-toggle="tab" aria-controls="editPersonal" aria-selected="true">
                                                Informations personnelles
                                            </a>
                                        </li>

                                        <li class="categorie-item nav-item">
                                            <a href="#editOptionnal" class="nav-link categorie-link" data-toggle="tab"
                                                aria-controls="editOptionnal" aria-selected="false">
                                                Informations optionnelles
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>


                            <div class="col-md-12 col-lg-8 col-sm-12 mb-3 ml-lg-3">
                                <!-- Contenu -->
                                <div class="tab-content">

                                    <div id="editPersonal" class="tab-pane fade show active" role="tabpanel"
                                        aria-labelledby="editPersonal">

                                        <form class="form-horizontal" method="post" action="?&action=changeProfil"
                                            role="form">

                                            <div class="form-row py-1">

                                                <div class="col-md-12 py-2">
                                                    <label for="namePseudo"> Pseudo </label>
                                                    <div class="input-group">
                                                        <span class="input-group-prepend">
                                                            <div class="input-group-text bg-main border-0">
                                                                <i class="fa fa-user"></i>
                                                            </div>
                                                        </span>
                                                        <input type="text" name="pseudo"
                                                            class="form-control custom-text-input" id="namePseudo"
                                                            value="<?= $_Joueur_['pseudo']; ?>" disabled
                                                            style="cursor: not-allowed">
                                                    </div>
                                                </div>

                                            </div>

                                            <h5 class="mt-4 mb-0">Modifier votre mot de passe : <small>(Laisser vide
                                                    pour ne pas modifier)</small></h5>
                                            <hr class="bg-main w-80 float-left my-1">
                                            <div class="clearfix"></div>

                                            <div class="form-row py-2">

                                                <div class="col-md-12 mb-2">
                                                    <label for="mdpAncien"> Mot de passe Actuel </label>
                                                    <div class="input-group">
                                                        <span class="input-group-prepend">
                                                            <div class="input-group-text bg-main border-0">
                                                                <i class="fas fa-key"></i>
                                                            </div>
                                                        </span>
                                                        <input type="password" name="mdp"
                                                            class="form-control custom-text-input" id="mdpAncien"
                                                            placeholder="Entrez votre mot de passe">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="mdpNouveau"> Nouveau mot de passe </label>
                                                    <div class="input-group">
                                                        <span class="input-group-prepend">
                                                            <div class="input-group-text bg-main border-0">
                                                                <i class="fas fa-key"></i>
                                                            </div>
                                                        </span>
                                                        <input type="password" name="mdpNouveau"
                                                            class="form-control custom-text-input" id="mdpNouveau"
                                                            placeholder="Entrez votre nouveau mot de passe">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="mdpConfirme"> Confirmation Mot de passe </label>
                                                    <div class="input-group">
                                                        <span class="input-group-prepend">
                                                            <div class="input-group-text bg-main border-0">
                                                                <i class="fas fa-key"></i>
                                                            </div>
                                                        </span>
                                                        <input type="password" name="mdpConfirme"
                                                            class="form-control custom-text-input" id="mdpConfirme"
                                                            placeholder="Confirmez votre nouveau mot de passe">
                                                    </div>
                                                </div>

                                            </div>

                                            <h5 class="mt-4 mb-0">Modifier votre mail : <small>(Laisser vide pour ne
                                                    pas modifier)</small></h5>
                                            <hr class="bg-main w-80 float-left my-1">
                                            <div class="clearfix"></div>

                                            <div class="form-row py-2">

                                                <div class="col-md-8">
                                                    <label for="inputMail"> Email </label>
                                                    <div class="input-group">
                                                        <span class="input-group-prepend">
                                                            <div class="input-group-text bg-main border-0">
                                                                <i class="fa fa-user"></i>
                                                            </div>
                                                        </span>
                                                        <input type="email" name="email"
                                                            class="form-control custom-text-input" id="inputMail"
                                                            placeholder="Entrez votre mail"
                                                            value="<?= $joueurDonnees['email']; ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <?php if ($joueurDonnees['show_email']) : ?>
                                                    <button type="submit" class="btn btn-reverse form-control"
                                                        name="changeVisibilityMail" value="hideMail"
                                                        style="margin-top: 1.9rem">
                                                        Cacher
                                                    </button>
                                                    <?php else : ?>
                                                    <button type="submit" class="btn btn-reverse form-control"
                                                        name="changeVisibilityMail" value="showMail"
                                                        style="margin-top: 1.9rem">
                                                        Afficher
                                                    </button>
                                                    <?php endif; ?>
                                                </div>
                                            </div>


                                            <div class="form-row py-2">
                                                <div class="col-md-8">
                                                    <label for="inputNewsletter"> Abonnement à la Newsletter </label>
                                                    <div class="input-group">
                                                        <span class="input-group-prepend">
                                                            <div class="input-group-text bg-main border-0">
                                                                <i class="fas fa-plus-square"></i>
                                                            </div>
                                                        </span>

                                                        <?php if ($joueurDonnees['newsletter']) : ?>
                                                        <input type="text"
                                                            class="form-control custom-text-input text-success"
                                                            id="inputNewsletter" name="inputNewsletter"
                                                            value="Déjà abonné !" disabled />
                                                        <?php else : ?>
                                                        <input type="text"
                                                            class="form-control custom-text-input text-danger"
                                                            id="inputNewsletter" name="inputNewsletter"
                                                            value="Non abonné !" disabled />
                                                        <?php endif; ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <?php if ($joueurDonnees['newsletter']) : ?>
                                                    <button type='submit'
                                                        class="btn btn-reverse form-control text-danger"
                                                        name="changeNewsletter" value="unsubscribeNewsletter"
                                                        style="margin-top: 1.9rem">Se désinscrire
                                                    </button>

                                                    <?php else : ?>

                                                    <button type='submit' class="btn btn-reverse form-control"
                                                        name="changeNewsletter" value="subscribeNewsletter"
                                                        style="margin-top: 1.9rem">S'inscrire
                                                    </button>
                                                    <?php endif; ?>
                                                </div>

                                                <div class="row w-100">
                                                    <div class="col-12 mt-4">
                                                        <button type="submit"
                                                            class="btn btn-main validerChange bg-lightest w-100 form-control">
                                                            Valider mes changements
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                    </div>

                                    <div id="editOptionnal" class="tab-pane fade" role="tabpanel"
                                        aria-labelledby="editOptionnal">
                                        <form class="form-horizontal" method="post" action="?&action=changeProfilAutres"
                                            role="form">

                                            <?php foreach ($listeReseaux as $value) : ?>

                                            <div class="form-row py-1">
                                                <label for="<?= $value['nom']; ?>">
                                                    <?= ucfirst($value['nom']); ?>
                                                </label>
                                                <input type="text" class="form-control custom-text-input"
                                                    name="<?= $value['nom']; ?>"
                                                    placeholder="Votre nom d'utilisateur <?= $value['nom']; ?>"
                                                    value="<?php if ($joueurDonnees[$value['nom']] != 'inconnu') echo $joueurDonnees[$value['nom']]; ?>">
                                            </div>

                                            <?php endforeach; ?>

                                            <div class="form-row">
                                                <label for="age">
                                                    Âge <small>(0 =
                                                        caché)</small>
                                                </label>
                                                <input type="number" name="age" class="form-control custom-text-input "
                                                    min="0" max="99" placeholder="17"
                                                    value="<?php if ($joueurDonnees['age'] != 'inconnu') echo $joueurDonnees['age']; ?>">

                                            </div>


                                            <div class="form-row wys-content">
                                                <h5 class="mt-4 mb-0">Signature Forum</h5>
                                                <hr class="bg-main w-80 float-left my-1">
                                                <div class="clearfix"></div>

                                                <div class="col-md-12 text-center wys-options">

                                                    <?php // Smiley, désactivé ici
                                                        /*
                                                        $smileys = getDonnees($bddConnection);
                                                        for ($i = 0; $i < count($smileys['symbole']); $i++) {
                                                            echo '<a href="javascript:insertAtCaret(\'signature\',\' ' . $smileys['symbole'][$i] . ' \')"><img src="' . $smileys['image'][$i] . '" alt="' . $smileys['symbole'][$i] . '" title="' . $smileys['symbole'][$i] . '" /></a>';
                                                        } */ ?>
                                                    <a class="wys-button"
                                                        href="javascript:ajout_text('signature', 'Ecrivez ici ce que vous voulez mettre en gras', 'ce texte sera en gras', 'b')"
                                                        style="text-decoration: none;" title="gras"><i
                                                            class="fas fa-bold" aria-hidden="true"></i></a>
                                                    <a class="wys-button"
                                                        href="javascript:ajout_text('signature', 'Ecrivez ici ce que vous voulez mettre en italique', 'ce texte sera en italique', 'i')"
                                                        style="text-decoration: none;" title="italique"><i
                                                            class="fas fa-italic"></i></a>
                                                    <a class="wys-button"
                                                        href="javascript:ajout_text('signature', 'Ecrivez ici ce que vous voulez mettre en souligné', 'ce texte sera en souligné', 'u')"
                                                        style="text-decoration: none;" title="souligné"><i
                                                            class="fas fa-underline"></i></a>
                                                    <a class="wys-button"
                                                        href="javascript:ajout_text('signature', 'Ecrivez ici ce que vous voulez mettre en barré', 'ce texte sera barré', 's')"
                                                        style="text-decoration: none;" title="barré"><i
                                                            class="fas fa-strikethrough"></i></a>
                                                    <a class="wys-button"
                                                        href="javascript:ajout_text('signature', 'Ecrivez ici ce que vous voulez mettre en aligné à gauche', 'ce texte sera aligné à gauche', 'left')"
                                                        style="text-decoration: none" title="aligné à gauche"><i
                                                            class="fas fa-align-left"></i></a>
                                                    <a class="wys-button"
                                                        href="javascript:ajout_text('signature', 'Ecrivez ici ce que vous voulez mettre en centré', 'ce texte sera centré', 'center')"
                                                        style="text-decoration: none" title="centré"><i
                                                            class="fas fa-align-center"></i></a>
                                                    <a class="wys-button"
                                                        href="javascript:ajout_text('signature', 'Ecrivez ici ce que vous voulez mettre en aligné à droite', 'ce texte sera aligné à droite', 'right')"
                                                        style="text-decoration: none" title="aligné à droite"><i
                                                            class="fas fa-align-right"></i></a>
                                                    <a class="wys-button"
                                                        href="javascript:ajout_text('signature', 'Ecrivez ici ce que vous voulez mettre en justifié', 'ce texte sera justifié', 'justify')"
                                                        style="text-decoration: none" title="justifié"><i
                                                            class="fas fa-align-justify"></i></a>
                                                    <a class="wys-button"
                                                        href="javascript:ajout_text_complement('signature', 'Ecrivez ici l\'adresse de votre lien', 'https://craftmywebsite.fr/forum', 'url', 'Entrez le titre de votre lien', 'CraftMyWebsite')"
                                                        style="text-decoration: none" title="lien"><i
                                                            class="fas fa-link"></i></a>
                                                    <a class="wys-button"
                                                        href="javascript:ajout_text_complement('signature', 'Ecrivez ici l\'adresse de votre image', 'https://craftmywebsite.fr/img/cat6.png', 'img', 'Entrez ici le titre de votre image (laisser vide si vous ne voulez pas compléter', 'Titre')"
                                                        style="text-decoration: none" title="image"><i
                                                            class="fas fa-image"></i></a>
                                                    <a class="wys-button"
                                                        href="javascript:ajout_text_complement('signature', 'Ecrivez ici votre texte en couleur', 'Ce texte sera coloré', 'color', 'Entrer le nom de la couleur en anglais ou en hexaécimal avec le  # : http://www.code-couleur.com/', 'red ou #40A497')"
                                                        style="text-decoration: none" title="couleur"><i
                                                            class="fas fa-font"></i></a>
                                                    <a class="wys-button"
                                                        href="javascript:ajout_text_complement('signature', 'Ecrivez ici votre message caché', 'contenue du spoiler', 'spoiler', 'Entrer le titre du message caché (si la case est vide le titre sera \'Spoiler\'', 'Spoiler')"
                                                        style="text-decoration: none" title="spoiler"><i
                                                            class="fas fa-flag"></i></a>
                                                    <div class="dropdown d-inline wys-button">
                                                        <a href=" #" role="button" id="font" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            <i class="fas fa-text-height"></i>
                                                        </a>
                                                        <div class="dropdown-menu" aria-labelledby="font">
                                                            <a class="dropdown-item"
                                                                href="javascript:ajout_text('signature', 'Ecrivez ici ce que vous voulez mettre en taille 2', 'ce texte sera en taille 2', 'font=2')"><span
                                                                    style="font-size: 2em;">2</span></a>
                                                            <a class="dropdown-item"
                                                                href="javascript:ajout_text('signature', 'Ecrivez ici ce que vous voulez mettre en taille 5', 'ce texte sera en taille 5', 'font=5')"><span
                                                                    style="font-size: 5em;">5</span></a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <textarea name="signature"
                                                        class="form-control custom-text-input wys-textarea"
                                                        placeholder="Votre signature" oninput="previewTopic(this);"
                                                        id="signature"><?php if (isset($joueurDonnees['signature'])) echo $joueurDonnees['signature']; ?></textarea>
                                                </div>
                                                <div class="col-sm-12 mt-3">
                                                    <p class="form-control-static bg-lightest" id="previewTopic"></p>
                                                </div>
                                            </div>

                                            <div class="row w-100">
                                                <div class="col-12 mt-4">
                                                    <button type="submit"
                                                        class="btn btn-main validerChange bg-lightest w-100 form-control">
                                                        Valider mes changements
                                                    </button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>


                    </div>

                </div>
            </div>
        </div>

        <?php endif; ?>


        <!-- Affichage Profile -->
        <div class="row">


            <!-- Image et edition de la photo de profil -->
            <?php if ($isMyAccount) : ?>

            <div class="col-lg-4 col-sm-12 col-md-12">
                <form method="post" action="?action=modifImgProfil" role="form" enctype="multipart/form-data">

                    <label for="img_profil">

                        <div class="card-container">
                            <input type="file" class="form-control-file d-none" name="img_profil" id="img_profil"
                                onchange='getUploadFileName(this)' required />
                            <img class="profile-image"
                                src="<?= $_ImgProfil_->getUrlHeadByPseudo($_Joueur_['pseudo']); ?>"
                                style="height:128px; width:128px;"
                                alt="Image de profil de <?= htmlspecialchars($joueurDonnees['pseudo']) ?>" />
                            <div class="hoverText">
                                <div class="caption">
                                    <i class="fas fa-edit"></i>
                                </div>
                            </div>
                        </div>

                    </label>



                    <div class="alert alert-main p-1 w-80"><span class=> Image Choisie : </span><span
                            id="file-name">Aucune image sélectionné !</span></div>
                    <div class="form-group">

                        <button type="submit" class="btn btn-main">Modifier</button>
                        <a class="btn btn-reverse" href="?action=removeImgProfil">Supprimer</a>

                    </div>

                </form>
            </div>


            <?php else : ?>
            <div class="col-lg-4 col-sm-12 col-md-12">
                <img class="profile-image" src="<?= $_ImgProfil_->getUrlHeadByPseudo($_Joueur_['pseudo']); ?>"
                    style="height:128px; width:128px;"
                    alt="Image de profil de <?= htmlspecialchars($joueurDonnees['pseudo']) ?>" />
            </div>
            <?php endif; ?>

            <div class="col-lg-4 col-sm-12 col-md-12">
                <div class="text-presentation-profile ">
                    <div class="p-2">
                        <span class="font-weight-bolder"> <?= $gradeSite ?>
                        </span><?= htmlspecialchars($joueurDonnees['pseudo']); ?>
                    </div>
                    <div class="p-2">
                        Inscrit le <?= date('d/m/Y', $joueurDonnees['anciennete']); ?>
                    </div>
                    <?php if ($joueurDonnees['age'] > 5 && $joueurDonnees['age'] != "??") : ?>
                    <div class="p-2">
                        <?= $joueurDonnees['age'] ?> ans
                    </div>
                    <?php endif; ?>
                    <div class="p-2">
                        <?php require_once("modele/topVotes.class.php");
                        $topVotes = new TopVotes($bddConnection);
                        $nbreVotes = $topVotes->getNbreVotes($getprofil); ?>
                        <?= $nbreVotes . ' ' . ($nbreVotes > 1 ? "votes" : "vote"); ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-sm-12 col-md-12">

                <div class="card">

                    <div class="card-header">
                        Comptes de <?= $_Joueur_['pseudo'] ?>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <ul class="list-group list-group-flush w-100">
                                <?php if ($joueurDonnees['show_email']) :
                                    $nbrAccount++ ?>

                                <li class="social-user list-group-item bg-lightest">
                                    <div class="float-left">E-mail : </div>
                                    <div class="float-right"><?= $joueurDonnees['email'] ?> </div>
                                </li>

                                <?php endif; ?>

                                <?php foreach ($listeReseaux as $reseauSocial) :
                                    if ($joueurDonnees[$reseauSocial['nom']] != "inconnu") :
                                        $nbrAccount++ ?>

                                <li class="social-user list-group-item bg-lightest">
                                    <div class="float-left"><?= ucfirst($reseauSocial['nom']); ?> : </div>
                                    <div class="float-right"><?= $joueurDonnees[$reseauSocial['nom']]; ?> </div>
                                </li>

                                <?php endif; ?>
                                <?php endforeach; ?>

                                <?php if ($nbrAccount == 0) : ?>
                                <li class="list-group-item bg-danger p-3">Aucun Compte à afficher</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <div class="col-10 text-center mx-auto">
            <h4 class="my-5 text-left">Signature : </h4>
            <?php if (!empty($joueurDonnees['signature'])) : ?>

            <blockquote class="blockquote about-content col-8 mx-auto">
                <p class="ml-4 mb-0 h5"> <?= BBCode($joueurDonnees['signature'], $bddConnection); ?> </p>
            </blockquote>

            <?php else : ?>
            <div class="alert alert-main col-10 mx-auto">
                <p class="mb-0 h4 ml-3 p-3"> Ce joueur n'a aucune signature... </p>
            </div>
            <?php endif; ?>
        </div>

    </div>
</section>