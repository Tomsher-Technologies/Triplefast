<body>
    <div style="max-width: 650px;margin:auto; box-shadow: rgba(135, 138, 153, 0.10) 0 5px 20px -6px;border-radius: 6px;border: 1px solid #0171b9;overflow: hidden;background-color: #fff;">
        <div  style="padding: 1.5rem; display: flex;gap: 8px; align-items: center; justify-content: space-between;flex-wrap: wrap;">
            <div>
                <a href="#"><img src="{{ asset('assets/images/logo1.jpg') }}" alt="" height="40"></a>
            </div>
        </div>
        <div style="padding: 1.5rem; text-align: left;">
            <h5 style="font-size: 16px;font-family: 'Poppins', sans-serif;font-weight: 600;margin-bottom: 0px;margin-top: 0px;line-height: 1.2;">Hi {{ $user['name'] }},</h5>
            <h6 style="font-size: 15px;font-weight: 500;margin-bottom: 12px;margin-top: 0px;line-height: 1.2;">
                
                <ul>
                    @foreach($mailContent['message'] as $con)
                        <li>{!! $con !!}</li>
                    @endforeach
                </ul>
            </h6>
        </div>
        <div style="padding: 1.5rem;">
            <div style="text-align: center;">
                <p style="color: #878a99; margin: 0;font-weight: 500;">
                    <script>document.write(new Date().getFullYear())</script> © {{ env('APP_NAME') }} 
                </p>
            </div>
        </div>
    </div>
</body>