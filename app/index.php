<?php
    require_once "../vendor/autoload.php";
    require __DIR__ . "/controllers/BaseController.php";

    use Phroute\Phroute\RouteCollector;

    $router = new RouteCollector();

    $router->get("/", function () {
        require __DIR__ . "/controllers/Home.php";
        $home = new Home;
    });

    $router->get("/home", function () {
        require __DIR__ . "/controllers/Home.php";
        $home = new Home;
    });

    $router->get("/dashboard", function () {
        require __DIR__ . "/controllers/Dashboard.php";
        $dashboard = new Dashboard;

    });

    $router->any("/signup", function () {
        require __DIR__ . "/controllers/Signup.php";
        $signup = new Signup;
    });

    $router->get("/delete-user/{username}", function($username) {
        require __DIR__ . "/controllers/DeleteUser.php";
        $deleteUser = new DeleteUser($username);
    });

    $router->any("/login", function() {
        require __DIR__ . "/controllers/Login.php";
        $login = new Login;
    });

    $router->any("/logout", function () {
        require __DIR__ . "/controllers/Logout.php";
        $logout = new Logout;
    });

    $router->post("/new-statement", function () {
        require __DIR__ . "/controllers/NewStatement.php";
        $newStatement = new NewStatement;
    });

    $router->get("/statement/{id}", function($id) {
        require __DIR__ . "/controllers/FullStatement.php";
        $fullStatement = new FullStatement($id);
    });

    $router->any("/edit-statement/{statementId}", function($statementId) {
        require __DIR__ . "/controllers/EditStatement.php";
        $editStatement = new EditStatement($statementId);
    });

    $router->get("/delete-statement/{statementId}", function($statementId) {
        require __DIR__ . "/controllers/DeleteStatement.php";
        $deleteStatement = new DeleteStatement($statementId);
    });

    $router->post("/vote/{statementId}/{vote}", function($statementId, $vote) {
        require __DIR__ . "/controllers/Vote.php";
        $vote = new VoteController($statementId, $vote);
    });

    $router->post("/comment/{statementId}/", function($statementId) {
        require __DIR__ . "/controllers/CommentController.php";
        $comment = new CommentController($statementId);
        $comment->handleRequest();
    });

    $router->any("/edit-comment/{commentId}", function($commentId) {
        require __DIR__ . "/controllers/EditComment.php";
        $editComment = new EditComment($commentId);
    });

    $router->get("/delete-comment/{commentId}", function($commentId) {
        require __DIR__ . "/controllers/DeleteComment.php";
        $deleteComment = new DeleteComment($commentId);
    });

    $router->get("/user/{username}", function($username) {
        require __DIR__ . "/controllers/UserProfile.php";
        $userProfile = new UserProfile($username);
    });

    $router->get("/new-friend/{toUsername}", function($toUsername) {
        require __DIR__ . "/controllers/FriendController.php";
        $createFriend = new FriendController($toUsername);
    });

    $router->post("/edit-user/{username}", function($username) {
        require __DIR__ . "/controllers/EditUser.php";
        $editUser = new EditUser($username);
    });

    // Ajax check username available
    $router->get("/user-avail/{username}", function($username) {
        require_once __DIR__ . "/models/SignupCheck.php";
        $signupCheck = new SignupCheck;
        echo $signupCheck->checkUserAvail($username);
    });

    // Ajax search for statements and users
    $router->get("/search/{term}", function($term) {
        require_once __DIR__ . "/controllers/Search.php";
        $search = new Search($term);
    });

    $router->get("/search/", function() {
        return json_encode([]);
    });

    // robots.txt
    $router->get("/robots.txt", function() {
        require_once __DIR__ . "/robots.txt";
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