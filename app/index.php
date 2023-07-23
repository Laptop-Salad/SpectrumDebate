<?php
    require_once "../vendor/autoload.php";
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

    $router->get("/delete-user/{username}", function($username) {
        require __DIR__ . "/controllers/deleteUser.php";
        $deleteUser = new DeleteUser($username);
    });

    $router->any("/login", function() {
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

    $router->get("/statement/{id}", function($id) {
        require __DIR__ . "/controllers/fullStatement.php";
        $fullStatement = new fullStatement($id);
    });

    $router->any("/edit-statement/{statementId}", function($statementId) {
        require __DIR__ . "/controllers/editStatement.php";
        $editStatement = new EditStatement($statementId);
    });

    $router->get("/delete-statement/{statementId}", function($statementId) {
        require __DIR__ . "/controllers/deleteStatement.php";
        $deleteStatement = new DeleteStatement($statementId);
    });

    $router->post("/vote/{statementId}/{vote}", function($statementId, $vote) {
        require __DIR__ . "/controllers/vote.php";
        $vote = new VoteController($statementId, $vote);
    });

    $router->post("/comment/{statementId}/", function($statementId) {
        require __DIR__ . "/controllers/comment.php";
        $comment = new CommentController($statementId);
    });

    $router->any("/edit-comment/{commentId}", function($commentId) {
        require __DIR__ . "/controllers/editComment.php";
        $editComment = new EditComment($commentId);
    });

    $router->get("/delete-comment/{commentId}", function($commentId) {
        require __DIR__ . "/controllers/deleteComment.php";
        $deleteComment = new DeleteComment($commentId);
    });

    $router->get("/user/{username}/{view}", function($username, $view) {
        require __DIR__ . "/controllers/userProfile.php";
        $userProfile = new UserProfile($username, $view);
    });

    // Ajax check username available
    $router->get("/user-avail/{username}", function($username) {
        require_once __DIR__ . "/models/signupChecks.php";
        $signupCheck = new SignupCheck;
        echo $signupCheck->checkUserAvail($username);
    });

    $dispatcher = new Phroute\Phroute\Dispatcher($router->getData());

    try {
        $response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        echo $response;
    } catch (Phroute\Phroute\Exception\HttpRouteNotFoundException $error) {
        require __DIR__ . "/controllers/notFound.php";
        $notFound = new NotFound;
    } catch (Phroute\Phroute\Exception\HttpMethodNotAllowedException $error) {
        $base = new BaseController;
        echo $base->getRedirect("");
    }
?>