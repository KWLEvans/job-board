<?php
    date_default_timezone_set("America/Los_Angeles");
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/JobOpening.php";
    require_once __DIR__."/../src/Contact.php";

    session_start();
    if (empty($_SESSION['list_of_jobs'])) {
        $_SESSION['list_of_jobs'] = [];
    }

    $app = new Silex\Application();
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
      return $app['twig']->render('addJobs.html.twig');
    });

    $app->post("/postings", function() use ($app) {
        $new_contact = new Contact($_POST["contact-name"], $_POST["contact-email"], $_POST["contact-phone"]);
        $new_posting = new JobOpening($_POST["title"], $_POST["description"], $new_contact);
        $new_posting->save();
        
        $job_array = JobOpening::getAll();

        return $app['twig']->render('jobs.html.twig', array('jobs' => $job_array));
    });

    return $app;
?>
