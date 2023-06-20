<?php
    require_once "vendor/autoload.php";
    require __DIR__ . "/controllers/baseController.php";

    use Phroute\Phroute\RouteCollector;

    $router = new RouteCollector();

    $router->get("/", function () {
        require __DIR__ . "/controllers/home.php";
        $home = new Home;
    });

    $router->get("/home", function () {
        require __DIR__ . "/controllers/home.php";
        $home = new Home;
    });

    $router->get("/dashboard", function () {
        require __DIR__ . "/controllers/dashboard.php";
        $dashboard = new Dashboard;

    });

    $router->any("/signup", function () {
        require __DIR__ . "/controllers/signup.php";
        $signup = new Signup;
    });

    $router->any("/login", function () {
        require __DIR__ . "/controllers/login.php";
        $login = new Login;
    });

    $router->any("/logout", function () {
        require __DIR__ . "/controllers/logout.php";
        $logout = new Logout;
    });

    $router->post("/new-statement", function () {
        require __DIR__ . "/controllers/newStatement.php";
        $newStatement = new NewStatement;
    });

    $router->any("/new-statement", function() {
        echo "<script type='text/javascript'>window.location.href='//localhost/'</script>";
    });

    $router->any("favicon.html", function () {
        require __DIR__ . "/views/components/favicon.html";
    });

    $dispatcher = new Phroute\Phroute\Dispatcher($router->getData());

    try {
        $response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        echo $response;
    } catch (Phroute\Phroute\Exception\HttpRouteNotFoundException $error) {
        require __DIR__ . "/controllers/notFound.php";
        $notFound = new NotFound;
    } catch (Phroute\Phroute\Exception\HttpMethodNotAllowedException $error) {
        header("Location: ");
    }
?>