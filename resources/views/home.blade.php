<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Welcome</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            margin-top: 50px;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: left;
        }

        .title {
            font-size: 32px;
            text-align: left;
        }

        .sub-title {
            font-size: 16px;
            text-align: left;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        table {
            text-align: left;
            width: 100%;
        }

        td {
            padding-right: 100px;
        }

        caption {
            text-align: left;
        }

        .get {
            color: #62B54F;
            font-weight: bold;
        }

        .post {
            color: #F5C836;
            font-weight: bold;
        }

        .put {
            color: #2772BB;
            font-weight: bold;
        }

        .delete {
            color: #E02F2F;
            font-weight: bold;
        }

        span {
            font-weight: bold;
        }

        a {
            text-decoration: none;
            color: #636b6f;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    <div class="content">
        <div class="title">
            Welcome to the Bunq Chat API
        </div>
        <div class="sub-title m-b-md">
            - Ruan Haarhoff
        </div>

        <table>
            <caption>Your API guide</caption>
            <thead>
            <tr>
                <th>Method</th>
                <th>URI</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="get">GET</td>
                <td>users</td>
                <td>Get all users</td>
            </tr>
            <tr>
                <td class="post">POST</td>
                <td>users</td>
                <td>Create a user</td>
            </tr>
            <tr>
                <td class="put">PUT</td>
                <td>users</td>
                <td>Update a user</td>
            </tr>
            <tr>
                <td class="get">GET</td>
                <td>users/:id</td>
                <td>Get user by id</td>
            </tr>
            <tr>
                <td class="delete">DELETE</td>
                <td>users/:id</td>
                <td>Delete user by id</td>
            </tr>
            <tr>
                <td class="get">GET</td>
                <td>users/:id/messages</td>
                <td>Get all messages of user</td>
            </tr>
            <tr>
                <td class="get">GET</td>
                <td>users/:id/messages/inc</td>
                <td>Get all incoming messages of user</td>
            </tr>
            <tr>
                <td class="get">GET</td>
                <td>users/:id/messages/inc/:from</td>
                <td>Get all incoming messages of user from another user</td>
            </tr>
            <tr>
                <td class="get">GET</td>
                <td>users/:id/messages/out</td>
                <td>Get all outgoing messages of user</td>
            </tr>
            <tr>
                <td class="get">GET</td>
                <td>users/:id/messages/out/:to</td>
                <td>Get all outgoing messages of user to another user</td>
            </tr>
            <tr>
                <td class="get">GET</td>
                <td>users/:id/messages/all/:user</td>
                <td>Get all messages between two users (in order)</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="get">GET</td>
                <td>messages</td>
                <td>Get all messages</td>
            </tr>
            <tr>
                <td class="post">POST</td>
                <td>messages</td>
                <td>Create a message</td>
            </tr>
            <tr>
                <td class="put">PUT</td>
                <td>messages</td>
                <td>Update a message</td>
            </tr>
            <tr>
                <td class="get">GET</td>
                <td>messages/:id</td>
                <td>Get message by id</td>
            </tr>
            <tr>
                <td class="delete">DELETE</td>
                <td>messages/:id</td>
                <td>Delete message by id</td>
            </tr>
        </table>
        <p>
            <span>Examples</span><br>
            <a target="_blank" href="{{env('APP_URL')}}/api/users">{{env('APP_URL')}}/api/users</a><br>
            <a target="_blank" href="{{env('APP_URL')}}/api/users/1">{{env('APP_URL')}}/api/users/1</a><br>
            <a target="_blank" href="{{env('APP_URL')}}/api/users/1/messages">{{env('APP_URL')}}/api/users/1/messages</a><br>
            <a target="_blank" href="{{env('APP_URL')}}/api/messages">{{env('APP_URL')}}/api/messages</a><br>
        </p>
    </div>
</div>
</body>
</html>
