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

    $app->get("/", function() {
      return
      "<!DOCTYPE html>
      <html>
          <head>
              <meta charset='utf-8'>
              <title>Daniel Craig's List</title>
          </head>
          <body>
              <form action='/postings' method='post'>
                  <h1>Hello, I'm Daniel Craig of England and the infamous Daniel Craig's List. Thank you kindly for visitig today. Post ya job, please? Kisses, Danny C.</h1>
                  <label for='title'>Job Title: </label>
                  <input id='title' name='title' type='text'>
                  <label for='description'>Job Description: </label>
                  <input id='description' name='description' type='text'>
                  <label>Contact Information: </label>
                  <label for='contact-name'>Name: </label>
                  <input id='contact-name' name='contact-name' type='text'>
                  <label for='contact-email'>Email: </label>
                  <input id='contact-email' name='contact-email' type='text'>
                  <label for='contact-phone'>Phone: </label>
                  <input id='contact-phone' name='contact-phone' type='text'>
                  <button type='submit'>There you are</button>
              </form>
          </body>
      </html>";
    });

    $app->post("/postings", function() {
        $new_contact = new Contact($_POST["contact-name"], $_POST["contact-email"], $_POST["contact-phone"]);
        $new_posting = new JobOpening($_POST["title"], $_POST["description"], $new_contact);

        $new_posting->save();
        $list_of_jobs = JobOpening::getAll();
        $output =
        "<!DOCTYPE html>
        <html>
            <head>
                <meta charset='utf-8'>
                <title>Lookit: Jobs!</title>
            </head>
            <body>
                <div>
                    <h1>Oh, hello, it's you. Welcome back. Here are those lovely jobs I promised you. XOXO Danny Boy</h1>
                    <ul>";

                    foreach ($list_of_jobs as $job) {
                      $output .= "<li><strong>Job Title:</strong> " . $job->get('title') . "</li>";
                      $output .= "<li><strong>Job Description:</strong>" . $job->get('description') . "</li>
                      <li><strong>Contact Information:</strong>
                          <ul>";
                      $output .= "<li><strong>Name:</strong> " . $job->get('contact')->get('name') . "</li>";
                      $output .= "<li><strong>Email:</strong> " . $job->get('contact')->get('email') . "</li>";
                      $output .= "<li><strong>Phone:</strong> " . $job->get('contact')->get('phone') . "</li>
                    </ul>
                  </li>";
                }
                $output .= "</ul>
                <a href='/'><button>Go on back, now</button></a>
            </div>
        </body>
    </html>";

        return $output;
    });

    return $app;
?>
