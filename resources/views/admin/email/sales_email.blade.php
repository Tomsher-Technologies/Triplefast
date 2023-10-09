<body>
    <p>Hi {{ $user['name'] }},</p>

    <p>
        <ul>
        @foreach($mailContent['message'] as $con)
            <li>{!! $con !!}</li>
        @endforeach

        </ul>
    </p>
    <p>
        Thank you.
    </p>
</body>