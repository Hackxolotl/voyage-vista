<?php

require __DIR__ . "/jwt.php";

function getAuthenticatedUser()
{
    $headers = getallheaders();

    if (
        !isset(
            $headers["Authorization"]
        )
    ) {
        return null;
    }

    $token = str_replace(
        "Bearer ",
        "",
        $headers["Authorization"]
    );

    try {

        return verifyJWT($token);

    } catch (Exception $e) {

        return null;
    }
}
