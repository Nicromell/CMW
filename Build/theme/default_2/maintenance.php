<?php
include('controleur/maintenance.php');
require('include/version.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>

	<title>
		<?= $_Serveur_['General']['name'] . " | MAINTENANCE " ?>
	</title>

	<!-- Meta -->
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<meta name="theme-color" content="<?= $_Serveur_["color"]["theme"]["main"]; ?>">
	<meta name="msapplication-navbutton-color" content="<?= $_Serveur_["color"]["theme"]["main"]; ?>">
	<meta name="apple-mobile-web-app-statut-bar-style" content="<?= $_Serveur_["color"]["theme"]["main"]; ?>">
	<meta name="apple-mobile-web-app-capable" content="<?= $_Serveur_["color"]["theme"]["main"]; ?>">

	<meta property="og:title" content="<?= $_Serveur_['General']['name'] ?>">
	<meta property="og:type" content="website" />
	<meta property="og:url" content="https://<?= $_SERVER["SERVER_NAME"] ?>">
	<meta property="og:image" content="https://<?= $_SERVER["SERVER_NAME"] ?>/favicon.ico">
	<meta property="og:image:alt" content="<?= $_Serveur_['General']['description'] ?>">
	<meta property="og:description" content="<?= $_Serveur_['General']['description'] ?>">
	<meta property="og:site_name" content="<?= $_Serveur_['General']['name'] ?>" />

	<meta name="twitter:title" content="<?= $_Serveur_['General']['name'] ?>">
	<meta name="twitter:description" content="<?= $_Serveur_['General']['description'] ?>">
	<meta name="twitter:image" content="https://<?= $_SERVER["SERVER_NAME"] ?>/favicon.ico">

	<meta name="author" content="CraftMyWebsite, TheTueurCiTy, <?= $_Serveur_['General']['name']; ?>" />

	<!-- CSS links -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
	<link rel="stylesheet" href="theme/<?= $_Serveur_['General']['theme']; ?>/assets/css/custom.css">

</head>

<body>
	<?php
	//Verif Version
	include("./include/version.php");
	include("./include/version_distant.php");
	?>

	<?php
	include('theme/' . $_Serveur_['General']['theme'] . '/entete.php'); //Header included
	tempMess(); ?>


	<!-- Contenue de la page -->

	<section id="Maintenance">
		<div class="container-fluid col-md-9 col-lg-9 col-sm-10">

			<div class="row">
				<!-- Présentation -->
				<div class="d-flex col-12 info-page mx-auto mb-3">
					<i class="fas fa-info-circle notification-icon"></i>
					<div class="info-content">
						<?php echo $donnees['maintenanceMsg']; ?>
					</div>
				</div>
			</div>

			<?php if (!empty($donnees['dateFin'])) :
				if ($donnees['dateFin'] != 0 && $donnees['dateFin'] <= time()) {
					$req = $bddConnection->prepare('UPDATE cmw_maintenance SET maintenanceEtat = :maintenanceEtat WHERE maintenanceId = :maintenanceId');
					$req->execute(array('maintenanceEtat' => 0, 'maintenanceId' => $donnees['maintenanceId']));
					header("Location: /");
				} ?>
				<div class="row">
					<!-- Temps restannt -->
					<div class="card col-10 my-4 mx-auto">
						<div id="clockdiv">
							<div class="card-header">
								<h4>Temps Restant :</h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col">
										<div class="content-clock">
											<span class="bloc-clock days h5"></span>
											<div>Jours</div>
										</div>
									</div>
									<div class="col">
										<div class="content-clock">
											<span class="bloc-clock hours h5"></span>
											<div>Heures</div>
										</div>
									</div>
									<div class="col">
										<div class="content-clock">
											<span class="bloc-clock minutes h5"></span>
											<div>Minutes</div>
										</div>
									</div>
									<div class="col">
										<div class="content-clock">
											<span class="bloc-clock seconds h5"></span>
											<div>Secondes</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer">
								<small>Merci pour votre patience !</small>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<div class="row">
				<!-- Connexion -->
				<div class="col-9 mx-auto mt-3">
					<div class="card">
						<div class="card-header">
							<h3 class="text-center m-0">Connexion</h3>
						</div>
						<div class="card-body">
							<h5><?= $donnees['maintenanceMsgAdmin']; ?></h5>
						</div>
						<div class="card-footer">
							<a data-toggle="modal" data-target="#ConnectionSlide" class="btn btn-main w-100">Se connecter</a>
						</div>
					</div>
				</div>
			</div>


		</div>
	</section>




	<?php include('theme/' . $_Serveur_['General']['theme'] . '/formulaires.php'); //Forms included 
	include('theme/' . $_Serveur_['General']['theme'] . '/pied.php');  //Footer included 
	?>



	<!-- JS, Popper.js, and jQuery -->
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

	<!-- Script pour fonctionnement de la page -->
	<script type="text/javascript">
		function getTimeRemaining(endtime) {
			var t = Date.parse(endtime) - Date.parse(new Date());
			var seconds = Math.floor((t / 1000) % 60);
			var minutes = Math.floor((t / 1000 / 60) % 60);
			var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
			var days = Math.floor(t / (1000 * 60 * 60 * 24));
			if (days == 0 && hours == 0 && minutes == 0 && seconds == 0)
				window.location.replace("/");
			return {
				'total': t,
				'days': days,
				'hours': hours,
				'minutes': minutes,
				'seconds': seconds
			};
		}

		function initializeClock(id, endtime) {
			var clock = document.getElementById(id);
			var daysSpan = clock.querySelector('.days');
			var hoursSpan = clock.querySelector('.hours');
			var minutesSpan = clock.querySelector('.minutes');
			var secondsSpan = clock.querySelector('.seconds');

			function updateClock() {
				var t = getTimeRemaining(endtime);

				daysSpan.innerHTML = t.days;
				hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
				minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
				secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

				if (t.total <= 0) {
					clearInterval(timeinterval);
				}
			}

			updateClock();
			var timeinterval = setInterval(updateClock, 1000);
		}

		var deadline = new Date(Date.parse(new Date()) + <?= ($donnees["dateFin"] - time()) ?> * 1000);
		initializeClock('clockdiv', deadline);
	</script>
</body>

</html>