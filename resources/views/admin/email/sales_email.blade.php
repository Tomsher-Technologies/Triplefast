<body>
    <div style="max-width: 70%;margin:auto; box-shadow: rgba(135, 138, 153, 0.10) 0 5px 20px -6px;border-radius: 6px;border: 1px solid #0171b9;overflow: hidden;background-color: #fff;">
        <!-- <div  style="padding: 1.5rem; display: flex;gap: 8px; align-items: center; justify-content: space-between;flex-wrap: wrap;">
            <div>
                <a href="#"><img src="{{ asset('assets/images/logo1.jpg') }}" alt="" height="40"></a>
            </div>
        </div> -->
        <div style="padding: 1.5rem; text-align: left;">
            <h5 style="font-size: 15px;font-weight: normal;font-family: 'Poppins', sans-serif;margin-bottom: 0px;margin-top: 0px;line-height: 1.2;">Hi {{ $user['name'] }},</h5>

            @if (isset($mailContent['extra']) && !empty($mailContent['extra']))
                <table style="margin-top:10px;font-size: 15px;">
                    <tr>
                        <td><b>Customer PO#</b></td>
                        <td> : {{ $mailContent['extra']['po_number'] ?? ''}}</td>
                    </tr>
                    <tr>
                        <td><b>Customer ID</b></td>
                        <td> : {{ $mailContent['extra']['customer_id'] ?? ''}}</td>
                    </tr>
                    <tr>
                        <td><b>Customer Name</b></td>
                        <td> : {{ $mailContent['extra']['customer_name'] ?? ''}}</td>
                    </tr>

                </table>
            @endif

            <ul style="line-height: 30px;padding:0;font-size: 15px;">
                @foreach($mailContent['message'] as $con)
                    <li>{!! $con !!}</li>
                @endforeach
            </ul>
        </div>
        <div style="padding: 0.5rem;">
            <div style="text-align: center;">
                <p style="color: #878a99; margin: 0;font-weight: 500;">
                     © @php echo date('Y'); @endphp {{ env('APP_NAME') }} 
                </p>
            </div>
        </div>
    </div>
</body>